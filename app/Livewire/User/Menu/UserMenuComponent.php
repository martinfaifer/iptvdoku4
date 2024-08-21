<?php

namespace App\Livewire\User\Menu;

use Livewire\Component;
use Illuminate\Contracts\View\Factory;

class UserMenuComponent extends Component
{
    public function render(): \Illuminate\Contracts\View\View|Factory
    {
        return view('livewire.user.menu.user-menu-component');
    }
}
