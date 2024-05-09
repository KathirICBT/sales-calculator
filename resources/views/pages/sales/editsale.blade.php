@extends('layouts.layout')
@section('content')
<div class="container-fluid">
    
    <x-content-header title="Shifts Management" />
    <x-alert-message />

    <div class="row">
        <div class="col-12 col-md-6 d-flex">
            <div class="card flex-fill border-0">
                <div class="card-body p-0 d-flex flex-fill">
                    <div class="row g-0 w-100">
                        <div class="col-12">
                            <div class="p-3 m-1">
                                <div class="card-header">
                                    <h5 class="card-title">
                                        Add Sales Details
                                    </h5>
                                    <p>
                                        @if(session('success'))
                                        <div class="alert" style="color: green;">{{ session('success') }}</div>
                                        @endif
                                    </p>
                                </div>
                                
                                <div class="card-body">
                                    <form class="row g-3"  method="GET" action="{{ route('shiftstaff.results') }}">
                                        <label for="username" class="form-label">Search by Staff Username:</label>
                                        <input type="text" name="username" id="username" required>
                                        <button type="submit"  class="btn btn-primary rounded-pill">Search</button>
                                    </form>                                    
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        

    </div>

    <div class="row">
    
            <div class="card flex-fill border-0">
                <div class="card-body p-0 d-flex flex-fill">
                    <div class="row g-0 w-100">
                        <div class="col-12">
                            <div class="p-3 m-1">
                                <div class="card-header">
                                    <h5 class="card-title">Search Results</h5>
                                </div>
                                <div class="card-body">
                                    @if($staffDetails->isNotEmpty())
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover">
                                                <thead style="position: sticky; top: 0; background-color: #1a1d20; z-index: 1;">
                                                    <tr>
                                                        <th>Staff Name</th>
                                                        <th>Shop Name</th>
                                                        <th>Start Date</th>
                                                        <th>Start Time</th>
                                                        <th>End Date</th>
                                                        <th>End Time</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($staffDetails as $staffDetail)
                                                        <tr>
                                                            <td>{{ optional($staffDetail->staff)->staff_name }}</td>
                                                            <td>{{ optional($staffDetail->shop)->name }}</td>
                                                            <td>{{ $staffDetail->start_date }}</td>
                                                            <td>{{ $staffDetail->start_time }}</td>
                                                            <td>{{ $staffDetail->end_date }}</td>
                                                            <td>{{ $staffDetail->end_time }}</td>
                                                            <td>
                                                                <button class="btn btn-primary edit-sale-btn" data-shift-id="{{ $staffDetail->id }}">Edit Sale</button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="alert alert-info" role="alert">
                                            No shifts found for the selected username.
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
         
    </div>
    <div class="row">
        <div class="card flex-fill border-0">
            <div class="card-body p-0 d-flex flex-fill">
                <div class="row g-0 w-100">
                    <div class="col-12">
                        <div class="p-3 m-1">
                            <div class="card-header">
                                <h5 class="card-title">Sales Details</h5>
                            </div>
                            <div class="card-body">
                                @isset($salesDetails)
                                    @if($salesDetails->isNotEmpty())
                                    <div class="table-responsive" class="mt-3 rounded-top">
                                        <table class="table table-striped table-hover sales-details-table">
                                            <thead style="position: sticky; top: 0; background-color: #1a1d20; z-index: 1;">
                                                <tr>
                                                    <th>Sale ID</th>
                                                    <th>Department</th>
                                                    <th>Amount</th>                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($salesDetails as $sale)
                                                    <tr>
                                                        <td>{{ $sale->id }}</td>
                                                        <td data-dept-id="{{ $sale->dept_id }}">{{ $sale->department->dept_name }}</td>
                                                        <td>{{ $sale->amount }}</td>
                                                        <!-- Add more columns as needed -->
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <p>No sales details found for this shift.</p>
                                @endif

                                @endisset
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

    
    
    
</div>
@endsection



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- <script>
   $(document).ready(function() {
        $('.edit-sale-btn').on('click', function() {
            var shiftId = $(this).data('shift-id');

            // Make an AJAX request to fetch sales details for the selected shift
            $.ajax({
                method: 'GET',
                url: '/shifts/' + shiftId + '/sales',
                success: function(response) {
                    // Clear previous data from the table body
                    $('.sales-details-table tbody').empty();

                    // Iterate over the sales details in the response and append rows to the table
                    $.each(response.salesDetails, function(index, sale) {
                        var row = '<tr>' +
                            '<td>' + sale.id + '</td>' +
                            '<td>' + sale.amount + '</td>' +
                            // Add more columns as needed
                            '</tr>';
                        $('.sales-details-table tbody').append(row);
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching sales details:', error);
                    // Optionally, display an error message
                }
            });
        });
    });


</script> -->


<script>
    $(document).ready(function() {
        $('.edit-sale-btn').on('click', function() {
            var shiftId = $(this).data('shift-id');

            // Make an AJAX request to fetch sales details for the selected shift
            $.ajax({
                method: 'GET',
                url: '/shifts/' + shiftId + '/sales',
                success: function(response) {
                    console.log(response);
                    // Clear previous data from the table body
                    $('.sales-details-table tbody').empty();

                    // Iterate over the sales details in the response and append rows to the table
                    $.each(response.salesDetails, function(index, sale) {
                        // Fetch the department name associated with the sale
                        var departmentName = getDepartmentName(sale.dept_id, response.departments);

                        // Construct the HTML row with department name
                        var row = '<tr>' +
                            '<td>' + sale.id + '</td>' +
                            '<td>' + departmentName + '</td>' + // Display department name
                            '<td>' + sale.amount + '</td>' +
                            // Add more columns as needed
                            '</tr>';
                        $('.sales-details-table tbody').append(row);
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching sales details:', error);
                    // Optionally, display an error message
                }
            });
        });
    });

    // Function to fetch department name based on dept_id
    // Function to fetch department name based on dept_id
    function getDepartmentName(deptId, departments) {
        for (var i = 0; i < departments.length; i++) {
            if (departments[i].id === deptId) {
                return departments[i].dept_name; // Return department name if dept_id matches
            }
        }
        return 'Unknown'; // Return 'Unknown' if department name is not found (optional)
    }


</script>







