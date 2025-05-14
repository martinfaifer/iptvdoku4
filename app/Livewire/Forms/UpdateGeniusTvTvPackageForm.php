<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use Livewire\Attributes\Validate;
use App\Models\GeniusTvChannelPackage;
use App\Traits\Channels\GetChannelPackagesTrait;

class UpdateGeniusTvTvPackageForm extends Form
{
    use GetChannelPackagesTrait;

    public ?GeniusTvChannelPackage $tvPackage;

    #[Validate('required', message: 'Vyplňte název balíčku')]
    #[Validate('required', message: 'Vyplňte název balíčku')]
    #[Validate('string', message: 'Neplatný formát')]
    #[Validate('max:255', message: 'Maximální délka je :max')]
    // #[Validate('unique:genius_tv_channel_packages,name', message: 'Balíček již existuje')]
    public string $name = '';

    #[Validate('required')]
    #[Validate('boolean', message: 'Neplatný formát')]
    public bool $is_optional = false;

    public function setTvPackage(GeniusTvChannelPackage $tvPackage): void
    {
        $this->tvPackage = $tvPackage;
        $this->name = $tvPackage->name;
        $this->is_optional = $tvPackage->is_optional;
    }

    public function update(): void
    {
        $this->validate();

        $this->tvPackage->update([
            'name' => $this->name,
            'is_optional' => $this->is_optional
        ]);

        $this->removeChannelPackagesFromCache();

        $this->reset();
    }
}
