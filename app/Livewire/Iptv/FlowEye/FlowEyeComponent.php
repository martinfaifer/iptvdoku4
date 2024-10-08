<?php

namespace App\Livewire\Iptv\FlowEye;

use App\Traits\Dates\DateParserTrait;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;

class FlowEyeComponent extends Component
{
    use DateParserTrait;

    public ?string $issue = null;

    public ?array $ticket = null;

    public string $title = 'IPTV dokumentace';

    public function mount(): void
    {
        $this->ticket_detail();
    }

    public function ticket_detail(): void
    {
        if (! is_null($this->issue)) {
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

    public function render(): mixed
    {
        return view('livewire.iptv.flow-eye.flow-eye-component')
            ->title($this->title);
    }
}
