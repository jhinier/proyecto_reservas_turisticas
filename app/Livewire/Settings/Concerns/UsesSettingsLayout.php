<?php

namespace App\Livewire\Settings\Concerns;

trait UsesSettingsLayout
{
    protected function settingsLayout(): string
    {
        $user = auth()->user();

        if ($user?->hasRole('emprendimiento')) {
            return 'layouts.app.sidebar_emprendimiento';
        }

        if ($user?->hasAnyRole(['admin', 'superAdministrador', 'administrador_gad'])) {
            return 'layouts.app.sidebar';
        }

        return 'layouts.turista';
    }
}
