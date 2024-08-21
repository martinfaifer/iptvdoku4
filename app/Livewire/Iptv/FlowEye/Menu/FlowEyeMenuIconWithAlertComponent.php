<?php

namespace App\Livewire\Iptv\FlowEye\Menu;

use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\On;
use Livewire\Component;

class FlowEyeMenuIconWithAlertComponent extends Component
{
    public int $numberOfAlerts = 0;

    public function mount(): void
    {
        $this->is_alert();
    }

    #[On('echo:floweye_active_tickets,BroadcastFlowEyeTicketsEvent')]
    public function is_alert(): void
    {
        if (Cache::has('floweye_active_tickets_count')) {
            $this->numberOfAlerts = Cache::get('floweye_active_tickets_count');
        }
    }

    public function render(): \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
    {
        return view('livewire.iptv.flow-eye.menu.flow-eye-menu-icon-with-alert-component');
    }
}
