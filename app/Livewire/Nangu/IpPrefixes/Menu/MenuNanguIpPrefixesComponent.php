<?php

namespace App\Livewire\Nangu\IpPrefixes\Menu;

use Livewire\Component;
use App\Models\NanguIsp;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Cache;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Collection;

class MenuNanguIpPrefixesComponent extends Component
{
    public Collection $ispsWithIpPrefixes;

    public function mount(): void
    {
        $this->loadIspsWithIpPrefixes();
    }

    #[On('refresh_isps_with_ip_prefixes')]
    public function loadIspsWithIpPrefixes(): void
    {
        if (! Cache::has('nangu_ip_prefixes_menu')) {
            Cache::forever('nangu_ip_prefixes_menu', NanguIsp::with('ipprefixes')->get());
        }
        $this->ispsWithIpPrefixes = Cache::get('nangu_ip_prefixes_menu');
    }

    public function render(): \Illuminate\Contracts\View\View|Factory
    {
        return view('livewire.nangu.ip-prefixes.menu.menu-nangu-ip-prefixes-component');
    }
}
