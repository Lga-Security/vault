<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PasswordShareController extends Controller
{
    public function index()
    {
        $shares = Auth::user()->receivedPasswords()->with(['passwordEntry.vault', 'passwordEntry.category', 'sharedBy'])
        ->get();
        return view('shares.index'); 

        }

    public function store(Request $request)
    {
        if($entry->vault->user_id !== auth()->id())
            {Abort(403);}
        $validated = $request->validate([
            'email' => ['required'  | 'email'  | 'exists:user'],
            'permission' => ['required'  | 'in:view,edit'],
        ]);

        $recipient = User::where('email', $validated['email'])->first();
        $alreadyshared = PasswordShare::where('password_entry_id', $entry->id)->where('shared_with_user_id', $recipient->id)->exists();

        PasswordShare::create([
            'password_entry_id' => $entry->id,
            'shared_by_used_id' => auth()->id,
            'shared_with_user_id' => $recipient -> id,
            'permission' => $validated['permission'], 
        ]);

        return back()->with('Success', 'Entry Shared with' .$recipient->name. 'successfully !');
    }

        
}

    