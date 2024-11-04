@extends('layouts.layout')
@section('content') 
<style>
    /* Side Slider Container */
    .side-slider {
        height: 100%;
        width: 0;
        position: fixed;
        z-index: 1050;
        top: 0;
        right: 0;
        background-color: #fff;
        overflow-x: hidden;
        transition: 0.5s;
        padding-top: 60px;
        box-shadow: -2px 0 5px rgba(0, 0, 0, 0.5);
    }

    /* Dark Mode for Side Slider */
    html[data-bs-theme="dark"] .side-slider {
        background-color: #1a1a1a; /* Dark background */
        color: #ffffff; /* Light text */
    }

    /* Close Button */
    .side-slider .closebtn {
        position: absolute;
        top: 10px;
        right: 25px;
        font-size: 36px;
    }

    /* Add Sale Form Content */
    .side-slider-content {
        padding: 20px;
    }

    .side-slider h4 {
        padding-left: 20px;
    }

    .side-slider input,
    .side-slider select,
    .side-slider button {
        margin-bottom: 15px;
    }

    /* Input fields for dark mode */
    html[data-bs-theme="dark"] .side-slider input,
    html[data-bs-theme="dark"] .side-slider select {
        background-color: #333; /* Darker input background */
        color: #fff; /* White text */
        border: 1px solid #555; /* Darker border */
    }

    /* Button styles */
    .btn-custom-green {
        background-color: #28a745; /* Green color */
        color: #fff; /* White text */
        border: none;
    }

    .btn-custom-green:hover {
        background-color: #218838; /* Darker green on hover */
    }

    .btn-custom-red {
        background-color: #dc3545; /* Red color */
        color: #fff; /* White text */
        border: none;
    }

    .btn-custom-red:hover {
        background-color: #c82333; /* Darker red on hover */
    }

    /* Button styles in dark mode */
    html[data-bs-theme="dark"] .btn-custom-green {
        background-color: #28a745; /* Same green */
    }

    html[data-bs-theme="dark"] .btn-custom-red {
        background-color: #dc3545; /* Same red */
    }
