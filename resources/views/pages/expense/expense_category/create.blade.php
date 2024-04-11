@extends('layouts.layout')
@section('content')
<div class="container-fluid">
    <div class="mb-3">
        <h4>Add Expense Category</h4>
    </div>
    <div class="row">
        <div class="col-12 col-md-6 d-flex">
            <div class="card flex-fill border-0 illustration">
                <div class="card-body p-0 d-flex flex-fill">
                    <div class="row g-0 w-100">
                        <div class="col-6">
                            <div class="p-3 m-1">
                                <h4>Welcome, {{ session('username') }}</h4>
                                <p class="mb-0">Expense Category Management</p>
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
                                <h4 class="n_h_style rounded">Expense Category</h4>                                
                                <form class="row g-3" method="POST" action="{{ route('expense_category.store') }}">
                                    @csrf
                                    <div class="col-md-12">
                                        <label for="expense_category" class="form-label">Expense Category:</label>
                                        <input type="text" class="form-control" id="expense_category" name="expense_category">
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



                            {{-- table --}}

                            <div class="p-3 m-1">
                                <h4 class="n_h2_style rounded">View All Expense Category</h4>
                                {{-- SEARCH --}}
                                <div class="input-group mt-3">
                                    <input type="text" class="form-control" placeholder="Search Expense Category..."
                                        id="searchInput">
                                    <button class="btn btn-outline-secondary" type="button"
                                        id="searchButton">Search</button>
                                </div>
                                {{-- SEARCH --}}
                                <div style="height: 300px; overflow-y: auto;">
                                    <table class="table" id="expenseCategoryTable">
                                        <thead>
                                            <tr>
                                                <th>Expense Category</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($expenseCategories as $expenseCategory)
                                            <tr>
                                                <td>{{ $expenseCategory->category }}</td>
                                                <td>
                                                    <a href="#" class="btn btn-warning btn-sm rounded-pill edit-btn"
                                                        data-toggle="modal" data-target="#editexpenseCategoryModal"
                                                        data-id="{{ $expenseCategory->id }}" style="width: 30%;"><i class="fa-regular fa-pen-to-square"></i></a>
                                                    <form method="post" style="display: inline;"
                                                        action="{{ route('expense_category.destroy', $expenseCategory->id) }}">
                                                        @csrf
                                                        @method('delete')
                                                        <button class="btn btn-danger btn-sm rounded-pill"
                                                            onclick="return confirm('Are you sure you want to delete this payment type?')"
                                                            type="submit" style="width: 30%;"><i class="fa-solid fa-trash-can"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            {{-- table --}}


                            
                        </div>
                    </div>
                </div>
            </div>
        </div>        
    </div>
</div>
@endsection

<!-- Edit Payment Method Modal -->
<div class="modal fade" id="editexpenseCategoryModal" tabindex="-1" role="dialog" aria-labelledby="editexpenseCategoryModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editexpenseCategoryModalLabel">Edit Expense Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editexpenseCategoryForm" method="POST" action="">
                @csrf
                @method('PUT')
                <input type="hidden" id="expenseCategoryId" name="expenseCategoryId">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="expenseCategory">Expense Category</label>
                        <input type="text" class="form-control mt-3" id="expenseCategory" name="expenseCategory" required>
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
                const expenseCategoryId = this.getAttribute('data-id');
                const editForm = document.getElementById('editexpenseCategoryForm');

                // Set the payment method ID in the form
                editForm.querySelector('#expenseCategoryId').value = expenseCategoryId;

                // Set the action URL for the form
                editForm.setAttribute('action', `/expense_category/${expenseCategoryId}`);

                // Fetch the payment method data and populate the form fields
                fetch(`/expense_category/${expenseCategoryId}/edit`)
                    .then(response => response.json())
                    .then(data => {
                        editForm.querySelector('#expenseCategory').value = data.category;
                        $('#editexpenseCategoryModal').modal('show');
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
        });

        $('#editexpenseCategoryModal').on('hidden.bs.modal', function() {
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
            $('body').css('overflow', 'auto');
        });
    });
</script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const expenseCategoryTable = document.getElementById('expenseCategoryTable');
        const tableRows = expenseCategoryTable.getElementsByTagName('tr');

        searchInput.addEventListener('input', function() {
            const query = searchInput.value.trim().toLowerCase();

            for (let i = 1; i < tableRows.length; i++) {
                const row = tableRows[i];
                const expenseCategoryCell = row.cells[0]; // Assuming payment method name is in the first cell

                if (expenseCategoryCell) {
                    const expenseCategoryText = expenseCategoryCell.textContent.trim().toLowerCase();

                    if (expenseCategoryText.includes(query)) {
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



