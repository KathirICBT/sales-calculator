@extends('layouts.layout')
@section('content') 
                <div class="container-fluid">
                    <div class="mb-3">
                        <h4>Staff Dashboard</h4>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-6 d-flex">
                            <div class="card flex-fill border-0 illustration">
                                <div class="card-body p-0 d-flex flex-fill">
                                    <div class="row g-0 w-100">
                                        
                                        {{-- <div class="col-6">
                                            <div class="p-3 m-1">
                                                <h4>Welcome, {{ session('username') }}</h4>
                                                <h4>{{ session('username') }}</h4>                                                
                                                <p class="mb-0">Staff Dashboard, Sales Calculator</p>
                                            </div>
                                        </div> --}}

                                        @if(session()->has('username'))
                                            <div class="col-6">
                                                <div class="p-3 m-1">
                                                    <h4>Welcome, {{ session('username') }}</h4>                                                                                                       
                                                    <p class="mb-0">Staff Dashboard, Sales Calculator</p>
                                                </div>
                                            </div>
                                        @elseif(session()->has('adminusername'))
                                            <div class="col-6">
                                                <div class="p-3 m-1">
                                                    <h4>Welcome, {{ session('adminusername') }}</h4>                                                                                                      
                                                    <p class="mb-0">Admin Dashboard, Sales Calculator : {{ Auth::user()->username }}</p>
                                                </div>
                                            </div>
                                        @else                                            
                                            <script>window.location = "{{ route('auth.login') }}";</script>                                            
                                        @endif

                                        
                                        <div class="col-6 align-self-end text-end">
                                            <img src="image/customer-support.jpg" class="img-fluid illustration-img"
                                                alt="">
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
                                            <h4 class="mb-2">
                                                Staff: {{ $shift->staff->staff_name }}
                                            </h4>
                                            <p class="mb-2">
                                                Shop: {{ $shift->shop->name }}
                                            </p>
                                            <span class="text-muted">
                                                Manage Sales for Shift: {{ $shift->id }}
                                            </span>
                                            <div class="mb-0">
                                                <span class="badge text-success me-2">
                                                    {{-- Manage Sales for Shift: {{ $shift->id }} --}}
                                                </span>
                                                <span class="text-muted">
                                                    {{-- Manage Sales for Shift: {{ $shift->id }} --}}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Forms -->
                    <div class="row">
                        <div class="col-12 col-md-6 d-flex">
                            <div class="card flex-fill border-0">
                                <div class="card-body p-0 d-flex flex-fill">
                                    <div class="row g-0 w-100">
                                        <div class="col-12">
                                            <div class="p-3 m-1">  
                                                
                                                <!-- Sales Table -->
                                                <h4 class="n_h2_style rounded">Sales</h4>
                                                <div class="input-group mt-3">
                                                    <input type="text" class="form-control" placeholder="Search Sales..." id="searchInputSales">
                                                    <button class="btn btn-outline-secondary" type="button" id="searchButton">Search</button>
                                                </div>
                                                <div style="height: 300px; overflow-y: auto;" class="mt-3 rounded-top">
                                                    <table class="table" id="salesTable" data-modal-type="sales">
                                                        <thead style="position: sticky; top: 0; background-color: #1a1d20; z-index: 1;">
                                                            <tr>
                                                                <th>Department</th>
                                                                <th>Amount</th>
                                                                <th scope="col" style="width: 30%">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($sales as $sale)
                                                            <tr>
                                                                <td>{{ $sale->department->dept_name }}</td>
                                                                <td>{{ $sale->amount }}</td>
                                                                <td>
                                                                    <button class="btn btn-warning btn-sm rounded-pill edit-btn" style="width: 40%;" data-toggle="modal" data-target="#salesModal" data-id="{{ $sale->id }}"><i class="fa-regular fa-pen-to-square"></i></button>
                                                                    <form method="post" style="display: inline;" action="{{ route('manage_sales.destroy', $sale->id) }}">
                                                                        @csrf
                                                                        @method('delete')
                                                                        <button class="btn btn-danger btn-sm rounded-pill" style="width: 40%;" onclick="return confirm('Are you sure you want to delete this sale?')" type="submit"><i class="fa-solid fa-trash-can"></i></button>
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
                        <div class="col-12 col-md-6 d-flex">
                            <div class="card flex-fill border-0">
                                <div class="card-body p-0 d-flex flex-fill">
                                    <div class="row g-0 w-100">
                                        <div class="col-12">
                                            <div class="p-3 m-1">  
                                                
                                                
                                                <h4 class="n_h2_style rounded">Payment Methods</h4>
                                                <div class="input-group mt-3">
                                                    <input type="text" class="form-control" placeholder="Search Payment Sales..." id="searchInputPaymentSales">
                                                    <button class="btn btn-outline-secondary" type="button" id="searchButton">Search</button>
                                                </div>
                                                <div style="height: 300px; overflow-y: auto;" class="mt-3 rounded-top">
                                                    <table class="table" id="paymentSalesTable" data-modal-type="paymentSales">
                                                        <thead style="position: sticky; top: 0; background-color: #1a1d20; z-index: 1;">
                                                            <tr>
                                                                <th>Payment Method</th>
                                                                <th>Amount</th>
                                                                <th scope="col" style="width: 30%">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($paymentSales as $paymentSale)
                                                            <tr>
                                                                <td>{{ $paymentSale->paymentMethod->payment_method }}</td>
                                                                <td>{{ $paymentSale->amount }}</td>
                                                                <td>
                                                                    <button class="btn btn-warning btn-sm rounded-pill edit-btn" style="width: 40%;" data-toggle="modal" data-target="#paymentSalesModal" data-id="{{ $paymentSale->id }}"><i class="fa-regular fa-pen-to-square"></i></button>
                                                                    <form method="post" style="display: inline;" action="{{ route('manage_paymentSales.destroy', $paymentSale->id) }}">
                                                                        @csrf
                                                                        @method('delete')
                                                                        <button class="btn btn-danger btn-sm rounded-pill" style="width: 40%;" onclick="return confirm('Are you sure you want to delete this payment sale?')" type="submit"><i class="fa-solid fa-trash-can"></i></button>
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


                    <div class="row">
                        <div class="col-12 col-md-6 d-flex">
                            <div class="card flex-fill border-0">
                                <div class="card-body p-0 d-flex flex-fill">
                                    <div class="row g-0 w-100">
                                        <div class="col-12">
                                            <div class="p-3 m-1">  
                                                
                                                <!-- Petticash Table -->
                                                <h4 class="n_h2_style rounded">Petticash</h4>
                                                <div class="input-group mt-3">
                                                    <input type="text" class="form-control" placeholder="Search Petticash..." id="searchInputPetticash">
                                                    <button class="btn btn-outline-secondary" type="button" id="searchButton">Search</button>
                                                </div>
                                                <div style="height: 300px; overflow-y: auto;" class="mt-3 rounded-top">
                                                    <table class="table" id="petticashTable" data-modal-type="petticash">
                                                        <thead style="position: sticky; top: 0; background-color: #1a1d20; z-index: 1;">
                                                            <tr>
                                                                <th>Reason</th>
                                                                <th>Amount</th>
                                                                <th scope="col" style="width: 30%">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($petticashes as $petticash)
                                                            <tr>
                                                                <td>{{ $petticash->pettyCashReason->reason }}</td>
                                                                <td>{{ $petticash->amount }}</td>
                                                                <td>
                                                                    <button class="btn btn-warning btn-sm rounded-pill edit-btn" style="width: 40%;" data-toggle="modal" data-target="#petticashModal" data-id="{{ $petticash->id }}"><i class="fa-regular fa-pen-to-square"></i></button>
                                                                    <form method="post" style="display: inline;" action="{{ route('manage_petticash.destroy', $petticash->id) }}">
                                                                        @csrf
                                                                        @method('delete')
                                                                        <button class="btn btn-danger btn-sm rounded-pill" style="width: 40%;" onclick="return confirm('Are you sure you want to delete this petticash?')" type="submit"><i class="fa-solid fa-trash-can"></i></button>
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
                        <div class="col-12 col-md-6 d-flex">
                            <div class="card flex-fill border-0">
                                <div class="card-body p-0 d-flex flex-fill">
                                    <div class="row g-0 w-100">
                                        <div class="col-12">
                                            <div class="p-3 m-1">  
                                                
                                                
                                                <!-- Cashdiffers Table -->
                                                <h4 class="n_h2_style rounded">Cashdiffers</h4>
                                                <div class="input-group mt-3">
                                                    <input type="text" class="form-control" placeholder="Search Cashdiffers..." id="searchInputCashdiffers">
                                                    <button class="btn btn-outline-secondary" type="button" id="searchButton">Search</button>
                                                </div>
                                                <div style="height: 300px; overflow-y: auto;" class="mt-3 rounded-top">
                                                    <table class="table" id="cashdiffersTable" data-modal-type="cashdiffers">
                                                        <thead style="position: sticky; top: 0; background-color: #1a1d20; z-index: 1;">
                                                            <tr>
                                                                <th>Cash Difference</th>
                                                                <th scope="col" style="width: 30%">Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($cashDiffers as $cashDiffer)
                                                            <tr>
                                                                <td>{{ $cashDiffer->cashdifference }}</td>
                                                                <td>
                                                                    <button class="btn btn-warning btn-sm rounded-pill edit-btn" style="width: 40%;" data-toggle="modal" data-target="#cashdiffersModal" data-id="{{ $cashDiffer->id }}"><i class="fa-regular fa-pen-to-square"></i></button>
                                                                    <form method="post" style="display: inline;" action="{{ route('manage_cashdiffers.destroy', $cashDiffer->id) }}">
                                                                        @csrf
                                                                        @method('delete')
                                                                        <button class="btn btn-danger btn-sm rounded-pill" style="width: 40%;" onclick="return confirm('Are you sure you want to delete this cash differ?')" type="submit"><i class="fa-solid fa-trash-can"></i></button>
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



                <!-- Edit Sales Modal -->
                <div class="modal fade" id="salesModal" tabindex="-1" role="dialog" aria-labelledby="editSalesModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editSalesModalLabel">Edit Sale</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form id="editSalesForm" method="POST" action="">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="sale_id" id="saleId">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="dept_id">Department</label>
                                        <select name="dept_id" id="dept_id" class="form-select" required>
                                            <option value="">Select a Department</option>
                                            @foreach($departments as $department)
                                            <option value="{{ $department->id }}">{{ $department->dept_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="amount">Amount</label>
                                        <input type="number" class="form-control" id="amount" name="amount" required>
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


                <!-- Edit Payment Sales Modal -->
                <div class="modal fade" id="paymentSalesModal" tabindex="-1" role="dialog" aria-labelledby="editPaymentSalesModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editPaymentSalesModalLabel">Edit Payment Sale</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form id="editPaymentSalesForm" method="POST" action="">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="sale_id" id="saleId">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="paymentmethod_id">Payment Method</label>
                                        <select name="paymentmethod_id" id="paymentmethod_id" class="form-select" required>
                                            <option value="">Select a Payment Method</option>
                                            @foreach($paymentMethods as $paymentMethod)
                                            <option value="{{ $paymentMethod->id }}">{{ $paymentMethod->payment_method }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="amount">Amount</label>
                                        <input type="number" class="form-control" id="amount" name="amount" required>
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


                <!-- Edit Petticash Modal -->
                <div class="modal fade" id="petticashModal" tabindex="-1" role="dialog" aria-labelledby="editPetticashModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editPetticashModalLabel">Edit Petticash</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form id="editPetticashForm" method="POST" action="">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="sale_id" id="saleId">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="petty_cash_reason_id">Reason</label>
                                        <select name="petty_cash_reason_id" id="petty_cash_reason_id" class="form-select" required>
                                            <option value="">Select a Reason</option>
                                            @foreach($pettyCashReasons as $pettyCashReason)
                                            <option value="{{ $pettyCashReason->id }}">{{ $pettyCashReason->reason }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="amount">Amount</label>
                                        <input type="number" class="form-control" id="amount" name="amount" required>
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

                <!-- Edit Cashdiffers Modal -->
                <div class="modal fade" id="cashdiffersModal" tabindex="-1" role="dialog" aria-labelledby="editCashdiffersModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editCashdiffersModalLabel">Edit Cash Difference</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form id="editCashdiffersForm" method="POST" action="">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="sale_id" id="saleId">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="cashdifference">Cash Difference</label>
                                        <input type="text" class="form-control" id="cashdifference" name="cashdifference" required>
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


                {{-- <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const editButtons = document.querySelectorAll('.edit-btn');
                
                        editButtons.forEach(button => {
                            button.addEventListener('click', function() {
                                const saleId = this.getAttribute('data-id');
                                const modalType = this.closest('table').dataset.modalType; // determine which table the button is in
                
                                let fetchUrl = '';
                                let formId = '';
                                let actionPath = '';
                                switch (modalType) {
                                    case 'sales':
                                        fetchUrl = `/manage_sales/${saleId}/edit`;
                                        formId = 'editSalesForm';
                                        actionPath = `/manage_sales/${saleId}`;
                                        break;
                                    case 'paymentSales':
                                        fetchUrl = `/manage_paymentSales/${saleId}/edit`;
                                        formId = 'editPaymentSalesForm';
                                        actionPath = `/manage_paymentSales/${saleId}`;
                                        break;
                                    case 'petticash':
                                        fetchUrl = `/manage_petticash/${saleId}/edit`;
                                        formId = 'editPetticashForm';
                                        actionPath = `/manage_petticash/${saleId}`;
                                        break;
                                    case 'cashdiffers':
                                        fetchUrl = `/manage_cashdiffers/${saleId}/edit`;
                                        formId = 'editCashdiffersForm';
                                        actionPath = `/manage_cashdiffers/${saleId}`;
                                        break;
                                }
                
                                const modal = document.getElementById(`${modalType}Modal`);
                                const editForm = document.getElementById(formId);
                
                                // Set the form action path dynamically
                                editForm.setAttribute('action', actionPath);
                                editForm.querySelector('input[name="sale_id"]').value = saleId;
                
                                fetch(fetchUrl)
                                    .then(response => response.json())
                                    .then(data => {
                                        Object.keys(data).forEach(key => {
                                            if (editForm.querySelector(`[name="${key}"]`)) {
                                                editForm.querySelector(`[name="${key}"]`).value = data[key];
                                            }
                                        });
                
                                        $(`#${modalType}Modal`).modal('show');
                                    })
                                    .catch(error => {
                                        console.error('Error:', error);
                                    });
                            });
                        });
                
                        // Add an event listener to the modal close event
                        $('.modal').on('hidden.bs.modal', function (e) {
                            // Ensure the page becomes active again
                            $('body').addClass('modal-open');
                            // Remove the modal backdrop
                            $('.modal-backdrop').remove();
                        });
                    });
                </script> --}}

                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const editButtons = document.querySelectorAll('.edit-btn');
                
                        editButtons.forEach(button => {
                            button.addEventListener('click', function() {
                                const saleId = this.getAttribute('data-id');
                                const modalType = this.closest('table').dataset.modalType;
                
                                let fetchUrl = '';
                                let formId = '';
                                let actionPath = '';
                                switch (modalType) {
                                    case 'sales':
                                        fetchUrl = `/manage_sales/${saleId}/edit`;
                                        formId = 'editSalesForm';
                                        actionPath = `/manage_sales/${saleId}`;
                                        break;
                                    case 'paymentSales':
                                        fetchUrl = `/manage_paymentSales/${saleId}/edit`;
                                        formId = 'editPaymentSalesForm';
                                        actionPath = `/manage_paymentSales/${saleId}`;
                                        break;
                                    case 'petticash':
                                        fetchUrl = `/manage_petticash/${saleId}/edit`;
                                        formId = 'editPetticashForm';
                                        actionPath = `/manage_petticash/${saleId}`;
                                        break;
                                    case 'cashdiffers':
                                        fetchUrl = `/manage_cashdiffers/${saleId}/edit`;
                                        formId = 'editCashdiffersForm';
                                        actionPath = `/manage_cashdiffers/${saleId}`;
                                        break;
                                }
                
                                const modal = document.getElementById(`${modalType}Modal`);
                                const editForm = document.getElementById(formId);                
                                
                                editForm.setAttribute('action', actionPath);
                                editForm.querySelector('input[name="sale_id"]').value = saleId;
                
                                fetch(fetchUrl)
                                    .then(response => response.json())
                                    .then(data => {
                                        Object.keys(data).forEach(key => {
                                            if (editForm.querySelector(`[name="${key}"]`)) {
                                                editForm.querySelector(`[name="${key}"]`).value = data[key];
                                            }
                                        });
                
                                        $(`#${modalType}Modal`).modal('show');
                                    })
                                    .catch(error => {
                                        console.error('Error:', error);
                                    });
                            });
                        });                
                        
                        $('.modal').on('hidden.bs.modal', function (e) {                            
                            $('body').removeClass('modal-open');                            
                            $('.modal-backdrop').remove();                            
                            $('body').css('overflow', 'auto');
                        });
                    });
                </script>
                

                <script>
                    document.addEventListener('DOMContentLoaded', function () {                        
                        const searchInputSales = document.getElementById('searchInputSales');
                        const salesTable = document.getElementById('salesTable');
                        const salesTableRows = salesTable.getElementsByTagName('tr');

                        searchInputSales.addEventListener('input', function () {
                            searchTable(searchInputSales, salesTableRows);
                        });
                        
                        const searchInputPaymentSales = document.getElementById('searchInputPaymentSales');
                        const paymentSalesTable = document.getElementById('paymentSalesTable');
                        const paymentSalesTableRows = paymentSalesTable.getElementsByTagName('tr');

                        searchInputPaymentSales.addEventListener('input', function () {
                            searchTable(searchInputPaymentSales, paymentSalesTableRows);
                        });
                        
                        const searchInputPetticash = document.getElementById('searchInputPetticash');
                        const petticashTable = document.getElementById('petticashTable');
                        const petticashTableRows = petticashTable.getElementsByTagName('tr');

                        searchInputPetticash.addEventListener('input', function () {
                            searchTable(searchInputPetticash, petticashTableRows);
                        });
                        
                        const searchInputCashdiffers = document.getElementById('searchInputCashdiffers');
                        const cashdiffersTable = document.getElementById('cashdiffersTable');
                        const cashdiffersTableRows = cashdiffersTable.getElementsByTagName('tr');

                        searchInputCashdiffers.addEventListener('input', function () {
                            searchTable(searchInputCashdiffers, cashdiffersTableRows);
                        });
                        
                        function searchTable(searchInput, tableRows) {
                            const query = searchInput.value.trim().toLowerCase();
                            for (let i = 1; i < tableRows.length; i++) {
                                const row = tableRows[i];
                                const departmentColumn = row.cells[0];
                                const amountColumn = row.cells[1];
                                if (departmentColumn && amountColumn) {
                                    const departmentText = departmentColumn.textContent.toLowerCase();
                                    const amountText = amountColumn.textContent.toLowerCase();
                                    if (departmentText.includes(query) || amountText.includes(query)) {
                                        row.style.display = '';
                                    } else {
                                        row.style.display = 'none';
                                    }
                                }
                            }
                        }
                    });
                </script>
@endsection            
            