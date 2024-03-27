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
                            <img src="{{ asset('image/customer-support.jpg') }}" class="img-fluid illustration-img"
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
                            <p class="mb-2">
                                Total Sales
                            </p>
                            <h4 class="mb-2">

                            </h4>
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-12 col-md-12 d-flex">
            <div class="card flex-fill border-0">
                <div class="card-body p-0 d-flex flex-fill">
                    <div class="row g-0 w-100">
                        <div class="col-12">
                            <div class="p-3 m-1">
                                @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show d-flex justify-content-between align-items-center"
                                    role="alert">
                                    <span>{{ session('success') }}</span>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                                @endif
                                <form class="row g-3" id="shiftForm" method="POST" action="{{ route('shifts.shift.submit') }}">
                                    @csrf
                                    <div class="col-md-12">
                                        
                                        @foreach($staffs as $staff)
                                        @if(session('username')==$staff->username)
                                        
                                        <input type="hidden" id="staff_id" name="staff_id" value="{{ $staff->id }}">
                                        @endif
                                        @endforeach
                                    </div>
                                    <div class="col-md-12">
                                        <label for="shop_id" class="form-label">Shop:</label>
                                        <select class="form-select" name="shop_id" id="shop_id" required>
                                            <option value="">Select a Shop</option>
                                            @foreach($shops as $shop)
                                            <option value="{{ $shop->id }}">{{ $shop->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="shift_start_date" class="form-label">Shift Start Date:</label>
                                        <input type="date" class="form-control" id="start_date" name="start_date" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="start_time" class="form-label">Start Time:</label>
                                        <input type="time" class="form-control" id="start_time" name="start_time"
                                            required>
                                    </div>

                                    <div class="col-md-3">
                                        <label for="shift_end_date" class="form-label">Shift End Date:</label>
                                        <input type="date" class="form-control" id="end_date" name="end_date" required>
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <label for="end_time" class="form-label">End Time:</label>
                                        <input type="time" class="form-control" id="end_time" name="end_time" required>
                                    </div>                                    
                                </form>
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
                                {{-- <div class="card-body">                                    
                                    <form class="row g-3" id="salesForm" method="post" action="{{ route('shifts.store.submit') }}">
                                        @csrf
                                        <table class="table" id="repeater-table">
                                            <thead>
                                                <tr>
                                                    <th>Department</th>
                                                    <th>Amount</th>
                                                    <th><button type="button" id="add-item" class="btn btn-primary rounded">Add Row</button></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="repeater-item">
                                                    <td>
                                                        <select name="dept_id[]" class="form-select" required>
                                                            <option value="">Select a Department</option>
                                                            @foreach($departments as $department)
                                                            <option value="{{ $department->id }}">{{ $department->dept_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="amount[]" class="form-control" required>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-danger remove-item">Remove</button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        
                                    </form>
                                    <button id="submit-btn" class="btn btn-primary rounded-pill">NewSubmit</button>
                                </div> --}}
                                <div class="card-body">                                    
                                    <form class="row g-3" id="salesForm" method="post" action="{{ route('shifts.store.submit') }}">
                                        @csrf
                                        <table class="table" id="repeater-table">
                                            <thead>
                                                <tr>
                                                    <th>Department</th>
                                                    <th>Amount</th>
                                                    <th><button type="button" id="add-item" class="btn btn-primary rounded">Add Row</button></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="repeater-item">
                                                    <td>
                                                        <select name="dept_id[]" class="form-select" required>
                                                            <option value="">Select a Department</option>
                                                            @foreach($departments as $department)
                                                            <option value="{{ $department->id }}">{{ $department->dept_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="amount[]" class="form-control amount-field" required>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-danger remove-item">Remove</button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        
                                    </form>
                                    <table class="table">
                                        <hr>
                                        <tr>
                                            <td><span class="form-control text-warning">Total Amount:</span></td>
                                            <td style="float: right;"><span id="total-amount" class="form-control text-warning">0</span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="form-control text-warning">Total Cash Amount:</span></td>
                                            <td style="float: right;"><span id="total-amount-after-subtraction" class="form-control text-warning">0</span></td>
                                        </tr>
                                    </table>
                                    {{-- <div>Total Amount: <span id="total-amount">0</span></div> --}}
                                    <hr>
                                    {{-- <button id="submit-btn" class="btn btn-primary rounded-pill">Submit</button> --}}
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
                                <div class="card-header">
                                    <h5 class="card-title">Add Payment Sale Details</h5>
                                    <p>
                                        @if(session('success'))
                                        <div class="alert" style="color: green;">{{ session('success') }}</div>
                                        @endif
                                    </p>
                                </div>
                                {{-- <div class="card-body">
                                    <form class="row g-3" id="paymentSaleForm" method="post" action="{{ route('payment.sale.submit') }}">
                                        @csrf
                                        <table class="table" id="paymentSaleTable">
                                            <thead>
                                                <tr>
                                                    <th>Payment Method</th>
                                                    <th>Amount</th>
                                                    <th><button type="button" id="addRow" class="btn btn-success">Add Row</button></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <select name="paymentmethod_id[]" class="form-select" required>
                                                            <option value="">Select a Payment Method</option>
                                                            @foreach($paymentmethods as $paymentmethod)
                                                            <option value="{{ $paymentmethod->id }}">{{ $paymentmethod->payment_method }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="amount[]" class="form-control" required>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-danger removeRow">Remove</button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <button type="submit-btn" class="btn btn-primary rounded-pill">Submit</button>
                                    </form>
                                    
                                </div> --}}
                                <div class="card-body">
                                    <form class="row g-3" id="paymentSaleForm" method="post" action="{{ route('payment.sale.submit') }}">
                                        @csrf
                                        <table class="table" id="paymentSaleTable">
                                            <thead>
                                                <tr>
                                                    <th>Payment Method</th>
                                                    <th>Amount</th>
                                                    <th><button type="button" id="addRow" class="btn btn-success">Add Row</button></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <select name="paymentmethod_id[]" class="form-select" required>
                                                            <option value="">Select a Payment Method</option>
                                                            @foreach($paymentmethods as $paymentmethod)
                                                            <option value="{{ $paymentmethod->id }}">{{ $paymentmethod->payment_method }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="amount[]" class="form-control amount-input" required>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-danger removeRow">Remove</button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        {{-- <div>Total Amount: <span id="custom-total-amount" class="text-warning">0</span></div> --}}
                                        
                                    </form>
                                    <table class="table">
                                        <hr>
                                        <tr>
                                            <td><span class="form-control text-warning">Total Other Payment:</span></td>
                                            <td style="float: right;"><span id="custom-total-amount" class="form-control text-warning">0</span></td>
                                        </tr>
                                    </table>                                    
                                    <hr>
                                    <button id="submit-btn" class="btn btn-primary rounded-pill">Submit</button>
                                    {{-- <button type="submit-btn" class="btn btn-primary rounded-pill">Submit</button> --}}
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
                                    <div class="card-header">
                                        <h5 class="card-title">Add Payment Sale Details</h5>
                                        <p>
                                            @if(session('success'))
                                            <div class="alert" style="color: green;">{{ session('success') }}</div>
                                            @endif
                                        </p>
                                    </div>
                                    <div class="card-body">
                                        <!-- resources/views/petticash/create.blade.php -->

                                        <form action="{{ route('petticash.store') }}" method="POST">
                                            @csrf
                                            
                                            
                                            <div class="col-md-6">
                                                <label for="reason" class="form-label">Reason:</label>
                                                <textarea name="reason" id="reason" class="form-control"></textarea>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="amount"  class="form-label">Amount:</label>
                                                <input type="number" name="amount" id="amount" class="form-control">
                                            </div>
                                            <button type="submit" class="btn btn-primary">Add Petticash Entry</button>
                                        </form>

                                    </div>
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
                                <h4 class="n_h_style rounded">Add Shifts name: {{ $staff->staff_name }}</h4>
                                @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show d-flex justify-content-between align-items-center"
                                    role="alert">
                                    <span>{{ session('success') }}</span>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                                @endif
                                <form class="row g-3" method="POST" action="{{ route('shifts.store.submit') }}">
                                    @csrf
                                    <div class="col-md-6">
                                        <label for="staff_name" class="form-label">Staff Name: </label>
                                        @foreach($staffs as $staff)
                                        @if(session('username')==$staff->username)
                                        <input type="text" class="form-control" id="staff_name_display"
                                            value="{{ $staff->staff_name }}" readonly>
                                        <input type="hidden" id="staff_id" name="staff_id" value="{{ $staff->id }}">
                                        @endif
                                        @endforeach
                                    </div>

                                    <div class="col-md-6">
                                        <label for="shop_id" class="form-label">Shop:</label>
                                        <select name="shop_id" id="shop_id" required>
                                            <option value="">Select a Shop</option>
                                            @foreach($shops as $shop)
                                            <option value="{{ $shop->id }}">{{ $shop->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="shift_date" class="form-label">Shift Date:</label>
                                        <input type="date" class="form-control" id="date" name="date" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="start_time" class="form-label">Start Time:</label>
                                        <input type="time" class="form-control" id="start_time" name="start_time"
                                            required>
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
                                
                                <div class="input-group mt-3">
                                    <input type="text" class="form-control" placeholder="Search shifts..."
                                        id="searchShiftInput">
                                    <button class="btn btn-outline-secondary" type="button"
                                        id="searchShiftButton">Search</button>
                                </div>
                                
                                <div style="height: 300px; overflow-y: auto;">
                                    <table class="table" id="staffTable">
                                        <thead>
                                            <tr>
                                                <th>Staff</th>
                                                <th>Shop</th>
                                                <th>Shift Start Date</th>
                                                <th>Start time</th>
                                                <th>Shift End Date</th>
                                                <th>End time</th>
                                                <th scope="col" style="width: 30%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($shifts as $shift)
                                            @if($shift->staff->username == session('username'))
                                            <tr>
                                                <td>{{ $shift->staff->staff_name }}</td>
                                                <td>{{ $shift->shop->name }}</td>
                                                <td>{{ $shift->start_date }}</td>
                                                <td>{{ $shift->start_time }}</td>
                                                <td>{{ $shift->end_date }}</td>
                                                <td>{{ $shift->end_time }}</td>
                                                <td>
                                                    <button class="btn btn-warning btn-sm rounded-pill edit-btn"
                                                        style="width: 40%;" data-toggle="modal"
                                                        data-target="#editShiftModal" data-id="{{ $shift->id }}"
                                                        data-staff-name="{{ $shift->staff->staff_name }}">Edit</button>
                                                    <form method="post" style="display: inline;"
                                                        action="{{ route('shifts.destroy', $shift->id) }}">
                                                        @csrf
                                                        @method('delete')
                                                        <button class="btn btn-danger btn-sm rounded-pill"
                                                            style="width: 40%;"
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
    <!-- Forms end -->
</div>
@endsection
<!-- Edit Staff Modal -->
<div class="modal fade" id="editShiftModal" tabindex="-1" role="dialog" aria-labelledby="editShiftModalLabel"
    aria-hidden="true">
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
                        <label for="date">Shift Start Date:</label>
                        <input type="start_date" class="form-control" id="date" name="start_date">
                    </div>

                    <div class="form-group">
                        <label for="start_time">Start Time:</label>
                        <input type="time" class="form-control" id="start_time" name="start_time">
                    </div>
                    <div class="form-group">
                        <label for="date">Shift End Date:</label>
                        <input type="end_date" class="form-control" id="end_date" name="end_date">
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

                // Set the action attribute of the form with proper string interpolation
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
                        editForm.querySelector('#start_date').value = data.start_date;
                        editForm.querySelector('#end_date').value = data.end_date;
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
                const startDateColumn = row.cells[0];
                const endDateColumn = row.cells[1];
                const startTimeColumn = row.cells[2];
                const endTimeColumn = row.cells[3];
                if (startDateColumn && endDateColumn && startTimeColumn && endTimeColumn) {
                    const startDateText = startDateColumn.textContent.toLowerCase();
                    const endDateText = endDateColumn.textContent.toLowerCase();
                    const startTimeText = startTimeColumn.textContent.toLowerCase();
                    const endTimeText = endTimeColumn.textContent.toLowerCase();
                    if (startDateText.includes(query) || endDateText.includes(query) || startTimeText.includes(query) || endTimeText.includes(query)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                }
            }
        });
    });
</script>

{{-- DATE AND TIME VALIDATION --}}
{{-- 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('#submit-btn').click(function() {
            // Check if both form 1 and form 2 are valid before proceeding
            if ($('#shiftForm')[0].checkValidity() && $('#salesForm')[0].checkValidity()) {
                // Check if end_date is greater than or equal to start_date
                var startDate = new Date($('#start_date').val());
                var endDate = new Date($('#end_date').val());

                if (endDate < startDate) {
                    alert('End date must be greater than or equal to start date.');
                    return; // Prevent further execution
                } else if (endDate.getTime() === startDate.getTime()) {
                    // If end_date is equal to start_date, check end_time > start_time
                    var startTime = parseTime($('#start_time').val());
                    var endTime = parseTime($('#end_time').val());

                    if (endTime <= startTime) {
                        alert('End time must be greater than start time.');
                        return; // Prevent further execution
                    }
                }

                // Rest of your code for form submission...
            } else {
                // If either form 1 or form 2 is invalid, prevent submission and show error message
                alert('Please fill out both form 1 and form 2 correctly before submitting.');
            }
        });
    });

    function parseTime(timeStr) {
        // Split time string into hours, minutes, and AM/PM
        var timeArr = timeStr.split(':');
        var hours = parseInt(timeArr[0]);
        var minutes = parseInt(timeArr[1].split(' ')[0]); // Extract minutes from the first part
        var period = timeArr[1].split(' ')[1];

        // Adjust hours for PM if necessary
        if (period === 'PM' && hours < 12) {
            hours += 12;
        }

        // Convert to 24-hour format
        if (period === 'AM' && hours === 12) {
            hours = 0; // 12:00 AM is 00:00 in 24-hour format
        }

        return hours * 60 + minutes; // Convert time to total minutes
    }
</script>
 --}}

{{-- DATE AND TIME VALIDATION --}}


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('#submit-btn').click(function() {
            // Check if both form 1 and form 2 are valid before proceeding
            if ($('#shiftForm')[0].checkValidity() && $('#salesForm')[0].checkValidity()) {
                var formData1 = $('#shiftForm').serialize();
                var formData2 = $('#salesForm').serialize();
                var formData3 = $('#paymentSaleForm').serialize();

                // Define route URLs from server side using inline script variables
                var shiftSubmitUrl = "{{ route('shifts.shift.submit') }}";
                var storeSubmitUrl = "{{ route('shifts.store.submit') }}";
                var paymentSubmitUrl = "{{ route('payment.sale.submit') }}";

                $.ajax({
                    type: 'POST',
                    url: shiftSubmitUrl,
                    data: formData1,
                    success: function(response) {
                        console.log('Form 1 Submission Response:', response);
                        // Now submit the second form
                        $.ajax({
                            type: 'POST',
                            url: storeSubmitUrl,
                            data: formData2,
                            success: function(response) {
                                console.log('Form 2 Submission Response:', response);
                                // Now check if form 3 is filled
                                if ($('#paymentSaleForm')[0].checkValidity()) {
                                    // If form 3 is filled, submit it
                                    $.ajax({
                                        type: 'POST',
                                        url: paymentSubmitUrl,
                                        data: formData3,
                                        success: function(response) {
                                            console.log('Form 3 Submission Response:', response);
                                            // Display success message or perform other actions
                                            alert(response);
                                            // Redirect to the desired page
                                            window.location.href = "{{ route('shifts.index') }}";
                                        },
                                        error: function(xhr, status, error) {
                                            console.error('Form 3 Submission Error:', error);
                                            // Display error message to user
                                            alert('Error submitting third form. Please try again later.');
                                        }
                                    });
                                } else {
                                    // If form 3 is not filled, log the message and proceed
                                    console.log('Form 3 not filled. Proceeding without saving.');
                                    // Display success message or perform other actions
                                    alert('Forms 1 and 2 submitted successfully. Form 3 not filled.');
                                    // Redirect to the desired page
                                    window.location.href = "{{ route('shifts.index') }}";
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error('Form 2 Submission Error:', error);
                                // Display error message to user
                                alert('Error submitting second form. Please try again later.');
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error('Form 1 Submission Error:', error);
                        // Display error message to user
                        alert('Error submitting first form. Check Date and Time.');
                    }
                });
            } else {
                // If either form 1 or form 2 is invalid, prevent submission and show error message
                alert('Please fill out both form 1 and form 2 correctly before submitting.');
            }
        });
    });
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        // Function to calculate and display the total amount
        function calculateTotalAmount() {
            var totalAmount = 0;
            $('.amount-field').each(function () {
                var amount = parseFloat($(this).val()) || 0;
                totalAmount += amount;
            });
            $('#total-amount').text(totalAmount.toFixed(2));
            calculateTotalAmountAfterSubtraction();
        }

        // Calculate and display total amount initially
        calculateTotalAmount();

        // Update total amount when input fields change
        $('#repeater-table').on('input', '.amount-field', function () {
            calculateTotalAmount();
        });

        $("#add-item").click(function () {
            var newRow = $(".repeater-item").first().clone();
            newRow.find('select[name="dept_id[]"]').attr('name', 'dept_id[]');
            newRow.find('input[name="amount[]"]').attr('name', 'amount[]');
            newRow.find('select').val('');
            newRow.find('input[type="text"]').val('');
            $("#repeater-table tbody").append(newRow);
        });

        $("#repeater-table").on('click', '.remove-item', function () {
            // Check if the row being removed is not the only row
            if ($("#repeater-table tbody tr").length > 1) {
                $(this).closest('.repeater-item').remove();
                calculateTotalAmount(); // Recalculate total amount after removing a row
            }
        });

        // Function to calculate and display the total amount after subtraction
        function calculateTotalAmountAfterSubtraction() {
            var totalAmount = parseFloat($('#total-amount').text()) || 0;
            var customTotalAmount = parseFloat($('#custom-total-amount').text()) || 0;
            var totalAmountAfterSubtraction = totalAmount - customTotalAmount;
            $('#total-amount-after-subtraction').text(totalAmountAfterSubtraction.toFixed(2));
        }

        // Update total amount after subtraction when input fields change
        $('#paymentSaleForm').on('input', '.amount-input', function () {
            calculateTotalAmountAfterSubtraction();
        });

        // Function to calculate and display the custom total amount
        function calculateCustomTotalAmount() {
            var customTotalAmount = 0;
            $('.amount-input').each(function () {
                var amount = parseFloat($(this).val()) || 0;
                customTotalAmount += amount;
            });
            $('#custom-total-amount').text(customTotalAmount.toFixed(2));
        }

        // Calculate and display custom total amount initially
        calculateCustomTotalAmount();

        // Update custom total amount when input fields change
        $('#paymentSaleForm').on('input', '.amount-input', function () {
            calculateCustomTotalAmount();
            calculateTotalAmountAfterSubtraction();
        });

        $("#addRow").click(function () {
            var newRow = $("#paymentSaleTable tbody tr").first().clone();
            newRow.find('select[name="paymentmethod_id[]"]').val('');
            newRow.find('input[name="amount[]"]').val('');
            $("#paymentSaleTable tbody").append(newRow);
        });

        $("#paymentSaleTable").on('click', '.removeRow', function () {
            // Check if the row being removed is not the only row
            if ($("#paymentSaleTable tbody tr").length > 1) {
                $(this).closest('tr').remove();
                calculateCustomTotalAmount(); // Recalculate custom total amount after removing a row
                calculateTotalAmountAfterSubtraction(); // Recalculate total amount after subtraction
            }
        });
    });
</script>








