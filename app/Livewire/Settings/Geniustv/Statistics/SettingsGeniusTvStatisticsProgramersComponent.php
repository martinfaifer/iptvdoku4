<?php

namespace App\Livewire\Settings\Geniustv\Statistics;

use Livewire\Component;
use App\Models\ChannelProgramer;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Cache;
use App\Exports\ProgrammersUsageExport;

class SettingsGeniusTvStatisticsProgramersComponent extends Component
{

    public function programers_usage(): array
    {
        return Cache::get('programmers_usage');
    }

    public function exportToCsv(string $programmerName)
    {
        $programmer = ChannelProgramer::where('name', $programmerName)->first();
        $fileName = $programmerName . '.csv';
        return Excel::download(new ProgrammersUsageExport($programmer), $fileName);
    }

    public function render()
    {
        return view('livewire.settings.genius-tv.statistics.settings-genius-tv-statistics-programers-component', [
            'programmersUsage' => $this->programers_usage()
        ]);
    }
}
