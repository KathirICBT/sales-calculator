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
        {{-- <div class="card-header">
            <h5 class="card-title">Cash Balance In/Out Details</h5>
            <h6 class="card-subtitle text-muted">Date Period: {{ $from_date }} to {{ $to_date }}</h6>
        </div> --}}
        <div class="py-4 text-center" style="background-color: #e3f2fd; border-radius: 7px; color: #1e88e5;">
            <h4 
                class="fw-bold mb-2" 
                style="font-size: 2rem; color: #1565c0; line-height: 1.2;">
                Cash Balance In and Out Details
            </h4>
            <p class="mb-2" style="font-size: 1rem; color: #1e88e5; line-height: 1.2;">
                <i class="bi bi-calendar-event" style="color: #42a5f5;"></i> 
                Date Period: 
                <span class="fw-semibold" style="color: #43a047;">{{ $from_date }}</span> to 
                <span class="fw-semibold" style="color: #1e88e5;">{{ $to_date }}</span>
            </p>
            <div class="d-flex justify-content-center">
                <hr class="mt-2" style="width: 80px; height: 3px; border-radius: 2px; background: #1565c0; margin: 0;">
            </div>
        </div>        
        
        <div class="card-body">
            @if(empty($financialTable))
                <div class="alert alert-warning" role="alert">
                    No financial data found for the selected period.
                </div>
            @else

                <div class="container-fluid">                    

                    <div class="row g-3">
                        <!-- Previous Running Total -->
                        <div class="col-md-4">
                            <div class="card shadow-sm border-0" style="background: linear-gradient(135deg, #e6ffe6, #ccf5cc);">
                                <div class="card-body text-center">
                                    <div class="mb-2">
                                        <i class="bi bi-arrow-left-circle text-success" style="font-size: 2rem;"></i>
                                    </div>
                                    <h5 class="card-title fw-bold text-success">Previous Running Total</h5>
                                    <p class="card-text text-muted mb-2">Before {{ $from_date }}</p>
                                    <h3 class="text-success fw-bold">{{ number_format($previousRunningTotal, 2) }}</h3>
                                </div>
                            </div>
                        </div>
                    
                        <!-- Final Running Total for Selected Date Range -->
                        <div class="col-md-4">
                            <div class="card shadow-sm border-0" style="background: linear-gradient(135deg, #d9f2fc, #b3e6ff);">
                                <div class="card-body text-center">
                                    <div class="mb-2">
                                        <i class="bi bi-calendar-range text-info" style="font-size: 2rem;"></i>
                                    </div>
                                    <h5 class="card-title fw-bold text-info">Final Running Total</h5>
                                    <p class="card-text text-muted mb-2">{{ $from_date }} to {{ $to_date }}</p>
                                    <h3 class="text-info fw-bold">{{ number_format($finalRunningTotalForDateRange, 2) }}</h3>
                                </div>
                            </div>
                        </div>
                    
                        <!-- Final Combined Running Total -->
                        <div class="col-md-4">
                            <div class="card shadow-sm border-0" style="background: linear-gradient(135deg, #e6f0ff, #ccdfff);">
                                <div class="card-body text-center">
                                    <div class="mb-2">
                                        <i class="bi bi-bar-chart-line text-primary" style="font-size: 2rem;"></i>
                                    </div>
                                    <h5 class="card-title fw-bold text-primary">Final Combined Running Total</h5>
                                    <p class="card-text text-muted mb-2">Up to {{ $to_date }}</p>
                                    <h3 class="text-primary fw-bold">{{ number_format($finalCombinedTotal, 2) }}</h3>
                                </div>
                            </div>
                        </div>
                    </div> 
                
                    <!-- Financial Report Table -->
                    <div class="table-responsive"> <!-- Ensures the table is responsive -->
                        <table class="table table-bordered table-striped w-100">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Description</th>
                                    <th>Shop Name</th>
                                    <th>Staff Name</th>
                                    <th>In Amount</th>
                                    <th>Out Amount</th>
                                    <th>Total Balance</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($financialTable as $row)
                                    <tr>
                                        <td>{{ $row['date'] }}</td>
                                        <td>{{ $row['description'] }}</td>
                                        <td>{{ $row['shop_name'] }}</td>
                                        <td>{{ $row['staff_name'] }}</td>
                                        <!-- In Amount: Green -->
                                        <td class="text-success">
                                            {{ $row['in_amount'] > 0 ? number_format($row['in_amount'], 2) : '' }}
                                        </td>
                                        <!-- Out Amount: Red -->
                                        <td class="text-danger">
                                            {{ $row['out_amount'] > 0 ? number_format($row['out_amount'], 2) : '' }}
                                        </td>
                                        <td>{{ number_format($row['total_cash'], 2) }}</td>
                                    </tr>
                                @endforeach
                                <!-- Totals Row -->
                                <tr class="table-success">
                                    <td colspan="4" class="text-end"><strong>Total</strong></td>
                                    <!-- Total In Amount: Green -->
                                    <td class="text-success"><strong>{{ number_format($totalInAmount, 2) }}</strong></td>
                                    <!-- Total Out Amount: Red -->
                                    <td class="text-danger"><strong>{{ number_format($totalOutAmount, 2) }}</strong></td>
                                    <!-- Final Total Balance -->
                                    <td><strong>{{ number_format($finalRunningTotalForDateRange, 2) }}</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                
            @endif
        </div>        
    </div>  
    @endif
    
</div>
@endsection
