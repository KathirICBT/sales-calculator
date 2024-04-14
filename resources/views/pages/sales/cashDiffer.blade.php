@extends('layouts.layout')

@section('content')
<div class="container-fluid">
    <div class="mb-3">
        <h4>Cash Difference Dashboard</h4>
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

    <!-- Cash Difference Table -->
    <div class="row">
        <div class="col-12">
            <div class="card flex-fill border-0">
                <div class="card-body p-0">
                    <div style="height: 300px; overflow-y: auto;">
                        <table class="table" id="cashDiffersTable">
                            <thead>
                                <tr>
                                    <th scope="col">Staff Name</th>
                                    <th scope="col">Shift Start Date</th>
                                    <th scope="col">Shift Start Time</th>
                                    <th scope="col">Cash Difference</th>
                                    <th scope="col">Shift ID</th>
                                    <th scope="col" style="width: 30%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cashdiffers as $cashdiffer)
                                <tr>
                                    <td>{{ $cashdiffer->shift->staff->staff_name }}</td>
                                    <td>{{ $cashdiffer->shift->start_date }}</td>
                                    <td>{{ $cashdiffer->shift->start_time }}</td>
                                    <td>{{ $cashdiffer->cashdifference }}</td>
                                    
                                    <td>
                                        <button class="btn btn-warning btn-sm rounded-pill edit-btn"
                                            data-toggle="modal" data-target="#editCashDifferModal"
                                            data-id="{{ $cashdiffer->id }}"><i class="fa-regular fa-pen-to-square"></i></button>
                                        <form method="post" style="display: inline;"
                                            action="{{ route('cashdiffers.destroy', $cashdiffer->id) }}">
                                            @csrf
                                            @method('delete')
                                            <button class="btn btn-danger btn-sm rounded-pill"
                                                onclick="return confirm('Are you sure you want to delete this cash difference?')"
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


<!-- Edit Cash Differ Modal -->

<!-- Edit Cash Difference Modal -->
<div class="modal fade" id="editCashDifferModal" tabindex="-1" role="dialog" aria-labelledby="editCashDifferModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCashDifferModalLabel">Edit Cash Difference</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editCashDifferForm" method="POST" action="">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="cashdifference">Cash Difference:</label>
                        <input type="number" class="form-control" id="cashdifference" name="cashdifference" required>
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
                const cashDifferId = this.getAttribute('data-id');
                const modal = document.getElementById('editCashDifferModal');
                const editForm = modal.querySelector('form');

                // Fetch cash differ data via AJAX
                fetch(`/cashdiffers/${cashDifferId}/edit`)
                    .then(response => response.json())
                    .then(data => {
                        // Populate form fields with cash differ data
                        editForm.querySelector('[name="cashdifference"]').value = data.cashdifference;

                        // Update the form action URL to include the cash differ ID
                        editForm.setAttribute('action', `/cashdiffers/${cashDifferId}`);

                        // Show the edit modal
                        $(modal).modal('show');
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
        });

        // Handle modal close event
        $('#editCashDifferModal').on('hidden.bs.modal', function() {
            const editForm = this.querySelector('form');
            editForm.reset();
        });
    });
</script>
