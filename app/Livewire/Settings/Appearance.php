<?php

namespace App\Livewire\Settings;

use App\Livewire\Settings\Concerns\UsesSettingsLayout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Appearance settings')]
class Appearance extends Component
{
    use UsesSettingsLayout;

    public function render()
    {
        /** @var \Illuminate\View\View $view */
        $view = view('livewire.settings.appearance');
        $view->layout($this->settingsLayout());

        return $view;
    }
}
