<?php

namespace App\Http\Controllers;

use App\Models\Vault;
use App\Models\PasswordEntry;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PasswordEntryController extends Controller
{

    public function index(Vault $vault)
    {
        $this->authorize('view', $vault);

        return redirect()->route('vaults.show', $vault);
    }


    public function create(Vault $vault)
    {
        $this->authorize('view', $vault);

        $categories = Category::where('is_default', true)
            ->orWhere('user_id', Auth::id())
            ->orderBy('name')
            ->get();

        return view('entries.create', compact('vault', 'categories'));
    }


    public function store(Request $request, Vault $vault)
    {
        $this->authorize('view', $vault);

        $validated = $request->validate([
            'site_name'   => 'required|string|max:255',
            'url'         => 'nullable|url|max:500',
            'username'    => 'required|string',
            'password'    => 'required|string',
            'notes'       => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $validated['username'] = encrypt($validated['username']);
        $validated['password'] = encrypt($validated['password']);
        $validated['notes']    = isset($validated['notes']) ? encrypt($validated['notes']) : null;

        $vault->passwordEntries()->create($validated);

        return redirect()->route('vaults.show', $vault)->with('success', 'Password entry added successfully!');
    }


    public function show(Vault $vault, PasswordEntry $entry)
    {
        $this->authorize('view', $vault);


        $entry->username = decrypt($entry->username);
        $entry->password = decrypt($entry->password);
        $entry->notes = $entry->notes ? decrypt($entry->notes) : null;

        return view('entries.show', compact('vault', 'entry'));
    }   

 
    public function edit(Vault $vault, PasswordEntry $entry)
    {
        $this->authorize('update', $entry);

        $decrypted = [
            'username' => decrypt($entry->username),
            'password' => decrypt($entry->password),
            'notes'    => $entry->notes ? decrypt($entry->notes) : null,
        ];

        $categories = Category::where('is_default', true)
            ->orWhere('user_id', Auth::id())
            ->orderBy('name')
            ->get();

        return view('entries.edit', compact('vault', 'entry', 'decrypted', 'categories'));
    }


    public function update(Request $request, Vault $vault, PasswordEntry $entry)
    {
        $this->authorize('update', $entry);

        $validated = $request->validate([
            'site_name'   => 'required|string|max:255',
            'url'         => 'nullable|url|max:500',
            'username'    => 'required|string',
            'password'    => 'required|string',
            'notes'       => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $validated['username'] = encrypt($validated['username']);
        $validated['password'] = encrypt($validated['password']);
        $validated['notes']    = isset($validated['notes']) ? encrypt($validated['notes']) : null;

        $entry->update($validated);

        return redirect()->route('vaults.entries.show', [$vault, $entry])->with('success', 'Password entry updated successfully!');
    }


    public function destroy(Vault $vault, PasswordEntry $entry)
    {
        $this->authorize('delete', $entry);

        $entry->delete();

        return redirect()->route('vaults.show', $vault)->with('success', 'Password entry deleted successfully!');
    }
}