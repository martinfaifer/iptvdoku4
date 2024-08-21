<?php

namespace App\Livewire\Settings;

use Illuminate\Contracts\View\Factory;
use Livewire\Component;

class SettingsNavigationComponent extends Component
{
    public function render(): \Illuminate\Contracts\View\View|Factory
    {
        return view('livewire.settings.settings-navigation-component');
    }
}
