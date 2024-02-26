<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Cache;

class Navbar extends Component
{
    public function render()
    {
        return view('livewire.navbar', [
            'iptv_dohled_alerts' => Cache::get('iptv_dohled_alerts')
        ]);
    }
}
