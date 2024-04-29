<?php

namespace App\Livewire\Iptv\FlowEye;

use Livewire\Component;
use Illuminate\Support\Facades\Cache;

class FlowEyeComponent extends Component
{
    public string|null $issue = null;

    public array|null $ticket = null;

    public string $title = "IPTV dokumentace";

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
                        $this->ticket = $ticket;
                        break;
                    }
                }

                $this->title = strip_tags($this->ticket['current_step']['inbox']);
            }
        }
    }

    public function render()
    {
        return view('livewire.iptv.flow-eye.flow-eye-component')
            ->title($this->title);
    }
}
