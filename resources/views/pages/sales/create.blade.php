@extends('layouts.layout')
@section('content')
<div class="container-fluid">

    <x-content-header title="Sales" />
    <x-alert-message />

    <div class="row">
        <div class="col-12 col-md-12 d-flex">
            <div class="card flex-fill border-0">
                <div class="card-body p-0 d-flex flex-fill">
                    <div class="row g-0 w-100">
                        <div class="p-3 m-1 w-100 d-flex justify-content-end">
                            <button type="button" class="btn btn-success rounded-pill" data-bs-toggle="modal" data-bs-target="#billInfoModal">
                                Add Bill Image
                            </button>
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
                                <form class="row g-3" id="shiftForm" method="POST"
                                    action="{{ route('shifts.shift.submit') }}">
                                    @csrf
                                    <div class="col-md-6">
                                        @foreach($staffs as $staff)
                                        @if(session('username')==$staff->username
                                        ||session('adminusername')==$staff->username)
                                        <label for="staff_name" class="form-label">User: </label>
                                        <input type="text" class="form-control" id="staff_name" name="staff_name"
                                            value="{{ $staff->staff_name }}" readonly>
                                        <input type="hidden" id="staff_id" name="staff_id" value="{{ $staff->id }}">
                                        @endif
                                        @endforeach
                                    </div>

                                    @if(session()->has('adminusername'))
                                    <div class="col-md-6">
                                        <label for="shop_id" class="form-label">Shop:</label>
                                        <select name="shop_id" id="shop_id" class="form-select">
                                            <option value="">Select a Shop</option>
                                            @foreach($shops as $shop)
                                            <option value="{{ $shop->id }}">{{ $shop->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @else
                                    <div class="col-md-6">
                                        @foreach($staffs as $staff)
                                        @if(session('username')==$staff->username)
                                        <label for="shop_name" class="form-label">Shop: </label>
                                        @if ($staff->shop && $staff->shop->name)
                                        <input type="text" class="form-control" id="shop_name" name="shop_name"
                                            value="{{ $staff->shop->name }}" readonly>
                                        <input type="hidden" id="shop_id" name="shop_id" value="{{ $staff->shop_id }}">
                                        @else
                                        <select name="shop_id" id="shop_id" class="form-select">
                                            <option value="">Select a Shop</option>
                                            @foreach($shops as $shop)
                                            <option value="{{ $shop->id }}">{{ $shop->name }}</option>
                                            @endforeach
                                        </select>
                                        @endif
                                        @endif
                                        @endforeach
                                    </div>
                                    @endif
                                    <div class="col-md-3">
                                        <label for="shift_start_date" class="form-label">Shift Start Date:</label>
                                        <input type="date" class="form-control" id="start_date" name="start_date"
                                            required>
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

                                    <div class="col-md-3">                                       
                                        <input type="hidden" class="form-control" id="total_amount" name="total_amount" value="0">
                                    </div>

                                    {{-- CASH BALANCE ============================================================================== --}}
                                    <div class="col-md-3">                                        
                                        <input type="hidden" id="cash_balance" name="cash_balance" value="0"> <!-- Hidden input for form submission -->
                                        {{-- <span id="total-amount-after-subtraction" class="form-control text-warning">0</span> <!-- Visible cash balance --> --}}
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
                                    <h5 class="card-title mt-3">
                                        Add Sales Details
                                    </h5>
                                    <p>
                                        @if(session('success'))
                                    <div class="alert" style="color: green;">{{ session('success') }}</div>
                                    @endif
                                    </p>
                                </div>

                                <div class="card-body" class="mt-3 rounded-top">
                                    <form class="row g-3" id="salesForm" method="post"
                                        action="{{ route('shifts.store.submit') }}">
                                        @csrf
                                        <table class="table" id="repeater-table">
                                            <thead
                                                style="position: sticky; top: 0; background-color: #1a1d20; z-index: 1;">
                                                <tr>
                                                    <th>Department</th>
                                                    <th>Amount</th>
                                                    <th><button type="button" id="add-item" class="btn btn-success"
                                                            style="width: 100%"><i
                                                                class="fa-regular fa-square-plus"></i></button></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="repeater-item">
                                                    <td>
                                                        <select name="dept_id[]" class="form-select" required>
                                                            <option value="">Select a Department</option>
                                                            @foreach($departments as $department)
                                                            <option value="{{ $department->id }}">{{
                                                                $department->dept_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="amount[]"
                                                            class="form-control amount-field" required>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-danger remove-item"
                                                            style="width:100%"><i
                                                                class="fa-regular fa-square-minus"></i></button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                    </form>
                                    <table class="table">
                                        <hr>
                                        <tr>
                                            <td><span class="form-control text-warning">Total Amount:</span></td>
                                            <td style="float: right;"><span id="total-amount"
                                                    class="form-control text-warning">0</span></td>
                                        </tr>
                                        <tr>
                                            <td><span class="form-control text-warning">Balance Cash Available:</span></td>
                                            <td style="float: right;"><span id="total-amount-after-subtraction"
                                                    class="form-control text-warning">0</span></td>
                                        </tr>
                                    </table>

                                    <hr>

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
                                    <h5 class="card-title mt-3">Other Payment Methods</h5>
                                    <p>
                                        @if(session('success'))
                                    <div class="alert" style="color: green;">
                                        {{ session('success') }}
                                    </div>
                                    @endif
                                    </p>
                                </div>
                                <div class="card-body">
                                    <form class="row g-3" id="paymentSaleForm" method="post"
                                        action="{{ route('payment.sale.submit') }}">
                                        @csrf
                                        <table class="table" id="paymentSaleTable">
                                            <thead>
                                                <tr>
                                                    <th>Payment Method</th>
                                                    <th>Amount</th>
                                                    <th><button type="button" id="addRow" class="btn btn-success"
                                                            style="width:100%"><i
                                                                class="fa-regular fa-square-plus"></i></button></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <select name="paymentmethod_id[]" class="form-select" required>
                                                            <option value="">Select a Payment Method</option>
                                                            @foreach($paymentmethods as $paymentmethod)
                                                            <option value="{{ $paymentmethod->id }}">{{
                                                                $paymentmethod->payment_method }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="amount[]"
                                                            class="form-control amount-input" required>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-danger removeRow"
                                                            style="width:100%"><i
                                                                class="fa-regular fa-square-minus"></i></button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </form>
                                    <table class="table">
                                        <hr>
                                        <tr>
                                            <td><span class="form-control text-warning">Total Other Payment:</span></td>
                                            <td style="float: right;"><span id="custom-total-amount"
                                                    class="form-control text-warning">0</span></td>
                                        </tr>
                                    </table>
                                    <hr>
                                </div>
                                <!-- Petticash -->

                                <div class="card-header">
                                    <h5 class="card-title mt-3">Cash Payments During Shift</h5>
                                    <p>
                                        @if(session('success'))
                                    <div class="alert" style="color: green;">
                                        {{ session('success') }}
                                    </div>
                                    @endif
                                    </p>
                                </div>

                                <div class="card-body">
                                    <form class="row g-3" id="petticashForm" action="{{ route('petticash.store') }}"
                                        method="POST">
                                        @csrf

                                        <table class="table" id="petticash-table">
                                            <thead>
                                                <tr>
                                                    <th>Reason</th>
                                                    <th>Amount</th>
                                                    <th><button type="button" id="add-row-btn" class="btn btn-success"
                                                            style="width:100%"><i
                                                                class="fa-regular fa-square-plus"></i></button></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        {{-- --}}

                                                        {{--
                                                    <td>
                                                        <select name="paymentmethod_id[]" class="form-select" required>
                                                            <option value="">Select a Payment Method</option>
                                                            @foreach($paymentmethods as $paymentmethod)
                                                            <option value="{{ $paymentmethod->id }}">{{
                                                                $paymentmethod->payment_method }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td> --}}

                                                    {{-- --}}

                                                    <select name="reason[]" class="form-select reason-input" required>
                                                        <option value="">Select Petty Cash Reason</option>
                                                        @foreach ($pettyCashReasons as $pettyCashReason)
                                                        <option value="{{ $pettyCashReason->id }}">{{
                                                            $pettyCashReason->reason }}</option>
                                                        @endforeach
                                                    </select>
                                                    </td>

                                                    <td><input type="text" name="petticash_amount[]"
                                                            class="form-control amount-input" required></td>
                                                    <td><button type="button" class="btn btn-danger removeRow"
                                                            style="width:100%"><i
                                                                class="fa-regular fa-square-minus"></i></button></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        {{-- <button type="submit">submit</button> --}}
                                    </form>
                                    <table class="table">
                                        <hr>
                                        <tr>
                                            <td><span class="form-control text-warning">Total Cash Taken:</span></td>
                                            <td style="float: right;"><span id="petticash-total-amount"
                                                    class="form-control text-warning">0</span></td>
                                        </tr>
                                    </table>
                                    <hr>
                                    <!-- Petticash -->
                                </div>

                                <!-- Cash Difference -->

                                <div class="card-header">
                                    <h5 class="card-title mt-3">Cash Difference</h5>
                                    <p>
                                        @if(session('success'))
                                    <div class="alert" style="color: green;">
                                        {{ session('success') }}
                                    </div>
                                    @endif
                                    </p>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('cashdiffer.store') }}" method="POST"
                                        id="cashdifferenceForm">
                                        @csrf
                                        <table class="table" id="cashdifference-table">
                                            <thead>
                                                <tr>
                                                    <th>REASON</th>
                                                    <th>AMOUNT</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <div class="row">

                                                    <div class="col-md-6">
                                                        <td>
                                                            <label for="cashdifference" class="form-label">Cash
                                                                Difference:</label>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="cashdifference" id="cashdifference"
                                                                class="form-control cashdifference-input"
                                                                placeholder="Enter cash difference">
                                                        </td>
                                                    </div>
                                                    {{-- <div class="col-md-6">
                                                        <button type="submit" class="btn btn-success">Submit</button>
                                                    </div> --}}
                                                </div>
                                            </tbody>
                                        </table>
                                    </form>
                                    <!-- Cash Difference End -->
                                    <hr>

                                    <button id="submit-btn" class="btn btn-success rounded-pill mt-3"
                                        style="width: 100%"><i class="fa-solid fa-floppy-disk me-1"></i> Submit
                                    </button>
                                    {{-- <button type="submit-btn" class="btn btn-primary rounded-pill">Submit</button>
                                    --}}
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>        
    </div>
    @endsection    

    {{-- MODEL FOR ADD BILL IMAGE --}}

    <!-- Modal -->
    <div class="modal fade" id="billInfoModal" tabindex="-1" aria-labelledby="billInfoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="billInfoModalLabel">Add Bill Info</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('bill_images.store') }}" method="POST" enctype="multipart/form-data"
                        class="row g-3">
                        @csrf
                        <div class="col-md-12">
                            @foreach($staffs as $staff)
                            @if(session('username') == $staff->username || session('adminusername') == $staff->username)
                            <label for="staff_name" class="form-label">User: </label>
                            <input type="text" class="form-control" id="staff_name" name="staff_name"
                                value="{{ $staff->staff_name }}" readonly>
                            <input type="hidden" id="staff_id" name="staff_id" value="{{ $staff->id }}">
                            @endif
                            @endforeach
                        </div>

                        @if(session()->has('adminusername'))
                        <div class="col-md-12">
                            <label for="shop_id" class="form-label">Shop:</label>
                            <select name="shop_id" id="shop_id" class="form-select">
                                <option value="">Select a Shop</option>
                                @foreach($shops as $shop)
                                <option value="{{ $shop->id }}">{{ $shop->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @else
                        <div class="col-md-12">
                            @foreach($staffs as $staff)
                            @if(session('username') == $staff->username)
                            <label for="shop_name" class="form-label">Shop: </label>
                            <input type="text" class="form-control" id="shop_name" name="shop_name"
                                value="{{ $staff->shop->name }}" readonly>
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

    {{-- MODEL FOR ADD BILL IMAGE END --}}


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


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
        function validatePaymentSaleForm() {
            var isValid = true;

            $('#paymentSaleTable tbody tr').each(function () {
                var paymentMethod = $(this).find('select[name="paymentmethod_id[]"]').val();
                var amount = $(this).find('input[name="amount[]"]').val();

                if (paymentMethod === '' && amount !== '') {
                    alert('Please select a Payment Method for all rows');
                    isValid = false;
                    return false; // Exit the loop
                }
                if (amount === '' && paymentMethod !== '') {
                    alert('Please enter an Add Payment Sale Details Amount for all rows');
                    isValid = false;
                    return false; // Exit the loop
                }
            });

            return isValid;
        }

        function validatePetticashForm() {
            var isValid = true;

            $('#petticash-table tbody tr').each(function () {
                var reason = $(this).find('select[name="reason[]"]').val();
                //var reason = $(this).find('input[name="reason[]"]').val();
                var amount = $(this).find('input[name="petticash_amount[]"]').val();

                if (reason === '' && amount !== '') {
                    alert('Please enter a Reason for all rows');
                    isValid = false;
                    return false; // Exit the loop
                }
                if (amount === '' && reason !== '') {
                    alert('Please enter an Additional Cash Taken Amount for all rows');
                    isValid = false;
                    return false; // Exit the loop
                }
            });

            return isValid;
        }

        function validateFormsPMANDPC() {
            var paymentSaleValid = validatePaymentSaleForm();
            var petticashValid = validatePetticashForm();

            // Check if both forms are valid
            if (!paymentSaleValid || !petticashValid) {
                e.preventDefault(); // Prevent form submission
                return false; // Exit the function and return false
            }

            // If both forms are valid, allow form submission
            return true;
        }

        $('#submit-btn').click(function (e) {
            if(validateFormsPMANDPC()){
                // Check if form 1 and form 2 are valid before proceeding
                if ($('#shiftForm')[0].checkValidity() && $('#salesForm')[0].checkValidity()) {
                    var formData1 = $('#shiftForm').serialize();
                    var formData2 = $('#salesForm').serialize();
                    var formData3 = $('#paymentSaleForm').serialize();
                    var formData4 = $('#petticashForm').serialize();
                    var formData5 = $('#cashdifferenceForm').serialize();

                    // Define route URLs from server side using inline script variables
                    var shiftSubmitUrl = "{{ route('shifts.shift.submit') }}";
                    var storeSubmitUrl = "{{ route('shifts.store.submit') }}";
                    var paymentSubmitUrl = "{{ route('payment.sale.submit') }}";
                    var petticashSubmitUrl = "{{ route('petticash.store') }}";
                    var cashDifferenceSubmitUrl = "{{ route('cashdiffer.store') }}";

                    //CASH DIFFER FORM FILL CHECK FUNCTION ========================================

                    function validateCashDifferForm() {
                        const cashDifferenceInput = document.getElementById('cashdifference').value;
                        if (cashDifferenceInput.trim() === '') {
                        // alert('Please enter the cash difference.');
                            return false; // Prevent form submission
                        }
                        return true; // Allow form submission
                    }

                    //=============================================================================

                    // Submit form 1
                    $.ajax({
                        type: 'POST',
                        url: shiftSubmitUrl,
                        data: formData1,
                        success: function(response) {
                            console.log('Form 1 Submission Response:', response);
                            // Submit form 2 after form 1 is submitted successfully
                            $.ajax({
                                type: 'POST',
                                url: storeSubmitUrl,
                                data: formData2,
                                success: function(response) {
                                    console.log('Form 2 Submission Response:', response);
                                    // Check if form 3 is filled
                                    if ($('#paymentSaleForm')[0].checkValidity()) {
                                        // Submit form 3 if filled
                                        $.ajax({
                                            type: 'POST',
                                            url: paymentSubmitUrl,
                                            data: formData3,
                                            success: function(response) {
                                                console.log('Form 3 Submission Response:', response);
                                                // Check if form 4 is filled
                                                if ($('#petticashForm')[0].checkValidity()) {
                                                    // Submit form 4 if filled
                                                    $.ajax({
                                                        type: 'POST',
                                                        url: petticashSubmitUrl,
                                                        data: formData4,
                                                        success: function(response) {
                                                            console.log('Form 4 Submission Response:', response);
                                                            // Check if form 5 (cash difference form) is filled
                                                            if (validateCashDifferForm()) {
                                                                // Submit form 5 if filled
                                                                $.ajax({
                                                                    type: 'POST',
                                                                    url: cashDifferenceSubmitUrl,
                                                                    data: formData5,
                                                                    success: function(response) {
                                                                        console.log('Form 5 Submission Response:', response);
                                                                        // Display success message or perform other actions
                                                                        alert('Shift Time, Sales Total, Payment Methods, Cash Payments, and Cash Difference submitted successfully.');
                                                                        // Redirect to the desired page
                                                                        window.location.href = "{{ route('shiftNode.index') }}";
                                                                    },
                                                                    error: function(xhr, status, error) {
                                                                        console.error('Form 5 Submission Error:', error);
                                                                        // Display error message to user
                                                                        alert('Error submitting cash difference form CHECK_01. Please try again later.');
                                                                    }
                                                                });
                                                            } else {
                                                                // If form 5 is not filled, proceed with success message
                                                                alert('Shift Time, Sales Total, Payment Methods, and Cash Payments submitted successfully. Cash difference form not filled.');
                                                                // Redirect to the desired page
                                                                window.location.href = "{{ route('shiftNode.index') }}";
                                                            }
                                                        },
                                                        error: function(xhr, status, error) {
                                                            console.error('Form 4 Submission Error:', error);
                                                            // Display error message to user
                                                            alert('Error submitting fourth form. Please try again later.');
                                                        }
                                                    });
                                                } else {                                               

                                                    // If form 4 is not filled, check if form 5 is filled
                                                    if (validateCashDifferForm()) {
                                                        $.ajax({
                                                            type: 'POST',
                                                            url: cashDifferenceSubmitUrl,
                                                            data: formData5,
                                                            success: function(response) {
                                                                console.log('Form 5 Submission Response:', response);
                                                                // Display success message or perform other actions
                                                                alert('Shift Time, Sales Total, Payment Methods, and Cash Difference submitted successfully. Cash Payments not filled.');
                                                                // Redirect to the desired page
                                                                window.location.href = "{{ route('shiftNode.index') }}";
                                                            },
                                                            error: function(xhr, status, error) {
                                                                console.error('Form 5 Submission Error:', error);
                                                                // Display error message to user
                                                                alert('Error submitting cash difference form. Please try again later.');
                                                            }
                                                        });
                                                    } else {
                                                        // If form 4 and form 5 are not filled, display message and redirect
                                                        alert('Shift Time, Sales Total, Payment Methods submitted successfully. Cash Payments not filled. Cash difference form not filled.');
                                                        // Redirect to the desired page
                                                        window.location.href = "{{ route('shiftNode.index') }}";
                                                    }
                                                    
                                                }
                                            },
                                            error: function(xhr, status, error) {
                                                console.error('Form 3 Submission Error:', error);
                                                // Display error message to user
                                                alert('Error submitting third form. Please try again later.');
                                            }
                                        });
                                    } else {
                                        // If form 3 is not filled, check if form 4 is filled
                                        if ($('#petticashForm')[0].checkValidity()) {
                                            $.ajax({
                                                type: 'POST',
                                                url: petticashSubmitUrl,
                                                data: formData4,
                                                success: function(response) {
                                                    console.log('Form 4 Submission Response:', response);
                                                    // Check if form 5 (cash difference form) is filled
                                                    if (validateCashDifferForm()) {
                                                        // Submit form 5 if filled
                                                        $.ajax({
                                                            type: 'POST',
                                                            url: cashDifferenceSubmitUrl,
                                                            data: formData5,
                                                            success: function(response) {
                                                                console.log('Form 5 Submission Response:', response);
                                                                // Display success message or perform other actions
                                                                alert('Shift Time, Sales Total, Cash Payments, and Cash Difference submitted successfully. Payment Methods not filled.');
                                                                // Redirect to the desired page
                                                                window.location.href = "{{ route('shiftNode.index') }}";
                                                            },
                                                            error: function(xhr, status, error) {
                                                                console.error('Form 5 Submission Error:', error);
                                                                // Display error message to user
                                                                alert('Error submitting cash difference form. Please try again later.');
                                                            }
                                                        });
                                                    } else {
                                                        // If form 5 is not filled, display message and redirect
                                                        alert('Shift Time, Sales Total, and Cash Payments submitted successfully. Payment Methods not filled. Cash difference form not filled.');
                                                        // Redirect to the desired page
                                                        window.location.href = "{{ route('shiftNode.index') }}";
                                                    }
                                                },
                                                error: function(xhr, status, error) {
                                                    console.error('Form 4 Submission Error:', error);
                                                    // Display error message to user
                                                    alert('Error submitting fourth form. Please try again later.');
                                                }
                                            });
                                        } else {
                                            // If form 4 is not filled, check if form 5 is filled
                                            if (validateCashDifferForm()) {
                                                $.ajax({
                                                    type: 'POST',
                                                    url: cashDifferenceSubmitUrl,
                                                    data: formData5,
                                                    success: function(response) {
                                                        console.log('Form 5 Submission Response:', response);
                                                        // Display success message or perform other actions
                                                        alert('Shift Time, Sales Total, and Cash Difference submitted successfully. Payment Methods and Cash Payments not filled.');
                                                        // Redirect to the desired page
                                                        window.location.href = "{{ route('shiftNode.index') }}";
                                                    },
                                                    error: function(xhr, status, error) {
                                                        console.error('Form 5 Submission Error:', error);
                                                        // Display error message to user
                                                        alert('Error submitting cash difference form. Please try again later.');
                                                    }
                                                });
                                            } else {
                                                // If form 4 and form 5 are not filled, display message and redirect
                                                alert('Shift Time and Sales Total submitted successfully. Payment Methods, Cash Payments, and Cash Difference not filled.');
                                                // Redirect to the desired page
                                                window.location.href = "{{ route('shiftNode.index') }}";
                                            }
                                        }
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
                    alert('Please fill out both form Shift Time and Sales Total correctly before submitting.');
                }
            }else{
                alert("NEEDTOFILLFOMECORRECTLY");
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
            $('#total_amount').val(totalAmount.toFixed(2));
            calculateTotalAmountAfterSubtraction();
        }

        // Function to calculate and display the total amount after subtraction
        function calculateTotalAmountAfterSubtraction() {
             // Get the input field for cash difference
             var cashDifferenceInput = document.getElementById('cashdifference');


            var totalAmount = parseFloat($('#total-amount').text()) || 0;
            var customTotalAmount = parseFloat($('#custom-total-amount').text()) || 0;
            var petticashTotalAmount = parseFloat($('#petticash-total-amount').text()) || 0;

            var cashDifferenceValue = parseFloat(cashDifferenceInput.value) || 0;
            var totalAmountAfterSubtraction = totalAmount - customTotalAmount - petticashTotalAmount + cashDifferenceValue;
            $('#total-amount-after-subtraction').text(totalAmountAfterSubtraction.toFixed(2));

            $('#cash_balance').val(totalAmountAfterSubtraction.toFixed(2));
        }

        // Calculate and display total amount initially
        calculateTotalAmount();

        // Update total amount when input fields change
        $('#repeater-table').on('input', '.amount-field', function () {
            var value = $(this).val();
            // Replace non-numeric characters
            value = value.replace(/[^0-9.+-]/g, '');
            $(this).val(value);
            calculateTotalAmount();
        });

        $("#add-item").click(function () {
            var newRow = $(".repeater-item").first().clone();
            newRow.find('select[name="dept_id[]"]').val('');
            newRow.find('input[name="amount[]"]').val('');
            $("#repeater-table tbody").append(newRow);
        });

        $("#repeater-table").on('click', '.remove-item', function () {
            // Check if the row being removed is not the only row
            if ($("#repeater-table tbody tr").length > 1) {
                $(this).closest('.repeater-item').remove();
                calculateTotalAmount(); // Recalculate total amount after removing a row
            }
        });
    });
    </script>

    <script>
        $(document).ready(function () {
        // Function to calculate and display the total amount after subtraction
        function calculateTotalAmountAfterSubtraction() {
            // Get the input field for cash difference
            var cashDifferenceInput = document.getElementById('cashdifference');

            var totalAmount = parseFloat($('#total-amount').text()) || 0;
            var customTotalAmount = parseFloat($('#custom-total-amount').text()) || 0;
            var petticashTotalAmount = parseFloat($('#petticash-total-amount').text()) || 0;

            var cashDifferenceValue = parseFloat(cashDifferenceInput.value) || 0;
            var totalAmountAfterSubtraction = totalAmount - customTotalAmount - petticashTotalAmount + cashDifferenceValue;
            $('#total-amount-after-subtraction').text(totalAmountAfterSubtraction.toFixed(2));

            $('#cash_balance').val(totalAmountAfterSubtraction.toFixed(2));
        }

        // Function to calculate and display the custom total amount
        function calculateCustomTotalAmount() {
            var customTotalAmount = 0;
            $('#paymentSaleForm .amount-input').each(function () {
                var amount = parseFloat($(this).val()) || 0;
                customTotalAmount += amount;
            });
            $('#custom-total-amount').text(customTotalAmount.toFixed(2));
        }

        // Function to calculate and display the petticash total amount
        function calculatePetticashTotalAmount() {
            var totalAmount = 0;
            $('#petticashForm .amount-input').each(function () {
                var amount = parseFloat($(this).val()) || 0;
                totalAmount += amount;
            });
            $('#petticash-total-amount').text(totalAmount.toFixed(2));
        }

        // Calculate and display initial values
        calculateCustomTotalAmount();
        calculatePetticashTotalAmount();
        calculateTotalAmountAfterSubtraction();

        // Update total amount after subtraction when input fields change
        $('#paymentSaleForm, #petticashForm').on('input', '.amount-input', function () {
            var value = $(this).val();
            // Replace non-numeric characters
            value = value.replace(/[^\d.]/g, '');
            $(this).val(value);
            calculateCustomTotalAmount();
            calculatePetticashTotalAmount();
            calculateTotalAmountAfterSubtraction();
        });

        // Add row functionality for payment sale form
        $("#addRow").click(function () {
            var newRow = $("#paymentSaleTable tbody tr").first().clone();
            newRow.find('select[name="paymentmethod_id[]"]').val('');
            newRow.find('input[name="amount[]"]').val('');
            $("#paymentSaleTable tbody").append(newRow);
        });

        // Remove row functionality for payment sale form
        $("#paymentSaleTable").on('click', '.removeRow', function () {
            if ($("#paymentSaleTable tbody tr").length > 1) {
                $(this).closest('tr').remove();
                calculateCustomTotalAmount();
                calculateTotalAmountAfterSubtraction();
            }
        }); 
        
        // NEW ADD RESON =========================================

        // Add row functionality for petticash form
        $("#add-row-btn").click(function () {
            var newRow = $("#petticash-table tbody tr").first().clone();
            newRow.find('select[name="reason[]"]').val('');
            newRow.find('input[name="petticash_amount[]"]').val('');
            $("#petticash-table tbody").append(newRow);
        });

        // =======================================================

        // // Add row functionality for petticash form
        // $("#add-row-btn").click(function () {
        //     var newRow = $("#petticash-table tbody tr").first().clone();
        //     newRow.find('.reason-input').val('');
        //     newRow.find('.amount-input').val('');
        //     $("#petticash-table tbody").append(newRow);
        // });

        // Remove row functionality for petticash form
        $("#petticash-table").on('click', '.removeRow', function () {
            if ($("#petticash-table tbody tr").length > 1) {
                $(this).closest('tr').remove();
                calculatePetticashTotalAmount();
                calculateTotalAmountAfterSubtraction();
            }
        });
    });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Get the input field for cash difference
            var cashDifferenceInput = document.getElementById('cashdifference');
    
            // Add event listener to the input field
            cashDifferenceInput.addEventListener('input', function() {
                // Remove non-numeric characters from the input
                this.value = this.value.replace(/[^0-9.+-]/g, '');
    
                // Call the function to update total amount
                updateTotalAmount();
            });
    
            function updateTotalAmount() {
                // Get the entered cash difference value
                var cashDifferenceValue = parseFloat(cashDifferenceInput.value) || 0;
                
                // Get the current total amount
                var totalAmount = parseFloat(document.getElementById('total-amount').textContent) || 0;
                
                // Get custom total amount
                var customTotalAmount = parseFloat(document.getElementById('custom-total-amount').textContent) || 0;
                
                // Get petticash total amount
                var petticashTotalAmount = parseFloat(document.getElementById('petticash-total-amount').textContent) || 0;
    
                // Calculate the new total amount after subtraction
                var totalAmountAfterSubtraction = totalAmount - customTotalAmount - petticashTotalAmount + cashDifferenceValue;
    
                // Update the total-amount-after-subtraction span with the result
                document.getElementById('total-amount-after-subtraction').textContent = totalAmountAfterSubtraction.toFixed(2);
                document.getElementById('cash_balance').value = totalAmountAfterSubtraction.toFixed(2);
                
            }
        });
    </script>