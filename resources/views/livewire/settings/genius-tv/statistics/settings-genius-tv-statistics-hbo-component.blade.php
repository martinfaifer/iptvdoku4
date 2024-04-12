<div>
    <div class="grid grid-cols-12 gap-4">
        @foreach ($nanguIsps as $nanguIsp)
            @php
                $hboGoChartData = App\Models\GeniusTvChart::where('item', 'hbogo')
                    ->where('nangu_isp_id', $nanguIsp->id)
                    ->orderBy('created_at', 'DESC')
                    ->get();

                $labels = [];
                $data = [];

                foreach ($hboGoChartData as $chartData) {
                    array_push($labels, $chartData->created_at->format('d.m. Y'));
                    array_push($data, (int) $chartData->value);
                }
            @endphp
            <div class="col-span-4">
                <livewire:charts.line-chart-component :xaxis="$labels" :yaxis="$data"
                    :label="$nanguIsp->name"></livewire:charts.line-chart-component>
            </div>
        @endforeach
    </div>

</div>
