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
                                <h4 class="n_h_style rounded">Add Other Income</h4>
                                <form id="addOtherIncomeForm" class="row g-3" method="POST" action="{{ route('otherincome.store') }}">
                                    @csrf
                                    <div class="col-md-12">
                                        <label for="shop_id" class="form-label">Shop:</label>
                                        <select name="shop_id" id="shop_id" required>
                                            <option value="">Select a Shop</option>
                                            @foreach($shops as $shop)
                                            <option value="{{ $shop->id }}">{{ $shop->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="date" class="form-label">Date:</label>
                                        <input type="date" class="form-control" id="date" name="date" required>
                                    </div>
                                    <div id="dynamicRows" class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Department</th>
                                                    <th>Payment Type</th>
                                                    <th>Amount</th>
                                                    <th><button type="button" class="btn btn-primary rounded-pill mt-3" id="addRowBtn">Add Row</button></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="dynamic-row">
                                                    <td>
                                                        <select class="form-select" name="other_income_department_id[]" required>
                                                            @foreach($other_income_departments as $other_income_department)
                                                            <option value="{{ $other_income_department->id }}">{{ $other_income_department->income_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select class="form-select" name="paymenttype_id[]" required>
                                                            @foreach($paymentTypes as $paymentType)
                                                            <option value="{{ $paymentType->id }}">{{ $paymentType->payment_type }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="number" class="form-control" name="amount[]" required>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-danger rounded-pill remove-row-btn">Remove</button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <button type="submit" class="btn btn-primary rounded-pill mt-3" form="addOtherIncomeForm">Add Other Income</button>
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
        <div class="col-12 d-flex">
            <div class="card flex-fill border-0">
                <div class="card-body p-0 d-flex flex-fill">
                    <div class="row g-0 w-100">
                        <div class="col-12">
                            <div class="p-3 m-1">
                                <h4 class="n_h2_style rounded">Other Incomes</h4>
                                {{-- SEARCH --}}
                                <div class="input-group mt-3">
                                    <input type="text" class="form-control" placeholder="Search other income..." id="searchInput">
                                    <button class="btn btn-outline-secondary" type="button" id="searchButton">Search</button>
                                </div>
                                {{-- SEARCH --}}
                                <div style="overflow-x: auto;">
                                    <table class="table" id="otherIncomeTable">
                                        <thead>
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
                        <select class="form-select" id="shop_id" name="shop_id" required>
                            <option value="">Select a Shop</option>
                            @foreach($shops as $shop)
                            <option value="{{ $shop->id }}">{{ $shop->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="date">Date:</label>
                        <input type="date" class="form-control" id="date" name="date" required>
                    </div>
                    <div class="form-group">
                        <label for="other_income_department_id">Department</label>
                        <select class="form-select" id="other_income_department_id" name="other_income_department_id" required>
                            @foreach($other_income_departments as $other_income_department)
                            <option value="{{ $other_income_department->id }}">{{ $other_income_department->income_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="paymenttype_id">Payment Type</label>
                        <select class="form-select" id="paymenttype_id" name="paymenttype_id" required>
                            @foreach($paymentTypes as $paymentType)
                            <option value="{{ $paymentType->id }}">{{ $paymentType->payment_type }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="amount">Amount</label>
                        <input type="number" class="form-control" id="amount" name="amount" required>
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
                const departmentCell = row.cells[0]; // Assuming department is in the first cell
                const paymentTypeCell = row.cells[1]; // Assuming payment type is in the second cell
                const amountCell = row.cells[2];

                if (departmentCell && paymentTypeCell && amountCell) {
                    const departmentText = departmentCell.textContent.trim().toLowerCase();
                    const paymentTypeText = paymentTypeCell.textContent.trim().toLowerCase();
                    const amountText = amountCell.textContent.trim().toLowerCase();

                    if (departmentText.includes(query) || paymentTypeText.includes(query) || amountText.includes(query)) {
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const addRowBtn = document.getElementById('addRowBtn');
        const dynamicRows = document.getElementById('dynamicRows');

        addRowBtn.addEventListener('click', function() {
            const rowHtml = `
                <tr class="dynamic-row">
                    <td>
                        <select class="form-select" name="other_income_department_id[]" required>
                            @foreach($other_income_departments as $other_income_department)
                            <option value="{{ $other_income_department->id }}">{{ $other_income_department->income_name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <select class="form-select" name="paymenttype_id[]" required>
                            @foreach($paymentTypes as $paymentType)
                            <option value="{{ $paymentType->id }}">{{ $paymentType->payment_type }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input type="number" class="form-control" name="amount[]" required>
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger rounded-pill remove-row-btn">Remove</button>
                    </td>
                </tr>
            `;
            dynamicRows.querySelector('tbody').insertAdjacentHTML('beforeend', rowHtml);
        });

        dynamicRows.addEventListener('click', function(event) {
            if (event.target.classList.contains('remove-row-btn')) {
                const row = event.target.closest('.dynamic-row');
                row.remove();
            }
        });
    });
</script>