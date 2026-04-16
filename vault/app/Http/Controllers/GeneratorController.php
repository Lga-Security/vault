<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GeneratorController extends Controller
{
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
}