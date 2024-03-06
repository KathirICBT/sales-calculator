<!-- resources/views/sales/search.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Search</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
    @include('includes.header')
    <div class="container">
        <h2>Sales Search</h2>
        <!-- Search Form -->
        <form method="get" action="{{ route('sales.search') }}">
            <div class="form-group">
                <label for="keyword">Keyword:</label>
                <input type="text" id="keyword" name="keyword" required>
            </div>
            <button type="submit" class="modify-button">Search</button>
        </form>

        <!-- Search Results -->
        @if(isset($sales))
            <h3>Search Results</h3>
            <table>
                <thead>
                    <tr>
                    <th>Department ID</th>
                    <th>Department Name</th>
                    <th>Staff ID</th>
                    <th>Staff Name</th>
                    <th>Shop ID</th>
                    <th>Shop Name</th>
                    <th>Amount</th>

                    </tr>
                </thead>
                <tbody>
                @foreach($sales as $sale)
                <tr>
                    <td>{{ $sale->dept_id }}</td>
                    <td>{{ $sale->dept_name }}</td>
                    <td>{{ $sale->staff_id }}</td>
                    <td>{{ $sale->staff_name }}</td>
                    <td>{{ $sale->shop_id }}</td>
                    <td>{{ $sale->shop_name }}</td>
                    <td>{{ $sale->amount }}</td>
                </tr>
                @endforeach
            </tbody>
            </table>
        @endif
        
        <button type="button" class="modify-button" onclick="window.location.href='{{ route('sales.index') }}'">Back</button>
    </div>
    
</body>
</html>
