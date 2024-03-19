@extends('layouts.layout')
@section('content')
<div class="container-fluid">
    <div class="mb-3">
        <h4>Shifts Dashboard</h4>
    </div>
    <div class="row">
        <div class="col-12 col-md-6 d-flex">
            <div class="card flex-fill border-0 illustration">
                <div class="card-body p-0 d-flex flex-fill">
                    <div class="row g-0 w-100">
                        <div class="col-6">
                            <div class="p-3 m-1">
                                <h4>Welcome, {{ session('username') }}</h4>
                                <p class="mb-0">Shift Management</p>
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
                                Total Staff
                            </p>
                            <h4 class="mb-2">
                                
                            </h4>                            
                            {{-- <div class="mb-0">
                                <span class="mb-2">
                                    +9.0%
                                </span>
                                <span class="text-muted">
                                    Since Last Month
                                </span>
                            </div> --}}
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
                                <h4 class="n_h_style rounded">Add Shifts</h4>
                                @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show d-flex justify-content-between align-items-center"
                                    role="alert">
                                    <span>{{ session('success') }}</span>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                                @endif
                                <form class="row g-3" method="POST" action="{{ route('shifts.store') }}">
                                    @csrf
                                    <div class="col-md-6">                                           
                                        <label for="staff_name" class="form-label">Staff Name: </label>
                                        @foreach($staffs as $staff)
                                        @if(session('username')==$staff->username)
                                        <input type="text" class="form-control" id="staff_name_display" value="{{ $staff->staff_name }}" readonly>
                                        <input type="hidden" id="staff_id" name="staff_id" value="{{ $staff->id }}">
                                        @endif
                                        @endforeach
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
                                        <label for="shift_date" class="form-label">Shift Date:</label>
                                        <input type="date" class="form-control" id="date" name="date" required >
                                    </div>
                                    <div class="col-md-6">
                                        <label for="start_time" class="form-label">Start Time:</label>
                                        <input type="time" class="form-control" id="start_time" name="start_time" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="end_time" class="form-label">End Time:</label>
                                        <input type="time" class="form-control" id="end_time" name="end_time" required>
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
                                <h4 class="n_h2_style rounded">Shifts</h4>
                                    {{-- SEARCH --}}
                                    <div class="input-group mt-3">
                                        <input type="text" class="form-control" placeholder="Search shifts..." id="searchShiftInput">
                                        <button class="btn btn-outline-secondary" type="button" id="searchShiftButton">Search</button>
                                    </div>
                                    {{-- SEARCH --}}
                                <div style="height: 300px; overflow-y: auto;">
                                    <table class="table" id="staffTable">
                                        <thead>
                                            <tr>
                                                <th>Staff</th>
                                                <th>Shop</th>
                                                <th>Shift Date</th>
                                                <th>Start time</th>
                                                <th>End time</th>                    
                                                <th scope="col" style="width: 30%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($shifts as $shift)
                                                @if($shift->staff->staff_name == $staff->staff_name)
                                                    <tr>
                                                        <td>{{ $shift->staff->staff_name }}</td>
                                                        <td>{{ $shift->shop->name }}</td>
                                                        <td>{{ $shift->date }}</td>
                                                        <td>{{ $shift->start_time }}</td>
                                                        <td>{{ $shift->end_time }}</td>
                                                        
                                                        <td>
                                                            <button class="btn btn-warning btn-sm rounded-pill edit-btn"
                                                                style="width: 40%;" data-toggle="modal"
                                                                data-target="#editShiftModal"
                                                                data-id="{{ $shift->id }}" data-staff-name="{{ $shift->staff->staff_name }}">Edit</button>
                                                            <form method="post" style="display: inline;"
                                                                action="{{ route('shifts.destroy', $shift->id) }}">
                                                                @csrf
                                                                @method('delete')
                                                                <button class="btn btn-danger btn-sm rounded-pill"
                                                                    style="width: 50%;"
                                                                    onclick="return confirm('Are you sure you want to delete this Shift?')"
                                                                    type="submit">Delete</button>
                                                            </form>
                                                        </td>
                                                    </tr>
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
<!-- extra -->
    <div class="card border-0">
        <div class="card-header">
            <h5 class="card-title">
                Add Sales Details
            </h5>
            <p>
                @if(session('success'))
                    <div class="alert" style="color: green;">{{ session('success') }}</div>
                 @endif
            </p>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Shift</th>
                        <th>Department</th>                                      
                        <th>Amount</th>
                        <th></th>
                        </tr>
                </thead>
                <tbody>
                    <tr>
                        <form class="row g-3" method="post" action="{{ route('sales.store') }}">
                                @csrf
                                <td>
                                    <input type="text" name="shift_id" id="shift_id" value="{{ $shift->id }}" readonly>
                                </td>
                                <td>
                                    <div class="col-md-6">
                                        <!-- <label for="dept_id" style="display: inline;">Department:</label> -->
                                        <select name="dept_id" id="dept_id" required>
                                            <option value="" >Select a Department</option>
                                                @foreach($departments as $department)
                                                    <option value="{{ $department->id }}">{{ $department->dept_name }}</option>
                                                @endforeach
                                        </select>
                                    </div>  
                                </td>
                                <td>
                                    <div class="col-md-6">
                                        <!-- <label for="amount" style="display: inline;" >Amount:</label> -->
                                        <input type="text" id="amount" name="amount" required>
                                    </div>
                                </td>                        
                                <td>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary rounded-pill">Add</button>                                        
                                    </div>
                                </td>
                        </form>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!-- Forms end -->        
