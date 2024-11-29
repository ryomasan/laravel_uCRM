<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\InertiaTest;

class InertiaTestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Inertia/index', [
            'posts' => InertiaTest::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Inertia/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // try {
            $validated = $request->validate([
                'title' => ['required', 'min:4', 'max:255'],
                'content' => ['required', 'min:10', 'max:255'],
            ]);

            $inertiaTest = new InertiaTest;
            $inertiaTest->title = $request->title;
            $inertiaTest->content = $request->content;
            $inertiaTest->save();
            return to_route('inertia.index')->with([
                'message' => "登録しました"
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Inertia::render('Inertia/show', [
            'id' => $id,
            'post'=> InertiaTest::findOrFail($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $post = InertiaTest::findOrFail($id);
            $post->delete();
            return to_route('inertia.index')->with([
                'message' => "削除しました"
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Custom response or logging could be done here
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422); // Respond with 422 Unprocessable Entity
        }
    }
}
