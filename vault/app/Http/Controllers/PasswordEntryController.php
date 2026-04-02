<?php

namespace App\Http\Controllers;

use App\Models\Vault;
use App\Models\PasswordEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PasswordEntryController extends Controller
{
    private function authorizeVault(Vault $vault): void
    {
        if ($vault->user_id !== Auth::id()) {
            abort(403);
        }
    }

    public function store(Request $request, Vault $vault)
    {
        $this->authorizeVault($vault);

        $validated = $request->validate([
            'site_name' => ['required', 'string', 'max:255'],
            'username'  => ['required', 'string'],
            'password'  => ['required', 'string'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'notes'     => ['nullable', 'string'],
        ]);

        $vault->passwordEntries()->create($validated);

        return redirect()->route('vaults.show', $vault)->with('success', 'Password entry added.');
    }

    public function edit(Vault $vault, PasswordEntry $entry)
    {
        $this->authorizeVault($vault);

        $categories = Auth::user()->categories()->orderBy('name')->get();

        return view('entries.edit', compact('vault', 'entry', 'categories'));
    }

    public function update(Request $request, Vault $vault, PasswordEntry $entry)
    {
        $this->authorizeVault($vault);

        $validated = $request->validate([
            'site_name' => ['required', 'string', 'max:255'],
            'username'  => ['required', 'string'],
            'password'  => ['required', 'string'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'notes'     => ['nullable', 'string'],
        ]);

        $entry->update($validated);

        return redirect()->route('vaults.show', $vault)->with('success', 'Password entry updated.');
    }

    public function destroy(Vault $vault, PasswordEntry $entry)
    {
        $this->authorizeVault($vault);

        $entry->delete();

        return redirect()->route('vaults.show', $vault)->with('success', 'Password entry deleted.');
    }
}
