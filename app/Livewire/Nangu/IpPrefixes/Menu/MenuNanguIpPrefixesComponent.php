<?php

namespace App\Livewire\Nangu\IpPrefixes\Menu;

use App\Models\NanguIsp;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\On;
use Livewire\Component;

class MenuNanguIpPrefixesComponent extends Component
{
    public Collection $ispsWithIpPrefixes;

    public function mount()
    {
        $this->loadIspsWithIpPrefixes();
    }

    #[On('refresh_isps_with_ip_prefixes')]
    public function loadIspsWithIpPrefixes()
    {
        if (! Cache::has('nangu_ip_prefixes_menu')) {
            Cache::forever('nangu_ip_prefixes_menu', NanguIsp::with('ipprefixes')->get());
        }
        $this->ispsWithIpPrefixes = Cache::get('nangu_ip_prefixes_menu');
    }

    public function render()
    {
        return view('livewire.nangu.ip-prefixes.menu.menu-nangu-ip-prefixes-component');
    }
}
