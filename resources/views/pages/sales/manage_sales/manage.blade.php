@extends('layouts.layout')
@section('content')
<div class="container-fluid">    

    <x-content-header title="Sales Management" />   
    <x-alert-message />     

    <!-- Forms -->
    <div class="row">        
        <div class="col-12 col-md-12 d-flex">
            <div class="card flex-fill border-0">
                <div class="card-body p-0 d-flex flex-fill">
                    <div class="row g-0 w-100">
                        <div class="col-12">
                            <div class="p-3 m-1">
                                <h4 class="n_h2_style rounded">All Sales</h4>
                                {{-- SEARCH --}}
                                <div class="input-group mt-3">
                                    <input type="text" class="form-control" placeholder="Search Sales..."
                                        id="searchInput">
                                    <button class="btn btn-outline-secondary" type="button"
                                        id="searchButton">Search</button>
                                </div>
                                {{-- SEARCH --}}
                                <div style="height: 500px; overflow-y: auto;" class="mt-3 rounded-top">
                                    <table class="table" id="salesTable">
                                        <thead style="position: sticky; top: 0; background-color: #1a1d20; z-index: 1;">
                                            <tr>
                                                <th scope="col">Staff Name</th>
                                                <th scope="col">Shift Start Date</th>
                                                <th scope="col">Shift Start Time</th>
                                                <th scope="col">Department</th>
                                                <th scope="col">Amount</th>
                                                <th scope="col" style="width: 20%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($sales as $sale)
                                            <tr>
                                                <td>{{ $sale->shift->staff->staff_name }}</td>
                                                <td>{{ $sale->shift->start_date }}</td>
                                                <td>{{ $sale->shift->start_time }}</td>
                                                <td>{{ $sale->department->dept_name }}</td>
                                                <td>{{ $sale->amount }}</td>
                                                <td>
                                                    <button class="btn btn-warning btn-sm rounded-pill edit-btn"
                                                        style="width: 40%;" data-toggle="modal"
                                                        data-target="#editSaleModal" data-id="{{ $sale->id }}"><i
                                                            class="fa-regular fa-pen-to-square"></i></button>
                                                    <form method="post" style="display: inline;"
                                                        action="{{ route('sales.destroy', $sale->id) }}">
                                                        @csrf
                                                        @method('delete')
                                                        <button class="btn btn-danger btn-sm rounded-pill"
                                                            style="width: 40%;"
                                                            onclick="return confirm('Are you sure you want to delete this shop?')"
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

<!-- Edit Shop Modal -->
<div class="modal fade" id="editSaleModal" tabindex="-1" role="dialog" aria-labelledby="editSaleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSaleModalLabel">Edit Shop</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editSaleForm" method="POST" action="">
                @csrf
                @method('PUT')
                <input type="hidden" id="saleId" name="saleId">
                <div class="modal-body">
                    <div class="form-group">                        
                        <label for="dept_id">Department:</label>
                        <select name="dept_id" id="dept_id" class="form-select mt-1" required>
                            <option value="">Select a Department</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->dept_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mt-2">
                        <label for="amount">Amount:</label>
                        <input type="number" class="form-control mt-1" id="amount" name="amount" required>
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
                const saleId = this.getAttribute('data-id');
                const modal = document.getElementById('editSaleModal');
                const editForm = document.getElementById('editSaleForm');

                editForm.querySelector('#saleId').value = saleId;

                editForm.setAttribute('action', `/sales/${saleId}`);

                fetch(`/sales/${saleId}/edit`)
                    .then(response => response.json())
                    .then(data => {
                        //alert(data.dept_id);
                        editForm.querySelector('#dept_id').value = data.dept_id;
                        editForm.querySelector('#amount').value = data.amount;                        
                        $('#editSaleModal').modal('show');
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
        });

        $('#editSaleModal').on('hidden.bs.modal', function() {
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
            $('body').css('overflow', 'auto');
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('searchInput');
        const salesTable = document.getElementById('salesTable');
        const tableRows = salesTable.getElementsByTagName('tr');

        searchInput.addEventListener('input', function () {
            const query = searchInput.value.trim().toLowerCase();
            for (let i = 1; i < tableRows.length; i++) {
                const row = tableRows[i];
                const nameColumn = row.cells[0];
                const dateColumn = row.cells[1];
                const timeColumn = row.cells[2];
                const deptColumn = row.cells[3];
                const amountColumn = row.cells[4];
                if (nameColumn && dateColumn && timeColumn && deptColumn && amountColumn) {
                    const nameText = nameColumn.textContent.toLowerCase();
                    const dateText = dateColumn.textContent.toLowerCase();
                    const timeText = timeColumn.textContent.toLowerCase();
                    const deptText = deptColumn.textContent.toLowerCase();
                    const amountText = amountColumn.textContent.toLowerCase();
                    if (nameText.includes(query) || dateText.includes(query) || timeText.includes(query) || deptText.includes(query) || amountText.includes(query)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                }
            }
        });
    });
</script>