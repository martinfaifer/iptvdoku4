<?php

namespace App\Livewire\Iptv\FlowEye\Menu;

use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Cache;

class FlowEyeMenuIconWithAlertComponent extends Component
{

    public int $numberOfAlerts = 0;

    public function mount()
    {
        $this->is_alert();
    }

    #[On('echo:floweye_active_tickets,FlowEyeActiveTicketsEvent')]
    public function is_alert()
    {
        if (Cache::has('floweye_active_tickets_count')) {
            return $this->numberOfAlerts = Cache::get('floweye_active_tickets_count');
        }
    }

    public function render()
    {
        return view('livewire.iptv.flow-eye.menu.flow-eye-menu-icon-with-alert-component');
    }
}
