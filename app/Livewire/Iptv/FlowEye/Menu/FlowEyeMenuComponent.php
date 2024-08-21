<?php

namespace App\Livewire\Iptv\FlowEye\Menu;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Livewire\Iptv\Sftps\Factory;
use Illuminate\Support\Facades\Cache;

class FlowEyeMenuComponent extends Component
{
    public array $flowEyeNavigation = [];

    public function mount(): void
    {
        $this->get_active_tickets();
    }

    #[On('echo:floweye_active_tickets,FlowEyeActiveTicketsEvent')]
    public function get_active_tickets(): void
    {
        if (Cache::has('floweye_active_tickets')) {
            $this->flowEyeNavigation = Cache::get('floweye_active_tickets');
        }
    }

    public function render():\Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
    {
        return view('livewire.iptv.flow-eye.menu.flow-eye-menu-component');
    }
}
