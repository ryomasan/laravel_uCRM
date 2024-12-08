<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Models\Item;
use Inertia\Inertia;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = Item::query();
        $items = $query->paginate(50);
        return Inertia::render('Items/index', [
            'items' => $items
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Items/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreItemRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreItemRequest $request)
    {
        // try {
        Item::create([
            'name' => $request->name,
            'memo' => $request->memo,
            'price' => $request->price,
            'stocks' => $request->stocks,
        ]);

        return to_route('items.index')->with([
            'message' => "登録しました",
            'status' => "success"
        ]);
        // } catch (\Illuminate\Validation\ValidationException $e) {
        //     // Custom response or logging could be done here
        //     return response()->json([
        //         'message' => 'Validation failed',
        //         'errors' => $e->errors(),
        //     ], 422); // Respond with 422 Unprocessable Entity
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        return Inertia::render('Items/show', [
            'item' => $item,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        return Inertia::render('Items/edit', [
            'item' => $item
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateItemRequest  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateItemRequest $request, Item $item)
    {
        $id = $item->id;
        Item::where('id', $id)->update([
            'name' => $request->name,
            'price' => $request->price,
            'stocks' => $request->stocks,
            'memo' => $request->memo,
            // 'is_selling' => $request->is_selling,
        ]);
        return to_route('items.index')->with([
            'message' => "更新しました",
            'status' => "success"
        ]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {
        $item->delete();
        // $item->purchases()->delete();
        // $item->delete();
        return to_route('items.index')->with([
            'message' => "削除しました",
            'status' => "success"
        ]);
    }
}
