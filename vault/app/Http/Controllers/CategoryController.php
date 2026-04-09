<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    
    
    public function update(Request $request, string $id)
    {
        $this->authorize('update', $category);

        $validated = $request->validate([
        'name' => ['required' | 'string' | 'max:255'],
        'icon' => ['nullable' | 'string' | 'max:50'],
        ]);

        $category->update($validated);

        return redirect()-> route('category.index')-> with('Sucess' , 'Informations updated !');

    }

    

    public function destroy(string $id)
    {
        $this->authorize('delete', $category);

        $category->delete();

        return redirect()->route('category.index')->with('Success', 'Category deleted successfully!');
    }
}
