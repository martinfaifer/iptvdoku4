<table class="table">
    <!-- head -->
    <thead>
        <tr>

        </tr>
    </thead>
    <tbody>
        @foreach ($programerUsage as $channel => $channelUsage)
            <tr>
                <th>{{ $channel }}</th>
                @foreach ($channelUsage as $isp => $usage)
                    <td>{{ $isp }}</td>
                    <td>{{ $usage }}</td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>
