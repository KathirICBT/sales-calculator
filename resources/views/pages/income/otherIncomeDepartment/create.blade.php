@extends('layouts.layout')

@section('content')
<div class="container-fluid">

    <x-content-header title="Other Income Department Management" /> 
    <x-alert-message />    

    <!-- Forms -->
    <div class="row">
        <div class="col-12 col-md-6 d-flex">
            <div class="card flex-fill border-0">
                <div class="card-body p-0 d-flex flex-fill">
                    <div class="row g-0 w-100">
                        <div class="col-12">
                            <div class="p-3 m-1">
                                <h4 class="n_h_style rounded">Add Other Income Department</h4>                                
                                <form class="row g-3" method="POST"
                                    action="{{ route('other_income_departments.store') }}">
                                    @csrf
                                    <div class="col-md-6">
                                        <label for="income_name" class="form-label">Income Name: </label>
                                        <input type="text" class="form-control" id="income_name" name="income_name">
                                    </div>

                                    <div class="col-md-6">
                                        <label for="category_id" class="form-label">Category:</label>
                                        <select class="form-select" id="category_id" name="category_id">
                                            <option value="">Select Income Category</option>
                                            @foreach($incomeCategories as $incomeCategory)
                                            <option value="{{ $incomeCategory->id }}">{{ $incomeCategory->category }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-12">
                                        <label for="subcategory" class="form-label">Subcategory: </label>
                                        <div class="form-control">
                                            <div class="form-check form-check-inline col-md-6">
                                                <input class="form-check-input" type="radio" name="subcategory"
                                                    id="direct_income" value="Direct Income" checked>
                                                <label class="form-check-label" for="direct_income">
                                                    Direct
                                                </label>
                                            </div>
                                            <div class="form-check form-check-inline col-md-4">
                                                <input class="form-check-input" type="radio" name="subcategory"
                                                    id="calculated_income" value="Calculated Income">
                                                <label class="form-check-label" for="calculated_income">
                                                    Calculated
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
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
                                <h4 class="n_h2_style rounded">Other Income Departments</h4>
                                {{-- SEARCH --}}
                                <div class="input-group mt-3">
                                    <input type="text" class="form-control" placeholder="Search department..."
                                        id="searchInput">
                                    <button class="btn btn-outline-secondary" type="button"
                                        id="searchButton">Search</button>
                                </div>
                                {{-- SEARCH --}}
                                <div style="height: 300px; overflow-y: auto;">
                                    <table class="table" id="otherIncomeDepartmentTable">
                                        <thead>
                                            <tr>
                                                <th scope="col">Income Name</th>
                                                <th scope="col">Category</th>
                                                <th scope="col">Subcategory</th>
                                                <th scope="col" style="width: 30%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($otherIncomeDepartments as $otherIncomeDepartment)
                                            <tr>
                                                <td>{{ $otherIncomeDepartment->income_name }}</td>
                                                <td>{{ $otherIncomeDepartment->incomeCategory->category }}</td>
                                                <td>{{ $otherIncomeDepartment->subcategory }}</td>
                                                <td>
                                                    <button class="btn btn-warning btn-sm rounded-pill edit-btn"
                                                        style="width: 40%;" data-toggle="modal"
                                                        data-target="#editOtherIncomeDepartmentModal"
                                                        data-id="{{ $otherIncomeDepartment->id }}"><i class="fa-regular fa-pen-to-square"></i></button>
                                                    <form method="post" style="display: inline;"
                                                        action="{{ route('other_income_departments.destroy', $otherIncomeDepartment->id) }}">
                                                        @csrf
                                                        @method('delete')
                                                        <button class="btn btn-danger btn-sm rounded-pill"
                                                            style="width: 40%;"
                                                            onclick="return confirm('Are you sure you want to delete this department?')"
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
    <!-- Forms end -->
</div>
@endsection

<!-- Edit Other Income Department Modal -->
<div class="modal fade" id="editOtherIncomeDepartmentModal" tabindex="-1" role="dialog"
    aria-labelledby="editOtherIncomeDepartmentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editOtherIncomeDepartmentModalLabel">Edit Other Income Department</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editOtherIncomeDepartmentForm" method="POST" action="">
                @csrf
                @method('PUT')
                <input type="hidden" id="editOtherIncomeDepartmentId" name="id">
                <div class="modal-body">
                    <div class="form-group mt-3">
                        <label for="edit_income_name">Income Name:</label>
                        <input type="text" class="form-control mt-2" id="edit_income_name" name="income_name" required>
                    </div>

                    <div class="form-group mt-3">
                        <label for="category_id">Income Category</label>
                        <select class="form-select" id="category_id" name="category_id" required>
                            @foreach($incomeCategories as $incomeCategory)
                            <option value="{{ $incomeCategory->id }}">{{ $incomeCategory->category }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="form-group mt-3">
                        <label>Subcategory:</label>
                        <div class="form-control mt-2">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="edit_subcategory"
                                    id="edit_direct_income" value="Direct Income" checked>
                                <label class="form-check-label" for="edit_direct_income">
                                    Direct
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="edit_subcategory"
                                    id="edit_calculated_income" value="Calculated Income">
                                <label class="form-check-label" for="edit_calculated_income">
                                    Calculated
                                </label>
                            </div>
                        </div>
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


<!-- Bootstrap JS (jQuery required) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- Custom JavaScript -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
    const editButtons = document.querySelectorAll('.edit-btn');

    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            const otherIncomeDepartmentId = this.getAttribute('data-id');
            const modal = document.getElementById('editOtherIncomeDepartmentModal');
            const editForm = document.getElementById('editOtherIncomeDepartmentForm');
            
            editForm.querySelector('#editOtherIncomeDepartmentId').value = otherIncomeDepartmentId;
            
            editForm.setAttribute('action', `/other_income_departments/${otherIncomeDepartmentId}`); 

            fetch(`/other_income_departments/${otherIncomeDepartmentId}/edit`)
                .then(response => response.json())
                .then(data => {     
                    editForm.querySelector('#edit_income_name').value = data.income_name;
                    editForm.querySelector('#category_id').value = data.category_id;
                    if (data.subcategory === 'Calculated Income') {
                        editForm.querySelector('#edit_calculated_income').checked = true;
                    } else {
                        editForm.querySelector('#edit_direct_income').checked = true;
                    }
                    $('#editOtherIncomeDepartmentModal').modal('show');
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });
    });
    
    $('#editOtherIncomeDepartmentModal').on('hidden.bs.modal', function () {
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();
        $('body').css('overflow', 'auto');
    });
});

</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const otherIncomeDepartmentTable = document.getElementById('otherIncomeDepartmentTable');
        const tableRows = otherIncomeDepartmentTable.getElementsByTagName('tr');

        searchInput.addEventListener('input', function() {
            const query = searchInput.value.trim().toLowerCase();

            for (let i = 1; i < tableRows.length; i++) {
                const row = tableRows[i];
                const incomeNameCell = row.cells[0];
                const categoryCell = row.cells[1];
                const subCategoryCell = row.cells[2];             

                if (incomeNameCell && categoryCell && subCategoryCell) {
                    const incomeNameText = incomeNameCell.textContent.trim().toLowerCase();
                    const categoryText = categoryCell.textContent.trim().toLowerCase();
                    const subCategoryText = subCategoryCell.textContent.trim().toLowerCase();                    

                    if (incomeNameText.includes(query) || categoryText.includes(query) || subCategoryText.includes(query)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                }
            }
        });
    });
</script>