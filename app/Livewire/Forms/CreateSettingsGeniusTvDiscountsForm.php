<?php

namespace App\Livewire\Forms;

use App\Models\GeniusTvDiscount;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CreateSettingsGeniusTvDiscountsForm extends Form
{
    #[Validate('required', message: 'Vyberte poskytovatele služeb')]
    #[Validate('exists:nangu_isps,id', message: 'Neexistující poskytovatel')]
    public string $nangu_isp_id = '';

    #[Validate('required', message: 'Vyplňte slevu')]
    #[Validate('string', message: 'Neplatný formát')]
    #[Validate('max:10', message: 'Maximální počet znaků je :max')]
    public string $discount = '';

    public function create(): void
    {
        $this->validate();

        GeniusTvDiscount::create([
            'nangu_isp_id' => $this->nangu_isp_id,
            'discount' => $this->discount,
        ]);

        $this->reset();
    }
}
