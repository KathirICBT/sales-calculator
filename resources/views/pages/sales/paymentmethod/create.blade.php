@extends('layouts.layout')
@section('content')
<div class="container-fluid">

    <x-content-header title="Payment Method Management" />    
    <x-alert-message />    
    
    <div class="row">
        <div class="col-12 col-md-6 d-flex">
            <div class="card flex-fill border-0">
                <div class="card-body p-0 d-flex flex-fill">
                    <div class="row g-0 w-100">
                        <div class="col-12">
                            <div class="p-3 m-1">
                                <h4 class="n_h_style rounded">Add Payment Method</h4>                                
                                <form class="row g-3" method="POST" action="{{ route('paymentmethod.store') }}">
                                    @csrf
                                    <div class="col-md-12">
                                        <label for="payment_method" class="form-label">Payment Method:</label>
                                        <input type="text" class="form-control" id="payment_method" name="payment_method">
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
                                <h4 class="n_h2_style rounded">Payment Methods</h4>
                                {{-- SEARCH --}}
                                <div class="input-group mt-3">
                                    <input type="text" class="form-control" placeholder="Search payment method..." id="searchInput">
                                    <button class="btn btn-outline-secondary" type="button" id="searchButton">Search</button>
                                </div>
                                {{-- SEARCH --}}
                                <div style="height: 300px; overflow-y: auto;">
                                    <table class="table" id="paymentMethodTable">
                                        <thead>
                                            <tr>
                                                <th>Payment Method</th>
                                                <th scope="col" style="width: 30%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($paymentMethods as $paymentMethod)
                                            <tr>
                                                <td>{{ $paymentMethod->payment_method }}</td>
                                                <td>
                                                    <a href="#" class="btn btn-warning btn-sm rounded-pill edit-btn" style="width: 40%;" data-toggle="modal" data-target="#editPaymentMethodModal" data-id="{{ $paymentMethod->id }}"><i class="fa-regular fa-pen-to-square"></i></a>
                                                    <form method="post" style="display: inline;" action="{{ route('paymentmethod.destroy', $paymentMethod->id) }}">
                                                        @csrf
                                                        @method('delete')
                                                        <button class="btn btn-danger btn-sm rounded-pill" style="width: 40%;" onclick="return confirm('Are you sure you want to delete this payment method?')" type="submit"><i class="fa-solid fa-trash-can"></i></button>
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

<!-- Edit Payment Method Modal -->
<div class="modal fade" id="editPaymentMethodModal" tabindex="-1" role="dialog" aria-labelledby="editPaymentMethodModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPaymentMethodModalLabel">Edit Payment Method</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editPaymentMethodForm" method="POST" action="">
                @csrf
                @method('PUT')
                <input type="hidden" id="paymentMethodId" name="paymentMethod_id">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="payment_method">Payment Method</label>
                        <input type="text" class="form-control" id="payment_method" name="payment_method">
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
                const paymentMethodId = this.getAttribute('data-id');
                const editForm = document.getElementById('editPaymentMethodForm');

                // Set the payment method ID in the form
                editForm.querySelector('#paymentMethodId').value = paymentMethodId;

                // Set the action URL for the form
                editForm.setAttribute('action', `/paymentmethods/${paymentMethodId}`);

                // Fetch the payment method data and populate the form fields
                fetch(`/paymentmethods/${paymentMethodId}/edit`)
                    .then(response => response.json())
                    .then(data => {
                        editForm.querySelector('#payment_method').value = data.payment_method;
                        $('#editPaymentMethodModal').modal('show');
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
        });

        $('#editPaymentMethodModal').on('hidden.bs.modal', function() {
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
            $('body').css('overflow', 'auto');
        });
    });
</script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        const paymentMethodTable = document.getElementById('paymentMethodTable');
        const tableRows = paymentMethodTable.getElementsByTagName('tr');

        searchInput.addEventListener('input', function() {
            const query = searchInput.value.trim().toLowerCase();

            for (let i = 1; i < tableRows.length; i++) {
                const row = tableRows[i];
                const paymentMethodCell = row.cells[0]; // Assuming payment method name is in the first cell

                if (paymentMethodCell) {
                    const paymentMethodText = paymentMethodCell.textContent.trim().toLowerCase();

                    if (paymentMethodText.includes(query)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                }
            }
        });
    });
</script>



