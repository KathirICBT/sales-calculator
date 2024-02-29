<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
</head>
<body>
    @include('includes.header')
    <div class="container">
        <h2>Search Results</h2>
        @isset($sales)
            @if ($sales->count() > 0)
                <table border="1">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Department</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $totalAmount = 0; 
                        @endphp
                        @foreach ($sales as $sale)
                            <tr>
                                <td>{{ $sale->created_at->format('Y-m-d') }}</td>
                                <td>{{ $sale->department->dept_name }}</td>
                                <td>{{ $sale->amount }}</td>
                                
                            </tr>
                            @php
                                $totalAmount += $sale->amount; 
                            @endphp
                        @endforeach
                        <tr>
                            <td colspan="2">Total</td>
                            <td>{{ $totalAmount }}</td>
                        </tr>
                    </tbody>
                </table>
            @else
                <p>No sales found for the specified shop and date.</p>
            @endif
        @endisset
        <a href="{{ route('shopsale.searchForm') }}" class="common-link">Back to Search</a>
    </div>

</body>
</html>
