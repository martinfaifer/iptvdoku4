<?php

namespace App\Livewire\Settings;

use Livewire\Component;
use Illuminate\Contracts\View\Factory;

class SettingsNavigationComponent extends Component
{
    public function render(): \Illuminate\Contracts\View\View|Factory
    {
        return view('livewire.settings.settings-navigation-component');
    }
}
