<?php

namespace App\Livewire\Iptv\FlowEye;

use Livewire\Component;
use Illuminate\Support\Facades\Cache;

class FlowEyeComponent extends Component
{
    public string|null $issue = null;

    public array|null $ticket = null;

    public function mount()
    {
        $this->ticket_detail();
    }

    public function ticket_detail()
    {
        if (!is_null($this->issue)) {
            if (Cache::has('floweye_active_tickets')) {
                $tickets = Cache::get('floweye_active_tickets');

                foreach ($tickets['data'] as $ticket) {
                    if ($ticket['id'] == $this->issue) {
                        return $this->ticket = $ticket;
                        break;
                    }
                }
            }
        }
    }

    public function render()
    {
        return view('livewire.iptv.flow-eye.flow-eye-component');
    }
}