</div>
@endsection
<!-- Edit Staff Modal -->
<div class="modal fade" id="editShiftModal" tabindex="-1" role="dialog" aria-labelledby="editShiftModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editShiftModalLabel">Edit Shift</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editShiftForm" method="POST" action="">
                @csrf
                @method('PUT')
                <input type="hidden" id="shiftId" name="shift_id">
                <input type="hidden" id="staffId" name="staff_id"> 

                <div class="modal-body">
                    <div class="form-group">
                        <label for="staff_name" class="form-label">Staff Name:</label>
                        <input type="text" class="form-control" id="staff_name" name="staff_name" readonly>
                    </div>
                    
                    <div class="form-group">
                        <label for="shop_id">Shop:</label>
                        <select class="form-control" id="shop_id" name="shop_id">
                            @foreach($shops as $shop)
                                <option value="{{ $shop->id }}">{{ $shop->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="date">Shift Date:</label>
                        <input type="date" class="form-control" id="date" name="date">
                    </div>

                    <div class="form-group">
                        <label for="start_time">Start Time:</label>
                        <input type="time" class="form-control" id="start_time" name="start_time">
                    </div>

                    <div class="form-group">
                        <label for="end_time">End Time:</label>
                        <input type="time" class="form-control" id="end_time" name="end_time">
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
                const shiftId = this.getAttribute('data-id');
                const editForm = document.getElementById('editShiftForm');
                const staffName = this.getAttribute('data-staff-name');

                // Set the action attribute of the form
                editForm.setAttribute('action', `/shifts/${shiftId}`);

                // Set staff name field value
                editForm.querySelector('#staff_name').value = staffName;

                // Fetch shift data for the selected shift
                fetch(`/shifts/${shiftId}/edit`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        // Populate form fields with shift details
                        editForm.querySelector('#shop_id').value = data.shop_id;
                        editForm.querySelector('#date').value = data.date;
                        editForm.querySelector('#start_time').value = data.start_time;
                        editForm.querySelector('#end_time').value = data.end_time;

                        // Show the modal
                        $('#editShiftModal').modal('show');
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchShiftInput = document.getElementById('searchShiftInput');
        const shiftTable = document.getElementById('shiftTable');
        const tableRows = shiftTable.getElementsByTagName('tr');

        searchShiftInput.addEventListener('input', function () {
            const query = searchShiftInput.value.trim().toLowerCase();
            for (let i = 1; i < tableRows.length; i++) {
                const row = tableRows[i];
                const dateColumn = row.cells[0];
                const startTimeColumn = row.cells[1];
                const endTimeColumn = row.cells[2];
                if (dateColumn && startTimeColumn && endTimeColumn) {
                    const dateText = dateColumn.textContent.toLowerCase();
                    const startTimeText = startTimeColumn.textContent.toLowerCase();
                    const endTimeText = endTimeColumn.textContent.toLowerCase();
                    if (dateText.includes(query) || startTimeText.includes(query) || endTimeText.includes(query)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                }
            }
        });
    });
</script>