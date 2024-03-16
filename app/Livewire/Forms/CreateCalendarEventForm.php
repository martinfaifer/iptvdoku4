<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Models\Event;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;
use App\Jobs\SendCreateEventNotificationJob;

class CreateCalendarEventForm extends Form
{
    #[Validate('required', message: " Vyplňte popis")]
    #[Validate('string', message: "Neplatný formát")]
    #[Validate('max:255', message: "Maximální počet znaků je :max")]
    public string $label = "";

    #[Validate('required', message: " Vyplňte popis")]
    #[Validate('string', message: "Neplatný formát")]
    public string $description = "";

    #[Validate('required', message: "Vyberte začátek události")]
    public string $start_date = "";

    #[Validate('nullable')]
    public $start_time = null;

    #[Validate('nullable')]
    public $end_date = null;

    #[Validate('nullable')]
    public $end_time = null;

    #[Validate('nullable')]
    public array $users = [];

    #[Validate('nullable')]
    public array $channels = [];

    #[Validate('nullable')]
    public null|string $color = null;

    #[Validate('nullable')]
    public null|string $tag_id = null;

    public function create()
    {
        $event = Event::create([
            'label' => $this->label,
            'description' => $this->description,
            'start_date' => $this->start_date,
            'start_time' => $this->start_time,
            'end_date' => $this->end_date,
            'end_time' => $this->end_time,
            'color' => is_null($this->color) ? 1 : $this->color,
            'users' => json_encode($this->users),
            'creator' => Auth::user()->email,
            'channels' => json_encode($this->channels),
            'tag_id' => $this->tag_id
        ]);


        if (!is_null($this->users)) {
            SendCreateEventNotificationJob::dispatch($this->users, $event);
        }

        $this->reset();
    }
}
