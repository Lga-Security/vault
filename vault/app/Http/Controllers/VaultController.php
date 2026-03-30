<?php

namespace App\Http\Controllers;

use App\Models\Vault;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VaultController extends Controller
{
    public function index()
    {
        $vaults = Auth::user()->vaults()->withCount('passwordEntries')->latest()->get();

        return view('vaults.index', compact('vaults'));
    }

    public function create()
    {
        return view('vaults.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'icon' => ['nullable', 'string', 'max:50'],
            'color' => ['nullable', 'string', 'max:7'],
        ]);

        Auth::user()->vaults()->create($validated);

        return redirect()->route('vaults.index')->with('success', 'Vault created successfully!');
    }

    public function show(Vault $vault)
    {
        if ($vault->user_id !== Auth::id()) {
            abort(403);
        }

        return view('vaults.show', compact('vault'));
    }

    public function edit(Vault $vault)
    {
        if ($vault->user_id !== Auth::id()) {
            abort(403);
        }

        return view('vaults.edit', compact('vault'));
    }

    public function update(Request $request, Vault $vault)
    {
        if ($vault->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'icon' => ['nullable', 'string', 'max:50'],
            'color' => ['nullable', 'string', 'max:7'],
        ]);

        $vault->update($validated);

        return redirect()->route('vaults.index')->with('success', 'Vault updated successfully');
    }

    public function destroy(Vault $vault)
    {
        if ($vault->user_id !== Auth::id()) {
            abort(403);
        }

        $vault->delete();

        return redirect()->route('vaults.index')->with('success', 'Vault deleted successfully');
    }
}
