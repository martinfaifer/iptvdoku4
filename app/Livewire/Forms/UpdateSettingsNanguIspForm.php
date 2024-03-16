<?php

namespace App\Livewire\Forms;

use App\Models\NanguIsp;
use Livewire\Attributes\Validate;
use Livewire\Form;

class UpdateSettingsNanguIspForm extends Form
{
    public ?NanguIsp $nanguIsp;

    public string $name = "";

    public string $nangu_isp_id = "";

    #[Validate('required', message: "Je nebo není akcionář isp alliance?")]
    #[Validate('boolean', message: "Neplatný formát")]
    public bool $is_akcionar = false;

    #[Validate('nullable')]
    #[Validate('string', message: "Neplatný formát")]
    #[Validate('max:100', message: "Maximální počet znaků je :max")]
    #[Validate('unique:nangu_isps,ic', message: "Toto ič již existuje")]
    public string|null $ic = null;

    #[Validate('nullable')]
    #[Validate('string', message: "Neplatný formát")]
    #[Validate('max:100', message: "Maximální počet znaků je :max")]
    #[Validate('unique:nangu_isps,dic', message: "Toto dič již existuje")]
    public string|null $dic = null;

    #[Validate('nullable')]
    #[Validate('string', message: "Neplatný formát")]
    #[Validate('max:100', message: "Maximální počet znaků je :max")]
    #[Validate('unique:nangu_isps,hbo_key', message: "Tento klíč již existuje")]
    public string|null $hbo_key = null;

    #[Validate('nullable')]
    #[Validate('string', message: "Neplatný formát")]
    #[Validate('max:255', message: "Maximální počet znaků je :max")]
    #[Validate('unique:nangu_isps,crm_contract_id', message: "Tento contract id již existuje")]
    public string|null $crm_contract_id = null;


    public function setNanguIsp($nanguIsp)
    {
        $this->nanguIsp = $nanguIsp;
        $this->name = $nanguIsp->name;
        $this->nangu_isp_id = $nanguIsp->nangu_isp_id;
        $this->is_akcionar = $nanguIsp->is_akcionar;
        $this->ic = $nanguIsp->ic;
        $this->dic = $nanguIsp->dic;
        $this->hbo_key = $nanguIsp->hbo_key;
        $this->crm_contract_id = $nanguIsp->crm_contract_id;
    }

    public function update()
    {
        $this->nanguIsp->update([
            'is_akcionar' => $this->is_akcionar,
            'ic' => $this->ic,
            'dic' => $this->dic,
            'hbo_key' => $this->hbo_key,
            'crm_contract_id' => $this->crm_contract_id
        ]);

        return $this->reset();
    }
}
