@extends('layouts.layout')
@section('content')
<div class="container-fluid">
    <div class="mb-3">
        <h4>Report</h4>
    </div>
    <div class="row">
        <div class="col-12 col-md-6 d-flex">
            <div class="card flex-fill border-0 illustration">
                <div class="card-body p-0 d-flex flex-fill">
                    <div class="row g-0 w-100">
                        <div class="col-6">
                            <div class="p-3 m-1">
                                <h4>Welcome, {{ session('username') }}</h4>
                                <p class="mb-0">Shop Management</p>
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

    <!-- Forms -->
    <div class="row">
        <div class="col-12">
            <div class="card flex-fill border-0">
                <div class="card-body p-0 d-flex flex-fill">
                    <div class="p-3 m-1 w-100">
                        <h4 class="n_h2_style rounded">Shops</h4>
                        
                        <div class="card-body">
                            <h5 class="card-title">Search Sales by Date</h5>
                            <form method="POST" action="{{ route('reports.generate') }}">
                                @csrf
                                <div class="row mb-3">
                                    <div class="col form-group">
                                        <label for="from_date" class="form-label">From Date:</label>
                                        <input type="date" class="form-control" id="from_date" name="from_date" required>
                                    </div>
                                    <div class="col form-group">
                                        <label for="to_date" class="form-label">To Date:</label>
                                        <input type="date" class="form-control" id="to_date" name="to_date" required>
                                    </div>
                                    <div class="col">
                                        <button type="submit" class="btn btn-primary">Generate Report</button>
                                    </div>
                                </div>
                            </form>
                        
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @if(isset($shopTotalsByDate))

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Shop Totals by Date</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Shop</th>
                                    <th>Total Cash Differ</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($shopTotalsByDate as $date => $shopTotals)
                                @foreach($shopTotals as $shopId => $total)
                                <tr>
                                    <td>{{ $date }}</td>
                                    <td>{{ App\Models\Shop::find($shopId)->name }}</td>
                                    <td>{{ $total }}</td>
                                </tr>
                                @endforeach
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
  
    <div class="row">
        <div class="col-12 d-flex">
            <div class="card flex-fill border-0">
                <div class="card-body p-0 d-flex flex-fill">
                    <div class="row g-0 w-100">
                        <div class="col-12">
                            <div class="p-3 m-1">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">Cash Differ Details</h4>
                                        @if(isset($from_date) && isset($to_date))                                        
                                            <div class="col-12">
                                                <h6>Date Period: {{ $from_date }} to {{ $to_date }}</h6>
                                            </div>                                        
                                       
                                        <div class="table-responsive">
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
                                                                        {{ $shopTotals[$shop->id] }}
                                                                        @php $total += $shopTotals[$shop->id]; @endphp
                                                                    @else
                                                                        0
                                                                    @endif
                                                                </td>
                                                            @endforeach
                                                            <td>{{ $total }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>  
                                            @endif                              
                                        </div>
                                    </div>
                                </div>                              
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
    <!-- Forms end -->
{{-- 
    <div class="row">
        <div class="col-12 d-flex">
            <div class="card flex-fill border-0">
                <div class="card-body p-0 d-flex flex-fill">
                    <div class="row g-0 w-100">
                        <div class="col-12">
                            <div class="p-3 m-1">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Cash Differ Details</h5>
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Shift ID</th>
                                                        <th>Cash Differ</th>
                                                        <th>Shop</th>
                                                        <th>Created At</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($shifts as $shift)
                                                    <tr>
                                                        <td>{{ $shift->id }}</td>
                                                        <td>
                                                            @foreach($cashdiffers->where('shift_id', $shift->id) as $cashdiffer)
                                                                {{ $cashdiffer->cashdifference }}<br>
                                                            @endforeach
                                                        </td>
                                                        <td>{{ $shift->shop->name }}</td>
                                                        <td>{{ $shift->created_at }}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>                                
                                        </div>
                                    </div>
                                </div>                              
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
{{-- 
    <div class="row mt-4">
        <div class="col-12 d-flex">
            <div class="card flex-fill border-0">
                <div class="card-body p-0 d-flex flex-fill">
                    <div class="row g-0 w-100">
                        <div class="col-12">
                            <div class="p-3 m-1">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Total Cash Differs by Shop</h5>
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Shop</th>
                                                        <th>Total Cash Differ</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($shopTotals as $shopId => $total)
                                                    <tr>
                                                        <td>{{ $shops->find($shopId)->name }}</td>
                                                        <td>{{ $total }}</td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>                                
                                        </div>
                                    </div>
                                </div>                              
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    {{-- xxxxxxx --}}
    {{-- <div class="row">
        <div class="col-12 d-flex">
            <div class="card flex-fill border-0">
                <div class="card-body p-0 d-flex flex-fill">
                    <div class="row g-0 w-100">
                        <div class="col-12">
                            <div class="p-3 m-1">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Cash Differ Details</h5>
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Date</th>
                                                        <th>Shop</th>
                                                        <th>Total Cash Differ</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php $previousDate = null; @endphp
                                                    @foreach($cashdiffers as $cashdiffer)
                                                    @if($cashdiffer->shift->created_at != $previousDate)
                                                        <tr>
                                                            <td>{{ $cashdiffer->shift->created_at->format('Y-m-d') }}</td>
                                                            <td>{{ $cashdiffer->shift->shop->name }}</td>
                                                            <td>{{ $cashdiffers->where('shift_id', $cashdiffer->shift_id)->sum('cashdifference') }}</td>
                                                        </tr>
                                                    @php $previousDate = $cashdiffer->shift->created_at; @endphp
                                                    @endif
                                                    @endforeach
                                                </tbody>
                                            </table>                                
                                        </div>
                                    </div>
                                </div>                              
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
     --}}
{{--     
    @foreach($shopTotals as $shopId => $total)
    <div class="row mt-4">
        <div class="col-12 d-flex">
            <div class="card flex-fill border-0">
                <div class="card-body p-0 d-flex flex-fill">
                    <div class="row g-0 w-100">
                        <div class="col-12">
                            <div class="p-3 m-1">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $shops->find($shopId)->name }} Total Cash Differ</h5>
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Total Cash Differ</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>{{ $total }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>                                
                                        </div>
                                    </div>
                                </div>                              
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach --}}
    
    
</div>
@endsection



