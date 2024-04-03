@extends('layouts.layout')

@section('content')
<div class="container-fluid">
    <div class="mb-3">
        <h4>Other Income Department Dashboard</h4>
    </div>
    <div class="row">
        <div class="col-12 col-md-6 d-flex">
            <div class="card flex-fill border-0 illustration">
                <div class="card-body p-0 d-flex flex-fill">
                    <div class="row g-0 w-100">
                        <div class="col-6">
                            <div class="p-3 m-1">
                                <h4>Welcome, {{ session('username') }}</h4>
                                <p class="mb-0">Department Management</p>
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
                            <p class="mb-2">
                                Total Other Income Departments
                            </p>
                            <h4 class="mb-2">
                               
                            </h4>                            
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
                                <h4 class="n_h_style rounded">Add Other Income Department</h4>
                                @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show d-flex justify-content-between align-items-center"
                                    role="alert">
                                    <span>{{ session('success') }}</span>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                                @endif
                                <form class="row g-3" method="POST" action="{{ route('other_income_departments.store') }}">
                                    @csrf
                                    <div class="col-md-12">
                                        <label for="income_name" class="form-label">Income Name: </label>
                                        <input type="text" class="form-control" id="income_name" name="income_name">
                                    </div>
                                    <div class="col-md-12">
                                        <label for="category" class="form-label">Category: </label>
                                        <input type="text" class="form-control" id="category" name="category">
                                    </div>
                                    <div class="col-md-12">
                                        <label for="subcategory" class="form-label">Subcategory: </label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="subcategory" id="direct_income" value="Direct Income" checked>
                                            <label class="form-check-label" for="direct_income">
                                                Direct Income
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="subcategory" id="calculated_income" value="Calculated Income">
                                            <label class="form-check-label" for="calculated_income">
                                                Calculated Income
                                            </label>
                                        </div>
                                    </div>
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
        <div class="col-12 col-md-6 d-flex">
            <div class="card flex-fill border-0">
                <div class="card-body p-0 d-flex flex-fill">
                    <div class="row g-0 w-100">
                        <div class="col-12">
                            <div class="p-3 m-1">
                                <h4 class="n_h2_style rounded">Other Income Departments</h4>
                                {{-- SEARCH --}}                                
                                <div class="input-group mt-3">
                                    <input type="text" class="form-control" placeholder="Search department..." id="searchInput">
                                    <button class="btn btn-outline-secondary" type="button" id="searchButton">Search</button>
                                </div>
                                {{-- SEARCH --}}
                                <div style="height: 300px; overflow-y: auto;">
                                    <table class="table" id="otherIncomeDepartmentTable">
                                        <thead>
                                            <tr>
                                                <th scope="col">Income Name</th>
                                                <th scope="col">Category</th>
                                                <th scope="col">Subcategory</th>
                                                <th scope="col" style="width: 30%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($otherIncomeDepartments as $otherIncomeDepartment)
                                            <tr>
                                                <td>{{ $otherIncomeDepartment->income_name }}</td>
                                                <td>{{ $otherIncomeDepartment->category }}</td>
                                                <td>{{ $otherIncomeDepartment->subcategory }}</td>
                                                <td>
                                                    <button class="btn btn-warning btn-sm rounded-pill edit-btn"
                                                        style="width: 40%;" data-toggle="modal"
                                                        data-target="#editOtherIncomeDepartmentModal"
                                                        data-id="{{ $otherIncomeDepartment->id }}">Edit</button>
                                                    <form method="post" style="display: inline;"
                                                        action="{{ route('other_income_departments.destroy', $otherIncomeDepartment->id) }}">
                                                        @csrf
                                                        @method('delete')
                                                        <button class="btn btn-danger btn-sm rounded-pill"
                                                            style="width: 50%;"
                                                            onclick="return confirm('Are you sure you want to delete this department?')"
                                                            type="submit">Delete</button>
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
@endsection

<!-- Edit Other Income Department Modal -->
<div class="modal fade" id="editOtherIncomeDepartmentModal" tabindex="-1" role="dialog" aria-labelledby="editOtherIncomeDepartmentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editOtherIncomeDepartmentModalLabel">Edit Other Income Department</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editOtherIncomeDepartmentForm" method="POST" action="">
                @csrf
                @method('PUT')
                <input type="hidden" id="editOtherIncomeDepartmentId" name="id">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_income_name">Income Name:</label>
                        <input type="text" class="form-control" id="edit_income_name" name="income_name" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_category">Category:</label>
                        <input type="text" class="form-control" id="edit_category" name="category" required>
                    </div>
                    <div class="form-group">
                        <label>Subcategory:</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="edit_subcategory" id="edit_direct_income" value="Direct Income" checked>
                            <label class="form-check-label" for="edit_direct_income">
                                Direct Income
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="edit_subcategory" id="edit_calculated_income" value="Calculated Income">
                            <label class="form-check-label" for="edit_calculated_income">
                                Calculated Income
                            </label>
                        </div>
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


    <!-- Bootstrap JS (jQuery required) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Custom JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
    const editButtons = document.querySelectorAll('.edit-btn');

    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            const otherIncomeDepartmentId = this.getAttribute('data-id');
            const modal = document.getElementById('editOtherIncomeDepartmentModal');
            const editForm = document.getElementById('editOtherIncomeDepartmentForm');
            
            editForm.querySelector('#editOtherIncomeDepartmentId').value = otherIncomeDepartmentId;
            
            editForm.setAttribute('action', `/other_income_departments/${otherIncomeDepartmentId}`); 

            fetch(`/other_income_departments/${otherIncomeDepartmentId}/edit`)
                .then(response => response.json())
                .then(data => {     
                    editForm.querySelector('#edit_income_name').value = data.income_name;
                    editForm.querySelector('#edit_category').value = data.category;
                    if (data.subcategory === 'Calculated Income') {
                        editForm.querySelector('#edit_calculated_income').checked = true;
                    } else {
                        editForm.querySelector('#edit_direct_income').checked = true;
                    }
                    $('#editOtherIncomeDepartmentModal').modal('show');
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });
    });
    
    $('#editOtherIncomeDepartmentModal').on('hidden.bs.modal', function () {
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();
    });
});

    </script>