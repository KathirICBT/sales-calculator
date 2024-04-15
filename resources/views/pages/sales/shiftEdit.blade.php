@extends('layouts.layout')

@section('content')
<div class="container-fluid">
    <div class="mb-3">
        <h4>Shift Edit</h4>
    </div>
    <div class="row">
        <div class="col-12 col-md-6 d-flex">
            <div class="card flex-fill border-0 illustration">
                <div class="card-body p-0 d-flex flex-fill">
                    <div class="row g-0 w-100">
                        <div class="col-6">
                            <div class="p-3 m-1">
                                <h4>Welcome, {{ session('username') }}</h4>
                                <p class="mb-0">Shift Edit</p>
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
                            <p class="mb-2">Total Shops</p>
                            <h4 class="mb-2">Total Shop Count</h4>
                            <div class="mb-0">
                                <span class="text-muted">Owner:</span>
                                <span class="mb-2">Mr. Tharsan</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Alert Messages -->
    <div class="row">
        <div class="col-12">
            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            @if ($errors->any())
            @foreach ($errors->all() as $error)
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ $error }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endforeach
            @endif
        </div>
    </div>

    <!-- Display Shifts Table -->
    <div class="card border-0">
        
        <div class="card-header">
            <h4 class="n_h_style rounded">Shift Edit</h4>
            <!-- Search Shop Input -->
           <!-- Search Shop Input -->
            <div class="input-group mt-3">
                <input type="text" class="form-control" placeholder="Search shop..." id="searchInput">
                <button class="btn btn-outline-secondary" type="button" id="searchButton">Search</button>
            </div>

            
        </div>
        <div class="card-body">
            <table class="table" id="shiftsTable">
                <thead>
                    <tr>
                        <th>Staff Name</th>
                        <th>Shop</th>
                        <th>Shift Start Date</th>
                        <th>Start Time</th>
                        <th>Shift End Date</th>
                        <th>End Time</th>
                        <th>Action</th>
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
                                data-toggle="modal" data-target="#editShiftModal"
                                data-id="{{ $shift->id }}" data-staff-name="{{ $shift->staff->staff_name }}"><i class="fa-regular fa-pen-to-square"></i></button>
                            <form method="post" style="display: inline;"
                                action="{{ route('shifts.destroy', $shift->id) }}">
                                @csrf
                                @method('delete')
                                <button class="btn btn-danger btn-sm rounded-pill"
                                    onclick="return confirm('Are you sure you want to delete this Shift?')"
                                    type="submit"><i class="fa-solid fa-trash-can"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
        </div>        
        
    </div> 

    {{-- <div class="row">
        <div class="col-12">
            <div class="card flex-fill border-0">
                <div class="card-body p-0">
                    <div style="height: 300px; overflow-y: auto;">

                        
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

   

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
            const editForm = this.querySelector('form');
            editForm.reset();
        });
    });
</script>





<script>
   document.addEventListener('DOMContentLoaded', function() {
    const shiftsTableBody = document.getElementById('shiftsTable').querySelector('tbody');

    // Function to fetch shifts based on shop name
    const fetchShiftsByShop = (searchTerm) => {
        fetch(`/sales/shifts/search?searchTerm=${encodeURIComponent(searchTerm)}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(shifts => {
                // Clear existing table rows
                shiftsTableBody.innerHTML = '';

                // Populate table with filtered shifts
                shifts.forEach(shift => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${shift.staff.staff_name}</td>
                        <td>${shift.shop.name}</td>
                        <td>${shift.start_date}</td>
                        <td>${shift.start_time}</td>
                        <td>${shift.end_date}</td>
                        <td>${shift.end_time}</td>
                        <td>
                            <button class="btn btn-warning btn-sm rounded-pill edit-btn"
                                data-toggle="modal" data-target="#editShiftModal"
                                data-id="${shift.id}" data-staff-name="${shift.staff.staff_name}"><i class="fa-regular fa-pen-to-square"></i></button>
                            <form method="post" style="display: inline;"
                                action="{{ route('shifts.destroy', ':shiftId') }}">
                                @csrf
                                @method('delete')
                                <button class="btn btn-danger btn-sm rounded-pill delete-btn"
                                    onclick="return confirm('Are you sure you want to delete this Shift?')"
                                    data-shift-id="${shift.id}"><i class="fa-solid fa-trash-can"></i></button>
                            </form>
                        </td>
                    `;
                    shiftsTableBody.appendChild(row);
                });

                // Reattach event listeners to edit buttons
                attachEditButtonListeners();

                // Reattach event listeners to delete buttons
                attachDeleteButtonListeners();
            })
            .catch(error => {
                console.error('Error fetching shifts:', error);
            });
    };

    // Function to attach event listeners to edit buttons
    const attachEditButtonListeners = () => {
        const editButtons = shiftsTableBody.querySelectorAll('.edit-btn');
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
    };

    // Function to attach event listeners to delete buttons
    const attachDeleteButtonListeners = () => {
        const deleteButtons = shiftsTableBody.querySelectorAll('.delete-btn');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault(); // Prevent default form submission

                const shiftId = this.getAttribute('data-shift-id');
                const confirmation = confirm('Are you sure you want to delete this Shift?');
                if (confirmation) {
                    // Submit the delete form via AJAX
                    fetch(`/sales/shifts/${shiftId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Handle success response (e.g., remove row from table)
                        console.log('Shift deleted successfully:', data);
                    })
                    .catch(error => {
                        console.error('Error deleting shift:', error);
                    });
                }
            });
        });
    };

    // Event listener for search button click
    document.getElementById('searchButton').addEventListener('click', () => {
        const searchTerm = document.getElementById('searchInput').value.trim();
        if (searchTerm !== '') {
            fetchShiftsByShop(searchTerm);
        } else {
            // If search input is empty, show all shifts (optional)
            fetchShiftsByShop('');
        }
    });

    // Initial attachment of event listeners to edit and delete buttons
    attachEditButtonListeners();
    attachDeleteButtonListeners();
});

</script>
