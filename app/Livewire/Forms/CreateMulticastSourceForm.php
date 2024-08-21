<?php

namespace App\Livewire\Forms;

use App\Models\ChannelSource;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CreateMulticastSourceForm extends Form
{
    #[Validate('required', message: 'Vyplňte zdroj')]
    #[Validate('unique:channel_sources,name', message: 'Již existuje')]
    #[Validate('string', message: "Neplatný formát")]
    #[Validate('max:100', message: "Maximální počet znaků je :max")]
    public string $source = "";

    public function create(): void
    {
        $this->validate();

        ChannelSource::create([
            'name' => $this->source,
        ]);

        $this->reset();
    }
}
