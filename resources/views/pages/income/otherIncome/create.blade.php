@extends('layouts.layout')

@section('content')
<div class="container-fluid">

    <x-content-header title="Other Income Management" /> 
    <x-alert-message />    
    
    <div class="row">
        <div class="col-12 col-md-12 d-flex">
            <div class="card flex-fill border-0">
                <div class="card-body p-0 d-flex flex-fill">
                    <div class="row g-0 w-100">
                        <div class="col-12">
                            <div class="p-3 m-1">
                                <h4 class="n_h_style rounded">Add Other Income</h4>
                                <form id="addOtherIncomeForm" class="row g-3" method="POST" action="{{ route('otherincome.store') }}">
                                    @csrf
                                    <div class="col-md-6">
                                        <label for="shop_id" class="form-label">Shop:</label>
                                        <select name="shop_id" id="shop_id" class="form-select">
                                            <option value="">Select a Shop</option>
                                            @foreach($shops as $shop)
                                            <option value="{{ $shop->id }}">{{ $shop->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="date" class="form-label">Date:</label>
                                        <input type="date" class="form-control" id="date" name="date">
                                    </div>
                                    <div class="col-md-12" id="dynamicRows" class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th style="width: 25%;">Department</th>
                                                    <th style="width: 25%;">Payment Type</th>
                                                    <th style="width: 25%;">Amount</th>
                                                    <th style="width: 10%;"><button type="button" class="btn btn-primary rounded-pill mt-3" id="addRowBtn" style="width: 100%"><i class="fa-regular fa-square-plus"></i></button></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="dynamic-row">
                                                    <td>
                                                        <select class="form-select" name="other_income_department_id[]">
                                                            <option value="">Select Department</option>
                                                            @foreach($other_income_departments as $other_income_department)
                                                            <option value="{{ $other_income_department->id }}">{{ $other_income_department->income_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select class="form-select" name="paymenttype_id[]">
                                                            <option value="">Select Payment Type</option>
                                                            @foreach($paymentTypes as $paymentType)
                                                            <option value="{{ $paymentType->id }}">{{ $paymentType->payment_type }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control amount-input" name="amount[]" pattern="[-+]?\d*">
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-danger rounded-pill remove-row-btn" style="width: 100%"><i class="fa-regular fa-square-minus"></i></button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table> 
                                        <div style="float: right;">
                                         <div id="totalAmountDisplay" class="form-control text-warning"></div>
                                        </div><br><br><hr class="mt-3">
                                        <button type="submit" class="btn btn-success rounded-pill mt-3" form="addOtherIncomeForm" style="width: 29%; margin-right: 5px;"><i class="fa-solid fa-floppy-disk me-1"></i> Add </button>
                                        
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- NEW TABLE --}}

        <div class="col-12 col-md-12 d-flex">
            <div class="card flex-fill border-0">
                <div class="card-body p-0 d-flex flex-fill">
                    <div class="row g-0 w-100">
                        <div class="col-12">
                            <div class="p-3 m-1">                                                
                                <h4 class="n_h2_style rounded">View Other Incomes</h4>
                                {{-- SEARCH --}}
                                <div class="input-group mt-3">
                                    <input type="text" class="form-control" placeholder="Search other income..." id="searchInput">
                                    <button class="btn btn-outline-secondary" type="button" id="searchButton">Search</button>
                                </div>
                                {{-- SEARCH --}}
                                <div style="overflow-x: auto;" class="mt-3 rounded-top">
                                <table class="table" id="otherIncomeTable">
                                    <thead style="position: sticky; top: 0; background-color: #1a1d20; z-index: 1;">
                                        <tr>                                                            
                                            <th>Shop</th>
                                            <th>Date</th>
                                            <th>Department</th>
                                            <th>Payment Type</th>
                                            <th>Amount</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($otherIncomes as $otherIncome)
                                        <tr>
                                            <td>{{ $otherIncome->shop->name }}</td>
                                            <td>{{ $otherIncome->date }}</td>
                                            <td>{{ $otherIncome->otherIncomeDepartment->income_name }}</td>                                                
                                            <td>{{ $otherIncome->paymentType->payment_type}}</td>
                                            <td>{{ $otherIncome->amount }}</td>
                                            <td>
                                                <a href="#" class="btn btn-warning btn-sm rounded-pill edit-btn" style="width: 40%;" data-toggle="modal" data-target="#editOtherIncomeModal" data-id="{{ $otherIncome->id }}"><i class="fa-regular fa-pen-to-square"></i></a>
                                                <form method="post" style="display: inline;" action="{{ route('otherincome.destroy', $otherIncome->id) }}">
                                                    @csrf
                                                    @method('delete')
                                                    <button class="btn btn-danger btn-sm rounded-pill" style="width: 40%;" onclick="return confirm('Are you sure you want to delete this other income?')" type="submit"><i class="fa-solid fa-trash-can"></i></button>
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
        {{-- NEW TABLE END --}}

    </div>    
</div>
@endsection

<!-- Edit Other Income Modal -->
<!-- Edit Other Income Modal -->
<div class="modal fade" id="editOtherIncomeModal" tabindex="-1" role="dialog" aria-labelledby="editOtherIncomeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editOtherIncomeModalLabel">Edit Other Income</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editOtherIncomeForm" method="POST" action="">
                @csrf
                @method('PUT')
                <input type="hidden" id="otherIncomeId" name="otherIncome_id">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="shop_id">Shop:</label>
                        <select class="form-select" id="shop_id" name="shop_id">
                            <option value="">Select a Shop</option>
                            @foreach($shops as $shop)
                            <option value="{{ $shop->id }}">{{ $shop->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="date">Date:</label>
                        <input type="date" class="form-control" id="date" name="date">
                    </div>
                    <div class="form-group">
                        <label for="other_income_department_id">Department</label>
                        <select class="form-select" id="other_income_department_id" name="other_income_department_id">
                            @foreach($other_income_departments as $other_income_department)
                            <option value="{{ $other_income_department->id }}">{{ $other_income_department->income_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="paymenttype_id">Payment Type</label>
                        <select class="form-select" id="paymenttype_id" name="paymenttype_id">
                            @foreach($paymentTypes as $paymentType)
                            <option value="{{ $paymentType->id }}">{{ $paymentType->payment_type }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="amount">Amount</label>
                        <input type="text" class="form-control" id="amount" name="amount">
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
                const otherIncomeId = this.getAttribute('data-id');
                const editForm = document.getElementById('editOtherIncomeForm');

                // Set the other income ID in the form
                editForm.querySelector('#otherIncomeId').value = otherIncomeId;

                editForm.setAttribute('action', `/otherincomes/${otherIncomeId}`);

                // Fetch the other income data and populate the form fields
                fetch(`/otherincomes/${otherIncomeId}/edit`)
                    .then(response => response.json())
                    .then(data => {
                        editForm.querySelector('#shop_id').value = data.shop_id;
                        editForm.querySelector('#date').value = data.date;
                        editForm.querySelector('#other_income_department_id').value = data.other_income_department_id;
                        editForm.querySelector('#paymenttype_id').value = data.paymenttype_id;
                        editForm.querySelector('#amount').value = data.amount;
                        $('#editOtherIncomeModal').modal('show');
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
        });

        $('#editOtherIncomeModal').on('hidden.bs.modal', function() {
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
            // Re-enable scrollbar
            $('body').css('overflow', 'auto');
        });
    });
</script> --}}

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editButtons = document.querySelectorAll('.edit-btn');

        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                const otherIncomeId = this.getAttribute('data-id');
                const editForm = document.getElementById('editOtherIncomeForm');

                // Set the other income ID in the form
                editForm.querySelector('#otherIncomeId').value = otherIncomeId;

                editForm.setAttribute('action', `/otherincomes/${otherIncomeId}`);

                // Fetch the other income data and populate the form fields
                fetch(`/otherincomes/${otherIncomeId}/edit`)
                    .then(response => response.json())
                    .then(data => {
                        editForm.querySelector('#shop_id').value = data.shop_id;
                        editForm.querySelector('#date').value = data.date;
                        editForm.querySelector('#other_income_department_id').value = data.other_income_department_id;
                        editForm.querySelector('#paymenttype_id').value = data.paymenttype_id;
                        editForm.querySelector('#amount').value = data.amount;
                        $('#editOtherIncomeModal').modal('show');
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
        });

        $('#editOtherIncomeModal').on('hidden.bs.modal', function() {
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
            // Re-enable scrollbar
            $('body').css('overflow', 'auto');
        });

        // Add event listener to the amount field for input validation
        const amountField = document.getElementById('amount');
        amountField.addEventListener('input', function() {
            // Remove any non-numeric characters except + and -
            this.value = this.value.replace(/[^0-9.+-]/g, '');
        });
    });
</script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const otherIncomeTable = document.getElementById('otherIncomeTable');
        const tableRows = otherIncomeTable.getElementsByTagName('tr');

        searchInput.addEventListener('input', function() {
            const query = searchInput.value.trim().toLowerCase();

            for (let i = 1; i < tableRows.length; i++) {
                const row = tableRows[i];
                const shopCell = row.cells[0]; 
                const dateCell = row.cells[1]; 
                const departmentCell = row.cells[2];
                const paymenttypeCell = row.cells[3];
                const amountCell = row.cells[4];

                if (shopCell && dateCell && departmentCell && paymenttypeCell && amountCell) {
                    const shopText = shopCell.textContent.trim().toLowerCase();
                    const dateText = dateCell.textContent.trim().toLowerCase();
                    const departmentText = departmentCell.textContent.trim().toLowerCase();
                    const paymenttypeText = paymenttypeCell.textContent.trim().toLowerCase();
                    const amountText = amountCell.textContent.trim().toLowerCase();

                    if (shopText.includes(query) || dateText.includes(query) || departmentText.includes(query) || paymenttypeText.includes(query) || amountText.includes(query)) {
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
        // Function to calculate and display the total amount for repeating form
        function calculateTotalAmount() {
            var totalAmount = 0;
            $('.amount-input').each(function () {
                var amount = parseFloat($(this).val()) || 0;
                totalAmount += amount;
            });
            // Display the total amount within the addOtherIncomeForm
            $('#totalAmountDisplay').text('Total Amount: ' + totalAmount.toFixed(2));
        }

        // Function to add a new row to the repeating form
        $("#addRowBtn").click(function () {
            var newRow = $(".dynamic-row").first().clone();
            // Clear input values for the new row
            newRow.find('select[name="other_income_department_id[]"]').val('');
            newRow.find('select[name="paymenttype_id[]"]').val('');
            newRow.find('input[name="amount[]"]').val('');
            // Append the new row to the table body
            $("#dynamicRows tbody").append(newRow);
            calculateTotalAmount(); // Recalculate total amount after adding a row
        });

        // Function to remove a row from the repeating form
        $("#dynamicRows").on('click', '.remove-row-btn', function () {
            // Check if the row being removed is not the only row
            if ($("#dynamicRows tbody tr").length > 1) {
                $(this).closest('.dynamic-row').remove();
                calculateTotalAmount(); // Recalculate total amount after removing a row
            }
        });

        // Event listeners for input fields to update total amount and validate input
        $("#dynamicRows").on('input', '.amount-input', function () {
            // Remove any non-numeric characters except + and -
            $(this).val(function (index, value) {
                return value.replace(/[^0-9.+-]/g, '');
            });
            calculateTotalAmount(); // Recalculate total amount when input fields change
        });

        // Function to calculate total amount initially
        calculateTotalAmount();
    });
</script>


