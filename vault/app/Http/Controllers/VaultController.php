<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vault;
use App\Models\PasswordEntry;
use App\Models\PasswordShare;
use App\Models\Category;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VaultController extends Controller
{
    private function user(): User
    {
        /** @var User */
        return Auth::user();
    }

    public function dashboard()
    {
        $user = $this->user();

        $vaultCount = $user->vaults()->count();
        $entryCount = PasswordEntry::whereIn('vault_id', $user->vaults()->pluck('id'))->count();
        $categoryCount = $user->categories()->count();
        $shareCount = PasswordShare::where('shared_by_user_id', $user->id)
            ->orWhere('shared_with_user_id', $user->id)
            ->count();

        $vaults = $user->vaults()->withCount('passwordEntries')->latest()->take(5)->get();
        $activities = ActivityLog::where('user_id', $user->id)->latest()->take(10)->get();

        return view('dashboard', compact(
            'vaultCount', 'entryCount', 'categoryCount', 'shareCount',
            'vaults', 'activities'
        ));
    }

    public function index()
    {
        $vaults = $this->user()->vaults()->withCount('passwordEntries')->latest()->get();

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

        $this->user()->vaults()->create($validated);

        return redirect()->route('vaults.index')->with('success', 'Vault created successfully!');
    }

    public function show(Vault $vault)
    {
        if ($vault->user_id !== Auth::id()) {
            abort(403);
        }

        $entries = $vault->passwordEntries()->with('category')->latest()->get();
        $categories = Category::where('is_default', true)
                ->orwhere('user_id', auth::id())
                ->orderby('name')
                ->get();
        return view('vaults.show', compact('vault', 'entries', 'categories'));
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
