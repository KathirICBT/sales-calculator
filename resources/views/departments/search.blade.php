<!-- resources/views/departments/search.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Departments</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>

@include('includes.header')
    <div class="container">
        <h2>Search Departments</h2>

        <form method="get" action="{{ route('departments.search') }}" class="department-form">
            <div class="form-group">
                <label for="search">Search by Department Name:</label>
                <input type="text" id="search" name="search" value="{{ request('search') }}" required>
            </div>
            <button type="submit" class="btn">Search</button>
        </form>

        @if(isset($departments))
            <h3>Results:</h3>
            @if(count($departments) > 0)
                <table>
                    <thead>
                        <tr>
                            <th>Department Name</th>
                            <th>Other Taking</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($departments as $result)
                            <tr>
                                <td>{{ $result->dept_name }}</td>
                                <td>{{ $result->other_taking ? 'Yes' : 'No' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>No results found.</p>
            @endif
        @endif
    </div>

</body>
</html>
