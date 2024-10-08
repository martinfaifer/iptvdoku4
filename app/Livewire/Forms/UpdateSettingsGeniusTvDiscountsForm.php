<?php

namespace App\Livewire\Forms;

use App\Models\GeniusTvDiscount;
use Livewire\Attributes\Validate;
use Livewire\Form;

class UpdateSettingsGeniusTvDiscountsForm extends Form
{
    public ?GeniusTvDiscount $geniusTvDiscount;

    #[Validate('required', message: 'Vyberte poskytovatele služeb')]
    #[Validate('exists:nangu_isps,id', message: 'Neexistující poskytovatel')]
    public string|int $nangu_isp_id = '';

    #[Validate('required', message: 'Vyplňte slevu')]
    #[Validate('string', message: 'Neplatný formát')]
    #[Validate('max:10', message: 'Maximální počet znaků je :max')]
    public string|float $discount = '';

    public function setGeniusTvDiscount(GeniusTvDiscount $geniusTvDiscount): void
    {
        $this->geniusTvDiscount = $geniusTvDiscount;
        $this->nangu_isp_id = $geniusTvDiscount->nangu_isp_id;
        $this->discount = $geniusTvDiscount->discount;
    }

    public function update(): void
    {
        $this->validate();

        $this->geniusTvDiscount->update([
            'discount' => $this->discount,
        ]);

        $this->reset();
    }
}
