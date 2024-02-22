<!-- resources/views/departments/search.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Departments</title>
    <style>
        <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    </style>
</head>
<body>

    <h2>Search Departments</h2>

    <form method="get" action="{{ route('departments.search') }}">
        <label for="search">Search by Department Name:</label>
        <input type="text" id="search" name="search" value="{{ request('search') }}" required>

        <button type="submit">Search</button>
    </form>

    @if(isset($departments))
        <h3>Search Results:</h3>
        @if(count($departments) > 0)
            <ul>
                @foreach($departments as $result)
                    <li>{{ $result->dept_name }} (Other Taking: {{ $result->other_taking ? 'Yes' : 'No' }})</li>
                @endforeach
            </ul>
        @else
            <p>No results found.</p>
        @endif
    @endif

</body>
</html>
