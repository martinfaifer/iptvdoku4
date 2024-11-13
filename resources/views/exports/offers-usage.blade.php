<table class="table">
    <!-- head -->
    <thead>
        <tr>

        </tr>
    </thead>
    <tbody>
        @foreach ($offersUsage as $key => $offerUsage)
            <tr>
                <th>{{ $key }}</th>
                @foreach ($offersUsage[$key] as $offerName => $usage)
                    <td>{{ $offerName }}</td>
                    <td>{{ $usage }}</td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>
