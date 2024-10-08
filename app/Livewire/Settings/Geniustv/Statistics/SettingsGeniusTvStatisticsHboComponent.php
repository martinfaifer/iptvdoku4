<?php

namespace App\Livewire\Settings\GeniusTv\Statistics;

use App\Models\NanguIsp;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class SettingsGeniusTvStatisticsHboComponent extends Component
{
    public Collection $nanguIsps;

    public function mount(): void
    {
        $this->nanguIsps = NanguIsp::get();
    }

    public function render(): \Illuminate\Contracts\View\View|Factory
    {
        return view('livewire.settings.genius-tv.statistics.settings-genius-tv-statistics-hbo-component');
    }
}
