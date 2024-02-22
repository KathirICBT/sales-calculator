<!-- resources/views/staff/search.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Staff</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>

@include('includes.header')
    <div class="container">
        <h2>Search Staff</h2>

        <form method="get" action="{{ route('staff.search') }}" class="staff-form">
            <div class="form-group">
                <label for="search">Search by Staff Name or Phone Number:</label>
                <input type="text" id="search" name="search" value="{{ request('search') }}" required>
            </div>
            <button type="submit" class="btn">Search</button>
        </form>

        @if(isset($staff))
            <h3>Results:</h3>
            @if(count($staff) > 0)
                <table>
                    <thead>
                        <tr>
                            <th>Staff Name</th>
                            <th>Phone Number</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($staff as $result)
                            <tr>
                                <td>{{ $result->staff_name }}</td>
                                <td>{{ $result->phonenumber }}</td>
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
