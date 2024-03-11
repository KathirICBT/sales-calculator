@extends('layouts.layout')
@section('content') 
                <div class="container-fluid">
                    <div class="mb-3">
                        <h4>Department Dashboard</h4>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-6 d-flex">
                            <div class="card flex-fill border-0 illustration">
                                <div class="card-body p-0 d-flex flex-fill">
                                    <div class="row g-0 w-100">
                                        <div class="col-6">
                                            <div class="p-3 m-1">
                                                <h4>Welcome, {{ session('username') }}</h4>
                                                <p class="mb-0">Department Dashboard, Sales Calculator</p>
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
                                                <h4 class="n_h_style rounded">Add Department</h4>
                                                <form class="row g-3">
                                                    <div class="col-md-6">
                                                        <label for="inputEmail" class="form-label">Department Name:</label>                                                        
                                                        <select class="form-select" aria-label="Default select example" name="dept_name" id="dept_name">
                                                            <option selected>Open this select menu</option>
                                                            <option value="1">Cake</option>
                                                            <option value="2">Soft Drink</option>
                                                            <option value="3">Sweet</option>
                                                        </select>
                                                            <!-- aria-describedby="emailHelp"> -->
                                                        <!-- <div id="emailHelp" class="form-text">We'll never share your
                                                            email with anyone else.</div> -->
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="amount" class="form-label">Amount:</label>
                                                        <input type="text" class="form-control" id="amount" name="amount">
                                                    </div>                                                    
                                                    <div class="col-12">
                                                        <button type="submit" class="btn btn-primary rounded-pill">Add Sale</button>
                                                    </div>
                                                </form>
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
                                                <h4 class="n_h2_style rounded">Today Sale</h4>
                                                <table class="table">
                                                    <thead>
                                                        <tr>                                                            
                                                            <th scope="col">Department</th>
                                                            <th scope="col">Amount</th>
                                                            <th scope="col" style="width: 30%">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>                                                            
                                                            <td>Soft Drink</td>
                                                            <td>10</td>
                                                            <td>
                                                                <a href="" class="btn btn-warning btn-sm rounded-pill" style="width: 40%;"> Edit </a>
                                                                <a href="" class="btn btn-danger btn-sm rounded-pill" style="width: 40%;"> Delete </a>
                                                            </td>
                                                        </tr>
                                                        <tr>                                                            
                                                            <td>Cake</td>
                                                            <td>15</td>
                                                            <td>
                                                                <a href="" class="btn btn-warning btn-sm rounded-pill" style="width: 40%;"> Edit </a>
                                                                <a href="" class="btn btn-danger btn-sm rounded-pill" style="width: 40%;"> Delete </a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Apple</td>
                                                            <td>20</td>
                                                            <td>
                                                                <a href="" class="btn btn-warning btn-sm rounded-pill" style="width: 40%;"> Edit </a>
                                                                <a href="" class="btn btn-danger btn-sm rounded-pill" style="width: 40%;"> Delete </a>
                                                            </td>
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
            
            