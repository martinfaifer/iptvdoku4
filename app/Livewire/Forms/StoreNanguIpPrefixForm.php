<?php

namespace App\Livewire\Forms;

use App\Models\Ip;
use Livewire\Attributes\Validate;
use Livewire\Form;

class StoreNanguIpPrefixForm extends Form
{
    #[Validate('required', message: "Vyplňte pole")]
    #[Validate('max:18', message: "Maximální délka je :max")]
    #[Validate('ipv4', message: "Neplatný formát")]
    public string $ip_address = "";

    #[Validate('required', message: "Vyplňte pole")]
    #[Validate('exists:nangu_isps,id', message: "Neexistující ISP")]
    public string $nangu_isp_id = "";

    #[Validate('required', message: "Vyplňte pole")]
    public $cidr;

    public function create()
    {
        $this->validate();
        $ip = Ip::create([
            'ip_address' => $this->ip_address,
            'cidr' => $this->cidr,
            'nangu_isp_id' => $this->nangu_isp_id,
            'ip_cidr_hash' => md5($this->ip_address . '/' . $this->cidr),
        ]);

        return $ip;
    }
}
