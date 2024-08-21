<?php

namespace App\Livewire\Charts;

use Illuminate\Contracts\View\Factory;
use Livewire\Component;

class LineChartComponent extends Component
{
    public array $chart = [
        'type' => 'line',
        'data' => [
            'labels' => null,
            'datasets' => [
                [
                    'label' => 'bitrate',
                    'data' => null,
                ],
            ],
        ],
    ];

    public function mount(array $xaxis, array $yaxis, string $label): void
    {
        $this->chart['data']['labels'] = $xaxis;

        if (isset($yaxis[0]['data'])) {
            $this->chart['data']['datasets'][0]['data'] = $yaxis[0]['data'];
        } else {
            $this->chart['data']['datasets'][0]['data'] = $yaxis;
        }

        $this->chart['data']['datasets'][0]['label'] = $label;
    }

    public function render(): \Illuminate\Contracts\View\View|Factory
    {
        return view('livewire.charts.line-chart-component');
    }
}
