<?php

namespace App\Livewire\Forms;

use App\Models\NanguIsp;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CreateSettingsNanguIspForm extends Form
{
    #[Validate('required', message: 'Vyplňte název poskytovatele')]
    #[Validate('string', message: 'Neplatný formát')]
    #[Validate('max:255', message: 'Maximální počet znaků je :max')]
    #[Validate('unique:nangu_isps,name', message: 'Tento poskytovatel již existuje')]
    public string $name = '';

    #[Validate('required', message: 'Vyplňte nangu isp id')]
    #[Validate('string', message: 'Neplatný formát')]
    #[Validate('max:100', message: 'Maximální počet znaků je :max')]
    #[Validate('unique:nangu_isps,nangu_isp_id', message: 'Toto id již existuje')]
    public string $nangu_isp_id = '';

    #[Validate('required', message: 'Je nebo není akcionář isp alliance?')]
    #[Validate('boolean', message: 'Neplatný formát')]
    public bool $is_akcionar = false;

    #[Validate('nullable')]
    #[Validate('string', message: 'Neplatný formát')]
    #[Validate('max:100', message: 'Maximální počet znaků je :max')]
    #[Validate('unique:nangu_isps,ic', message: 'Toto ič již existuje')]
    public ?string $ic = null;

    #[Validate('nullable')]
    #[Validate('string', message: 'Neplatný formát')]
    #[Validate('max:100', message: 'Maximální počet znaků je :max')]
    #[Validate('unique:nangu_isps,dic', message: 'Toto dič již existuje')]
    public ?string $dic = null;

    #[Validate('nullable')]
    #[Validate('string', message: 'Neplatný formát')]
    #[Validate('max:100', message: 'Maximální počet znaků je :max')]
    #[Validate('unique:nangu_isps,hbo_key', message: 'Tento klíč již existuje')]
    public ?string $hbo_key = null;

    #[Validate('nullable')]
    #[Validate('string', message: 'Neplatný formát')]
    #[Validate('max:255', message: 'Maximální počet znaků je :max')]
    #[Validate('unique:nangu_isps,crm_contract_id', message: 'Tento contract id již existuje')]
    public ?string $crm_contract_id = null;

    public function create()
    {
        $this->validate();

        $nanguIsp = NanguIsp::create([
            'name' => $this->name,
            'nangu_isp_id' => $this->nangu_isp_id,
            'is_akcionar' => $this->is_akcionar,
            'ic' => $this->ic,
            'dic' => $this->dic,
            'hbo_key' => $this->hbo_key,
            'crm_contract_id' => $this->crm_contract_id,
        ]);

        // send notifiction about created new nangu isp only for admins

        $this->reset();

        return $nanguIsp;
    }
}
