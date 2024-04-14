@extends('layouts.layout')

@section('content')
<div class="container-fluid">
    <div class="mb-3">
        <h4>Payment Sales Dashboard</h4>
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

    <!-- Payment Sales Table -->
    <div class="row">
        <div class="col-12">
            <div class="card flex-fill border-0">
                <div class="card-body p-0">
                    <div style="height: 300px; overflow-y: auto;">
                        <table class="table" id="paymentSalesTable">
                            <thead>
                                <tr>
                                    <th scope="col">Staff Name</th>
                                    <th scope="col">Shift Start Date</th>
                                    <th scope="col">Shift Start Time</th>
                                    <th scope="col">Payment Method</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col" style="width: 30%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($paymentSales as $paymentsale)
                                <tr>
                                    <td>{{ $paymentsale->shift->staff->staff_name }}</td>
                                    <td>{{ $paymentsale->shift->start_date }}</td>
                                    <td>{{ $paymentsale->shift->start_time }}</td>
                                    <td>{{ $paymentsale->paymentMethod->payment_method }}</td>
                                    <td>{{ $paymentsale->amount }}</td>
                                    
                                    <td>
                                        <button class="btn btn-warning btn-sm rounded-pill edit-btn"
                                            data-toggle="modal" data-target="#editPaymentSaleModal"
                                            data-id="{{ $paymentsale->id }}"><i class="fa-regular fa-pen-to-square"></i></button>
                                        <form method="post" style="display: inline;"
                                            action="{{ route('paymentsales.destroy', $paymentsale->id) }}">
                                            @csrf
                                            @method('delete')
                                            <button class="btn btn-danger btn-sm rounded-pill"
                                                onclick="return confirm('Are you sure you want to delete this payment sale?')"
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

<!-- Edit Payment Sale Modal -->
<div class="modal fade" id="editPaymentSaleModal" tabindex="-1" role="dialog" aria-labelledby="editPaymentSaleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPaymentSaleModalLabel">Edit Payment Sale</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editPaymentSaleForm" method="POST" action="">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="paymentmethod_id">Payment Method:</label>
                        <select name="paymentmethod_id" class="form-select" required>
                            <option value="">Select a Payment Method</option>
                            @foreach($paymentMethods as $paymentmethod)
                                <option value="{{ $paymentmethod->id }}">{{ $paymentmethod->payment_method }}</option>
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
                const paymentSaleId = this.getAttribute('data-id');
                const modal = document.getElementById('editPaymentSaleModal');
                const editForm = modal.querySelector('form');

                // Fetch payment sale data via AJAX
                fetch(`/paymentsales/${paymentSaleId}/edit`)
                    .then(response => response.json())
                    .then(data => {
                        // Populate form fields with payment sale data
                        editForm.querySelector('[name="paymentmethod_id"]').value = data.paymentmethod_id;
                        editForm.querySelector('[name="amount"]').value = data.amount;

                        // Update the form action URL to include the payment sale ID
                        editForm.setAttribute('action', `/paymentsales/${paymentSaleId}`);

                        // Show the edit modal
                        $(modal).modal('show');
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
        });

        // Handle modal close event
        $('#editPaymentSaleModal').on('hidden.bs.modal', function() {
            const editForm = this.querySelector('form');
            editForm.reset();
        });
    });
</script>
@endsection