</style>



                <div class="container-fluid">
                    <div class="mb-3">
                        <h4>Manage Shift Sales</h4>
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

                        {{-- <div class="col-12 col-md-6 d-flex">
                            <div class="card flex-fill border-0">
                                <div class="card-body py-4">
                                    <div class="row">
                                        <!-- First Column: Staff and Shop Information -->
                                        <div class="col-md-4">
                                            <h4 class="mb-2">
                                                Staff: {{ $shift->staff->staff_name }}
                                            </h4>
                                            <p class="mb-2">
                                                Shop: {{ $shift->shop->name }}
                                            </p>
                                        </div>
                                        
                                        <!-- Second Column: Labels and Values for Shift ID, Total Amount, and Cash Balance -->
                                        <div class="col-md-8">
                                            <div class="row mb-2">
                                                <div class="col-6 text-muted">Manage Sales for Shift:</div>
                                                <div class="col-6">{{ $shift->id }}</div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-6 text-muted">Total Amount:</div>
                                                <div class="col-6">£{{ number_format($totalAmount, 2) }}</div>
                                            </div>
                                            <div class="row">
                                                <div class="col-6 text-muted">Cash Balance:</div>
                                                <div class="col-6">£{{ number_format($shift->cash_balance, 2) }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}

                        {{-- <div class="col-12 col-md-6 d-flex">
                            <div class="card flex-fill border-0 shadow-sm">
                                <div class="card-body py-4">
                                    <div class="row">
                                        <!-- First Column: Staff and Shop Information -->
                                        <div class="col-md-4">
                                            <h4 class="mb-2">
                                                Staff: <span class="fw-bold">{{ $shift->staff->staff_name }}</span>
                                            </h4>
                                            <p class="mb-2">
                                                Shop: <span class="fw-semibold">{{ $shift->shop->name }}</span>
                                            </p>
                                        </div>
                                        
                                        <!-- Second Column: Labels for Shift ID, Total Amount, and Cash Balance -->
                                        <div class="col-md-4">
                                            <div class="row mb-1" style="height: 40px;">
                                                <div class="col-12 text-muted d-flex align-items-center">Manage Sales for Shift:</div>
                                            </div>
                                            <div class="row mb-1" style="height: 40px;">
                                                <div class="col-12 text-muted d-flex align-items-center">Total Amount:</div>
                                            </div>
                                            <div class="row" style="height: 40px;">
                                                <div class="col-12 text-muted d-flex align-items-center">Cash Balance:</div>
                                            </div>
                                        </div>
                                        
                                        <!-- Third Column: Smaller Boxes for Values of Shift ID, Total Amount, and Cash Balance -->
                                        <div class="col-md-4">
                                            <div class="row mb-1" style="height: 40px;">
                                                <div class="col-12 d-flex align-items-center">
                                                    <span class="d-inline-block border p-1 rounded text-center w-100">{{ $shift->id }}</span>
                                                </div>
                                            </div>
                                            <div class="row mb-1" style="height: 40px;">
                                                <div class="col-12 d-flex align-items-center">
                                                    <span class="d-inline-block border p-1 rounded text-center w-100">£{{ number_format($totalAmount, 2) }}</span>
                                                </div>
                                            </div>
                                            <div class="row" style="height: 40px;">
                                                <div class="col-12 d-flex align-items-center">
                                                    <span class="d-inline-block border p-1 rounded text-center w-100">£{{ number_format($shift->cash_balance, 2) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> --}}

                        <div class="col-12 col-md-6 d-flex">
                            <div class="card flex-fill border-0 shadow-sm">
                                <div class="card-body py-4 mx-3">
                                    <div class="row">
                                        <!-- First Column: Reduced Width for Staff and Shop Information -->
                                        <div class="col-md-3">
                                            <h4 class="mb-2">
                                                Staff: <span class="fw-bold">{{ $shift->staff->staff_name }}</span>
                                            </h4>
                                            <p class="mb-2">
                                                Shop: <span class="fw-semibold">{{ $shift->shop->name }}</span>
                                            </p>
                                        </div>
                                        
                                        <!-- Combined Column: Labels and Values -->
                                        <div class="col-md-9 border p-0">
                                            <div class="row mx-0 border-bottom" style="height: 40px;">
                                                <div class="col-6 text-muted d-flex align-items-center px-2">Manage Sales for Shift:</div>
                                                <div class="col-6 d-flex align-items-center px-2">
                                                    <span class="d-inline-block border p-1 rounded text-center w-100">{{ $shift->id }}</span>
                                                </div>
                                            </div>
                                            <div class="row mx-0 border-bottom" style="height: 40px;">
                                                <div class="col-6 text-muted d-flex align-items-center px-2">Total Amount:</div>
                                                <div class="col-6 d-flex align-items-center px-2">
                                                    <span class="d-inline-block border p-1 rounded text-center w-100">£{{ number_format($totalAmount, 2) }}</span>
                                                </div>
                                            </div>
                                            <div class="row mx-0" style="height: 40px;">
                                                <div class="col-6 text-muted d-flex align-items-center px-2">Cash Balance:</div>
                                                <div class="col-6 d-flex align-items-center px-2">
                                                    <span class="d-inline-block border p-1 rounded text-center w-100">£{{ number_format($shift->cash_balance, 2) }}</span>
                                                </div>
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
                                                
                                                <!-- Sales Table -->
                                                {{-- <h4 class="n_h2_style rounded">Sales</h4>
                                                <div class="input-group mt-3">
                                                    <input type="text" class="form-control" placeholder="Search Sales..." id="searchInputSales">
                                                    <button class="btn btn-outline-secondary" type="button" id="searchButton">Search</button>
                                                </div>
                                                <div style="height: 300px; overflow-y: auto;" class="mt-3 rounded-top">
                                                    <table class="table" id="salesTable" data-modal-type="sales">
                                                        <thead style="position: sticky; top: 0; background-color: #1a1d20; z-index: 1;">
                                                            <tr>
                                                                <th>Department</th>
                                                                <th>Amount</th>
                                                                <th scope="col" style="width: 30%">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($sales as $sale)
                                                            <tr>
                                                                <td>{{ $sale->department->dept_name }}</td>
                                                                <td>{{ $sale->amount }}</td>
                                                                <td>
                                                                    <button class="btn btn-warning btn-sm rounded-pill edit-btn" style="width: 40%;" data-toggle="modal" data-target="#salesModal" data-id="{{ $sale->id }}"><i class="fa-regular fa-pen-to-square"></i></button>
                                                                    <form method="post" style="display: inline;" action="{{ route('manage_sales.destroy', $sale->id) }}">
                                                                        @csrf
                                                                        @method('delete')
                                                                        <button class="btn btn-danger btn-sm rounded-pill" style="width: 40%;" onclick="return confirm('Are you sure you want to delete this sale?')" type="submit"><i class="fa-solid fa-trash-can"></i></button>
                                                                    </form>
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div> --}}

                                                {{-- NEW SALES TABLE --}}
                                                <h4 class="n_h2_style rounded">Sales</h4>

                                                <!-- Add Sale Button -->                                               

                                                <button class="btn btn-success mb-3" onclick="openSideSlider()">Add Sale</button>

                                                <div class="input-group mt-3">
                                                    <input type="text" class="form-control" placeholder="Search Sales..." id="searchInputSales">
                                                    <button class="btn btn-outline-secondary" type="button" id="searchButton">Search</button>
                                                </div>
                                                <div style="height: 300px; overflow-y: auto;" class="mt-3 rounded-top">
                                                    <table class="table" id="salesTable" data-modal-type="sales">
                                                        <thead style="position: sticky; top: 0; background-color: #1a1d20; z-index: 1;">
                                                            <tr>
                                                                <th>Department</th>
                                                                <th>Amount</th>
                                                                <th scope="col" style="width: 30%">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($sales as $sale)
                                                            <tr>
                                                                <td>{{ $sale->department->dept_name }}</td>
                                                                <td>{{ $sale->amount }}</td>
                                                                <td>
                                                                    <button class="btn btn-warning btn-sm rounded-pill edit-btn" style="width: 40%;" data-toggle="modal" data-target="#salesModal" data-id="{{ $sale->id }}">
                                                                        <i class="fa-regular fa-pen-to-square"></i>
                                                                    </button>
                                                                    <form method="post" style="display: inline;" action="{{ route('manage_sales.destroy', $sale->id) }}">
                                                                        @csrf
                                                                        @method('delete')
                                                                        <button class="btn btn-danger btn-sm rounded-pill" style="width: 40%;" onclick="return confirm('Are you sure you want to delete this sale?')" type="submit">
                                                                            <i class="fa-solid fa-trash-can"></i>
                                                                        </button>
                                                                    </form>
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>

                                                {{-- ADD SALE FORM ========================================================================================== --}}                                                

                                                <!-- Side Slider for Add Sale Form -->
                                                {{-- <div id="addSaleSlider" class="side-slider">
                                                    <a href="javascript:void(0)" class="closebtn" onclick="closeSideSlider()">&times;</a>
                                                    <div class="side-slider-content">
                                                        <h4>Add New Sale</h4>
                                                        <hr>
                                                        <form method="POST" action="{{ route('add.sale', $shift->id) }}">
                                                            <form method="POST" action="">
                                                            @csrf
                                                            <div class="form-group">
                                                                <label for="dept_id">Department</label>
                                                                <select name="dept_id" class="form-select mt-2" required>
                                                                    <option value="">Select a Department</option>
                                                                    @foreach($departments as $department)
                                                                    <option value="{{ $department->id }}">{{ $department->dept_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="amount">Amount</label>
                                                                <input type="number" name="amount" class="form-control mt-2" required>
                                                            </div>
                                                            <button type="submit" class="btn btn-primary mt-2">Add Sale</button>
                                                        </form>
                                                    </div>
                                                </div> --}}

                                                <div id="addSaleSlider" class="side-slider">
                                                    <a href="javascript:void(0)" class="closebtn" onclick="closeSideSlider()">&times;</a>
                                                    <div class="side-slider-content">
                                                        <h4 style="padding-left: 0;">Add New Sale</h4>
                                                        <hr>
                                                        <form method="POST" action="{{ route('add.sale', $shift->id) }}">                                                        
                                                            @csrf
                                                            <div class="form-group">
                                                                <label for="dept_id">Department</label>
                                                                <select name="dept_id" class="form-select mt-2" required>
                                                                    <option value="">Select a Department</option>
                                                                    @foreach($departments as $department)
                                                                    <option value="{{ $department->id }}">{{ $department->dept_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="amount">Amount</label>
                                                                <input type="number" name="amount" class="form-control mt-2" required>
                                                            </div>
                                                            <div class="d-flex justify-content-between">
                                                                <button type="submit" class="btn btn-custom-green mt-2">Add Sale</button>
                                                                <button type="button" class="btn btn-custom-red mt-2" onclick="closeSideSlider()">Cancel</button>

                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                                

                                                {{-- ======================================================================================================== --}}
                                                
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
                                                
                                                
                                                <h4 class="n_h2_style rounded">Payment Methods</h4>
                                                <button class="btn btn-success mb-3" onclick="">Add Payment Method</button>
                                                <div class="input-group mt-3">
                                                    <input type="text" class="form-control" placeholder="Search Payment Sales..." id="searchInputPaymentSales">
                                                    <button class="btn btn-outline-secondary" type="button" id="searchButton">Search</button>
                                                </div>
                                                <div style="height: 300px; overflow-y: auto;" class="mt-3 rounded-top">
                                                    <table class="table" id="paymentSalesTable" data-modal-type="paymentSales">
                                                        <thead style="position: sticky; top: 0; background-color: #1a1d20; z-index: 1;">
                                                            <tr>
                                                                <th>Payment Method</th>
                                                                <th>Amount</th>
                                                                <th scope="col" style="width: 30%">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($paymentSales as $paymentSale)
                                                            <tr>
                                                                <td>{{ $paymentSale->paymentMethod->payment_method }}</td>
                                                                <td>{{ $paymentSale->amount }}</td>
                                                                <td>
                                                                    <button class="btn btn-warning btn-sm rounded-pill edit-btn" style="width: 40%;" data-toggle="modal" data-target="#paymentSalesModal" data-id="{{ $paymentSale->id }}"><i class="fa-regular fa-pen-to-square"></i></button>
                                                                    <form method="post" style="display: inline;" action="{{ route('manage_paymentSales.destroy', $paymentSale->id) }}">
                                                                        @csrf
                                                                        @method('delete')
                                                                        <button class="btn btn-danger btn-sm rounded-pill" style="width: 40%;" onclick="return confirm('Are you sure you want to delete this payment sale?')" type="submit"><i class="fa-solid fa-trash-can"></i></button>
                                                                    </form>
                                                                </td>
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


                    <div class="row">
                        <div class="col-12 col-md-6 d-flex">
                            <div class="card flex-fill border-0">
                                <div class="card-body p-0 d-flex flex-fill">
                                    <div class="row g-0 w-100">
                                        <div class="col-12">
                                            <div class="p-3 m-1">  
                                                
                                                <!-- Petticash Table -->
                                                <h4 class="n_h2_style rounded">Petticash</h4>
                                                <div class="input-group mt-3">
                                                    <input type="text" class="form-control" placeholder="Search Petticash..." id="searchInputPetticash">
                                                    <button class="btn btn-outline-secondary" type="button" id="searchButton">Search</button>
                                                </div>
                                                <div style="height: 300px; overflow-y: auto;" class="mt-3 rounded-top">
                                                    <table class="table" id="petticashTable" data-modal-type="petticash">
                                                        <thead style="position: sticky; top: 0; background-color: #1a1d20; z-index: 1;">
                                                            <tr>
                                                                <th>Reason</th>
                                                                <th>Amount</th>
                                                                <th scope="col" style="width: 30%">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($petticashes as $petticash)
                                                            <tr>
                                                                <td>{{ $petticash->pettyCashReason->reason }}</td>
                                                                <td>{{ $petticash->amount }}</td>
                                                                <td>
                                                                    <button class="btn btn-warning btn-sm rounded-pill edit-btn" style="width: 40%;" data-toggle="modal" data-target="#petticashModal" data-id="{{ $petticash->id }}"><i class="fa-regular fa-pen-to-square"></i></button>
                                                                    <form method="post" style="display: inline;" action="{{ route('manage_petticash.destroy', $petticash->id) }}">
                                                                        @csrf
                                                                        @method('delete')
                                                                        <button class="btn btn-danger btn-sm rounded-pill" style="width: 40%;" onclick="return confirm('Are you sure you want to delete this petticash?')" type="submit"><i class="fa-solid fa-trash-can"></i></button>
                                                                    </form>
                                                                </td>
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
                        <div class="col-12 col-md-6 d-flex">
                            <div class="card flex-fill border-0">
                                <div class="card-body p-0 d-flex flex-fill">
                                    <div class="row g-0 w-100">
                                        <div class="col-12">
                                            <div class="p-3 m-1">  
                                                
                                                
                                                <!-- Cashdiffers Table -->
                                                <h4 class="n_h2_style rounded">Cashdiffers</h4>
                                                <div class="input-group mt-3">
                                                    <input type="text" class="form-control" placeholder="Search Cashdiffers..." id="searchInputCashdiffers">
                                                    <button class="btn btn-outline-secondary" type="button" id="searchButton">Search</button>
                                                </div>
                                                <div style="height: 300px; overflow-y: auto;" class="mt-3 rounded-top">
                                                    <table class="table" id="cashdiffersTable" data-modal-type="cashdiffers">
                                                        <thead style="position: sticky; top: 0; background-color: #1a1d20; z-index: 1;">
                                                            <tr>
                                                                <th>Cash Difference</th>
                                                                <th scope="col" style="width: 30%">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($cashDiffers as $cashDiffer)
                                                            <tr>
                                                                <td>{{ $cashDiffer->cashdifference }}</td>
                                                                <td>
                                                                    <button class="btn btn-warning btn-sm rounded-pill edit-btn" style="width: 40%;" data-toggle="modal" data-target="#cashdiffersModal" data-id="{{ $cashDiffer->id }}"><i class="fa-regular fa-pen-to-square"></i></button>
                                                                    <form method="post" style="display: inline;" action="{{ route('manage_cashdiffers.destroy', $cashDiffer->id) }}">
                                                                        @csrf
                                                                        @method('delete')
                                                                        <button class="btn btn-danger btn-sm rounded-pill" style="width: 40%;" onclick="return confirm('Are you sure you want to delete this cash differ?')" type="submit"><i class="fa-solid fa-trash-can"></i></button>
                                                                    </form>
                                                                </td>
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
                    <!-- Forms end -->
                   
                    
                </div>



                <!-- Edit Sales Modal -->
                <div class="modal fade" id="salesModal" tabindex="-1" role="dialog" aria-labelledby="editSalesModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editSalesModalLabel">Edit Sale</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form id="editSalesForm" method="POST" action="">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="sale_id" id="saleId">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="dept_id">Department</label>
                                        <select name="dept_id" id="dept_id" class="form-select" required>
                                            <option value="">Select a Department</option>
                                            @foreach($departments as $department)
                                            <option value="{{ $department->id }}">{{ $department->dept_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="amount">Amount</label>
                                        <input type="number" class="form-control" id="amount" name="amount" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


                <!-- Edit Payment Sales Modal -->
                <div class="modal fade" id="paymentSalesModal" tabindex="-1" role="dialog" aria-labelledby="editPaymentSalesModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editPaymentSalesModalLabel">Edit Payment Sale</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form id="editPaymentSalesForm" method="POST" action="">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="sale_id" id="saleId">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="paymentmethod_id">Payment Method</label>
                                        <select name="paymentmethod_id" id="paymentmethod_id" class="form-select" required>
                                            <option value="">Select a Payment Method</option>
                                            @foreach($paymentMethods as $paymentMethod)
                                            <option value="{{ $paymentMethod->id }}">{{ $paymentMethod->payment_method }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="amount">Amount</label>
                                        <input type="number" class="form-control" id="amount" name="amount" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


                <!-- Edit Petticash Modal -->
                <div class="modal fade" id="petticashModal" tabindex="-1" role="dialog" aria-labelledby="editPetticashModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editPetticashModalLabel">Edit Petticash</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form id="editPetticashForm" method="POST" action="">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="sale_id" id="saleId">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="petty_cash_reason_id">Reason</label>
                                        <select name="petty_cash_reason_id" id="petty_cash_reason_id" class="form-select" required>
                                            <option value="">Select a Reason</option>
                                            @foreach($pettyCashReasons as $pettyCashReason)
                                            <option value="{{ $pettyCashReason->id }}">{{ $pettyCashReason->reason }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="amount">Amount</label>
                                        <input type="number" class="form-control" id="amount" name="amount" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Edit Cashdiffers Modal -->
                <div class="modal fade" id="cashdiffersModal" tabindex="-1" role="dialog" aria-labelledby="editCashdiffersModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editCashdiffersModalLabel">Edit Cash Difference</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form id="editCashdiffersForm" method="POST" action="">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="sale_id" id="saleId">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="cashdifference">Cash Difference</label>
                                        <input type="text" class="form-control" id="cashdifference" name="cashdifference" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


                {{-- <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const editButtons = document.querySelectorAll('.edit-btn');
                
                        editButtons.forEach(button => {
                            button.addEventListener('click', function() {
                                const saleId = this.getAttribute('data-id');
                                const modalType = this.closest('table').dataset.modalType; // determine which table the button is in
                
                                let fetchUrl = '';
                                let formId = '';
                                let actionPath = '';
                                switch (modalType) {
                                    case 'sales':
                                        fetchUrl = `/manage_sales/${saleId}/edit`;
                                        formId = 'editSalesForm';
                                        actionPath = `/manage_sales/${saleId}`;
                                        break;
                                    case 'paymentSales':
                                        fetchUrl = `/manage_paymentSales/${saleId}/edit`;
                                        formId = 'editPaymentSalesForm';
                                        actionPath = `/manage_paymentSales/${saleId}`;
                                        break;
                                    case 'petticash':
                                        fetchUrl = `/manage_petticash/${saleId}/edit`;
                                        formId = 'editPetticashForm';
                                        actionPath = `/manage_petticash/${saleId}`;
                                        break;
                                    case 'cashdiffers':
                                        fetchUrl = `/manage_cashdiffers/${saleId}/edit`;
                                        formId = 'editCashdiffersForm';
                                        actionPath = `/manage_cashdiffers/${saleId}`;
                                        break;
                                }
                
                                const modal = document.getElementById(`${modalType}Modal`);
                                const editForm = document.getElementById(formId);
                
                                // Set the form action path dynamically
                                editForm.setAttribute('action', actionPath);
                                editForm.querySelector('input[name="sale_id"]').value = saleId;
                
                                fetch(fetchUrl)
                                    .then(response => response.json())
                                    .then(data => {
                                        Object.keys(data).forEach(key => {
                                            if (editForm.querySelector(`[name="${key}"]`)) {
                                                editForm.querySelector(`[name="${key}"]`).value = data[key];
                                            }
                                        });
                
                                        $(`#${modalType}Modal`).modal('show');
                                    })
                                    .catch(error => {
                                        console.error('Error:', error);
                                    });
                            });
                        });
                
                        // Add an event listener to the modal close event
                        $('.modal').on('hidden.bs.modal', function (e) {
                            // Ensure the page becomes active again
                            $('body').addClass('modal-open');
                            // Remove the modal backdrop
                            $('.modal-backdrop').remove();
                        });
                    });
                </script> --}}

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const editButtons = document.querySelectorAll('.edit-btn');
                
                        editButtons.forEach(button => {
                            button.addEventListener('click', function() {
                                const saleId = this.getAttribute('data-id');
                                const modalType = this.closest('table').dataset.modalType;
                
                                let fetchUrl = '';
                                let formId = '';
                                let actionPath = '';
                                switch (modalType) {
                                    case 'sales':
                                        fetchUrl = `/manage_sales/${saleId}/edit`;
                                        formId = 'editSalesForm';
                                        actionPath = `/manage_sales/${saleId}`;
                                        break;
                                    case 'paymentSales':
                                        fetchUrl = `/manage_paymentSales/${saleId}/edit`;
                                        formId = 'editPaymentSalesForm';
                                        actionPath = `/manage_paymentSales/${saleId}`;
                                        break;
                                    case 'petticash':
                                        fetchUrl = `/manage_petticash/${saleId}/edit`;
                                        formId = 'editPetticashForm';
                                        actionPath = `/manage_petticash/${saleId}`;
                                        break;
                                    case 'cashdiffers':
                                        fetchUrl = `/manage_cashdiffers/${saleId}/edit`;
                                        formId = 'editCashdiffersForm';
                                        actionPath = `/manage_cashdiffers/${saleId}`;
                                        break;
                                }
                
                                const modal = document.getElementById(`${modalType}Modal`);
                                const editForm = document.getElementById(formId);                
                                
                                editForm.setAttribute('action', actionPath);
                                editForm.querySelector('input[name="sale_id"]').value = saleId;
                
                                fetch(fetchUrl)
                                    .then(response => response.json())
                                    .then(data => {
                                        Object.keys(data).forEach(key => {
                                            if (editForm.querySelector(`[name="${key}"]`)) {
                                                editForm.querySelector(`[name="${key}"]`).value = data[key];
                                            }
                                        });
                
                                        $(`#${modalType}Modal`).modal('show');
                                    })
                                    .catch(error => {
                                        console.error('Error:', error);
                                    });
                            });
                        });                
                        
                        $('.modal').on('hidden.bs.modal', function (e) {                            
                            $('body').removeClass('modal-open');                            
                            $('.modal-backdrop').remove();                            
                            $('body').css('overflow', 'auto');
                        });
                    });
                </script>
                

                <script>
                    document.addEventListener('DOMContentLoaded', function () {                        
                        const searchInputSales = document.getElementById('searchInputSales');
                        const salesTable = document.getElementById('salesTable');
                        const salesTableRows = salesTable.getElementsByTagName('tr');

                        searchInputSales.addEventListener('input', function () {
                            searchTable(searchInputSales, salesTableRows);
                        });
                        
                        const searchInputPaymentSales = document.getElementById('searchInputPaymentSales');
                        const paymentSalesTable = document.getElementById('paymentSalesTable');
                        const paymentSalesTableRows = paymentSalesTable.getElementsByTagName('tr');

                        searchInputPaymentSales.addEventListener('input', function () {
                            searchTable(searchInputPaymentSales, paymentSalesTableRows);
                        });
                        
                        const searchInputPetticash = document.getElementById('searchInputPetticash');
                        const petticashTable = document.getElementById('petticashTable');
                        const petticashTableRows = petticashTable.getElementsByTagName('tr');

                        searchInputPetticash.addEventListener('input', function () {
                            searchTable(searchInputPetticash, petticashTableRows);
                        });
                        
                        const searchInputCashdiffers = document.getElementById('searchInputCashdiffers');
                        const cashdiffersTable = document.getElementById('cashdiffersTable');
                        const cashdiffersTableRows = cashdiffersTable.getElementsByTagName('tr');

                        searchInputCashdiffers.addEventListener('input', function () {
                            searchTable(searchInputCashdiffers, cashdiffersTableRows);
                        });
                        
                        function searchTable(searchInput, tableRows) {
                            const query = searchInput.value.trim().toLowerCase();
                            for (let i = 1; i < tableRows.length; i++) {
                                const row = tableRows[i];
                                const departmentColumn = row.cells[0];
                                const amountColumn = row.cells[1];
                                if (departmentColumn && amountColumn) {
                                    const departmentText = departmentColumn.textContent.toLowerCase();
                                    const amountText = amountColumn.textContent.toLowerCase();
                                    if (departmentText.includes(query) || amountText.includes(query)) {
                                        row.style.display = '';
                                    } else {
                                        row.style.display = 'none';
                                    }
                                }
                            }
                        }
                    });
                </script>

                {{-- <script>
                    function toggleForm(formId) {
                        // Hide all forms
                        document.getElementById('addSaleForm').style.display = 'none';
                        document.getElementById('addPaymentForm').style.display = 'none';
                        document.getElementById('addPetticashForm').style.display = 'none';
                        document.getElementById('addCashDifferForm').style.display = 'none';

                        // Show the selected form
                        document.getElementById(formId).style.display = 'block';
                    }
                </script> --}}

                <script>
                    function openSideSlider() {
                        document.getElementById("addSaleSlider").style.width = "350px"; // Set the width to make it visible
                    }

                    function closeSideSlider() {
                        document.getElementById("addSaleSlider").style.width = "0"; // Reset the width to hide it
                    }
                </script> 
                
                <style>
                    .side-slider h4 {
                        padding-left: 0; /* Remove left padding */
                    }
                </style>
                
                
                


@endsection            
            