<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Models\ChannelProgramer;
use Livewire\Attributes\Validate;
use App\Traits\Channels\ChannelProgramerTrait;

class CreateChannelProgrammerForm extends Form
{
    use ChannelProgramerTrait;

    #[Validate('required', message: "Vyplňte jméno")]
    #[Validate('string', message: "Neplatná formát")]
    #[Validate('max:255', message: "Maximální počet znaků je :max")]
    #[Validate('unique:channel_programers,name', message: "Tento programmer již existuje")]
    public string $name = "";

    public function create(): void
    {
        $this->validate();

        ChannelProgramer::create([
            'name' => $this->name
        ]);

        $this->removeCachedChannelProgramers();
    }
}
