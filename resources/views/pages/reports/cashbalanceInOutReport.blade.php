@extends('layouts.layout')
@section('content')
<div class="container-fluid">
    
    <x-content-header title="Cash Balance In/Out Report" />
    <x-alert-message />

    {{-- Report Filter Form --}}
    <div class="row">
        <div class="col-12 col-md-12 d-flex">
            <div class="card flex-fill border-0">
                <div class="card-body p-0 d-flex flex-fill">
                    <div class="row g-0 w-100">
                        <div class="col-12">
                            <div class="p-3 m-1">
                                <h4 class="n_h_style rounded">Cash Balance In/Out</h4>
                                <form class="row g-3" method="POST" action="{{ route('reports.generatecashbalanceReport') }}">
                                    @csrf
                                    <div class="col-md-5 mt-5">
                                        <label for="from_date" class="form-label">From Date:</label>
                                        <input type="date" class="form-control" id="from_date" name="from_date" required>
                                    </div>
                                    <div class="col-md-5 mt-5">
                                        <label for="to_date" class="form-label">To Date:</label>
                                        <input type="date" class="form-control" id="to_date" name="to_date" required>
                                    </div>
                                    <div class="col-md-2 mt-5">
                                        <label for="" class="form-label">Generate Report:</label><br>
                                        <button type="submit" class="btn btn-success rounded-pill" style="width: 100%">Report</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Cash Balance In/Out Report --}}
    @if(isset($from_date) && isset($to_date))
    <div class="card border-0 mt-4">
        <div class="card-header">
            <h5 class="card-title">Cash Balance In/Out Details</h5>
            <h6 class="card-subtitle text-muted">Date Period: {{ $from_date }} to {{ $to_date }}</h6>
        </div>
        <div class="card-body">
            @if(empty($financialTable))
                <div class="alert alert-warning" role="alert">
                    No financial data found for the selected period.
                </div>
            @else
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Cash In </th>
                            <th>Cash Out </th>
                            <th>Total Balance </th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $totalIn = 0;
                            $totalOut = 0;
                            $grandTotal = 0;
                        @endphp

                        @foreach ($financialTable as $row)
                            <tr>
                                <td>{{ $row['date'] }}</td>
                                <td class="{{ $row['type'] == 'In' ? 'positive' : '' }}">
                                    {{ $row['type'] == 'In' ? number_format($row['amount'], 2) : '' }}
                                </td>
                                <td class="{{ $row['type'] == 'Out' ? 'negative' : '' }}">
                                    {{ $row['type'] == 'Out' ? number_format($row['amount'], 2) : '' }}
                                </td>
                                <td>{{ number_format($row['total_cash'], 2) }}</td>
                            </tr>

                            @php
                                if ($row['type'] == 'In') {
                                    $totalIn += $row['amount'];
                                } else {
                                    $totalOut += $row['amount'];
                                }
                                $grandTotal = $row['total_cash'];
                            @endphp
                        @endforeach

                        <!-- Total Row -->
                        <tr class="total-row">
                            <td>Total</td>
                            <td>{{ number_format($totalIn, 2) }}</td>
                            <td>{{ number_format($totalOut, 2) }}</td>
                            <td>{{ number_format($grandTotal, 2) }}</td>
                        </tr>
                    </tbody>
                </table>
            @endif
        </div>        
    </div>  
    @endif
    
</div>
@endsection
