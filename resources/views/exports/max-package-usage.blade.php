<table class="table">
    <!-- head -->
    <thead>
        <tr>

        </tr>
    </thead>
    <tbody>
        @foreach ($usage as $use)
        <tr>
            <th>{{ $use['isp'] }}</th>
            <td>{{ $use['usage'] }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
