<!-- resources/views/shifts/search.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shift Search</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
    @include('includes.header')
    <div class="container">
        <h2>Shift Search</h2>
        <!-- Search Form -->
        <form method="get" action="{{ route('shifts.search') }}">
            <div class="form-group">
                <label for="keyword">Keyword:</label>
                <input type="text" id="keyword" name="keyword" required>
            </div>
            <button type="submit" class="modify-button">Search</button>
        </form>

        <!-- Search Results -->
        @if(isset($shifts))
            <h3>Search Results</h3>
            <table>
                <thead>
                    <tr>
                        <th>Shop</th>
                        <th>Staff</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($shifts as $shift)
                        <tr>
                            <td>{{ $shift->shop->name }}</td>
                            <td>{{ $shift->staff->staff_name }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
        
        <button type="button" class="modify-button" onclick="window.location.href='{{ route('shifts.index') }}'">Back</button>
    </div>
</body>
</html>
