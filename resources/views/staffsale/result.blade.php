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
                            <th colspan="4">Date: {{ $sales[0]->created_at->format('Y-m-d') }} <br> <br>Staff:{{ $sales[0]->staff->staff_name }}</th>
                        </tr>
                        <tr>
                            <th>Departrment</th>
                            <th>Amount</th>
                        </tr>
                        <tr>
                            <th colspan="2">Normal</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        @php
                            $totalAmount = 0; 
                        @endphp
                        @foreach ($sales as $sale)
                            @if(!($sale->department->other_taking))
                                <tr>
                                    <td>{{ $sale->department->dept_name }}</td>
                                    <td>{{ $sale->amount }}</td>
                                </tr>
                                @php
                                    $totalAmount += $sale->amount;
                                @endphp
                            @endif
                        @endforeach
                        <tr>
                            <th colspan="2">Other Taking</th>
                        </tr>
                        <tr>
                            @foreach ($sales as $sale)
                                @if($sale->department->other_taking)
                                    <tr>
                                        <td>{{ $sale->department->dept_name }}</td>
                                        <td>{{ $sale->amount }}</td>
                                    </tr>
                                    @php
                                        $totalAmount += $sale->amount;
                                    @endphp
                                @endif
                            @endforeach
                        </tr>
                        <tr>
                            <th>Total amount:</th>
                            <th>{{ $totalAmount }}</th>
                        </tr>
                        
                    </tbody>
                </table>
            @else
                <p>No sales found for the specified staff and date.</p>
            @endif
        @endisset
        <a href="{{ route('staffsale.searchForm') }}" class="common-link">Back to Search</a>
    </div>
</body>
</html>
