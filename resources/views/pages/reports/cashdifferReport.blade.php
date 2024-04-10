@extends('layouts.layout')
@section('content')
<div class="container-fluid">
    <div class="mb-3">
        <h4>Staff Dashboard</h4>
    </div>
    <div class="row">
        <div class="col-12 col-md-6 d-flex">
            <div class="card flex-fill border-0 illustration">
                <div class="card-body p-0 d-flex flex-fill">
                    <div class="row g-0 w-100">
                        <div class="col-6">
                            <div class="p-3 m-1">
                                <h4>Welcome, {{ session('username') }}</h4>
                                <h4>{{ session('username') }}</h4>
                                {{-- <h4>{{ $staff->staff_name }}</h4> --}}
                                <p class="mb-0">Staff Dashboard, Sales Calculator</p>
                            </div>
                        </div>
                        <div class="col-6 align-self-end text-end">
                            <img src="image/customer-support.jpg" class="img-fluid illustration-img"
                                alt="">
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
                            <h4 class="mb-2">
                                -
                            </h4>
                            <p class="mb-2">
                                -
                            </p>
                            <div class="mb-0">
                                <span class="badge text-success me-2">
                                    -
                                </span>
                                <span class="text-muted">
                                    -
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- NEW --}}

    <div class="row">
        <div class="col-12 col-md-12 d-flex">
            <div class="card flex-fill border-0">
                <div class="card-body p-0 d-flex flex-fill">
                    <div class="row g-0 w-100">
                        <div class="col-12">
                            <div class="p-3 m-1">                                                
                                <h4 class="n_h_style rounded">Cash Differ Details</h4>
                                <form class="row g-3" method="POST" action="{{ route('reports.generate') }}">
                                    @csrf
                                    <div class="col-md-5">
                                        <label for="from_date" class="form-label">From Date:</label>                                                        
                                        <input type="date" class="form-control" id="from_date" name="from_date" required>                                            
                                    </div>
                                    <div class="col-md-5">
                                        <label for="to_date" class="form-label">To Date:</label>
                                        <input type="date" class="form-control" id="to_date" name="to_date" required>
                                    </div>                                                    
                                    <div class="col-md-2">
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

    {{-- NEW TABLE 02 --}}

    <div class="card border-0">
        @if(isset($from_date) && isset($to_date))
        <div class="card-header">
            <h5 class="card-title">
                Cash Differ Details
            </h5>
            <h6 class="card-subtitle text-muted">
                <div class="col-12">
                    <h6>Date Period: {{ $from_date }} to {{ $to_date }}</h6>
                </div>
            </h6>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Date</th>
                        @foreach($shops as $shop)
                        <th>{{ $shop->name }}</th>
                        @endforeach
                        <th class="text-end fw-bold">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @php $grandTotal = 0; @endphp
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
                            -
                            @endif
                        </td>
                        @endforeach
                        <td class="text-end fw-bold">{{ number_format($total, 2) }}</td>
                        @php $grandTotal += $total; @endphp
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>                       
                        <td colspan="{{ count($shops) + 2 }}" class="text-end fw-bold">
                            <small>Total Cash Differ:</small><span class="ms-3" style="color: rgb(250, 139, 60);">{{ number_format($grandTotal, 2) }}</span>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>        
        @endif
    </div>  

    {{-- NEW TABLE 02 END --}}

    {{-- NEW TABLE --}}

    <!-- Table Element -->
    @if(isset($shopTotalsByDate))   

    <div class="card border-0">
        <div class="card-header">
            <h5 class="card-title">
                Cash Differ Details Based on Shop
            </h5>
            <h6 class="card-subtitle text-muted">
                @if(isset($from_date) && isset($to_date))                                        
                    <div class="col-12">
                        <h6>Date Period: {{ $from_date }} to {{ $to_date }}</h6>
                    </div> 
                @endif
            </h6>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Shop</th>
                        <th class="text-end fw-bold">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @php $grandTotal = 0; @endphp
                    @foreach($shopTotalsByDate as $date => $shopTotals)
                        @foreach($shopTotals as $shopId => $total)
                            <tr>
                                <td>{{ $date }}</td>
                                <td>{{ App\Models\Shop::find($shopId)->name }}</td>
                                <td class="text-end fw-bold">{{ $total }}</td>
                            </tr>
                            @php $grandTotal += $total; @endphp
                        @endforeach
                    @endforeach                    
                </tbody>
                <tfoot>
                    <tr>                        
                        <td colspan="3" class="text-end fw-bold">                            
                            <small>Total Cash Differ:</small><span class="ms-3" style="color: rgb(250, 139, 60);">{{ number_format($grandTotal, 2) }}</span>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    

    @endif

    {{-- NEW TABLE END --}}  
    
</div>
@endsection



