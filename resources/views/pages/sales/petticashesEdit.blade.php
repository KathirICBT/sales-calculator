@extends('layouts.layout')

@section('content')
<div class="container-fluid">
    <div class="mb-3">
        <h4>Petticash Edit</h4>
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

    <!-- Petticash Table -->
    <div class="row">
        <div class="col-12">
            <div class="card flex-fill border-0">
                <div class="card-body p-0">
                    <div style="height: 300px; overflow-y: auto;">
                        <table class="table" id="petticashTable">
                            <thead>
                                <tr>
                                    <th scope="col">Petty Cash Reason</th>
                                    <th scope="col">Shift Start Date</th>
                                    <th scope="col">Shift Start Time</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col" style="width: 30%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($petticashes as $petticash)
                                <tr>
                                    
                                    
                                    <td>{{ $petticash->pettyCashReason->reason }}</td>

                                    <td>{{ $petticash->shift->start_date }}</td>
                                    <td>{{ $petticash->shift->start_time }}</td>
                                    <td>{{ $petticash->amount }}</td>
                                    
                                    <td>
                                        <button class="btn btn-warning btn-sm rounded-pill edit-btn"
                                            data-toggle="modal" data-target="#editPetticashModal"
                                            data-id="{{ $petticash->id }}"><i class="fa-regular fa-pen-to-square"></i></button>
                                        <form method="post" style="display: inline;"
                                            action="{{ route('petticashes.destroy', $petticash->id) }}">
                                            @csrf
                                            @method('delete')
                                            <button class="btn btn-danger btn-sm rounded-pill"
                                                onclick="return confirm('Are you sure you want to delete this Petticash record?')"
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

<!-- Edit Petticash Modal -->
<div class="modal fade" id="editPetticashModal" tabindex="-1" role="dialog" aria-labelledby="editPetticashModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPetticashModalLabel">Edit Petticash</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editPetticashForm" method="POST" action="">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="petty_cash_reason_id">Petty Cash Reason:</label>
                        <select name="petty_cash_reason_id" class="form-select" required>
                            <option value="">Select a Petty Cash Reason</option>
                            @foreach($pettyCashReasons as $reason)
                                <option value="{{ $reason->id }}">{{ $reason->reason }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="amount">Amount:</label>
                        <input type="number" class="form-control" id="amount" name="amount" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editButtons = document.querySelectorAll('.edit-btn');

        editButtons.forEach(button => {
            button.addEventListener('click', function() {
                const petticashId = this.getAttribute('data-id');
                const modal = document.getElementById('editPetticashModal');
                const editForm = modal.querySelector('form');

                // Fetch petticash data via AJAX
                fetch(`/petticashes/${petticashId}/edit`)
                    .then(response => response.json())
                    .then(data => {
                        // Populate form fields with petticash data
                        editForm.querySelector('[name="petty_cash_reason_id"]').value = data.petty_cash_reason_id;
                        editForm.querySelector('[name="amount"]').value = data.amount;

                        // Update the form action URL to include the petticash ID
                        editForm.setAttribute('action', `/petticashes/${petticashId}`);

                        // Show the edit modal
                        $(modal).modal('show');
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
        });

        // Handle modal close event
        $('#editPetticashModal').on('hidden.bs.modal', function() {
            const editForm = this.querySelector('form');
            editForm.reset();
        });
    });
</script>
@endsection
