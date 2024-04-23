<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Models\Slack;
use Livewire\Attributes\Validate;

class UpdateSettingsSlackNotificationForm extends Form
{

    public ?Slack $slack;

    public string $url = "";

    #[Validate('required', message: "Vyplňte popis")]
    #[Validate('string', message: "Neplatný formát")]
    #[Validate('max:255', message: "Maximální počet znaků je :max")]
    public string $description = "";

    #[Validate('required', message: "Vyberte akci")]
    #[Validate('string', message: "Neplatný formát")]
    #[Validate('max:255', message: "Maximální počet znaků je :max")]
    public string $action = "";

    public function setChannel(Slack $slack)
    {
        $this->slack = $slack;
        $this->url = $slack->url;
        $this->description = $slack->description;
        $this->action = $slack->action;
    }

    public function update()
    {
        $this->validate();

        $this->slack->update([
            'description' => $this->description,
            'action' => $this->action
        ]);

        $this->reset();
    }
}
