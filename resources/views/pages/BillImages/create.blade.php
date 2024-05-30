@extends('layouts.layout')
@section('content')
<div class="container-fluid">

    <x-content-header title="Bills Management" />  
    <x-alert-message /> 

    <!-- Forms -->
    <div class="row">
        <div class="col-12 col-md-6 d-flex">
            <div class="card flex-fill border-0">
                <div class="card-body p-0 d-flex flex-fill">
                    <div class="row g-0 w-100">
                        <div class="col-12">
                            <div class="p-3 m-1">
                                <h4 class="n_h_style rounded">Add Bill Info</h4>                                
                                <form action="{{ route('bill_images.store') }}" method="POST" enctype="multipart/form-data" class="row g-3">
                                    @csrf
                                    <div class="col-md-12">
                                        @foreach($staffs as $staff)
                                        @if(session('username') == $staff->username || session('adminusername') == $staff->username)
                                        <label for="staff_name" class="form-label">User: </label>
                                        <input type="text" class="form-control" id="staff_name" name="staff_name" value="{{ $staff->staff_name }}" readonly>
                                        <input type="hidden" id="staff_id" name="staff_id" value="{{ $staff->id }}">
                                        @endif
                                        @endforeach
                                    </div>
                                    
                                    @if(session()->has('adminusername'))
                                        <div class="col-md-12">
                                            <label for="shop_id" class="form-label">Shop:</label>
                                            <select name="shop_id" id="shop_id" class="form-select">
                                                <option value="" >Select a Shop</option>
                                                @foreach($shops as $shop)
                                                    <option value="{{ $shop->id }}">{{ $shop->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @else
                                        <div class="col-md-12">
                                            @foreach($staffs as $staff)
                                            @if(session('username') == $staff->username)
                                            <label for="shop_name" class="form-label">Shop: </label>
                                            <input type="text" class="form-control" id="shop_name" name="shop_name" value="{{ $staff->shop->name }}" readonly>
                                            <input type="hidden" id="shop_id" name="shop_id" value="{{ $staff->shop_id }}">
                                            @endif
                                            @endforeach
                                        </div>
                                    @endif
                                    <div class="col-md-12">
                                        <label for="date" class="form-label">Date:</label>
                                        <input type="date" class="form-control" id="date" name="date">
                                    </div>
                                    <div class="col-md-12">
                                        <label for="image" class="form-label">Image:</label>
                                        <input type="file" name="image" id="image" class="form-control" required>
                                    </div>
                                    <div class="col-md-12 mt-3">
                                        <button type="submit" class="btn btn-success rounded-pill w-100">
                                            <i class="fa-solid fa-floppy-disk me-1"></i> Upload
                                        </button>                                        
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
                                <h4 class="n_h2_style rounded">Bill Images</h4>
                                {{-- SEARCH --}}                                
                                <div class="input-group mt-3">
                                    <input type="text" class="form-control" placeholder="Search bill images..." id="searchInput">
                                    <button class="btn btn-outline-secondary" type="button" id="searchButton">Search</button>
                                </div>
                                {{-- SEARCH --}}
                                <div style="height: 300px; overflow-y: auto;" class="mt-3 rounded-top">
                                    <table class="table" id="billImageTable">
                                        <thead style="position: sticky; top: 0; background-color: #1a1d20; z-index: 1;">
                                            <tr>
                                                <th scope="col">User</th>
                                                <th scope="col">Shop</th>
                                                <th scope="col">Date</th>
                                                <th scope="col">Image</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($billImages as $billImage)
                                            <tr>
                                                <td>{{ $billImage->staff->staff_name }}</td>
                                                <td>{{ $billImage->shop->name }}</td>
                                                <td>{{ $billImage->date }}</td>
                                                {{-- <td><img src="{{ asset($billImage->image) }}" alt="Bill Image" width="50"></td> --}}
                                                <td>
                                                    <img src="{{ asset($billImage->image) }}" alt="Bill Image" width="50" class="img-thumbnail" data-toggle="modal" data-target="#imageModal" data-image="{{ asset($billImage->image) }}">
                                                </td>
                                                <td>
                                                    <button class="btn btn-warning btn-sm rounded-pill edit-btn"
                                                        style="width: 40%;" data-toggle="modal"
                                                        data-target="#editBillImageModal"
                                                        data-id="{{ $billImage->id }}"><i class="fa-regular fa-pen-to-square"></i></button>
                                                    <form method="post" style="display: inline;"
                                                        action="{{ route('bill_images.destroy', $billImage->id) }}">
                                                        @csrf
                                                        @method('delete')
                                                        <button class="btn btn-danger btn-sm rounded-pill"
                                                            style="width: 40%;"
                                                            onclick="return confirm('Are you sure you want to delete this bill image?')"
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

<!-- Edit Bill Image Modal -->
<div class="modal fade" id="editBillImageModal" tabindex="-1" role="dialog" aria-labelledby="editBillImageModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editBillImageModalLabel">Edit Bill Image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editBillImageForm" method="POST" action="" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" id="billImageId" name="bill_image_id">
                <div class="modal-body">
                    <div class="form-group">
                        
                            <label for="staff_id" id="staff_id_edit" class="form-label">Staff:</label>
                            <select name="staff_id" id="staff_id_edit" class="form-select" >
                                @foreach($staffs as $staff)
                                    <option value="{{ $staff->id }}" {{ $staff->id == $billImage->staff_id ? 'selected' : '' }}>{{ $staff->staff_name }}</option>
                                @endforeach
                            </select>
                        

                    </div>
                    <div class="form-group">
                        <label for="shop_id_edit" class="form-label">Shop:</label>
                        <select name="shop_id" id="shop_id_edit" class="form-select">
                            <option value="">Select a Shop</option>
                            @foreach($shops as $shop)
                                <option value="{{ $shop->id }}">{{ $shop->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="date_edit" class="form-label">Date:</label>
                        <input type="date" class="form-control" id="date_edit" name="date">
                    </div>
                    <div class="form-group">
                        <label for="image_edit" class="form-label">Image:</label>
                        <input type="file" name="image" id="image_edit" class="form-control">
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
<!-- Image Modal -->
<div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Bill Image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" alt="Bill Image" class="img-fluid">
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const editButtons = document.querySelectorAll('.edit-btn');

    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            const billImageId = this.getAttribute('data-id');
            const modal = document.getElementById('editBillImageModal');
            const editForm = document.getElementById('editBillImageForm');
            
            editForm.querySelector('#billImageId').value = billImageId;
            
            editForm.setAttribute('action', `/bill_images/${billImageId}`); 

            fetch(`/bill_images/${billImageId}/edit`)
                .then(response => response.json())
                .then(data => {
                    editForm.querySelector('#staff_id_edit').value = data.staff_id;
                    editForm.querySelector('#shop_id_edit').value = data.shop_id;
                    editForm.querySelector('#date_edit').value = data.date;
                    $('#editBillImageModal').modal('show');
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });
    });
    
    $('#editBillImageModal').on('hidden.bs.modal', function () {
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();
        $('body').css('overflow', 'auto');
    });

    // SEARCH   
    const searchInput = document.getElementById('searchInput');
    const billImageTable = document.getElementById('billImageTable');
    const tableRows = billImageTable.getElementsByTagName('tr');

    searchInput.addEventListener('input', function () {
        const query = searchInput.value.trim().toLowerCase();
        for (let i = 1; i < tableRows.length; i++) {
            const row = tableRows[i];
            const userColumn = row.cells[0];
            const shopColumn = row.cells[1];
            if (userColumn && shopColumn) {
                const userText = userColumn.textContent.toLowerCase();
                const shopText = shopColumn.textContent.toLowerCase();
                if (userText.includes(query) || shopText.includes(query)) {
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
    document.addEventListener('DOMContentLoaded', function() {
        $('#imageModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var imageSrc = button.data('image'); // Extract info from data-* attributes
            var modal = $(this);
            modal.find('.modal-body img').attr('src', imageSrc);
        });
    });
    </script>
    