<?php

namespace App\Livewire\User\Menu;

use Illuminate\Contracts\View\Factory;
use Livewire\Component;

class UserMenuComponent extends Component
{
    public function render(): \Illuminate\Contracts\View\View|Factory
    {
        return view('livewire.user.menu.user-menu-component');
    }
}
