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
        <h2>Search Shop</h2>

        <form method="get" action="{{ route('shop.search') }}" class="staff-form">
            <div class="form-group">
                <label for="search">Search:</label>
                <input type="text" id="search" name="search" value="{{ request('search') }}">
            </div>
            <button type="submit" class="btn">Search</button>
        </form>

        @if ($shops->isNotEmpty())
            <h3>Results:</h3>
            <table>
                <thead>
                    <tr>
                        <th>Shop Name</th>
                        <th>Shop Phone</th>
                        <th>Shop Address</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($shops as $shop)
                    <tr>
                        <td>{{ $shop->name }}</td>
                        <td>{{ $shop->phone }}</td>
                        <td>{{ $shop->address }}</td>
                        <td>Edit</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No results found.</p>
        @endif

        {{-- @if(isset($staff))
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
        @endif --}}

    </div>

</body>
</html>
