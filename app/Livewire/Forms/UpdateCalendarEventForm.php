<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Models\Event;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;

class UpdateCalendarEventForm extends Form
{
    use WithFileUploads;

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

    // #[Validate('required', message: "Vyberte konec akce")]
    #[Validate('nullable')]
    public $end_date = null;

    #[Validate('nullable')]
    public $end_time = null;

    #[Validate('nullable')]
    public array $users = [];

    #[Validate('nullable')]
    public array $channels = [];

    #[Validate('nullable')]
    public null|string $tag_id = null;

    #[Validate('required', message: "Zobrazit upozornění?")]
    #[Validate('boolean', message: "Nepatný formát")]
    public bool $fe_notification = false;

    #[Validate('max:1024', message: 'Maximální velikost banneru je 1Mb')]
    #[Validate('nullable')]
    public $banner;

    #[Validate('nullable')]
    #[Validate('exists:sftp_servers,id', message: "Neznámý server")]
    public null|string $sftp_server_id = null;

    public function setEvent($event)
    {
        $this->event = $event;
        $this->label = $event->label;
        $this->description = $event['description'];
        $this->start_date = $event->start_date;
        $this->start_time = $event->start_time;
        $this->end_date = $event->end_date;
        $this->end_time = $event->end_time;
        $this->channels = json_decode($event->channels);
        $this->tag_id = $event->tag_id;
        $this->fe_notification = $event->fe_notification;
        $this->users = json_decode($event->users);
        $this->color = $event->color;
        $this->banner = $event->banner_path;
        $this->sftp_server_id = $event->sftp_server_id;
    }

    public function update()
    {
        $this->validate();

        $bannerPath = $this->event->banner_path;

        if (!is_string($this->banner)) {
            $bannerPath = $this->banner->store(path: 'public/NanguBanners');
        }

        return $this->event->update([
            'label' => $this->label,
            'description' => $this->description,
            'start_date' => $this->start_date,
            'start_time' => $this->start_time,
            'end_date' => $this->end_date,
            'end_time' => $this->end_time,
            'color' => "cs-rose-950",
            'fe_notification' => $this->fe_notification,
            'channels' => json_encode($this->channels),
            'tag_id' => $this->tag_id,
            'users' => json_encode($this->users),
            'banner_path' => $bannerPath,
            'sftp_server_id' => $this->sftp_server_id
        ]);

        $this->reset();
    }
}
