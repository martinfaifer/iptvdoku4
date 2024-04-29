<?php

namespace App\Livewire\Forms;

use App\Models\Slack;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CreateSettingsSlackNotificationForm extends Form
{
    #[Validate('required', message: 'Vyplňte url')]
    #[Validate('string', message: 'Neplatný formát')]
    #[Validate('max:255', message: 'Maximální počet znaků je :max')]
    public string $url = '';

    #[Validate('required', message: 'Vyplňte popis')]
    #[Validate('string', message: 'Neplatný formát')]
    #[Validate('max:255', message: 'Maximální počet znaků je :max')]
    public string $description = '';

    #[Validate('required', message: 'Vyberte akci')]
    #[Validate('string', message: 'Neplatný formát')]
    #[Validate('max:255', message: 'Maximální počet znaků je :max')]
    public string $action = '';

    public function create()
    {
        $this->validate();

        Slack::create([
            'url' => $this->url,
            'description' => $this->description,
            'action' => $this->action,
        ]);

        $this->reset();
    }
}
