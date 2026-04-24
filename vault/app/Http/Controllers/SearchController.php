<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $term = $request -> input('q');

        if(!$term) {
            return view('search',['results'=>[]]);
        }

        $user = auth() -> user();
        $vaultIds = auth()->user()->vaults()->pluck('id');

        $results = PasswordEntry::whereIn('vault_id', $vaultIds)
        ->where(function($q) use ($term) { $q->where('site_name', 'like', '%'.$term.'%')->orWhere('url', 'like', '%'.$term.'%'); })

        -> get();
        return view('search', [
            'results' => $results,
            'term' => $term,

        ]);
    }
}
