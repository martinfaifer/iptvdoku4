<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use Livewire\Attributes\Validate;
use App\Models\GeniusTvChannelPackage;

class CreateGeniusTvTvPackageForm extends Form
{
    #[Validate('required', message: "Vyplňte název balíčku")]
    #[Validate('string', message: "Neplatný formát")]
    #[Validate('max:255', message: "Maximální délka je :max")]
    #[Validate('unique:genius_tv_channel_packages,name', message: "Balíček již existuje")]
    public string $name = "";

    public function create()
    {
        $this->validate();

        GeniusTvChannelPackage::create([
            'name' => $this->name,
        ]);

        $this->reset();
    }
}
