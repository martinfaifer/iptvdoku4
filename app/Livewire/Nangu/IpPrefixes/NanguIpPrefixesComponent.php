<?php

namespace App\Livewire\Nangu\IpPrefixes;

use App\Models\Ip;
use Illuminate\Contracts\View\Factory;
use Livewire\Component;

class NanguIpPrefixesComponent extends Component
{
    public ?Ip $prefix;

    public function mount(Ip $ipPrefix): void
    {
        $this->prefix = $ipPrefix;
    }

    public function render(): \Illuminate\Contracts\View\View|Factory
    {
        return view('livewire.nangu.ip-prefixes.nangu-ip-prefixes-component');
    }
}
