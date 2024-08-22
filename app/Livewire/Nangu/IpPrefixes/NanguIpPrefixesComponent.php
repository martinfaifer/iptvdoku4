<?php

namespace App\Livewire\Nangu\IpPrefixes;

use App\Models\Ip;
use Illuminate\Contracts\View\Factory;
use Livewire\Component;

class NanguIpPrefixesComponent extends Component
{
    public mixed $prefix = null;

    public function mount(mixed $ipPrefix = null): void
    {
        if (!blank($ipPrefix)) {
            if (!$ipPrefixModel = Ip::where('id', $ipPrefix)->first()) {
                $this->redirect('/prefixes', true);
            } else {
                $this->prefix = $ipPrefixModel;
            }
        } else {
            $this->prefix = $ipPrefix;
        }
    }

    public function render(): \Illuminate\Contracts\View\View|Factory
    {
        return view('livewire.nangu.ip-prefixes.nangu-ip-prefixes-component');
    }
}
