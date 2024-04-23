<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Models\Event;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;
use App\Jobs\SendCreateEventNotificationJob;

class CreateCalendarEventForm extends Form
{
    use WithFileUploads;

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
    public null|string $color = null;

    #[Validate('nullable')]
    public null|string $tag_id = null;

    #[Validate('required', message: "Zobrazit upozornění?")]
    #[Validate('boolean', message: "Nepatný formát")]
    public bool $fe_notification = false;

    #[Validate('max:1024', message: 'Maximální velikost banneru je 1Mb')]
    #[Validate('nullable')]
    public $banner = null;

    #[Validate('nullable')]
    #[Validate('exists:sftp_servers,id', message: "Neznámý server")]
    public null|string $sftp_server_id = null;

    public function create()
    {
        $this->validate();

        $bannerPath = null;

        if (!is_null($this->banner)) {
            $bannerPath = $this->banner->store(path: 'public/NanguBanners');
        }

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
            'tag_id' => $this->tag_id,
            'fe_notification' => $this->fe_notification,
            'banner_path' => $bannerPath,
            'sftp_server_id' => $this->sftp_server_id
        ]);


        if (!is_null($this->users)) {
            SendCreateEventNotificationJob::dispatch($this->users, $event);
        }

        $this->reset();
    }
}
