<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class GeneratorController extends Controller
{
        // Character pools
    private const UPPER = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    private const LOWER = 'abcdefghijklmnopqrstuvwxyz';
    private const NUMBERS = '0123456789';
    private const SYMBOLS = '!@#$%^&*()_+-=[]{}|;:,.<>?';
    public function generate(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'length'  => 'required|integer|min:8|max:64',
            'upper'   => 'required|boolean',
            'lower'   => 'required|boolean',
            'numbers' => 'required|boolean',
            'symbols' => 'required|boolean',
        ]);

        // Build the character pool
        $pool = '';
        if ($validated['upper'])   $pool .= self::UPPER;
        if ($validated['lower'])   $pool .= self::LOWER;
        if ($validated['numbers']) $pool .= self::NUMBERS;
        if ($validated['symbols']) $pool .= self::SYMBOLS;

        // Edge case: no character types selected
        if ($pool === '') {
            return response()->json([
                'error' => 'Please select at least one character type.',
            ], 422);
        }

        // Generate the password using cryptographically secure randomness
        $password = '';
        $poolLength = strlen($pool);
        for ($i = 0; $i < $validated['length']; $i++) {
            $password .= $pool[random_int(0, $poolLength - 1)];
        }

        // Calculate strength
        $strength = $this->calculateStrength($password);

        return response()->json([
            'password' => $password,
            'strength' => $strength,
        ]);
    }

    public function index()
    {
        return view('generator.index');
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
                'filledBars' => 1,
            ];
        }
        
        if ($score <= 4) { 
            return[
                'level' => 'Fair',
                'label' => 'Fair',
                'color' => '#fd7e14',
                'filledBars' => 2,
            ];
        }   


        if ($score <= 6) {
            return[
                'level' => 'Good',
                'label' => 'Good',
                'color' => '#ffc107',
                'filledBars' => 3,
            ];
        }    
        
        if ($score >= 7) {
            return[
                'level' => 'Strong',
                'label' => 'Strong',
                'color' => '#198754',
                'filledBars' => 4,
            ];
        }              
                       


}

}