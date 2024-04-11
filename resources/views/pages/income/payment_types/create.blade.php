@extends('layouts.layout')

@section('content')
<div class="container-fluid">
    <div class="mb-3">
        <h4>Add Payment Type</h4>
    </div>
    <div class="row">
        <!-- Add Payment Type Card -->
        <div class="col-12 col-md-6 d-flex">
            <div class="card flex-fill border-0 illustration">
                <div class="card-body p-0 d-flex flex-fill">
                    <!-- Card Content -->
                    <div class="row g-0 w-100">
                        <div class="col-6">
                            <div class="p-3 m-1">
                                <h4>Welcome, {{ session('username') }}</h4>
                                <p class="mb-0">Department Management</p>
                            </div>
                        </div>
                        <div class="col-6 align-self-end text-end">
                            <img src="{{ asset('image/customer-support.jpg') }}" class="img-fluid illustration-img"
                                alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Edit and Delete Payment Type Card -->
        <div class="col-12 col-md-6 d-flex">
            <div class="card flex-fill border-0">
                <div class="card-body py-4">
                    <div class="d-flex align-items-start">
                        <div class="flex-grow-1"></div>
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
            <!-- ERROR -->
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
        </div>
    </div>
    <div class="row">
        <!-- Add Payment Type Form -->
        <div class="col-12 col-md-6 d-flex">
            <div class="card flex-fill border-0">
                <div class="card-body p-0 d-flex flex-fill">
                    <div class="row g-0 w-100">
                        <div class="col-12">
                            <div class="p-3 m-1">
                                <h4 class="n_h_style rounded">Add Payment Type</h4>
                                <form class="row g-3" method="POST" action="{{ route('paymenttype.store') }}">
                                    @csrf
                                    <div class="col-md-6">
                                        <label for="payment_type" class="form-label">Payment Type:</label>
                                        <input type="text" class="form-control" id="payment_type" name="payment_type">
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary rounded-pill">Add Payment
                                            Type</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- List of Payment Types -->
        <div class="col-12 col-md-6 d-flex">
            <div class="card flex-fill border-0">
                <div class="card-body p-0 d-flex flex-fill">
                    <div class="row g-0 w-100">
                        <div class="col-12">
                            <div class="p-3 m-1">
                                <h4 class="n_h2_style rounded">Payment Types</h4>
                                {{-- SEARCH --}}
                                <div class="input-group mt-3">
                                    <input type="text" class="form-control" placeholder="Search payment type..."
                                        id="searchInput">
                                    <button class="btn btn-outline-secondary" type="button"
                                        id="searchButton">Search</button>
                                </div>
                                {{-- SEARCH --}}
                                <div style="height: 300px; overflow-y: auto;">
                                    <table class="table" id="paymentTypeTable">
                                        <thead>
                                            <tr>
                                                <th>Payment Type</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($paymentTypes as $paymentType)
                                            <tr>
                                                <td>{{ $paymentType->payment_type }}</td>
                                                <td>
                                                    <a href="#" class="btn btn-warning btn-sm rounded-pill edit-btn"
                                                        data-toggle="modal" data-target="#editPaymentTypeModal"
                                                        data-id="{{ $paymentType->id }}" style="width: 30%;"><i class="fa-regular fa-pen-to-square"></i></a>
                                                    <form method="post" style="display: inline;"
                                                        action="{{ route('paymenttype.destroy', $paymentType->id) }}">
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<!-- Edit Payment Type Modal -->
<div class="modal fade" id="editPaymentTypeModal" tabindex="-1" role="dialog"
    aria-labelledby="editPaymentTypeModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPaymentTypeModalLabel">Edit Payment Type</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editPaymentTypeForm" method="POST" action="">
                @csrf
                @method('PUT')
                <input type="hidden" id="paymentTypeId" name="paymentType_id">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="payment_type">Payment Type</label>
                        <input type="text" class="form-control" id="payment_type" name="payment_type" required>
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
                const paymentTypeId = this.getAttribute('data-id');
                const editForm = document.getElementById('editPaymentTypeForm');

                // Set the payment type ID in the form
                editForm.querySelector('#paymentTypeId').value = paymentTypeId;

                // Set the action URL for the form
                editForm.setAttribute('action', `/paymenttypes/${paymentTypeId}`);

                // Fetch the payment type data and populate the form fields
                fetch(`/paymenttypes/${paymentTypeId}/edit`)
                    .then(response => response.json())
                    .then(data => {
                        editForm.querySelector('#payment_type').value = data.payment_type;
                        $('#editPaymentTypeModal').modal('show');
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
        });

        $('#editPaymentTypeModal').on('hidden.bs.modal', function() {
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
            $('body').css('overflow', 'auto');
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const paymentTypeTable = document.getElementById('paymentTypeTable');
        const tableRows = paymentTypeTable.getElementsByTagName('tr');

        searchInput.addEventListener('input', function() {
            const query = searchInput.value.trim().toLowerCase();

            for (let i = 1; i < tableRows.length; i++) {
                const row = tableRows[i];
                const paymentTypeCell = row.cells[0]; // Assuming payment type name is in the first cell

                if (paymentTypeCell) {
                    const paymentTypeText = paymentTypeCell.textContent.trim().toLowerCase();

                    if (paymentTypeText.includes(query)) {
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