@extends('layouts.layout')
@section('content')
<div class="container-fluid">

    <x-content-header title="Income Category Management" />
    <x-alert-message />
    
    <div class="row">
        <div class="col-12 col-md-6 d-flex">
            <div class="card flex-fill border-0">
                <div class="card-body p-0 d-flex flex-fill">
                    <div class="row g-0 w-100">
                        <div class="col-12">
                            <div class="p-3 m-1">
                                <h4 class="n_h_style rounded">Income Category</h4>                                
                                <form class="row g-3" method="POST" action="{{ route('income_category.store') }}">
                                    @csrf
                                    <div class="col-md-12">
                                        <label for="income_category" class="form-label">Income Category:</label>
                                        <input type="text" class="form-control" id="income_category" name="income_category">
                                    </div>
                                    <div class="col-6">
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

                            {{-- table --}}

                            <div class="p-3 m-1">
                                <h4 class="n_h2_style rounded">View All income Category</h4>
                                {{-- SEARCH --}}
                                <div class="input-group mt-3">
                                    <input type="text" class="form-control" placeholder="Search Income Category..."
                                        id="searchInput">
                                    <button class="btn btn-outline-secondary" type="button"
                                        id="searchButton">Search</button>
                                </div>
                                {{-- SEARCH --}}
                                <div style="height: 300px; overflow-y: auto;" class="mt-3 rounded-top">
                                    <table class="table" id="incomeCategoryTable">
                                        <thead style="position: sticky; top: 0; background-color: #1a1d20; z-index: 1;">
                                            <tr>
                                                <th>Income Category</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($incomeCategories as $incomeCategory)
                                            <tr>
                                                <td>{{ $incomeCategory->category }}</td>
                                                <td>
                                                    <a href="#" class="btn btn-warning btn-sm rounded-pill edit-btn"
                                                        data-toggle="modal" data-target="#editincomeCategoryModal"
                                                        data-id="{{ $incomeCategory->id }}" style="width: 30%;"><i class="fa-regular fa-pen-to-square"></i></a>
                                                    <form method="post" style="display: inline;"
                                                        action="{{ route('income_category.destroy', $incomeCategory->id) }}">
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
<div class="modal fade" id="editincomeCategoryModal" tabindex="-1" role="dialog" aria-labelledby="editincomeCategoryModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editincomeCategoryModalLabel">Edit Income Category</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editincomeCategoryForm" method="POST" action="">
                @csrf
                @method('PUT')
                <input type="hidden" id="incomeCategoryId" name="incomeCategoryId">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="incomeCategory">Income Category</label>
                        <input type="text" class="form-control mt-3" id="incomeCategory" name="incomeCategory" required>
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
                const incomeCategoryId = this.getAttribute('data-id');
                const editForm = document.getElementById('editincomeCategoryForm');

                // Set the payment method ID in the form
                editForm.querySelector('#incomeCategoryId').value = incomeCategoryId;

                // Set the action URL for the form
                editForm.setAttribute('action', `/income_category/${incomeCategoryId}`);

                // Fetch the payment method data and populate the form fields
                fetch(`/income_category/${incomeCategoryId}/edit`)
                    .then(response => response.json())
                    .then(data => {
                        editForm.querySelector('#incomeCategory').value = data.category;
                        $('#editincomeCategoryModal').modal('show');
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
        });

        $('#editincomeCategoryModal').on('hidden.bs.modal', function() {
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
            $('body').css('overflow', 'auto');
        });
    });
</script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const incomeCategoryTable = document.getElementById('incomeCategoryTable');
        const tableRows = incomeCategoryTable.getElementsByTagName('tr');

        searchInput.addEventListener('input', function() {
            const query = searchInput.value.trim().toLowerCase();

            for (let i = 1; i < tableRows.length; i++) {
                const row = tableRows[i];
                const incomeCategoryCell = row.cells[0]; // Assuming payment method name is in the first cell

                if (incomeCategoryCell) {
                    const incomeCategoryText = incomeCategoryCell.textContent.trim().toLowerCase();

                    if (incomeCategoryText.includes(query)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                }
            }
        });
    });
</script>




