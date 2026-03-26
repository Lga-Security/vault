<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class VaultController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vault = Auth::User->Vaults()->withCount('passwordEntries')->latest()->get();
        return view('vault.index',compact('vaults'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('vault.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string' , 'max:255'],
            'description' => ['nullable' , 'string' ],
            'icon' => ['nullable', 'max:50'],
            'color' => ['nullable' , 'max:7'],
        ]);
        Auth::User()->vaults()->create($validatedData);
        redirect()->route('vaults.index')->with('success', 'Vault created successfully!');
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

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
