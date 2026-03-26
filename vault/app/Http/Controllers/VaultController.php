<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vault;
use Illuminate\Support\Facades\Auth;


class VaultController extends Controller
{
    public function index()
    {

    }

    public function create()
    {
        
    }

    public function store(Request $request)
    {
        
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
