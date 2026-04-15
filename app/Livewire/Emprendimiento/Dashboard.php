<?php

namespace App\Livewire\Emprendimiento;

use Livewire\Component;
use Livewire\Attributes\Layout; // <-- 1. Asegúrate de tener esta importación aquí arriba

// 2. ¡Aquí es donde "llamas" a tu marco/sidebar!
#[Layout('layouts.app.sidebar_emprendimiento')] 
class Dashboard extends Component
{
    public function render()
    {
        // 3. Esta es tu "foto" (el HTML puro con los cuadritos que diseñaste)
        return view('livewire.emprendimiento.dashboard');
    }
}