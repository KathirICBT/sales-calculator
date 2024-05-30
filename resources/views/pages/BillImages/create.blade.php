@extends('layouts.layout')
@section('content')
<div class="container-fluid">

    <x-content-header title="Bills Management" />  
    <x-alert-message /> 

    <!-- Forms -->
    <div class="row">
        <div class="col-12 col-md-6 d-flex">
            <div class="card flex-fill border-0">
                <div class="card-body p-0 d-flex flex-fill">
                    <div class="row g-0 w-100">
                        <div class="col-12">
                            <div class="p-3 m-1">
                                <h4 class="n_h_style rounded">Add Bill Info</h4>                                
                                <form action="{{ route('bill_images.store') }}" method="POST" enctype="multipart/form-data" class="row g-3">
                                    @csrf
                                    {{-- <div class="col-md-12">
                                        <label for="staff_id" class="form-label">Staff:</label>
                                        <select name="staff_id" id="staff_id" class="form-select" required>
                                            @foreach($staffs as $staff)
                                                <option value="{{ $staff->id }}">{{ $staff->staff_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="shop_id" class="form-label">Shop:</label>
                                        <select name="shop_id" id="shop_id" class="form-select">
                                            <option value="">Select a Shop</option>
                                            @foreach($shops as $shop)
                                                <option value="{{ $shop->id }}">{{ $shop->name }}</option>
                                            @endforeach
                                        </select>
                                    </div> --}}
                                    <div class="col-md-12">
                                        @foreach($staffs as $staff)
                                        @if(session('username')==$staff->username ||session('adminusername')==$staff->username)
                                        <label for="staff_name" class="form-label">User: </label>
                                        <input type="text" class="form-control" id="staff_name" name="staff_name" value="{{ $staff->staff_name }}" readonly>
                                        <input type="hidden" id="staff_id" name="staff_id" value="{{ $staff->id }}">
                                        @endif
                                        @endforeach
                                    </div>
                                    
                                    @if(session()->has('adminusername'))
                                        <div class="col-md-12">
                                            <label for="shop_id" class="form-label">Shop:</label>
                                            <select name="shop_id" id="shop_id" class="form-select">
                                                <option value="" >Select a Shop</option>
                                                @foreach($shops as $shop)
                                                    <option value="{{ $shop->id }}">{{ $shop->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @else
                                        <div class="col-md-12">
                                            @foreach($staffs as $staff)
                                            @if(session('username')==$staff->username)
                                            <label for="shop_name" class="form-label">Shop: </label>
                                            <input type="text" class="form-control" id="shop_name" name="shop_name" value="{{ $staff->shop->name }}" readonly>
                                            <input type="hidden" id="shop_id" name="shop_id" value="{{ $staff->shop_id }}">
                                            @endif
                                            @endforeach
                                        </div>
                                    @endif
                                    <div class="col-md-12">
                                        <label for="date" class="form-label">Date:</label>
                                        <input type="date" class="form-control" id="date" name="date">
                                    </div>
                                    <div class="col-md-12">
                                        <label for="image" class="form-label">Image:</label>
                                        <input type="file" name="image" id="image" class="form-control" required>
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <button type="submit" class="btn btn-success rounded-pill w-100">
                                            <i class="fa-solid fa-floppy-disk me-1"></i> Upload
                                        </button>                                        
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
