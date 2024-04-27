@extends('layouts.layout')
@section('content')
<div class="container-fluid">

    <x-content-header title="Expense Reason Management" />
    <x-alert-message />

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
                                        <input type="text" class="form-control" id="petty_cash_reason"
                                            name="petty_cash_reason">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="expense_category_id" class="form-label">Expense Category:</label>
                                        <select class="form-select" id="expense_category_id" name="expense_category_id">
                                            <option value="">Select Expense Category</option>
                                            @foreach($expenseCategories as $expenseCategory)
                                            <option value="{{ $expenseCategory->id }}">{{ $expenseCategory->category }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="expense_sub_category_id" class="form-label">Expense Sub
                                            Category:</label>
                                        <select class="form-select" id="expense_sub_category_id"
                                            name="expense_sub_category_id">
                                            <option value="">Select Expense Sub Category</option>
                                            @foreach($expenseSubCategories as $expenseSubCategory)
                                            <option value="{{ $expenseSubCategory->id }}">{{
                                                $expenseSubCategory->sub_category }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-12 mt-3">

                                        <label for="supplier" class="form-label">Select Reason Type:</label>
                                        <div class="form-control">
                                            <div class="form-check form-check-inline col-md-5">
                                                <input class="form-check-input" type="radio" id="store_supplier"
                                                    name="supplier" value="Supplier" checked>
                                                <label class="form-check-label" for="store_supplier">Supplier</label>
                                            </div>
                                            <div class="form-check form-check-inline col-md-5">
                                                <input class="form-check-input" type="radio" id="store_owner"
                                                    name="supplier" value="Owner">
                                                <label class="form-check-label" for="store_owner">Owner</label>
                                            </div>
                                            <div class="form-check form-check-inline col-md-5">
                                                <input class="form-check-input" type="radio" id="store_banking"
                                                    name="supplier" value="Banking">
                                                <label class="form-check-label" for="store_banking">Banking</label>
                                            </div>
                                            <div class="form-check form-check-inline col-md-5">
                                                <input class="form-check-input" type="radio" id="store_income_tax"
                                                    name="supplier" value="Income Tax">
                                                <label class="form-check-label" for="store_income_tax">Income
                                                    Tax</label>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Purchase --}}

                                    <div class="col-md-12" id="purchase_section">
                                        <label for="purchase" class="form-label">Purchase: </label>
                                        <div class="form-control">
                                            <div class="form-check form-check-inline col-md-3">
                                                <input class="form-check-input" type="radio" name="purchase"
                                                    id="expense" value="Expense" checked>
                                                <label class="form-check-label" for="expense">
                                                    Expense
                                                </label>
                                            </div>
                                            <div class="form-check form-check-inline col-md-4">
                                                <input class="form-check-input" type="radio" name="purchase"
                                                    id="normal_purchase" value="Shop Sale">
                                                <label class="form-check-label" for="normal_purchase">
                                                    Shop Sale Purchase
                                                </label>
                                            </div>
                                            <div class="form-check form-check-inline col-md-3">
                                                <input class="form-check-input" type="radio" name="purchase"
                                                    id="fuel_purchase" value="Fuel">
                                                <label class="form-check-label" for="fuel_purchase">
                                                    Fuel Purchase
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Purchase --}}

                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-success rounded-pill"
                                            style="width: 100%"><i class="fa-solid fa-floppy-disk me-1"></i> Add
                                        </button>
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
                                    <input type="text" class="form-control" placeholder="Search payment method..."
                                        id="searchInput">
                                    <button class="btn btn-outline-secondary" type="button"
                                        id="searchButton">Search</button>
                                </div>
                                <!-- SEARCH -->
                                <div style="height: 300px; overflow-y: auto;">
                                    <table class="table" id="expenseReasonsTable">
                                        <thead>
                                            <tr>
                                                <th>Reasons</th>
                                                <th>Category</th>
                                                <th>Sub Category</th>
                                                <th>Expense Type</th>
                                                <th>Purchase Type</th>
                                                <th scope="col" style="width: 20%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($pettyCashReasons as $pettyCashReason)
                                            <tr>
                                                <td>{{ $pettyCashReason->reason }}</td>
                                                <td>{{ $pettyCashReason->expenseCategory->category }}</td>
                                                <td>{{ $pettyCashReason->expenseSubCategory->sub_category }}</td>
                                                <td>{{ $pettyCashReason->supplier }}</td>
                                                <td>{{ $pettyCashReason->purchase_type }}</td>
                                                <td>
                                                    <a href="#" class="btn btn-warning btn-sm rounded-pill edit-btn"
                                                        style="width: 45%;" data-toggle="modal"
                                                        data-target="#pettyCashReasonModal"
                                                        data-id="{{ $pettyCashReason->id }}"
                                                        onclick="toggleModelPurchaseSection('{{ $pettyCashReason->supplier }}')"><i
                                                            class="fa-regular fa-pen-to-square"></i></a>
                                                    <form method="post" style="display: inline;"
                                                        action="{{ route('pettycashreason.destroy', $pettyCashReason->id) }}">
                                                        @csrf
                                                        @method('delete')
                                                        <button class="btn btn-danger btn-sm rounded-pill"
                                                            style="width: 45%;"
                                                            onclick="return confirm('Are you sure you want to delete this payment method?')"
                                                            type="submit"><i class="fa-solid fa-trash-can"></i></button>
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
<div class="modal fade" id="pettyCashReasonModal" tabindex="-1" role="dialog"
    aria-labelledby="pettyCashReasonModalLabel" aria-hidden="true">
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
                        <input type="text" class="form-control" id="model_petty_cash_reason"
                            name="model_petty_cash_reason">
                    </div>
                    <div class="form-group mt-2">
                        <label for="model_expense_category_id" class="form-label">Expense Category:</label>
                        <select class="form-select" id="model_expense_category_id" name="model_expense_category_id">
                            <option value="">Select Expense Category</option>
                            @foreach($expenseCategories as $expenseCategory)
                            <option value="{{ $expenseCategory->id }}">{{ $expenseCategory->category }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mt-2">
                        <label for="model_expense_sub_category_id" class="form-label">Expense Sub Category:</label>
                        <select class="form-select" id="model_expense_sub_category_id"
                            name="model_expense_sub_category_id">
                            <option value="">Select Expense Sub Category</option>
                            @foreach($expenseSubCategories as $expenseSubCategory)
                            <option value="{{ $expenseSubCategory->id }}">{{ $expenseSubCategory->sub_category }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mt-2">
                        <label class="form-label">Select Supplier:</label>
                        <div class="d-flex form-control">
                            <div class="form-check me-3">
                                <input class="form-check-input" type="radio" id="supplier" name="model_supplier"
                                    value="Supplier" checked>
                                <label class="form-check-label" for="supplier">Supplier</label>
                            </div>
                            <div class="form-check me-3">
                                <input class="form-check-input" type="radio" id="owner" name="model_supplier"
                                    value="Owner">
                                <label class="form-check-label" for="owner">Owner</label>
                            </div>
                            <div class="form-check me-3">
                                <input class="form-check-input" type="radio" id="banking" name="model_supplier"
                                    value="Banking">
                                <label class="form-check-label" for="banking">Banking</label>
                            </div>
                            <div class="form-check me-3">
                                <input class="form-check-input" type="radio" id="income_tax" name="model_supplier"
                                    value="Income Tax">
                                <label class="form-check-label" for="income_tax">Income Tax</label>
                            </div>
                        </div>
                    </div>

                    {{-- Purchase --}}

                    <div class="col-md-12" id="model_purchase_section">
                        <label for="model_purchase" class="form-label">Purchase: </label>
                        <div class="form-control">
                            <div class="form-check form-check-inline col-md-3">
                                <input class="form-check-input" type="radio" name="model_purchase"
                                    id="model_expense" value="Expense" checked>
                                <label class="form-check-label" for="model_expense">
                                    Expense
                                </label>
                            </div>
                            <div class="form-check form-check-inline col-md-4">
                                <input class="form-check-input" type="radio" name="model_purchase"
                                    id="model_normal_purchase" value="Shop Sale">
                                <label class="form-check-label" for="model_normal_purchase">
                                    Shop Sale Purchase
                                </label>
                            </div>
                            <div class="form-check form-check-inline col-md-3">
                                <input class="form-check-input" type="radio" name="model_purchase"
                                    id="model_fuel_purchase" value="Fuel">
                                <label class="form-check-label" for="model_fuel_purchase">
                                    Fuel Purchase
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- Purchase --}}

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

                        // Set supplier radio button based on fetched data
                        // const supplierOption = data.supplier === 'Supplier' ? 'Supplier' : 'Other';
                        // editForm.querySelector(`input[name="model_supplier"][value="${supplierOption}"]`).checked = true;

                        // Set supplier radio button based on fetched data
                        const supplierOption = data.supplier;
                        editForm.querySelector(`input[name="model_supplier"][value="${supplierOption}"]`).checked = true;                        

                        const modelPurchaseSection = document.getElementById('model_purchase_section');
                        if (supplierOption === 'Supplier') {
                            const purchaseType = data.purchase_type;
                            editForm.querySelector(`input[name="model_purchase"][value="${purchaseType}"]`).checked = true;
                            modelPurchaseSection.style.display = 'block'; // Display purchase section
                        } else {
                            modelPurchaseSection.style.display = 'none'; // Hide purchase section
                        }

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
            $('body').css('overflow', 'auto');
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


    //Safe ====

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

                        // Set supplier radio button based on fetched data
                        // const supplierOption = data.supplier === 'Supplier' ? 'Supplier' : 'Other';
                        // editForm.querySelector(`input[name="model_supplier"][value="${supplierOption}"]`).checked = true;

                        // Set supplier radio button based on fetched data
                        const supplierOption = data.supplier;
                        editForm.querySelector(`input[name="model_supplier"][value="${supplierOption}"]`).checked = true;

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
            $('body').css('overflow', 'auto');
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

    //=========
