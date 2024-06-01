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
                                        
                                        {{-- <div class="col-6">
                                            <div class="p-3 m-1">
                                                <h4>Welcome, {{ session('username') }}</h4>
                                                <h4>{{ session('username') }}</h4>                                                
                                                <p class="mb-0">Staff Dashboard, Sales Calculator</p>
                                            </div>
                                        </div> --}}

                                        @if(session()->has('username'))
                                            <div class="col-6">
                                                <div class="p-3 m-1">
                                                    <h4>Welcome, {{ session('username') }}</h4>                                                                                                       
                                                    <p class="mb-0">Staff Dashboard, Sales Calculator</p>
                                                </div>
                                            </div>
                                        @elseif(session()->has('adminusername'))
                                            <div class="col-6">
                                                <div class="p-3 m-1">
                                                    <h4>Welcome, {{ session('adminusername') }}</h4>                                                                                                      
                                                    <p class="mb-0">Admin Dashboard, Sales Calculator : {{ Auth::user()->username }}</p>
                                                </div>
                                            </div>
                                        @else                                            
                                            <script>window.location = "{{ route('auth.login') }}";</script>                                            
                                        @endif

                                        
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
                                                £ 50.00
                                            </h4>
                                            <p class="mb-2">
                                                Total Earnings
                                            </p>
                                            <div class="mb-0">
                                                <span class="badge text-success me-2">
                                                    +9.0%
                                                </span>
                                                <span class="text-muted">
                                                    Since Last Month
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Forms -->
                    <div class="row">
                        <div class="col-12 col-md-6 d-flex">
                            <div class="card flex-fill border-0">
                                <div class="card-body p-0 d-flex flex-fill">
                                    <div class="row g-0 w-100">
                                        <div class="col-12">
                                            <div class="p-3 m-1">                                                
                                                <h4 class="card-title">Shop Income Details Report</h4>
                                                <form method="POST" action="{{ route('reports.generateIncomeShops') }}" class="row g-3">
                                                    @csrf
                                                    <div class="col-md-4 mt-3">
                                                        <label for="from_date" class="form-label">From Date:</label>
                                                        <input type="date" class="form-control" id="from_date" name="from_date" required>
                                                    </div>
                                                    <div class="col-md-4 mt-3">
                                                        <label for="to_date" class="form-label">To Date:</label>
                                                        <input type="date" class="form-control" id="to_date" name="to_date" required>
                                                    </div>
                                                    <div class="col-md-3 mt-3">
                                                        <label for="" class="form-label">Generate Report:</label>
                                                        <button type="submit" class="btn btn-success rounded-pill w-100">Report</button>
                                                    </div>
                                                </form>
                                                {{-- @if(isset($from_date) && isset($to_date)) --}}
                                                <div class="card border-0 mt-3">
                                                    <div class="card-header">
                                                        <h5 class="card-title">
                                                            Shop-wise Cash Movement Details
                                                        </h5>
                                                        <h6 class="card-subtitle text-muted">
                                                            <p>Date Period: {{ $from_date }} to {{ $to_date }}</p>
                                                        </h6>
                                                    </div>
                                                    <div class="card-body">
                                                        @if($shops->isEmpty())
                                                        <div class="alert alert-warning" role="alert">
                                                            No shops found.
                                                        </div>
                                                        @else
                                                        <div class="form-group">
                                                            <input type="text" id="searchInput" class="form-control" placeholder="Search Shop">
                                                        </div>
                                                        <table class="table table-bordered" id="reportTable">
                                                            <thead>
                                                                <tr>
                                                                    <th>Shop</th>
                                                                    <th>Total Income</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach ($shops as $shop)
                                                                <tr>
                                                                    @if(isset($from_date) && isset($to_date))
                                                                    <td><a href="{{ route('reports.shopDetails', ['shop' => $shop->id, 'from_date' => $from_date, 'to_date' => $to_date]) }}">{{ $shop->name }}</a></td>
                                                                    @else
                                                                    {{-- <td>{{ $shop->name }}</a></td> --}}
                                                                    <td><a href="{{ route('reports.allshopDetails', ['shop' => $shop->id]) }}">{{ $shop->name }}</a></td>
                                                                    @endif
                                                                    <td>{{ $shopTotalIncome[$shop->id] ?? 0 }}</td>
                                                                   
                                                                </tr>
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                        @endif
                                                    </div>
                                                </div>
                                            {{-- @endif --}}
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
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Forms end -->
                    <!-- Table Element -->
                    <div class="card border-0">
                        <div class="card-header">
                            <h5 class="card-title">
                                Total Sales
                            </h5>
                            <h6 class="card-subtitle text-muted">
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatum ducimus,
                                necessitatibus reprehenderit itaque!
                            </h6>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">First</th>
                                        <th scope="col">Last</th>
                                        <th scope="col">Handle</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>Mark</td>
                                        <td>Otto</td>
                                        <td>@mdo</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">2</th>
                                        <td>Jacob</td>
                                        <td>Thornton</td>
                                        <td>@fat</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">3</th>
                                        <td colspan="2">Larry the Bird</td>
                                        <td>@twitter</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
@endsection
            
            