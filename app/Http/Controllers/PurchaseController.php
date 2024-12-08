<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePurchaseRequest;
use App\Http\Requests\UpdatePurchaseRequest;
use App\Models\Customer;
use App\Models\Item;
use App\Models\Order;
use App\Models\Purchase;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $purchases = Order::paginate(50);
        $orders = Order::groupBy('id')->selectRaw('id, customer_name, sum(subtotal) as total, status, created_at')->paginate(50);
        return Inertia::render('Purchases/index', [
            'orders' => $orders
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customers = Customer::select('id', 'name', 'kana', 'tel')->get();
        $items = Item::select('id', 'name', 'price', 'stocks')->get();
        return Inertia::render('Purchases/create', [
            'customers' => $customers,
            'items' => $items
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePurchaseRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePurchaseRequest $request)
    {
        DB::beginTransaction();
        // dd($request);
        try {
            $purchase = Purchase::create([
                'status' => $request->status,
                'customer_id' => $request->customer_id,
            ]);

            foreach ($request->items as $item) {
                $purchase->items()->attach($purchase->id, [
                    'item_id' => $item['id'],
                    'quantity' => $item['quantity']
                ]);
                $purchasedItem = Item::find($item['id']);
                $purchasedItem->stocks -= $item['quantity'];
                $purchasedItem->save();
            }

            DB::commit();

            return to_route('purchases.index')->with([
                'message' => "登録しました",
                'status' => "success"
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422); // Respond with 422 Unprocessable Entity
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function show(Purchase $purchase)
    {
        $items = Order::where('id', $purchase->id)->get();
        $order = Order::groupBy('id')->where('id', $purchase->id)->selectRaw('id, customer_name, sum(subtotal) as total, created_at, updated_at')->get();
        // $order = Order::groupBy('id')->where('id', $purchase->id)->selectRaw('id, customer_name, item_name, quantity, subtotal, sum(subtotal) as total, created_at')->get();
        // $order = Order::groupBy('id')->selectRaw('id, customer_name, item_name, quantity, subtotal, sum(subtotal) as total, status, created_at, updated_at')->get()->where('id', $purchase->id);
        return Inertia::render('Purchases/show', [
            'items' => $items,
            'order' => $order,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function edit(Purchase $purchase)
    {
        $items = Order::where('id', $purchase->id)
            ->get();
        $order = Order::groupBy('id')
            ->where('id', $purchase->id)
            ->selectRaw('id, customer_id, customer_name, status, created_at')
            ->get();
        // dd($order);
        // $order = Order::groupBy('id')->where('id', $purchase->id)->selectRaw('id, customer_name, item_name, quantity, subtotal, sum(subtotal) as total, created_at')->get();
        // $order = Order::groupBy('id')->selectRaw('id, customer_name, item_name, quantity, subtotal, sum(subtotal) as total, status, created_at, updated_at')->get()->where('id', $purchase->id);
        return Inertia::render('Purchases/edit', [
            'items' => $items,
            'order' => $order
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePurchaseRequest  $request
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePurchaseRequest $request, Purchase $purchase)
    {
        DB::beginTransaction();
        // dd($request);
        try {

            $purchase->status = $request->status;
            $purchase->save();

            foreach ($request->items as $item) {
                $purchase->items()->updateExistingPivot($item['id'], [
                    'quantity' => $item['quantity']
                ]);
            }
            DB::commit();

            return to_route('purchases.show', $purchase->id)->with([
                'message' => "登録しました",
                'status' => "success"
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422); // Respond with 422 Unprocessable Entity
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function destroy(Purchase $purchase)
    {
        $purchase->delete();
        return to_route('purchases.index')->with([
            'message' => "削除しました",
            'status' => "success"
        ]);
    }

    // public function removeItemFromPurchase(Purchase $purchase, Item $item)
    // {
    //     $purchase->items()->detach($item->id);
    //     return response()->json([
    //         'message' => "削除しました",
    //         'status' => "success"
    //     ]);
    // }
}
