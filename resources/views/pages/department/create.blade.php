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
                                <p class="mb-0">Department Management</p>
                            </div>
                        </div>
                        <div class="col-6 align-self-end text-end">
                            <img src="image/customer-support.jpg" class="img-fluid illustration-img" alt="">
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
                                @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show d-flex justify-content-between align-items-center"
                                    role="alert">
                                    <span>{{ session('success') }}</span>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                                @endif
                                <form class="row g-3" method="POST" action="{{ route('departments.store.submit') }}">
                                    @csrf
                                    <div class="col-md-6">
                                        <label for="sdept_name" class="form-label">Department Name: </label>
                                        <input type="text" class="form-control" id="dept_name" name="dept_name">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="other_taking" class="form-label">Other Taking:</label>
                                        <input type="checkbox" class="" id="other_taking" name="other_taking"  value="1" >                                              
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary rounded-pill">Register</button>
                                        <button type="button" class="btn btn-warning rounded-pill"
                                            onclick="window.location.href='{{ route('departments.index') }}'">Modify</button>
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
                                <h4 class="n_h2_style rounded">Departments</h4>
                                {{-- SEARCH --}}                                
                                <div class="input-group mt-3">
                                    <input type="text" class="form-control" placeholder="Search department..." id="searchInput">
                                    <button class="btn btn-outline-secondary" type="button" id="searchButton">Search</button>
                                </div>
                                {{-- SEARCH --}}
                                <div style="height: 300px; overflow-y: auto;">
                                    <table class="table" id="staffTable">
                                        <thead>
                                            <tr>
                                                <th scope="col">Department Name</th>
                                                <th scope="col">Other Taking</th>
                                                <th scope="col" style="width: 30%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($departments as $department)
                                            <tr>
                                                <td>{{ $department->dept_name }}</td>
                                                <td>{{ $department->other_taking ? 'Yes' : 'No' }}</td>
                                                <td>
                                                    <button class="btn btn-warning btn-sm rounded-pill edit-btn"
                                                        style="width: 40%;" data-toggle="modal"
                                                        data-target="#editDepartmentModal"
                                                        data-id="{{ $department->id }}">Edit</button>
                                                    <form method="post" style="display: inline;"
                                                        action="{{ route('departments.destroy', $department->id) }}">
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

<!-- Edit Staff Modal -->
<div class="modal fade" id="editDepartmentModal" tabindex="-1" role="dialog" aria-labelledby="editDepartmentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editDepartmentModalLabel">Edit department</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editDepartmentForm" method="POST" action="">
                @csrf
                @method('PUT')
                <input type="hidden" id="departmentId" name="dept_id">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="dept_name">Department Name:</label>
                        <input type="text" id="dept_name" name="dept_name"  required>
                    </div>

                    <div class="form-group">
                        <label for="other_taking">Other Taking:</label>
                        <input type="checkbox" id="other_taking" name="other_taking" >
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


<script>
    document.addEventListener('DOMContentLoaded', function() {
    const editButtons = document.querySelectorAll('.edit-btn');

    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            const departmentId = this.getAttribute('data-id');
            const modal = document.getElementById('editDepartmentModal');
            const editForm = document.getElementById('editDepartmentForm');
            
            editForm.querySelector('#departmentId').value = departmentId;
            
            editForm.setAttribute('action', `/departments/${departmentId}`); 

            fetch(`/departments/${departmentId}/edit`)
                .then(response => response.json())
                .then(data => {                        
                    editForm.querySelector('#dept_name').value = data.dept_name;
                    editForm.querySelector('#description').value = data.description;                    
                    $('#editDepartmentModal').modal('show');
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });
    });
    
    $('#editDepartmentModal').on('hidden.bs.modal', function () {
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();
    });
});



    // SEARCH   

    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('searchInput');
        const departmentTable = document.getElementById('departmentTable');
        const tableRows = departmentTable.getElementsByTagName('tr');

        searchInput.addEventListener('input', function () {
            const query = searchInput.value.trim().toLowerCase();
            for (let i = 1; i < tableRows.length; i++) {
                const row = tableRows[i];
                const nameColumn = row.cells[0];
                const descriptionColumn = row.cells[1];
                if (nameColumn && descriptionColumn) {
                    const nameText = nameColumn.textContent.toLowerCase();
                    const descriptionText = descriptionColumn.textContent.toLowerCase();
                    if (nameText.includes(query) || descriptionText.includes(query)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                }
            }
        });
    });

</script>
