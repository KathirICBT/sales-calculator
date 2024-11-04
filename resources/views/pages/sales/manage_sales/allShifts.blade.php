@extends('layouts.layout')
@section('content')
<div class="container-fluid">    

    <x-content-header title="Shift Sales Management" />   
    <x-alert-message />     

    <!-- Forms -->
    <div class="row">        
        <div class="col-12 col-md-12 d-flex">
            <div class="card flex-fill border-0">
                <div class="card-body p-0 d-flex flex-fill">
                    <div class="row g-0 w-100">
                        <div class="col-12">
                            <div class="p-3 m-1">
                                <h4 class="n_h2_style rounded">All Shifts</h4>
                                {{-- SEARCH --}}
                                <div class="input-group mt-3">
                                    <input type="text" class="form-control" placeholder="Search Shift..."
                                        id="searchInput">
                                    <button class="btn btn-outline-secondary" type="button"
                                        id="searchButton">Search</button>
                                </div>
                                {{-- SEARCH --}}
                                <div style="height: 500px; overflow-y: auto;" class="mt-3 rounded-top">
                                    <table class="table" id="manageSalesTable">
                                        <thead style="position: sticky; top: 0; background-color: #1a1d20; z-index: 1;">
                                            <tr>
                                                <th scope="col">Staff Name</th>
                                                <th scope="col">Shop</th>
                                                <th scope="col">Shift Start Date</th>
                                                <th scope="col">Start Time</th>
                                                <th scope="col">Shift End Date</th>
                                                <th scope="col">End Time</th>                                                
                                                <th scope="col" style="width: 10%">Action</th>
                                                <th scope="col" style="width: 10%">Manage Sales</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($shifts as $shift)
                                            <tr>
                                                <td>{{ $shift->staff->staff_name }}</td>
                                                <td>{{ $shift->shop->name }}</td>
                                                <td>{{ $shift->start_date }}</td>
                                                <td>{{ $shift->start_time }}</td>
                                                <td>{{ $shift->end_date }}</td>
                                                <td>{{ $shift->end_time }}</td>
                                                <td>
                                                    <button class="btn btn-warning btn-sm rounded-pill edit-btn"
                                                        style="width: 100%;" data-toggle="modal"
                                                        data-target="#editShiftModal" data-id="{{ $shift->id }}" data-staff-name="{{ $shift->staff->staff_name }}"><i
                                                            class="fa-regular fa-pen-to-square"></i></button>
                                                    {{-- <form method="post" style="display: inline;"
                                                        action="{{ route('shifts.destroy', $shift->id) }}">
                                                        @csrf
                                                        @method('delete')
                                                        <button class="btn btn-danger btn-sm rounded-pill"
                                                            style="width: 40%;"
                                                            onclick="return confirm('Are you sure you want to delete this Shift?')"
                                                            type="submit"><i class="fa-solid fa-trash-can"></i></button>
                                                    </form> --}}
                                                </td>
                                                <td>
                                                    <a href="{{ route('shifts.manageSales', $shift->id) }}" class="btn btn-info btn-sm rounded-pill" style="width: 100%;">
                                                        <i class="fa-solid fa-list-check"></i> Manage Sales
                                                    </a>
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


<!-- Edit Shift Modal -->
<div class="modal fade" id="editShiftModal" tabindex="-1" role="dialog" aria-labelledby="editShiftModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editShiftModalLabel">Edit Shift</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editShiftForm" method="POST" action="">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="staffId" name="staff_id">

                    
                        <div class="form-group">
                            <label for="staff_name" class="form-label">Staff Name:</label>
                            <input type="text" class="form-control" id="staff_name" name="staff_name" readonly>
                        </div>
       
                    <div class="form-group">
                        <label for="shop_id">Shop:</label>
                        <select name="shop_id" class="form-select" required>
                            <option value="">Select a Shop</option>
                            @foreach($shops as $shop)
                                <option value="{{ $shop->id }}">{{ $shop->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="start_date">Shift Start Date:</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" required>
                    </div>

                    <div class="form-group">
                        <label for="start_time">Start Time:</label>
                        <input type="time" class="form-control" id="start_time" name="start_time" required>
                    </div>

                    <div class="form-group">
                        <label for="end_date">Shift End Date:</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" required>
                    </div>

                    <div class="form-group">
                        <label for="end_time">End Time:</label>
                        <input type="time" class="form-control" id="end_time" name="end_time" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>


@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editButtons = document.querySelectorAll('.edit-btn');

        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                const shiftId = this.getAttribute('data-id');
                const modal = document.getElementById('editShiftModal');
                const editForm = modal.querySelector('form');
                const staffName = this.getAttribute('data-staff-name');

                // Fetch shift data via AJAX
                fetch(`/sales/shiftEdit/${shiftId}/edit`)
                    .then(response => response.json())
                    .then(data => {
                        // Populate form fields with shift data
                        editForm.querySelector('#staffId').value = data.staff_id;
                        
                        editForm.querySelector('#staff_name').value = staffName;
                        editForm.querySelector('[name="shop_id"]').value = data.shop_id;
                        editForm.querySelector('[name="start_date"]').value = data.start_date;
                        editForm.querySelector('[name="start_time"]').value = data.start_time;
                        editForm.querySelector('[name="end_date"]').value = data.end_date;
                        editForm.querySelector('[name="end_time"]').value = data.end_time;

                        // Update the form action URL to include the shift ID
                        editForm.setAttribute('action', `/sales/shiftEdit/${shiftId}`);

                        // Show the edit modal
                        $(modal).modal('show');
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
        });

        // Handle modal close event
        $('#editShiftModal').on('hidden.bs.modal', function() {
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
            $('body').css('overflow', 'auto');
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('searchInput');
        const manageSalesTable = document.getElementById('manageSalesTable');
        const tableRows = manageSalesTable.getElementsByTagName('tr');

        searchInput.addEventListener('input', function () {
            const query = searchInput.value.trim().toLowerCase();
            for (let i = 1; i < tableRows.length; i++) {
                const row = tableRows[i];
                const nameColumn = row.cells[0];
                const shopColumn = row.cells[1];
                const sDateColumn = row.cells[2];
                const sTimeColumn = row.cells[3];
                const eDateColumn = row.cells[4];
                const eTimeColumn = row.cells[5];
                if (nameColumn && shopColumn && sDateColumn && sTimeColumn && eDateColumn && eTimeColumn) {
                    const nameText = nameColumn.textContent.toLowerCase();
                    const shopText = shopColumn.textContent.toLowerCase();
                    const sDateText = sDateColumn.textContent.toLowerCase();
                    const sTimeText = sTimeColumn.textContent.toLowerCase();
                    const eDateText = eDateColumn.textContent.toLowerCase();
                    const eTimeText = eTimeColumn.textContent.toLowerCase();
                    if (nameText.includes(query) || shopText.includes(query) || sDateText.includes(query) || sTimeText.includes(query) || eDateText.includes(query) || eTimeText.includes(query)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                }
            }
        });
    });
</script>

