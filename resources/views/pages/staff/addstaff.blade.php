@extends('layouts.layout')
@section('content')
<div class="container-fluid">

    <x-content-header title="Staff Management" /> 
    <x-alert-message />      

    <!-- Forms -->
    <div class="row">
        <div class="col-12 col-md-6 d-flex">
            <div class="card flex-fill border-0">
                <div class="card-body p-0 d-flex flex-fill">
                    <div class="row g-0 w-100">
                        <div class="col-12">
                            <div class="p-3 m-1">
                                <h4 class="n_h_style rounded">Add Staff</h4>                                
                                <form class="row g-3" method="POST" action="{{ route('staff.addstaff.submit') }}">
                                    @csrf
                                    <div class="col-md-6">
                                        <label for="staff_name" class="form-label">Staff Name: </label>
                                        <input type="text" class="form-control" id="staff_name" name="staff_name">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="phone" class="form-label">Phone:</label>
                                        <input type="text" class="form-control" id="phone" name="phonenumber">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="username" class="form-label">Username:</label>
                                        <input type="text" class="form-control" id="username" name="username">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="password" class="form-label">Password:</label>
                                        <input type="password" class="form-control" id="password" name="password"
                                            >
                                    </div>
                                    <div class="col-md-6">
                                        <label for="shop_id" class="form-label">Shop:</label>
                                        <select name="shop_id" id="shop_id" class="form-select" required>
                                            <option value="" >Select a Shop</option>
                                            @foreach($shops as $shop)
                                                <option value="{{ $shop->id }}">{{ $shop->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="shop_id" class="form-label">Save:</label>
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
                                <h4 class="n_h2_style rounded">Staffs</h4>
                                {{-- SEARCH --}}                                
                                <div class="input-group mt-3">
                                    <input type="text" class="form-control" placeholder="Search staff..." id="searchInput">
                                    <button class="btn btn-outline-secondary" type="button" id="searchButton">Search</button>
                                </div>
                                {{-- SEARCH --}}
                                <div style="height: 300px; overflow-y: auto;" class="mt-3 rounded-top">
                                    <table class="table" id="staffTable">
                                        <thead style="position: sticky; top: 0; background-color: #1a1d20; z-index: 1;">
                                            <tr>
                                                <th scope="col">Name</th>
                                                <th scope="col">Phonenumber</th>
                                                <th scope="col">Shop</th>
                                                <th scope="col" style="width: 30%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($staffs as $staff)
                                            <tr>
                                                <td>{{ $staff->staff_name }}</td>
                                                <td>{{ $staff->phonenumber }}</td>
                                                {{-- <td>{{ $staff->shop->name }}</td> --}}
                                                <td>
                                                    @if($staff->shop)
                                                        {{ $staff->shop->name }}
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>
                                                    <button class="btn btn-warning btn-sm rounded-pill edit-btn"
                                                        style="width: 40%;" data-toggle="modal"
                                                        data-target="#editStaffModal"
                                                        data-id="{{ $staff->id }}"><i class="fa-regular fa-pen-to-square"></i></button>
                                                    <form method="post" style="display: inline;"
                                                        action="{{ route('staff.destroy', $staff->id) }}">
                                                        @csrf
                                                        @method('delete')
                                                        <button class="btn btn-danger btn-sm rounded-pill"
                                                            style="width: 40%;"
                                                            onclick="return confirm('Are you sure you want to delete this staff member?')"
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

<!-- Edit Staff Modal -->
<div class="modal fade" id="editStaffModal" tabindex="-1" role="dialog" aria-labelledby="editStaffModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editStaffModalLabel">Edit Staff Member</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editStaffForm" method="POST" action="">
                @csrf
                @method('PUT')
                <input type="hidden" id="staffId" name="staff_id">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" readonly>
                    </div>

                    <div class="form-group">
                        <label for="staff_name">Staff Name</label>
                        <input type="text" class="form-control" id="staff_name" name="staff_name">
                    </div>
                    
                    <div class="form-group">
                        <label for="phonenumber">Phone Number</label>
                        <input type="text" class="form-control" id="phonenumber" name="phonenumber">
                    </div>
                    <div class="form-group">
                        <label for="shop_id">Shop:</label>
                        <select name="shop_id" id="shop_id" required>
                            <option value="" >Select a Shop</option>
                            @foreach($shops as $shop)
                                <option value="{{ $shop->id }}">{{ $shop->name }}</option>
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


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editButtons = document.querySelectorAll('.edit-btn');

        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                const staffId = this.getAttribute('data-id');
                const modal = document.getElementById('editStaffModal');
                const editForm = document.getElementById('editStaffForm');
                
                editForm.querySelector('#staffId').value = staffId;
                
                editForm.setAttribute('action', `/staff/${staffId}`); 

                fetch(`/staff/${staffId}/edit`)
                    .then(response => response.json())
                    .then(data => {                        
                        editForm.querySelector('#staff_name').value = data.staff_name;
                        editForm.querySelector('#username').value = data.username;
                        editForm.querySelector('#phonenumber').value = data.phonenumber;   
                        editForm.querySelector('#shop_id').value = data.shop_id;                     
                        $('#editStaffModal').modal('show');
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
        });
        
        $('#editStaffModal').on('hidden.bs.modal', function () {
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
            $('body').css('overflow', 'auto');
        });
    });


    // SEARCH   

    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('searchInput');
        const staffTable = document.getElementById('staffTable');
        const tableRows = staffTable.getElementsByTagName('tr');

        searchInput.addEventListener('input', function () {
            const query = searchInput.value.trim().toLowerCase();
            for (let i = 1; i < tableRows.length; i++) {
                const row = tableRows[i];
                const nameColumn = row.cells[0];
                const phoneNumberColumn = row.cells[1];
                if (nameColumn && phoneNumberColumn) {
                    const nameText = nameColumn.textContent.toLowerCase();
                    const phoneNumberText = phoneNumberColumn.textContent.toLowerCase();
                    if (nameText.includes(query) || phoneNumberText.includes(query)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                }
            }
        });
    });
</script>
