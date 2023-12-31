<!-- resources/views/planets/index.blade.php -->


    <form action="{{ route('planets.index') }}" method="GET">
        <input type="text" name="diameter" placeholder="Diameter" value="{{ request('diameter') }}">
        <input type="text" name="rotation_period" placeholder="Rotation Period" value="{{ request('rotation_period') }}">
        <input type="text" name="gravity" placeholder="Gravity" value="{{ request('gravity') }}">
        <button type="submit">Filter</button>
    </form>

    <table>
        <thead>
        <tr>
            <th>Name</th>
            <th>Diameter</th>
            <th>Rotation Period</th>
            <th>Gravity</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($planets as $planet)
            <tr>
                <td>{{ $planet->name }}</td>
                <td>{{ $planet->diameter }}</td>
                <td>{{ $planet->rotation_period }}</td>
                <td>{{ $planet->gravity }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $planets->links() }} <!-- Pagination links -->
