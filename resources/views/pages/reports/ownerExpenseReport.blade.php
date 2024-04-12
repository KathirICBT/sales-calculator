@extends('layouts.layout')

@section('content')
<div class="container-fluid">
    <div class="mb-3">
        <h4>Owner Expense Report</h4>
    </div>
    <div class="row">
        <div class="col-12 col-md-6 d-flex">
            <div class="card flex-fill border-0 illustration">
                <div class="card-body p-0 d-flex flex-fill">
                    <div class="row g-0 w-100">
                        <div class="col-6">
                            <div class="p-3 m-1">
                                <h4>Welcome, {{ session('username') }}</h4>
                                <p class="mb-0">Owner Expense Report</p>
                            </div>
                        </div>
                        <div class="col-6 align-self-end text-end">
                            <img src="{{ asset('image/customer-support.jpg') }}" class="img-fluid illustration-img" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 d-flex">
            <div class="card flex-fill border-0">
                <div class="card-body py-4">
                    <div class="d-flex align-items-start">
                        <div class="flex-grow-1">
                            <p class="mb-2">Total Shops</p>
                            <h4 class="mb-2">Total Shop Count</h4>
                            <div class="mb-0">
                                <span class="text-muted">Owner:</span>
                                <span class="mb-2">Mr. Tharsan</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Report Form Section -->
    

    <div class="row">
        <div class="col-12 col-md-12 d-flex">
            <div class="card flex-fill border-0">
                <div class="card-body p-0 d-flex flex-fill">
                    <div class="row g-0 w-100">
                        <div class="col-12">
                            <div class="p-3 m-1">                                                
                                <h4 class="n_h_style rounded">Owner Expense Report</h4>
                                <form method="POST" action="{{ route('reports.ownerexpense') }}">
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
                                        
                                        <div class="col-md-12 mt-3">
                                            <button type="submit" class="btn btn-success">Generate Report</button>
                                        </div>
                                    </div>
                                </form>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>        
    </div>
    <!-- Report Table Section -->
    @if(isset($shopTotalsByDate))
        <div class="card border-0 mt-4">
            
            <div class="card-body">
                <div class="mb-3">
                    <h4>Payment Report</h4>
                    <p>Date Period: {{ $from_date }} to {{ $to_date }}</p>
                </div>
            
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
            </div>
        </div>
    @endif
</div>
@endsection
