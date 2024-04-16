@extends('layouts.layout')

@section('content')
<div class="container-fluid">   

    <x-content-header title="Expense Report - Reason" />
    <x-alert-message />

    <!-- Report Form Section -->   

    <div class="row">
        <div class="col-12 col-md-12 d-flex">
            <div class="card flex-fill border-0">
                <div class="card-body p-0 d-flex flex-fill">
                    <div class="row g-0 w-100">
                        <div class="col-12">
                            <div class="p-3 m-1">                                                
                                <h4 class="n_h_style rounded">Expense Report - Reason</h4>
                                <form method="POST" action="{{ route('reports.expense') }}">
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
                                            <label for="petty_cash_reason_id" class="form-label">Petty Cash Reason:</label>
                                            <select class="form-control" id="petty_cash_reason_id" name="petty_cash_reason_id" required>
                                                <option value="" selected disabled>Select Reason</option>
                                                @foreach($pettyCashReasons as $reason)
                                                    <option value="{{ $reason->id }}">{{ $reason->reason }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="" class="form-label">Generate
                                                Report:</label><br>
                                            <button type="submit" class="btn btn-success rounded-pill" style="width: 100%">Generate Report</button>
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
    <!-- Report Table Section -->
    @if(isset($shopTotalsByDate))
        <div class="card border-0 mt-4">
            
            <div class="card-body">
                <div class="mb-3">
                    <h4>Expense Report - Reason: {{ $expenseReason }}</h4>
                    <p>Date Period: {{ $from_date }} to {{ $to_date }}</p>
                </div>
            
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
            </div>
        </div>
    @endif
</div>
@endsection
