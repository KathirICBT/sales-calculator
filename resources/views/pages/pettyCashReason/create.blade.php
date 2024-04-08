@extends('layouts.layout')
@section('content')
<div class="container-fluid">
    <div class="mb-3">
        <h4>Add Payment Method</h4>
    </div>
    <div class="row">
        <div class="col-12 col-md-6 d-flex">
            <div class="card flex-fill border-0 illustration">
                <div class="card-body p-0 d-flex flex-fill">
                    <div class="row g-0 w-100">
                        <div class="col-6">
                            <div class="p-3 m-1">
                                <h4>Welcome, {{ session('username') }}</h4>
                                <p class="mb-0">Petty Cash Management</p>
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
            <!-- ERROR 01-->
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
            <!-- ERROR 02 -->
             <!-- success -->
             @if(session('error'))
             <div class="alert alert-danger alert-dismissible fade show d-flex justify-content-between align-items-center"
                 role="alert">
                 <span>{{ session('error') }}</span>
                 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
             </div>
             @endif
            <!-- -->
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-md-6 d-flex">
            <div class="card flex-fill border-0">
                <div class="card-body p-0 d-flex flex-fill">
                    <div class="row g-0 w-100">
                        <div class="col-12">
                            <div class="p-3 m-1">
                                <h4 class="n_h_style rounded">Expense Reason</h4>                                
                                

                                <form class="row g-3" method="POST" action="{{ route('pettycashreason.store') }}">
                                    @csrf
                                    <div class="col-md-12">
                                        <label for="petty_cash_reason" class="form-label">Petty Cash Reason:</label>
                                        <input type="text" class="form-control" id="petty_cash_reason" name="petty_cash_reason">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="expense_category_id" class="form-label">Expense Category:</label>
                                        <select class="form-select" id="expense_category_id" name="expense_category_id">
                                            <option value="">Select Expense Category</option>
                                            @foreach($expenseCategories as $expenseCategory)
                                            <option value="{{ $expenseCategory->id }}">{{ $expenseCategory->category }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="expense_sub_category_id" class="form-label">Expense Sub Category:</label>
                                        <select class="form-select" id="expense_sub_category_id" name="expense_sub_category_id">
                                            <option value="">Select Expense Sub Category</option>
                                            @foreach($expenseSubCategories as $expenseSubCategory)
                                            <option value="{{ $expenseSubCategory->id }}">{{ $expenseSubCategory->sub_category }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-success rounded-pill" style="width: 100%">Add</button>                                        
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
                                <h4 class="n_h2_style rounded">Expense Reasons</h4>
                                 <!-- SEARCH -->
                                <div class="input-group mt-3">
                                    <input type="text" class="form-control" placeholder="Search payment method..." id="searchInput">
                                    <button class="btn btn-outline-secondary" type="button" id="searchButton">Search</button>
                                </div>
                                <!-- SEARCH -->
                                <div style="height: 300px; overflow-y: auto;">
                                    <table class="table" id="paymentMethodTable">
                                        <thead>
                                            <tr>
                                                <th>Reasons</th>
                                                <th>Expense Category</th>
                                                <th>Expense Sub Category</th>
                                                <th scope="col" style="width: 30%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($pettyCashReasons as $pettyCashReason)
                                            <tr>
                                                <td>{{ $pettyCashReason->reason }}</td>
                                                <td>{{ $pettyCashReason->expenseCategory->category }}</td>
                                                <td>{{ $pettyCashReason->expenseSubCategory->sub_category }}</td>
                                                <td>
                                                    <a href="#" class="btn btn-warning btn-sm rounded-pill edit-btn" style="width: 40%;" data-toggle="modal" data-target="#pettyCashReasonModal" data-id="{{ $pettyCashReason->id }}">Edit</a>
                                                    <form method="post" style="display: inline;" action="{{ route('pettycashreason.destroy', $pettyCashReason->id) }}">
                                                        @csrf
                                                        @method('delete')
                                                        <button class="btn btn-danger btn-sm rounded-pill" style="width: 50%;" onclick="return confirm('Are you sure you want to delete this payment method?')" type="submit">Delete</button>
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

<!-- Edit Payment Method Modal -->
<div class="modal fade" id="pettyCashReasonModal" tabindex="-1" role="dialog" aria-labelledby="pettyCashReasonModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pettyCashReasonModalLabel">Edit Petty Cash Reason</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="pettyCashReasonModalForm" method="POST" action="">
                @csrf
                @method('PUT')
                <input type="hidden" id="pettyCashReasonId" name="pettyCashReasonId">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="model_petty_cash_reason" class="form-label">Petty Cash Reason:</label>
                        <input type="text" class="form-control" id="model_petty_cash_reason" name="model_petty_cash_reason">
                    </div>
                    <div class="form-group">
                        <label for="model_expense_category_id" class="form-label">Expense Category:</label>
                        <select class="form-select" id="model_expense_category_id" name="model_expense_category_id">
                            <option value="">Select Expense Category</option>
                            @foreach($expenseCategories as $expenseCategory)
                            <option value="{{ $expenseCategory->id }}">{{ $expenseCategory->category }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="model_expense_sub_category_id" class="form-label">Expense Sub Category:</label>
                        <select class="form-select" id="model_expense_sub_category_id" name="model_expense_sub_category_id">
                            <option value="">Select Expense Sub Category</option>
                            @foreach($expenseSubCategories as $expenseSubCategory)
                            <option value="{{ $expenseSubCategory->id }}">{{ $expenseSubCategory->sub_category }}</option>
                            @endforeach
                        </select>
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
    const editForm = document.getElementById('pettyCashReasonModalForm');
    const expenseCategorySelect = document.getElementById('model_expense_category_id');
    const expenseSubCategorySelect = document.getElementById('model_expense_sub_category_id');
    let isModalSubmitted = false;

    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            const pettyCashReasonId = this.getAttribute('data-id');

            // Set the petty cash reason ID in the form
            editForm.querySelector('#pettyCashReasonId').value = pettyCashReasonId;

            // Set the action URL for the form
            editForm.setAttribute('action', `/pettycashreason/${pettyCashReasonId}`);

            // Fetch the petty cash reason data and populate the form fields
            fetch(`/pettycashreason/${pettyCashReasonId}/edit`)
                .then(response => response.json())
                .then(data => {
                    editForm.querySelector('#model_petty_cash_reason').value = data.reason;
                    expenseCategorySelect.value = data.expense_category_id;
                    populateSubCategories(data.expense_category_id, data.expense_sub_category_id);
                    $('#pettyCashReasonModal').modal('show');
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });
    });

    $('#pettyCashReasonModal').on('hidden.bs.modal', function() {
        if (!isModalSubmitted) {
            // Clear the form fields and reset dropdown lists
            editForm.reset();
            expenseCategorySelect.value = '';
            expenseSubCategorySelect.innerHTML = '<option value="">Select Expense Sub Category</option>';
        }
        isModalSubmitted = false;
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();
    });

    $('#pettyCashReasonModalForm').on('submit', function() {
        // Set the flag to true when the form is submitted
        isModalSubmitted = true;
    });

    // Function to populate Expense Sub Categories based on the selected Expense Category
    function populateSubCategories(categoryId, selectedSubCategoryId = '') {
        if (categoryId) {
            fetch(`/fetch-expense-sub-categories/${categoryId}`)
                .then(response => response.json())
                .then(data => {
                    expenseSubCategorySelect.innerHTML = '<option value="">Select Expense Sub Category</option>';
                    data.forEach(subCategory => {
                        const option = document.createElement('option');
                        option.value = subCategory.id;
                        option.textContent = subCategory.sub_category;
                        if (subCategory.id === selectedSubCategoryId) {
                            option.selected = true;
                        }
                        expenseSubCategorySelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error fetching expense sub categories:', error));
        } else {
            // Reset Expense Sub Category to default if no Expense Category is selected
            expenseSubCategorySelect.innerHTML = '<option value="">Select Expense Sub Category</option>';
        }
    }

    // Event listener for Expense Category selection
    expenseCategorySelect.addEventListener('change', function() {
        const selectedCategoryId = this.value;
        populateSubCategories(selectedCategoryId);
    });
});

</script> --}}

<script>
        document.addEventListener('DOMContentLoaded', function() {
        const editButtons = document.querySelectorAll('.edit-btn');
        const editForm = document.getElementById('pettyCashReasonModalForm');
        const expenseCategorySelect = document.getElementById('model_expense_category_id');
        const expenseSubCategorySelect = document.getElementById('model_expense_sub_category_id');
        let isModalSubmitted = false;

        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                const pettyCashReasonId = this.getAttribute('data-id');

                // Set the petty cash reason ID in the form
                editForm.querySelector('#pettyCashReasonId').value = pettyCashReasonId;

                // Set the action URL for the form
                editForm.setAttribute('action', `/pettycashreason/${pettyCashReasonId}`);

                // Fetch the petty cash reason data and populate the form fields
                fetch(`/pettycashreason/${pettyCashReasonId}/edit`)
                    .then(response => response.json())
                    .then(data => {
                        editForm.querySelector('#model_petty_cash_reason').value = data.reason;
                        expenseCategorySelect.value = data.expense_category_id;
                        populateSubCategories(data.expense_category_id, data.expense_sub_category_id);
                        $('#pettyCashReasonModal').modal('show');
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
        });

        $('#pettyCashReasonModal').on('hidden.bs.modal', function() {
            if (!isModalSubmitted) {
                // Clear the form fields and reset dropdown lists
                editForm.reset();
                expenseCategorySelect.value = '';
                expenseSubCategorySelect.innerHTML = '<option value="">Select Expense Sub Category</option>';
            }
            isModalSubmitted = false;
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
        });

        $('#pettyCashReasonModalForm').on('submit', function() {
            // Set the flag to true when the form is submitted
            isModalSubmitted = true;
        });

        // Function to populate Expense Sub Categories based on the selected Expense Category
        function populateSubCategories(categoryId, selectedSubCategoryId = '') {
            if (categoryId) {
                fetch(`/fetch-expense-sub-categories/${categoryId}`)
                    .then(response => response.json())
                    .then(data => {
                        expenseSubCategorySelect.innerHTML = '<option value="">Select Expense Sub Category</option>';
                        data.forEach(subCategory => {
                            const option = document.createElement('option');
                            option.value = subCategory.id;
                            option.textContent = subCategory.sub_category;
                            if (subCategory.id === selectedSubCategoryId) {
                                option.selected = true;
                            }
                            expenseSubCategorySelect.appendChild(option);
                        });
                    })
                    .catch(error => console.error('Error fetching expense sub categories:', error));
            } else {
                // Reset Expense Sub Category to default if no Expense Category is selected
                expenseSubCategorySelect.innerHTML = '<option value="">Select Expense Sub Category</option>';
            }
        }

        // Event listener for Expense Category selection
        expenseCategorySelect.addEventListener('change', function() {
            const selectedCategoryId = this.value;
            populateSubCategories(selectedCategoryId);
        });

        // Event listener for Expense Sub Category selection
        expenseSubCategorySelect.addEventListener('change', function() {
            const selectedSubCategoryId = this.value;
            // Here you can handle the change in expenseSubCategorySelect
        });
    });
</script>

{{--
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const paymentMethodTable = document.getElementById('paymentMethodTable');
        const tableRows = paymentMethodTable.getElementsByTagName('tr');

        searchInput.addEventListener('input', function() {
            const query = searchInput.value.trim().toLowerCase();

            for (let i = 1; i < tableRows.length; i++) {
                const row = tableRows[i];
                const paymentMethodCell = row.cells[0]; // Assuming payment method name is in the first cell

                if (paymentMethodCell) {
                    const paymentMethodText = paymentMethodCell.textContent.trim().toLowerCase();

                    if (paymentMethodText.includes(query)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                }
            }
        });
    });
</script>
 --}} 
 
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var expenseCategorySelect = document.getElementById('expense_category_id');
        var expenseSubCategorySelect = document.getElementById('expense_sub_category_id');

        // Function to fetch and populate Expense Sub Categories based on the selected Expense Category
        function populateSubCategories(categoryId) {
            fetch(`/fetch-expense-sub-categories/${categoryId}`)
                .then(response => response.json())
                .then(data => {
                    // Clear existing options
                    expenseSubCategorySelect.innerHTML = '';

                    // Add a null option
                    var nullOption = document.createElement('option');
                    nullOption.value = '';
                    nullOption.textContent = 'Select Expense Sub Category';
                    expenseSubCategorySelect.appendChild(nullOption);

                    // Add new options
                    data.forEach(subCategory => {
                        var option = document.createElement('option');
                        option.value = subCategory.id;
                        option.textContent = subCategory.sub_category;
                        expenseSubCategorySelect.appendChild(option);
                    });
                })
                .catch(error => console.error('Error fetching expense sub categories:', error));
        }

        // Event listener for Expense Category selection
        expenseCategorySelect.addEventListener('change', function() {
            var selectedCategoryId = this.value;

            // Reset Expense Sub Category to default if "Select Expense Category" is chosen
            if (selectedCategoryId === '') {
                expenseSubCategorySelect.value = '';
            } else {
                populateSubCategories(selectedCategoryId);
            }
        });

        // Event listener for Expense Sub Category selection
        expenseSubCategorySelect.addEventListener('change', function() {
            var selectedSubCategoryId = this.value;

            // Reset Expense Category to default if "Select Expense Sub Category" is chosen
            if (selectedSubCategoryId === '') {
                expenseCategorySelect.value = '';
            } else {
                // Fetch the associated Expense Category based on the selected Expense Sub Category
                fetch(`/fetch-expense-category/${selectedSubCategoryId}`)
                    .then(response => response.json())
                    .then(data => {
                        // Update the Expense Category dropdown with the fetched category
                        expenseCategorySelect.value = data.category_id;
                    })
                    .catch(error => console.error('Error fetching expense category:', error));
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


