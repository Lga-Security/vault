<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vault;
use Illuminate\Support\Facades\Auth;


class VaultController extends Controller
{
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
    public function show(string $id)
    {
        $vault = Vault::findOrFail($id);

        if ($vault->user_id !== Auth::id()) {
            abort(403);
    }
    return view('vaults.show', compact('vault'));
    }

    public function edit(string $id)
    {
        $vault = Vault::findOrFail($id);

        if ($vault->user_id !== Auth::id()) {
            abort(403);
    }

    return view('vaults.edit', compact('vault'));
    }

    public function update(Request $request, string $id)
    {
        $vault = Vault::findOrFail($id);

        if ($vault->user_id !== Auth::id()) {
            abort(403);

        $validated = $request->validate([
        'name' => 'required|string|max:255',
    ]);

        $vault->update($validated);
    }

    return redirect('/vaults')->with('success', 'Vault updated successfully');
    }

    public function destroy(string $id)
    {
        $vault = Vault::findOrFail($id);

        if ($vault->user_id !== Auth::id()){
            abort(403);
    }

    $vault->delete();

    return redirect('/vaults')->with('success', 'Vault deleted successfully');
}
}
    /**
     * Display a listing of the resource.
     */


    /**
     * Display the specified resource.
     */

