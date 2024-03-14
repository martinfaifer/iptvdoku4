<?php

namespace App\Livewire\Forms;

use App\Models\Event;
use Livewire\Attributes\Validate;
use Livewire\Form;

class UpdateCalendarEventForm extends Form
{

    public ?Event $event;


    #[Validate('required', message: "Vyplňte popis")]
    #[Validate('string', message: "Neplatný formát")]
    #[Validate('max:100', message: "Maximální počet znaků je 100")]
    public string $label = "";

    #[Validate('nullable')]
    #[Validate('string', message: "Neplatný formát")]
    public $description = "";

    #[Validate('nullable')]
    public string $color = "";

    #[Validate('required', message: "Vyplňte začátek události")]
    public string $start_date = "";

    #[Validate('nullable')]
    public $start_time = null;

    #[Validate('nullable')]
    public $end_date = null;

    #[Validate('nullable')]
    public $end_time = null;

    public function setEvent($event)
    {
        $this->event = $event;
        $this->label = $event->label;
        $this->description = $event['description'];
        $this->start_date = $event->start_date;
        $this->start_time = $event->start_time;
        $this->end_date = $event->end_date;
        $this->end_time = $event->end_time;
    }

    public function update()
    {
        return $this->event->update([
            'label' => $this->label,
            'description' => $this->description,
            'start_date' => $this->start_date,
            'start_time' => $this->start_time,
            'end_date' => $this->end_date,
            'end_time' => $this->end_time,
            'color' => "cs-rose-950",
        ]);

        $this->reset();
    }
}
