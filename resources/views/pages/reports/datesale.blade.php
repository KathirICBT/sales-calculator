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
                            <form action="{{ route('search.sales') }}" method="GET">
                                @csrf
                                <div class="form-group">
                                    <label for="searchDate">Enter Date:</label>
                                    <input type="date" class="form-control" id="searchDate" name="searchDate">
                                </div>
                                <button type="submit" class="btn btn-primary">Search</button>
                            </form>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    
  
    
    <!-- Forms end -->

    <div class="row">
        <div class="col-12 col-md-6 d-flex">
            <div class="card flex-fill border-0">
                <div class="card-body p-0 d-flex flex-fill">
                    <div class="row g-0 w-100">
                        <div class="col-12">
                            <div class="p-3 m-1">
                            @isset($sales)
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Sales Details</h5>
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Department</th>
                                                        <th>Amount</th>
                                                        <th>Date</th>
                                                        
                                                        <!-- Add more columns as needed -->
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($sales as $sale)
                                                    <tr>
                                                        
                                                        <td>{{ $sale->department->dept_name }}</td>
                                                        <td>{{ $sale->amount }}</td>
                                                        <td>{{ $sale->created_at }}</td>
                                                        <!-- Add more columns as needed -->
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                @endisset
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 d-flex">
            <div class="card flex-fill border-0">
                <div class="card-body p-0 d-flex flex-fill">
                    <div class="row g-0 w-100">
                        <div class="col-12">
                            <div class="p-3 m-1">
                            @if(isset($shifts) && count($shifts) > 0)
                                <h5 class="card-title">Shifts Details</h5>
                                <div class="table-responsive">
                                    <table class="table" id="shiftTable" >
                                        <thead>
                                            <tr>
                                                <th>Staff Name</th>
                                                <th>Shop Name</th>
                                                <th>Start Date</th>
                                                <th>Start Time</th>
                                                <th>End Date</th>
                                                <th>End Time</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($shifts as $shift)
                                            <tr class="shiftRow" data-shift-id="{{ $shift->id }}">
                                                <td>{{ $shift->staff->staff_name }}</td>
                                                <td>{{ $shift->shop->name }}</td>
                                                <td>{{ $shift->start_date }}</td>
                                                <td>{{ $shift->start_time }}</td>
                                                <td>{{ $shift->end_date }}</td>
                                                <td>{{ $shift->end_time }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  
    
</div>




@endsection

<script defer>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.shiftRow').forEach(row => {
            row.addEventListener('click', function() {
                const shiftId = this.getAttribute('data-shift-id');
                fetchSalesDetails(shiftId);
            });
        });
    });

    function fetchSalesDetails(shiftId) {
        fetch(`/getSalesDetails/${shiftId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                updateSalesTable(data);
            })
            .catch(error => {
                console.error('Error fetching sales details:', error);
            });
    }

    function updateSalesTable(data) {
        const salesTableBody = document.getElementById('salesTableBody');
        salesTableBody.innerHTML = '';


        data.forEach(sale => {
            const row = `
                <tr>
                    <td>${sale.department_id}</td>
                    <td>${sale.amount}</td>
                    <td>${sale.created_at}</td>
                </tr>
            `;
            salesTableBody.innerHTML += row;
        });
    }
</script>

