<?php

namespace App\Livewire\Forms;

use App\Models\ChannelQuality;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CreateSettingsChannelsQualitiesForm extends Form
{
    #[Validate('required', message: "Vyplňte pole")]
    #[Validate('string', message: "Neplatný formát")]
    #[Validate('max:12', message: "Maximální počet znaků je :max")]
    public string $name = "";

    #[Validate('required', message: "Vyplňte pole")]
    #[Validate('string', message: "Neplatný formát")]
    #[Validate('max:12', message: "Maximální počet znaků je :max")]
    public string $format = "";

    #[Validate('nullable')]
    #[Validate('max:60', message: "Maximální počet znaků je :max")]
    public ?int $bitrate = null;

    public function submit(): void
    {
        $validated = $this->validate();
        ChannelQuality::create([
            'name' => $validated['name'],
            'format' => $validated['format'],
            'bitrate' => $validated['bitrate']
        ]);
    }
}
