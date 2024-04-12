@extends('layouts.layout')

@section('content')
<div class="container-fluid">
    <div class="mb-3">
        <h4>Other Payment Method Sales Report</h4>
    </div>
    <div class="row">
        <div class="col-12 col-md-6 d-flex">
            <div class="card flex-fill border-0 illustration">
                <div class="card-body p-0 d-flex flex-fill">
                    <div class="row g-0 w-100">
                        <div class="col-6">
                            <div class="p-3 m-1">
                                <h4>Welcome, {{ session('username') }}</h4>
                                {{-- <h4>{{ session('username') }}</h4> --}}
                                {{-- <h4>{{ $staff->staff_name }}</h4> --}}
                                <p class="mb-0">Staff Dashboard, Sales Calculator</p>
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
        <div class="col-12 col-md-6 d-flex">
            <div class="card flex-fill border-0">
                <div class="card-body py-4">
                    <div class="d-flex align-items-start">
                        <div class="flex-grow-1">
                            <h4 class="mb-2">
                                -
                            </h4>
                            <p class="mb-2">
                                -
                            </p>
                            <div class="mb-0">
                                <span class="badge text-success me-2">
                                    -
                                </span>
                                <span class="text-muted">
                                    -
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- CHANGEING AREA --}}

    {{-- <div class="card border-0">
        <div class="card-body">
            <form method="POST" action="{{ route('reports.generatePayment') }}">
                @csrf
                <div class="row g-3">
                    <div class="col-md-3">
                        <label for="from_date" class="form-label">From Date:</label>
                        <input type="date" class="form-control" id="from_date" name="from_date" required>
                    </div>
                    <div class="col-md-3">
                        <label for="to_date" class="form-label">To Date:</label>
                        <input type="date" class="form-control" id="to_date" name="to_date" required>
                    </div>
                    <div class="col-md-3">
                        <label for="payment_method_id" class="form-label">Payment Method:</label>
                        <select class="form-select" id="payment_method_id" name="payment_method_id" required>
                            <option value="">Select Payment Method</option>
                            @foreach($paymentMethods as $method)
                            <option value="{{ $method->id }}">{{ $method->payment_method }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="" class="form-label">Generate Report:</label><br>
                        <button type="submit" class="btn btn-success rounded-pill" style="width: 100%">Report</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if(isset($paymentSales))
    <div class="card border-0 mt-4">
        <div class="card-header">
            <h5 class="card-title">Other Payment Sales Report</h5>
            <h6 class="card-subtitle text-muted">Date Period: {{ $from_date }} to {{ $to_date }} | Payment Method: {{
                $selectedPaymentMethod }}</h6>
        </div>
        <div class="card-body">

            @if (!empty($shopTotalsByDate))
            <div class="card border-0">
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                @foreach($shops as $shop)
                                <th>{{ $shop->name }}</th>
                                @endforeach
                                <th class="text-end fw-bold">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $grandTotal = 0; @endphp
                            @foreach($shopTotalsByDate as $date => $shopTotals)
                            <tr>
                                <td>{{ $date }}</td>
                                @php $total = 0; @endphp
                                @foreach($shops as $shop)
                                <td>
                                    @if(isset($shopTotals[$shop->id]))
                                    {{ number_format($shopTotals[$shop->id], 2) }}
                                    @php $total += $shopTotals[$shop->id]; @endphp
                                    @else
                                    -
                                    @endif
                                </td>
                                @endforeach
                                <td class="text-end fw-bold">{{ number_format($total, 2) }}</td>
                                @php $grandTotal += $total; @endphp
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="{{ count($shops) + 2 }}" class="text-end fw-bold">
                                    <small>Grand Total:</small><span class="ms-3" style="color: rgb(250, 139, 60);">{{
                                        number_format($grandTotal, 2) }}</span>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            @else
            <p>No data available for the selected date range.</p>
            @endif
        </div>
    </div>
    @endif


    @if(isset($reports))

    @foreach($reports as $report)
    <div class="card border-0 mt-4">
        <div class="card-header">
            <h5 class="card-title">Payment Report - {{ $report['paymentMethod'] }}</h5>
            <h6 class="card-subtitle text-muted">Date Period: {{ $report['from_date'] }} to {{ $report['to_date'] }}
            </h6>
        </div>
        <div class="card-body">
            @if (!empty($report['shopTotalsByDate']))
            <div class="card border-0">
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                @foreach($report['shops'] as $shop)
                                <th>{{ $shop->name }}</th>
                                @endforeach
                                <th class="text-end fw-bold">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $grandTotal = 0; @endphp
                            @foreach($report['shopTotalsByDate'] as $date => $shopTotals)
                            <tr>
                                <td>{{ $date }}</td>
                                @php $total = 0; @endphp
                                @foreach($report['shops'] as $shop)
                                <td>
                                    @if(isset($shopTotals[$shop->id]))
                                    {{ number_format($shopTotals[$shop->id], 2) }}
                                    @php $total += $shopTotals[$shop->id]; @endphp
                                    @else
                                    -
                                    @endif
                                </td>
                                @endforeach
                                <td class="text-end fw-bold">{{ number_format($total, 2) }}</td>
                                @php $grandTotal += $total; @endphp
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="{{ count($report['shops']) + 2 }}" class="text-end fw-bold">
                                    <small>Grand Total:</small><span class="ms-3" style="color: rgb(250, 139, 60);">{{
                                        number_format($grandTotal, 2) }}</span>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            @else
            <p>No data available for the selected date range.</p>
            @endif
        </div>
    </div>
    @endforeach

    @endif --}}

    {{-- CHANGEING AREA END --}}

    {{-- NEW AREA --}}

    {{-- row start --}}

    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="paymentSales-tab" data-bs-toggle="tab" data-bs-target="#paymentSales"
                type="button" role="tab" aria-controls="paymentSales" aria-selected="true">Selected Payment Method
                </button>
        </li>
        <li class="nav-item ms-1" role="presentation">
            <button class="nav-link" id="reports-tab" data-bs-toggle="tab" data-bs-target="#reports" type="button"
                role="tab" aria-controls="reports" aria-selected="false"> All Payment Methods</button>
        </li>
    </ul>
    <div class="tab-content mt-3" id="myTabContent">
        <div class="tab-pane fade show active" id="paymentSales" role="tabpanel" aria-labelledby="paymentSales-tab">
            <div class="card border-0">
                <div class="card-body">
                    <!-- Form for paymentSales tab -->

                    <div class="row">
                        <div class="col-12 col-md-12 d-flex">
                            <div class="card flex-fill border-0">
                                <div class="card-body p-0 d-flex flex-fill">
                                    <div class="row g-0 w-100">
                                        <div class="col-12">
                                            <div class="p-3 m-1">
                                                <h4 class="n_h_style rounded">Other Payment Methods Sales - Selected Payment Method</h4>


                                                <form method="POST" action="{{ route('report.generatePayment') }}"
                                                    id="paymentSalesForm">
                                                    @csrf
                                                    <div class="row g-3 mt-5">
                                                        <div class="col-md-3">
                                                            <label for="from_date" class="form-label">From Date:</label>
                                                            <input type="date" class="form-control" id="from_date"
                                                                name="from_date" required>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label for="to_date" class="form-label">To Date:</label>
                                                            <input type="date" class="form-control" id="to_date"
                                                                name="to_date" required>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label for="payment_method_id" class="form-label">Payment
                                                                Method:</label>
                                                            <select class="form-select" id="payment_method_id"
                                                                name="payment_method_id" required>
                                                                <option value="">Select Payment Method</option>
                                                                @foreach($paymentMethods as $method)
                                                                <option value="{{ $method->id }}">{{
                                                                    $method->payment_method }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label for="" class="form-label">Generate
                                                                Report:</label><br>
                                                            <button type="submit" class="btn btn-success rounded-pill"
                                                                style="width: 100%">Report</button>
                                                        </div>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Form for paymentSales tab -->
                </div>
            </div>
            <!-- Content for paymentSales tab -->
            @if(isset($paymentSales))
            <div class="card border-0 mt-4">
                <div class="card-header">
                    <h5 class="card-title">Other Payment Sales Report - 
                       {{ $selectedPaymentMethod }}</h5>
                    <h6 class="card-subtitle text-muted"> Date Period: {{ $from_date }} to {{ $to_date }} </h6>
                </div>
                <div class="card-body">

                    @if (!empty($shopTotalsByDate))
                    <div class="card border-0">
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        @foreach($shops as $shop)
                                        <th>{{ $shop->name }}</th>
                                        @endforeach
                                        <th class="text-end fw-bold">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $grandTotal = 0; @endphp
                                    @foreach($shopTotalsByDate as $date => $shopTotals)
                                    <tr>
                                        <td>{{ $date }}</td>
                                        @php $total = 0; @endphp
                                        @foreach($shops as $shop)
                                        <td>
                                            @if(isset($shopTotals[$shop->id]))
                                            {{ number_format($shopTotals[$shop->id], 2) }}
                                            @php $total += $shopTotals[$shop->id]; @endphp
                                            @else
                                            -
                                            @endif
                                        </td>
                                        @endforeach
                                        <td class="text-end fw-bold">{{ number_format($total, 2) }}</td>
                                        @php $grandTotal += $total; @endphp
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="{{ count($shops) + 2 }}" class="text-end fw-bold">
                                            <small>Grand Total:</small><span class="ms-3"
                                                style="color: rgb(250, 139, 60);">{{ number_format($grandTotal, 2)
                                                }}</span>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    @else
                    <p>No data available for the selected date range.</p>
                    @endif
                </div>
            </div>
            @endif
            <!-- Content for paymentSales tab -->
        </div>
        <div class="tab-pane fade" id="reports" role="tabpanel" aria-labelledby="reports-tab">
            <div class="card border-0">
                <div class="card-body">
                    <!-- Form for reports tab -->


                    <div class="row">
                        <div class="col-12 col-md-12 d-flex">
                            <div class="card flex-fill border-0">
                                <div class="card-body p-0 d-flex flex-fill">
                                    <div class="row g-0 w-100">
                                        <div class="col-12">
                                            <div class="p-3 m-1">
                                                <h4 class="n_h_style rounded">Other Payment Methods Sales - All Payment Methods</h4>



                                                <form method="POST" action="{{ route('reports.generatePayment') }}"
                                                    id="reportsForm">
                                                    @csrf
                                                    <div class="row g-3 mt-5">
                                                        <div class="col-md-5">
                                                            <label for="from_date" class="form-label">From Date:</label>
                                                            <input type="date" class="form-control" id="from_date"
                                                                name="from_date" required>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <label for="to_date" class="form-label">To Date:</label>
                                                            <input type="date" class="form-control" id="to_date"
                                                                name="to_date" required>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for="" class="form-label">Generate
                                                                Report:</label><br>
                                                            <button type="submit" class="btn btn-success rounded-pill"
                                                                style="width: 100%">Report</button>
                                                        </div>
                                                    </div>
                                                </form>


                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
            <!-- Content for reports tab -->

            @if(isset($reports))

            @foreach($reports as $report)
            <div class="card border-0 mt-4">
                <div class="card-header">
                    <h5 class="card-title">Payment Report - {{ $report['paymentMethod'] }}</h5>
                    <h6 class="card-subtitle text-muted">Date Period: {{ $report['from_date'] }} to {{
                        $report['to_date'] }}</h6>
                </div>
                <div class="card-body">
                    @if (!empty($report['shopTotalsByDate']))
                    <div class="card border-0">
                        <div class="card-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        @foreach($report['shops'] as $shop)
                                        <th>{{ $shop->name }}</th>
                                        @endforeach
                                        <th class="text-end fw-bold">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $grandTotal = 0; @endphp
                                    @foreach($report['shopTotalsByDate'] as $date => $shopTotals)
                                    <tr>
                                        <td>{{ $date }}</td>
                                        @php $total = 0; @endphp
                                        @foreach($report['shops'] as $shop)
                                        <td>
                                            @if(isset($shopTotals[$shop->id]))
                                            {{ number_format($shopTotals[$shop->id], 2) }}
                                            @php $total += $shopTotals[$shop->id]; @endphp
                                            @else
                                            -
                                            @endif
                                        </td>
                                        @endforeach
                                        <td class="text-end fw-bold">{{ number_format($total, 2) }}</td>
                                        @php $grandTotal += $total; @endphp
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="{{ count($report['shops']) + 2 }}" class="text-end fw-bold">
                                            <small>Grand Total:</small><span class="ms-3"
                                                style="color: rgb(250, 139, 60);">{{ number_format($grandTotal, 2)
                                                }}</span>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    @else
                    <p>No data available for the selected date range.</p>
                    @endif
                </div>
            </div>
            @endforeach

            @endif

            <!-- Content for reports tab -->
        </div>
    </div>



    {{-- row end --}}


    {{-- NEW AREA END --}}





</div>
@endsection


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>   

$(document).ready(function () {
    // Handle form submission for paymentSales tab
    $(document).off('submit', '#paymentSalesForm').on('submit', '#paymentSalesForm', function (e) {
        e.preventDefault(); // Prevent default form submission
        // AJAX request to submit form data
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function (response) {
                // Check if the response contains the updated content for the paymentSales tab
                if ($(response).find('#paymentSales').length > 0) {
                    $('#paymentSales').html($(response).find('#paymentSales').html());
                } else {
                    // Handle error if the response does not contain the expected content
                    console.error('Error: Could not find updated content for the paymentSales tab in the response.');
                }
            },
            error: function (xhr, status, error) {
                // Handle error if AJAX request fails
                console.error('AJAX Error:', error);
            }
        });
        return false; // Prevent default behavior of the form
    });

    // Handle form submission for reports tab
    $(document).off('submit', '#reportsForm').on('submit', '#reportsForm', function (e) {
        e.preventDefault(); // Prevent default form submission
        // AJAX request to submit form data
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function (response) {
                // Check if the response contains the updated content for the reports tab
                if ($(response).find('#reports').length > 0) {
                    $('#reports').html($(response).find('#reports').html());
                } else {
                    // Handle error if the response does not contain the expected content
                    console.error('Error: Could not find updated content for the reports tab in the response.');
                }
            },
            error: function (xhr, status, error) {
                // Handle error if AJAX request fails
                console.error('AJAX Error:', error);
            }
        });
        return false; // Prevent default behavior of the form
    });
});



</script>