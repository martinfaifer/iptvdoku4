<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use Livewire\Attributes\Validate;
use App\Models\GeniusTvChannelPackage;
use App\Traits\Channels\GetChannelPackagesTrait;

class CreateGeniusTvTvPackageForm extends Form
{

    use GetChannelPackagesTrait;

    #[Validate('required', message: 'Vyplňte název balíčku')]
    #[Validate('string', message: 'Neplatný formát')]
    #[Validate('max:255', message: 'Maximální délka je :max')]
    #[Validate('unique:genius_tv_channel_packages,name', message: 'Balíček již existuje')]
    public string $name = '';

    #[Validate('required')]
    #[Validate('boolean', message: 'Neplatný formát')]
    public bool $is_optional = false;

    public function create(): void
    {
        $this->validate();

        GeniusTvChannelPackage::create([
            'name' => $this->name,
            'is_optional' => $this->is_optional
        ]);

        $this->removeChannelPackagesFromCache();

        $this->reset();
    }
}
