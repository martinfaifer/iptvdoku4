<?php

namespace App\Livewire\Forms;

use App\Models\GeniusTvChannelPackage;
use Livewire\Attributes\Validate;
use Livewire\Form;

class UpdateGeniusTvTvPackageForm extends Form
{
    public ?GeniusTvChannelPackage $tvPackage;

    #[Validate('required', message: 'Vyplňte název balíčku')]
    #[Validate('required', message: 'Vyplňte název balíčku')]
    #[Validate('string', message: 'Neplatný formát')]
    #[Validate('max:255', message: 'Maximální délka je :max')]
    #[Validate('unique:genius_tv_channel_packages,name', message: 'Balíček již existuje')]
    public string $name = '';

    public function setTvPackage(GeniusTvChannelPackage $tvPackage)
    {
        $this->tvPackage = $tvPackage;
        $this->name = $tvPackage->name;
    }

    public function update()
    {
        $this->validate();

        $this->tvPackage->update([
            'name' => $this->name,
        ]);

        $this->reset();
    }
}
