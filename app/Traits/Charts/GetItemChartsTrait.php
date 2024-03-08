<?php

namespace App\Traits\Charts;

use App\Models\Chart;

trait GetItemChartsTrait
{
    public function get_charts(string $item, bool $useDisctinct = false, string $chartType = "line")
    {
        $charts = [];
        // select unique items
        if ($useDisctinct == true) {
            $chartUniqueItems = Chart::itemCharts($item)->take('100')->distinct()->get('item');
            foreach ($chartUniqueItems as $uniqueItem) {
                $charts[$uniqueItem->item][] = $this->createAxis(
                    chartsData: Chart::specificItemCharts($uniqueItem->item)->get(),
                    chartType: $chartType
                );
            }

            return $charts;
        }

        return $this->createAxis(chartsData: Chart::specificItemCharts($item)->get(), chartType: $chartType);
    }

    public function createAxis($chartsData, string $chartType = "line"): array
    {
        $labels = [];
        $data = [];

        foreach ($chartsData as $chartData) {
            array_push($labels, $chartData->created_at->format('H:i , d.m. Y'));
            array_push($data, (int) $chartData->value);
        }

        return [
            'xaxis' => $labels,
            'yaxis' => $data
        ];
    }
}
