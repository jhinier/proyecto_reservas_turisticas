<?php

namespace App\Livewire\Settings;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Appearance settings')]
class Appearance extends Component
{
    public function render()
    {
        /** @var \App\Models\User|null $user */
        $user = auth()->user();

        $layout = $user?->hasRole('emprendimiento') ? 'layouts.app.sidebar_emprendimiento' : 'layouts.app';

        /** @var \Illuminate\View\View $view */
        $view = view('livewire.settings.appearance');
        $view->layout($layout);

        return $view;
    }
}
