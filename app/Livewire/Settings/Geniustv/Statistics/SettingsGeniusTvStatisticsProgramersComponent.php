<?php

namespace App\Livewire\Settings\Geniustv\Statistics;

use Livewire\Component;
use App\Models\ChannelProgramer;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Cache;
use App\Exports\ProgrammersUsageExport;

class SettingsGeniusTvStatisticsProgramersComponent extends Component
{

    public function programers_usage(): array|null
    {
        return Cache::get('programmers_usage');
    }

    public function exportToCsv(string $programmerName)
    {
        $programmer = ChannelProgramer::where('name', $programmerName)->first();
        $fileName = $programmerName . '.xlsx';
        return Excel::download(new ProgrammersUsageExport($programmer), $fileName, \Maatwebsite\Excel\Excel::XLSX);
    }

    public function render()
    {
        return view('livewire.settings.genius-tv.statistics.settings-genius-tv-statistics-programers-component', [
            'programmersUsage' => $this->programers_usage()
        ]);
    }
}
