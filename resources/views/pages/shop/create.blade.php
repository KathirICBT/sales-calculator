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
                        <div class="col-6">
                            <div class="p-3 m-1">
                                <h4>Welcome, {{ session('username') }}</h4>
                                <p class="mb-0">Shop Management</p>
                            </div>
                        </div>
                        <div class="col-6 align-self-end text-end">
                            <img src="image/customer-support.jpg" class="img-fluid illustration-img" alt="">
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
                                £ 50.00
                            </h4>
                            <p class="mb-2">
                                Total Earnings
                            </p>
                            <div class="mb-0">
                                <span class="badge text-success me-2">
                                    +9.0%
                                </span>
                                <span class="text-muted">
                                    Since Last Month
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
                                <h4 class="n_h_style rounded">Add Shop</h4>
                                @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show d-flex justify-content-between align-items-center"
                                    role="alert">
                                    <span>{{ session('success') }}</span>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                                @endif
                                <form class="row g-3" method="POST" action="{{ route('shop.store.submit') }}">
                                    @csrf                                             
                                    <div class="col-md-6">
                                        <label for="name" class="form-label">Shop Name: </label>
                                        <input type="text" class="form-control" id="name" name="name">
                                        @error('name')
                                            <span class="error-alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="phone" class="form-label">Phone:</label>
                                        <input type="text" class="form-control" id="phone" name="phone" required>
                                    </div>        
                                    <div class="col-md-6">
                                        <label for="address" class="form-label">Address:</label>
                                        <input type="text" class="form-control" id="address" name="address" required>
                                    </div>
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary rounded-pill">Register</button>
                                        <button type="button" class="btn btn-warning rounded-pill"
                                            onclick="window.location.href='{{ route('shop.index') }}'">Modify</button>
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
                                <h4 class="n_h2_style rounded">Shops</h4>
                                {{-- SEARCH --}}                                
                                <div class="input-group mt-3">
                                    <input type="text" class="form-control" placeholder="Search shop..." id="searchInput">
                                    <button class="btn btn-outline-secondary" type="button" id="searchButton">Search</button>
                                </div>
                                {{-- SEARCH --}}
                                <div style="height: 300px; overflow-y: auto;">
                                    <table class="table" id="shopTable">
                                        <thead>
                                            <tr>
                                                <th>Shop Name</th>
                                                <th>Phone</th>
                                                <th>Address</th>
                                                <th scope="col" style="width: 30%">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($shops as $shop)
                                            <tr>
                                                <td>{{ $shop->name }}</td>
                                                <td>{{ $shop->phone }}</td>
                                                <td>{{ $shop->address }}</td>
                                                <td>
                                                    <button class="btn btn-warning btn-sm rounded-pill edit-btn"
                                                        style="width: 40%;" data-toggle="modal"
                                                        data-target="#editShopModal"
                                                        data-id="{{ $shop->id }}">Edit</button>
                                                    <form method="post" style="display: inline;"
                                                        action="{{ route('shop.destroy', $shop->id) }}">
                                                        @csrf
                                                        @method('delete')
                                                        <button class="btn btn-danger btn-sm rounded-pill"
                                                            style="width: 50%;"
                                                            onclick="return confirm('Are you sure you want to delete this shop?')"
                                                            type="submit">Delete</button>
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
    <!-- Table Element -->
    <div class="card border-0">
        <div class="card-header">
            <h5 class="card-title">
                Total Sales
            </h5>
            <h6 class="card-subtitle text-muted">
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatum ducimus,
                necessitatibus reprehenderit itaque!
            </h6>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">First</th>
                        <th scope="col">Last</th>
                        <th scope="col">Handle</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                    </tr>
                    <tr>
                        <th scope="row">2</th>
                        <td>Jacob</td>
                        <td>Thornton</td>
                        <td>@fat</td>
                    </tr>
                    <tr>
                        <th scope="row">3</th>
                        <td colspan="2">Larry the Bird</td>
                        <td>@twitter</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

<!-- Edit Staff Modal -->
<div class="modal fade" id="editShopModal" tabindex="-1" role="dialog" aria-labelledby="editShopModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editShopModalLabel">Edit  Shop</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editShopForm" method="POST" action="">
                @csrf
                @method('PUT')
                <input type="hidden" id="shopId" name="shop_id">
                <div class="modal-body">                   
                    <div class="form-group">
                        <label for="staff_name">Staff Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $shop->name }}" required>
                        @error('name')
                        <span class="error-alert">{{ $message }}</span>
                        @enderror
                    </div>                    
                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="{{ $shop->phone }}" required>
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text"  class="form-control" id="address" name="address" value="{{ $shop->address }}" required>
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
                const shopId = this.getAttribute('data-id');
                const modal = document.getElementById('editShopModal');
                const editForm = document.getElementById('editShopForm');
                
                editForm.querySelector('#shopId').value = shopId;
                
                editForm.setAttribute('action', `/shops/${shopId}`); 

                fetch(`/shops/${shopId}/edit`)
                    .then(response => response.json())
                    .then(data => {                        
                        editForm.querySelector('#name').value = data.shop_name;
                        editForm.querySelector('#phone').value = data.phone;    
                        editForm.querySelector('#address').value = data.address;                    
                        $('#editShopModal').modal('show');
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
        });
        
        $('#editShopModal').on('hidden.bs.modal', function () {
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
        });
    });


    // SEARCH   

    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('searchInput');
        const shopTable = document.getElementById('shopTable');
        const tableRows = shopTable.getElementsByTagName('tr');

        searchInput.addEventListener('input', function () {
            const query = searchInput.value.trim().toLowerCase();
            for (let i = 1; i < tableRows.length; i++) {
                const row = tableRows[i];
                const nameColumn = row.cells[0];
                const addressColumn = row.cells[1];
                const phoneNumberColumn = row.cells[2];
                if (nameColumn && addressColumn && phoneNumberColumn) {
                    const nameText = nameColumn.textContent.toLowerCase();
                    const addressText = addressColumn.textContent.toLowerCase();
                    const phoneNumberText = phoneNumberColumn.textContent.toLowerCase();
                    if (nameText.includes(query) || addressText.includes(query) || phoneNumberText.includes(query)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                }
            }
        });
    });
</script>


