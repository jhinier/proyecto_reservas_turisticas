<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        // Esto le dice a Laravel que busque tu vista welcome.blade.php
        // y la muestre en la pantalla.
        return view('welcome');
    }
}
