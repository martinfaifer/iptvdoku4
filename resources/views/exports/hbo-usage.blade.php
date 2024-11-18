<table class="table">
    <!-- head -->
    <thead>
        <tr>

        </tr>
    </thead>
    <tbody>
        @foreach ($usage as $isp => $use)
            <tr>
                <th>{{ $isp }}</th>
                <td>{{ $use }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
