<?php

namespace App\Livewire\Forms;

use App\Models\GeniusTvChannelPackage;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CreateGeniusTvTvPackageForm extends Form
{
    #[Validate('required', message: 'Vyplňte název balíčku')]
    #[Validate('string', message: 'Neplatný formát')]
    #[Validate('max:255', message: 'Maximální délka je :max')]
    #[Validate('unique:genius_tv_channel_packages,name', message: 'Balíček již existuje')]
    public string $name = '';

    public function create(): void
    {
        $this->validate();

        GeniusTvChannelPackage::create([
            'name' => $this->name,
        ]);

        $this->reset();
    }
}
