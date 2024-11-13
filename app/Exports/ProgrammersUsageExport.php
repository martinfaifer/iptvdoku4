<?php

namespace App\Exports;

use App\Models\NanguIsp;
use App\Models\NanguSubscription;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ProgrammersUsageExport implements FromView
{
    public function __construct(public object $programer) {}

    public function programer_usage(): array
    {
        $result = [];
        $isps = NanguIsp::get();

        if (!blank($this->programer->channels)) {
            foreach ($this->programer->channels as $channel) {
                $result[$channel->name]['celkem'] = NanguSubscription::where('channels', "like", "%" . $channel->nangu_channel_code . "%")->count();
                foreach ($isps as $isp) {
                    if (NanguSubscription::where('nangu_isp_id', $isp->id)->where('channels', "like", "%" . $channel->nangu_channel_code . "%")->count() != 0) {
                        $result[$channel->name][$isp->name] = NanguSubscription::where('nangu_isp_id', $isp->id)->where('channels', "like", "%" . $channel->nangu_channel_code . "%")->count();
                    }
                }
            }
        }

        return $result;
    }

    public function view(): View
    {
        return view('exports.programers-usage', [
            'programerUsage' => $this->programer_usage()
        ]);
    }
}
