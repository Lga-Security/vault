<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PasswordShare;

class PasswordShareController extends Controller
{
    public function update(Request $request, PasswordShare $shares)
    {
        $this->authorize('update', $shares);

        $validated = $request->validate([
            'permission' => ['required', 'in:view,edit'],
        ]);

        $shares->update([
            'permission' => $validated['permission'],
        ]);

        return back()->with('sucess', 'Permission mise à jour avec succès.');
    }

    public function destroy(PasswordShare $shares)
    {
        $this->authorize('delete', $shares);

        $shares->delete();

        return back()->with('success', 'Accès supprimé avec succès.');

    }
}
