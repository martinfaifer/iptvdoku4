<?php

namespace App\Livewire\Iptv\FlowEye\Menu;

use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\On;
use Livewire\Component;

class FlowEyeMenuComponent extends Component
{
    public array $flowEyeNavigation = [];

    public function mount()
    {
        $this->get_active_tickets();
    }

    #[On('echo:floweye_active_tickets,FlowEyeActiveTicketsEvent')]
    public function get_active_tickets()
    {
        if (Cache::has('floweye_active_tickets')) {
            $this->flowEyeNavigation = Cache::get('floweye_active_tickets');
        }
    }

    public function render()
    {
        return view('livewire.iptv.flow-eye.menu.flow-eye-menu-component');
    }
}
