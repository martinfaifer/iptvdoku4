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

    public string $color = "";

    #[Validate('required', message: "Vyberte začátek události")]
    public string $start_date = "";

    #[Validate('nullable')]
    public $start_time = null;

    #[Validate('nullable')]
    public $end_date = null;

    #[Validate('nullable')]
    public $end_time = null;

    #[Validate('nullable')]
    public null|array $users;

    public function create()
    {
        $event = Event::create([
            'label' => $this->label,
            'description' => $this->description,
            'start_date' => $this->start_date,
            'start_time' => $this->start_time,
            'end_date' => $this->end_date,
            'end_time' => $this->end_time,
            'color' => "cs-rose-950",
            'users' => json_encode($this->users),
            'creator' => Auth::user()->email
        ]);


        if (!is_null($this->users)) {
            SendCreateEventNotificationJob::dispatch($this->users, $event);
        }

        $this->reset();
    }
}