</script>




<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const expenseReasonsTable = document.getElementById('expenseReasonsTable');
        const tableRows = expenseReasonsTable.getElementsByTagName('tr');

        searchInput.addEventListener('input', function() {
            const query = searchInput.value.trim().toLowerCase();

            for (let i = 1; i < tableRows.length; i++) {
                const row = tableRows[i];
                const reason = row.cells[0]; // Assuming department is in the first cell
                const expense_category = row.cells[1]; // Assuming payment type is in the second cell
                const expense_sub_category = row.cells[2];
                const supplier = row.cells[3];
                const purchase_type = row.cells[4];

                if (reason && expense_category && expense_sub_category && supplier && purchase_type) {
                    const reasonText = reason.textContent.trim().toLowerCase();
                    const expense_categoryText = expense_category.textContent.trim().toLowerCase();
                    const expense_sub_categoryText = expense_sub_category.textContent.trim().toLowerCase();
                    const supplierText = supplier.textContent.trim().toLowerCase();
                    const purchase_typeText = purchase_type.textContent.trim().toLowerCase();

                    if (reasonText.includes(query) || expense_categoryText.includes(query) || expense_sub_categoryText.includes(query) || supplierText.includes(query) || purchase_typeText.includes(query)) {
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
    document.addEventListener('DOMContentLoaded', function() {
        const storeSupplierRadioButton = document.getElementById('store_supplier');
        const purchaseSection = document.getElementById('purchase_section');

        // Function to show/hide purchase section based on radio button state
        function togglePurchaseSection() {
            if (storeSupplierRadioButton.checked) {
                purchaseSection.style.display = 'block';
            } else {
                purchaseSection.style.display = 'none';
            }
        }

        // Initial toggle based on initial radio button state
        togglePurchaseSection();

        // Add event listener to the radio button group
        const radioButtons = document.querySelectorAll('input[name="supplier"]');
        radioButtons.forEach(function(button) {
            button.addEventListener('change', togglePurchaseSection);
        });
    });
</script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modelSupplierRadioButtons = document.querySelectorAll('input[name="model_supplier"]');
        const modelPurchaseSection = document.getElementById('model_purchase_section');
        
        function toggleModelPurchaseSection() {
            modelPurchaseSection.style.display = modelSupplierRadioButtons[0].checked ? 'block' : 'none';
        }
        
        toggleModelPurchaseSection();
        
        modelSupplierRadioButtons.forEach(function(radioButton) {
            radioButton.addEventListener('change', toggleModelPurchaseSection);
        });
    });
</script>
