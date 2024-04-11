@extends('layouts.layout')

@section('content')
<div class="container-fluid">
    <div class="mb-3">
        <h4>Add Other Income</h4>
    </div>
    <div class="row">
        <div class="col-12 col-md-6 d-flex">
            <div class="card flex-fill border-0 illustration">
                <div class="card-body p-0 d-flex flex-fill">
                    <div class="row g-0 w-100">
                        <div class="col-6">
                            <div class="p-3 m-1">
                                <h4>Welcome, {{ session('username') }}</h4>
                                <p class="mb-0">Other Expense Management</p>
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
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">       
        <div class="col-12">
             <!-- success -->
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show d-flex justify-content-between align-items-center"
                role="alert">
                <span>{{ session('success') }}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif
            <!-- -->
            <!-- ERROR -->
            @if ($errors->any())
            @foreach ($errors->all() as $error)
            <div class="alert alert-danger alert-dismissible fade show d-flex justify-content-between align-items-center"
                role="alert">
                <span>{{ $error }}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endforeach
            @endif
            <!-- -->
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-md-12 d-flex">
            <div class="card flex-fill border-0">
                <div class="card-body p-0 d-flex flex-fill">
                    <div class="row g-0 w-100">
                        <div class="col-12">
                            <div class="p-3 m-1">
                                <h4 class="n_h_style rounded">Add Other Expenses</h4>
                                <form id="addOtherExpenseForm" class="row g-3" method="POST" action="{{ route('otherexpense.store') }}">
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
                                                    <th style="width: 25%;">Other Expenses Reason</th>
                                                    <th style="width: 25%;">Payment Type</th>
                                                    <th style="width: 25%;">Amount</th>
                                                    <th style="width: 10%;"><button type="button" class="btn btn-primary rounded-pill mt-3" id="addRowBtn" style="width: 100%"><i class="fa-regular fa-square-plus"></i></button></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="dynamic-row">
                                                    <td>
                                                        <select class="form-select" name="pettyCashReason_id[]">
                                                            <option value="">Select Expense Reason</option>
                                                            @foreach($pettyCashReasons as $pettyCashReason)
                                                            <option value="{{ $pettyCashReason->id }}">{{ $pettyCashReason->reason }}</option>
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
                                        <button type="submit" class="btn btn-success rounded-pill mt-3" form="addOtherExpenseForm" style="width: 29%; margin-right: 5px;"><i class="fa-solid fa-floppy-disk"></i></button>
                                        
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
                                <h4 class="n_h2_style rounded">View Other Expenses</h4>
                                {{-- SEARCH --}}
                                <div class="input-group mt-3">
                                    <input type="text" class="form-control" placeholder="Search other expense..." id="searchInput">
                                    <button class="btn btn-outline-secondary" type="button" id="searchButton">Search</button>
                                </div>
                                {{-- SEARCH --}}
                                <div style="overflow-x: auto;">
                                <table class="table" id="otherExpenseTable">
                                    <thead>
                                        <tr>                                                            
                                            <th>Shop</th>
                                            <th>Date</th>
                                            <th>Other Espense Reson</th>
                                            <th>Payment Type</th>
                                            <th>Amount</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($otherExpenses as $otherExpense)
                                        <tr>
                                            <td>{{ $otherExpense->shop->name }}</td>
                                            <td>{{ $otherExpense->date }}</td>
                                            <td>{{ $otherExpense->expenseReason->reason }}</td>                                                
                                            <td>{{ $otherExpense->paymentType->payment_type}}</td>
                                            <td>{{ $otherExpense->amount }}</td>
                                            <td>
                                                <a href="#" class="btn btn-warning btn-sm rounded-pill edit-btn" style="width: 40%;" data-toggle="modal" data-target="#editOtherExpenseModal" data-id="{{ $otherExpense->id }}"><i class="fa-regular fa-pen-to-square"></i></a>
                                                <form method="post" style="display: inline;" action="{{ route('otherexpense.destroy', $otherExpense->id) }}">
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
<div class="modal fade" id="editOtherExpenseModal" tabindex="-1" role="dialog" aria-labelledby="editOtherExpenseModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editOtherExpenseModalLabel">Edit Other Expense</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editOtherExpenseForm" method="POST" action="">
                @csrf
                @method('PUT')
                <input type="hidden" id="editOtherExpenseId" name="editOtherExpenseId">
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
                        <label for="pettyCashReason_id">Department</label>
                        <select class="form-select" id="pettyCashReason_id" name="pettyCashReason_id">
                            @foreach($pettyCashReasons as $pettyCashReason)
                            <option value="{{ $pettyCashReason->id }}">{{ $pettyCashReason->reason }}</option>
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
                        <input type="number" class="form-control" id="amount" name="amount">
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
                const otherexpenseId = this.getAttribute('data-id');
                const editForm = document.getElementById('editOtherExpenseForm');

                // Set the other income ID in the form
                editForm.querySelector('#editOtherExpenseId').value = otherexpenseId;

                editForm.setAttribute('action', `/otherexpense/${otherexpenseId}`);

                // Fetch the other income data and populate the form fields
                fetch(`/otherexpense/${otherexpenseId}/edit`)
                    .then(response => response.json())
                    .then(data => {
                        editForm.querySelector('#shop_id').value = data.shop_id;
                        editForm.querySelector('#date').value = data.date;
                        editForm.querySelector('#pettyCashReason_id').value = data.expense_reason_id;
                        editForm.querySelector('#paymenttype_id').value = data.paymenttype_id;
                        editForm.querySelector('#amount').value = data.amount;
                        $('#editOtherExpenseModal').modal('show');
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
        });

        $('#editOtherExpenseModal').on('hidden.bs.modal', function() {
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
            // Re-enable scrollbar
            $('body').css('overflow', 'auto');
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const otherExpenseTable = document.getElementById('otherExpenseTable');
        const tableRows = otherExpenseTable.getElementsByTagName('tr');

        searchInput.addEventListener('input', function() {
            const query = searchInput.value.trim().toLowerCase();

            for (let i = 1; i < tableRows.length; i++) {
                const row = tableRows[i];
                const shopCell = row.cells[0]; 
                const dateCell = row.cells[1]; 
                const expenseReasonCell = row.cells[2];
                const paymenttypeCell = row.cells[3];
                const amountCell = row.cells[4];

                if (shopCell && dateCell && expenseReasonCell && paymenttypeCell && amountCell) {
                    const shopText = shopCell.textContent.trim().toLowerCase();
                    const dateText = dateCell.textContent.trim().toLowerCase();
                    const expenseReasonText = expenseReasonCell.textContent.trim().toLowerCase();
                    const paymenttypeText = paymenttypeCell.textContent.trim().toLowerCase();
                    const amountText = amountCell.textContent.trim().toLowerCase();

                    if (shopText.includes(query) || dateText.includes(query) || expenseReasonText.includes(query) || paymenttypeText.includes(query) || amountText.includes(query)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                }
            }
        });
    });
</script>

<script>
    // Automatically close alerts after 5 seconds
    window.setTimeout(function() {
        $(".alert").fadeTo(500, 0).slideUp(500, function(){
            $(this).remove();
        });
    }, 5000);
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
            // Display the total amount within the addOtherExpenseForm
            $('#totalAmountDisplay').text('Total Amount: ' + totalAmount.toFixed(2));
        }

        // Function to add a new row to the repeating form
        $("#addRowBtn").click(function () {
            var newRow = $(".dynamic-row").first().clone();
            // Clear input values for the new row
            newRow.find('select[name="pettyCashReason_id[]"]').val('');
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
 