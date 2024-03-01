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
                            <th>Staff</th>
                            <th>Department</th>
                            <th>Payment method</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $totalAmount = 0; 
                        @endphp
                        <tr ><th colspan="5">Normal</th></tr>
                        @foreach ($sales as $sale)
                            @if(!($sale->department->other_taking))
                                <tr>
                                    <td>{{ $sale->created_at->format('Y-m-d') }}</td>
                                    <td>{{ $sale->staff->staff_name }}</td>
                                    <td>{{ $sale->department->dept_name }}</td>
                                    <td>{{ $sale->payment_method }}</td>
                                    <td>{{ $sale->amount }}</td>
                                    
                                </tr>
                                @php
                                    $totalAmount += $sale->amount; 
                                @endphp
                            @endif
                        @endforeach
                        <tr><th colspan="5">Other Taking</th></tr>
                        @foreach ($sales as $sale)
                            @if($sale->department->other_taking)
                                <tr>
                                    <td>{{ $sale->created_at->format('Y-m-d') }}</td>
                                    <td>{{ $sale->staff->staff_name }}</td>
                                    <td>{{ $sale->department->dept_name }}</td>
                                    <td>{{ $sale->payment_method }}</td>
                                    <td>{{ $sale->amount }}</td>
                                    
                                </tr>
                                @php
                                    $totalAmount += $sale->amount; 
                                @endphp
                            @endif
                        @endforeach
                        <tr>
                            <th colspan="4">Total</th>
                            <th>{{ $totalAmount }}</th>
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
