<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GeneratorController extends Controller
{
    public function generate(Request $request)
    {
        $validated = $request->validate([
            'length' => 'required|integer|min:8|max:64',
            'upper' => 'required|boolean',
            'lower' => 'required|boolean',
            'numbers' => 'required|boolean',
            'symbols' => 'required|boolean',
        ]);

        $upper = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $lower = 'abcdefghijklmnopqrstuvwxyz';
        $numbers = '0123456789';
        $symbols = '!@#$%^&*()-_=+[]{}|;:,.<>?';

        $pool = '';

        if ($validated['upper']){
            $pool .= $upper;
        }
        if ($validated['lower']){
            $pool .= $lower;
        }
        if ($validated['numbers']){
            $pool .= $numbers;
        }
        if ($validated['symbols']){
            $pool .= $symbols;
        }
        if (empty($pool)){
            return response()->json([
                'error' => 'Un caractère doit être sélectionner'
            ], 422);
        }

        $password = '';
        $poolLenght = strlen($pool);

        for ($i = 0; $i < $validated['lenght']; $i++){
            $index = random_int(0, $poolLenght -1);
            $password .= $pool[$index];
        }

        $strenght = $this->calculateStrenght($password);

        return response()->json([
            'password' => $password,
            'strenght' => $strenght
        ]);
    }

    public function index()
    {
        return view('generator.index');
    }
}
