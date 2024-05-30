@extends('layouts.layout')
@section('content')
<div class="container-fluid">
    <div class="mb-3">
        {{-- <h4>Staff Dashboard</h4> --}}
    </div>
    <div class="row justify-content-center align-items-center"> <!-- Added justify-content-center and align-items-center to center and vertically align content -->
        <div class="col-12 col-md-6 d-flex">
            <div class="card flex-fill border-0 illustration">
                <div class="card-body p-0 d-flex flex-fill">
                    <div class="row g-0 w-100">
                        <div class="col-6">
                            <div class="p-3 m-1">
                                <h4>Welcome, {{ session('username') }}</h4>
                                <p class="mb-0">Staff Dashboard, Sales Calculator</p>
                            </div>
                        </div>
                        <div class="col-6 align-self-end text-end">
                            <img src="image/customer-support.jpg" class="img-fluid illustration-img" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>        
    </div>

    <!-- Forms -->
    <div class="row justify-content-center">
        <!-- Added justify-content-center to center content -->
        <div class="col-12 col-md-6 d-flex">
            <div class="card flex-fill border-0">
                <div class="card-body p-0 d-flex flex-fill">
                    <div class="row g-0 w-100">
                        <div class="col-12">
                            <div class="p-3 m-1">
                                <h4 class="n_h_style rounded text-center">Register User</h4>
                                <!-- Added text-center to center the heading -->
                                {{-- <form class="row g-3" method="POST" action="{{ route('register') }}">
                                    @csrf
                                    <div class="col-md-12">
                                        <label for="username" class="form-label">Username:</label>
                                        <input type="text" class="form-control" id="username" name="username">
                                        @error('username')
                                        <div class="alert alert-danger alert-dismissible fade show d-flex justify-content-between align-items-center mt-3"
                                            role="alert">
                                            <span>{{ $message }}</span>
                                            <button type="button" class="btn-close" data-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-12">
                                        <label for="password" class="form-label">Password:</label>
                                        <input type="text" class="form-control" id="password" name="password">
                                        @error('password')
                                        <div class="alert alert-danger alert-dismissible fade show d-flex justify-content-between align-items-center mt-3"
                                            role="alert">
                                            <span>{{ $message }}</span>
                                            <button type="button" class="btn-close" data-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-12">
                                        <label for="password-confirm" class="form-label">Confirm Password:</label>
                                        <input type="text" class="form-control" id="password-confirm"
                                            name="password_confirmation">
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary rounded-pill">Register</button>
                                    </div>
                                </form>
                                <form class="row g-3" method="POST" action="{{ route('staff.addstaff.submit') }}">
                                    @csrf
                                    <div class="col-md-6">
                                        <label for="staff_name" class="form-label">Staff Name: </label>
                                        <input type="text" class="form-control" id="staff_name" name="staff_name">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="phone" class="form-label">Phone:</label>
                                        <input type="text" class="form-control" id="phone" name="phonenumber">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="username" class="form-label">Username:</label>
                                        <input type="text" class="form-control" id="username" name="username">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="password" class="form-label">Password:</label>
                                        <input type="password" class="form-control" id="password" name="password"
                                            >
                                    </div>
                                    <div class="col-md-6">
                                        <label for="shop_id" class="form-label">Shop:</label>
                                        <select name="shop_id" id="shop_id" required>
                                            <option value="" >Select a Shop</option>
                                            @foreach($shops as $shop)
                                                <option value="{{ $shop->id }}">{{ $shop->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-success rounded-pill" style="width: 100%"><i class="fa-solid fa-floppy-disk me-1"></i> Add </button>                                        
                                    </div>
                                </form> --}}
                                <form class="row g-3" method="POST" action="{{ route('combined.register') }}">
                                    @csrf
                                    <!-- User Registration Fields -->
                                    <div class="col-md-12">
                                        <label for="username" class="form-label">Username:</label>
                                        <input type="text" class="form-control" id="username" name="username">
                                        @error('username')
                                        <div class="alert alert-danger alert-dismissible fade show d-flex justify-content-between align-items-center mt-3" role="alert">
                                            <span>{{ $message }}</span>
                                            <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-12">
                                        <label for="password" class="form-label">Password:</label>
                                        <input type="password" class="form-control" id="password" name="password">
                                        @error('password')
                                        <div class="alert alert-danger alert-dismissible fade show d-flex justify-content-between align-items-center mt-3" role="alert">
                                            <span>{{ $message }}</span>
                                            <button type="button" class="btn-close" data-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-12">
                                        <label for="password-confirm" class="form-label">Confirm Password:</label>
                                        <input type="password" class="form-control" id="password-confirm" name="password_confirmation">
                                    </div>
                                
                                    <!-- Staff Details Fields -->
                                    <div class="col-md-6">
                                        <label for="staff_name" class="form-label">Owner Name: </label>
                                        <input type="text" class="form-control" id="staff_name" name="staff_name">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="phone" class="form-label">Phone:</label>
                                        <input type="text" class="form-control" id="phone" name="phonenumber">
                                    </div>
                                    {{-- <div class="col-md-6">
                                        <label for="shop_id" class="form-label">Shop:</label>
                                        <select name="shop_id" id="shop_id" required>
                                            <option value="">Select a Shop</option>
                                            @foreach($shops as $shop)
                                                <option value="{{ $shop->id }}">{{ $shop->name }}</option>
                                            @endforeach
                                        </select>
                                    </div> --}}
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary rounded-pill">Register</button>
                                    </div>
                                </form>
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Forms end -->    
    
</div>
@endsection