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
    private function calculateStrength(string $password):array{

        $score = 0;

        if (strlen($password) >= 8 ) $score++;
        if (strlen($password) >= 12 ) $score++;
        if (strlen($password) >= 16 ) $score++;

        if (preg_match('/[A-Z]/' , $password)) $score++;
        if (preg_match('/[a-z]/' , $password)) $score++;
        if (preg_match('/[0-9]/' , $password)) $score++;
        if (preg_match('/[^A-Za-z0-9]/', $password)) $score++;
        if ($score <= 2) {
            return[
                'level' => 'Weak',
                'label' => 'Weak',
                'color' => '#dc3545',
                'filledBars' => '1',
            ];
        }
        
        if ($score <= 4) { 
            return[
                'level' => 'Fair',
                'label' => 'Fair',
                'color' => '#fd7e14',
                'filledBars' => '2',
            ];
        }   


        if ($score <= 6) {
            return[
                'level' => 'Good',
                'label' => 'Good',
                'color' => '#ffc107',
                'filledBars' => '3',
            ];
        }    
        
        if ($score >= 7) {
            return[
                'level' => 'Strong',
                'label' => 'Strong',
                'color' => '#198754',
                'filledBars' => '4'
            ];
        }              
                       


}

