<?php

namespace App\Livewire\Nangu\IpPrefixes;

use App\Models\Ip;
use Livewire\Component;

class NanguIpPrefixesComponent extends Component
{

    public ?Ip $prefix;

    public function mount(Ip $ipPrefix)
    {
        $this->prefix = $ipPrefix;
    }

    public function render()
    {
        return view('livewire.nangu.ip-prefixes.nangu-ip-prefixes-component');
    }
}
