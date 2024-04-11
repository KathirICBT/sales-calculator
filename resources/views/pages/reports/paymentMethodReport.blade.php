@extends('layouts.layout')

@section('content')
<div class="container-fluid">
    <div class="mb-3">
        <h4>Payment Report</h4>
    </div>

    <div class="card border-0">
        <div class="card-body">
            <form method="POST" action="{{ route('reports.generatePayment') }}">
                @csrf
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="from_date" class="form-label">From Date:</label>
                        <input type="date" class="form-control" id="from_date" name="from_date" required>
                    </div>
                    <div class="col-md-4">
                        <label for="to_date" class="form-label">To Date:</label>
                        <input type="date" class="form-control" id="to_date" name="to_date" required>
                    </div>
                    <div class="col-md-4">
                        <label for="payment_method_id" class="form-label">Payment Method:</label>
                        <select class="form-control" id="payment_method_id" name="payment_method_id" required>
                            @foreach($paymentMethods as $method)
                                <option value="{{ $method->id }}">{{ $method->payment_method }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-12 mt-3">
                        <button type="submit" class="btn btn-success">Generate Report</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if(isset($paymentSales))
        <div class="card border-0 mt-4">
            <div class="card-header">
                <h5 class="card-title">Payment Report</h5>
                <h6 class="card-subtitle text-muted">Date Period: {{ $from_date }} to {{ $to_date }}</h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <h4>Payment Report</h4>
                    <p>Date Period: {{ $from_date }} to {{ $to_date }}</p>
                </div>
            
                @if (!empty($shopTotalsByDate))
                    <div class="card border-0">
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        @foreach($shops as $shop)
                                            <th>{{ $shop->name }}</th>
                                        @endforeach
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($shopTotalsByDate as $date => $shopTotals)
                                        <tr>
                                            <td>{{ $date }}</td>
                                            @php $total = 0; @endphp
                                            @foreach($shops as $shop)
                                                <td>
                                                    @if(isset($shopTotals[$shop->id]))
                                                        {{ number_format($shopTotals[$shop->id], 2) }}
                                                        @php $total += $shopTotals[$shop->id]; @endphp
                                                    @else
                                                        0.00
                                                    @endif
                                                </td>
                                            @endforeach
                                            <td>{{ number_format($total, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @else
                    <p>No data available for the selected date range.</p>
                @endif
            </div>
        </div>
    @endif
</div>
@endsection
