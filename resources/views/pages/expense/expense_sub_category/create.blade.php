@extends('layouts.layout')

@section('content')
<div class="container-fluid">

    <x-content-header title="Expense Sub Category Management" />  
    <x-alert-message />    
    
    <div class="row">
        <div class="col-12 col-md-6 d-flex">
            <div class="card flex-fill border-0">
                <div class="card-body p-0 d-flex flex-fill">
                    <div class="row g-0 w-100">
                        <div class="col-12">
                            <div class="p-3 m-1">
                                <h4 class="n_h_style rounded">Add Expense Sub Category</h4>                                
                                <form class="row g-3" method="POST" action="{{ route('expense_sub_category.store') }}">
                                    @csrf                                    
                                    <div class="col-md-6">
                                        <label for="category_id" class="form-label">Category:</label>
                                        <select class="form-select" id="category_id" name="category_id">
                                            <option value="">Select Expense Category</option>
                                            @foreach($expenseCategories as $expenseCategory)
                                            <option value="{{ $expenseCategory->id }}">{{ $expenseCategory->category }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label for="sub_category" class="form-label">Sub Category:</label>
                                        <input type="text" class="form-control" id="sub_category" name="sub_category">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="report_order_number" class="form-label">Report Order Number:</label>
                                        <input type="text" class="form-control" id="report_order_number" name="report_order_number">
                                    </div>

                                    {{-- sub cat bombo --}}

                                    {{-- <div class="col-md-6">
                                        <label for="sub_category" class="form-label">Sub Category:</label>
                                        <select class="form-select" id="sub_category" name="sub_category">
                                            <option value="">Select Expense Category</option>
                                            <option value="Purchases">Purchases</option>
                                            <option value="Wages">Wages</option>
                                            <option value="Pension Cost">Pension Cost</option>
                                            <option value="PAYE Tax">PAYE Tax</option>
                                            <option value="Rent">Rent</option>
                                            <option value="Rates">Rates</option>
                                            <option value="Telephone">Telephone</option>
                                            <option value="Insurance">Insurance</option>
                                            <option value="Repairs">Repairs</option>
                                            <option value="Bank charges">Bank charges</option>
                                            <option value="Bank Interest">Bank Interest</option>
                                            <option value="Legal Fee">Legal Fee</option>
                                            <option value="Accountant Fee">Accountant Fee</option>
                                            <option value="Alarm">Alarm</option>
                                            <option value="VAT">VAT</option>
                                            <option value="Income Tax">Income Tax</option>
                                            <option value="Lottery">Lottery</option>
                                            <option value="Paypoint">Paypoint</option>
                                            <option value="Busspass">Busspass</option>
                                            <option value="Payzone">Payzone</option>
                                            <option value="Loan Repayment">Loan Repayment</option>
                                            <option value="Other staff costs">Other staff costs</option>
                                            <option value="Light and heat">Light and heat</option>
                                            <option value="Motor Expenses">Motor Expenses</option>
                                            <option value="Marketing">Marketing</option>
                                            <option value="Service charge">Service charge</option>
                                            <option value="Management Charges">Management Charges</option>
                                            <option value="Post, Print and stationary">Post, Print and stationary</option>                                            
                                            <option value="Professional Fee">Professional Fee</option>
                                            <option value="Cleaning">Cleaning</option>
                                            <option value="Fines and Penalty">Fines and Penalty</option>
                                            <option value="Donation">Donation</option>
                                            <option value="Sundry Ecpenses">Sundry Ecpenses</option>
                                            <option value="Corppration Tax">Corppration Tax</option>
                                            <option value="Fixed Asset Purchase">Fixed Asset Purchase</option>
                                            
                                            @foreach($expenseCategories as $expenseCategory)
                                            <option value="{{ $expenseCategory->id }}">{{ $expenseCategory->category }}</option>
                                            @endforeach
                                        </select>
                                    </div> --}}

                                    {{-- ============= --}}



                                    <div class="col-6">
                                        <label for="" class="form-label">Save Sub Category:</label>
                                        <button type="submit" class="btn btn-success rounded-pill" style="width: 100%"><i class="fa-solid fa-floppy-disk me-1"></i> Add </button>                                        
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
                                <h4 class="n_h2_style rounded">Expense Sub Category</h4>
                                
                                <div class="input-group mt-3">
                                    <input type="text" class="form-control" placeholder="Search Expense Sub Category..." id="searchInput">
                                    <button class="btn btn-outline-secondary" type="button" id="searchButton">Search</button>
                                </div>
                                
                                <div style="height: 300px; overflow-y: auto;" class="mt-3 rounded-top">
                                    <table class="table" id="expenseSubCategoryTable">
                                        <thead style="position: sticky; top: 0; background-color: #1a1d20; z-index: 1;">
                                            <tr>
                                                <th>Expense Category</th>
                                                <th>Expense Sub Category</th> 
                                                <th style="width: 15%">Order</th>                                                
                                                <th style="width: 25%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($expenseSubCategories as $expenseSubCategory)
                                            <tr>
                                                <td>{{ $expenseSubCategory->expenseCategory->category }}</td>
                                                <td>{{ $expenseSubCategory->sub_category }}</td>
                                                <td>{{ $expenseSubCategory->report_order_number }}</td>
                                                <td>
                                                    <a href="#" class="btn btn-warning btn-sm rounded-pill edit-btn" style="width: 40%;" data-toggle="modal" data-target="#editExpenseSubCategoryModal" data-id="{{ $expenseSubCategory->id }}"><i class="fa-regular fa-pen-to-square"></i></a>
                                                    <form method="post" style="display: inline;" action="{{ route('expense_sub_category.destroy', $expenseSubCategory->id) }}">
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
<div class="modal fade" id="editExpenseSubCategoryModal" tabindex="-1" role="dialog" aria-labelledby="editExpenseSubCategoryModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editExpenseSubCategoryModalLabel">Edit Expense Sub Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editExpenseSubCategoryForm" method="POST" action="">
                @csrf
                @method('PUT')
                <input type="hidden" id="editExpenseSubCategoryId" name="editExpenseSubCategoryId">
                <div class="modal-body">                    
                    <div class="form-group">
                        <label for="category_id">Expense Category</label>
                        <select class="form-select" id="category_id" name="category_id" required>
                            @foreach($expenseCategories as $expenseCategory)
                            <option value="{{ $expenseCategory->id }}">{{ $expenseCategory->category }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="sub_category">Expense Sub Category</label>
                        <input type="text" class="form-control" id="sub_category" name="sub_category" required>
                    </div>

                    <div class="form-group">
                        <label for="report_order_number">Report Order Number:</label>
                        <input type="text" class="form-control" id="report_order_number" name="report_order_number">
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
                const editExpenseSubCategoryId = this.getAttribute('data-id');
                const editForm = document.getElementById('editExpenseSubCategoryForm');

                // Set the other income ID in the form
                editForm.querySelector('#editExpenseSubCategoryId').value = editExpenseSubCategoryId;
                editForm.setAttribute('action', `/expense_sub_category/${editExpenseSubCategoryId}`);
                // Fetch the other income data and populate the form fields
                fetch(`/expense_sub_category/${editExpenseSubCategoryId}/edit`)
                    .then(response => response.json())
                    .then(data => {                        
                        editForm.querySelector('#category_id').value = data.category_id;
                        editForm.querySelector('#sub_category').value = data.sub_category;
                        editForm.querySelector('#report_order_number').value = data.report_order_number;
                        $('#editExpenseSubCategoryModal').modal('show');
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
        });

        $('#editExpenseSubCategoryModal').on('hidden.bs.modal', function() {
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
            $('body').css('overflow', 'auto');
        });
    });
</script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const expenseSubCategoryTable = document.getElementById('expenseSubCategoryTable');
        const tableRows = expenseSubCategoryTable.getElementsByTagName('tr');

        searchInput.addEventListener('input', function() {
            const query = searchInput.value.trim().toLowerCase();

            for (let i = 1; i < tableRows.length; i++) {
                const row = tableRows[i];
                const categoryCell = row.cells[0];
                const subCategoryCell = row.cells[1];
                const orderNumberCell = row.cells[2];             

                if (categoryCell && subCategoryCell && orderNumberCell) {
                    const categoryText = categoryCell.textContent.trim().toLowerCase();
                    const subCategoryText = subCategoryCell.textContent.trim().toLowerCase();  
                    const orderNumberText = orderNumberCell.textContent.trim().toLowerCase();                  

                    if (categoryText.includes(query) || subCategoryText.includes(query) || orderNumberText.includes(query)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                }
            }
        });
    });
</script>
