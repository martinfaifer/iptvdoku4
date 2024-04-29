<?php
namespace App\Livewire\Settings\GeniusTv\Statistics;

use App\Models\NanguIsp;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class SettingsGeniusTvStatisticsHboComponent extends Component
{
    public Collection $nanguIsps;

    public function mount()
    {
        $this->nanguIsps = NanguIsp::get();
    }

    public function render()
    {
        return view('livewire.settings.genius-tv.statistics.settings-genius-tv-statistics-hbo-component');
    }
}
