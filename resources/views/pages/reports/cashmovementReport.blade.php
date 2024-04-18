@extends('layouts.layout')

@section('content')
<div class="container-fluid">
    <x-content-header title="Cash Movement Details Report" />
    <x-alert-message />

    <div class="row">
        <div class="col-12">
            <div class="card border-0">
                <div class="card-body">
                    <h4 class="card-title">Cash Movement Details Report</h4>
                    <form method="POST" action="{{ route('reports.generatecashMove') }}" class="row g-3">
                        @csrf
                        <div class="col-md-5 mt-3">
                            <label for="from_date" class="form-label">From Date:</label>
                            <input type="date" class="form-control" id="from_date" name="from_date" required>
                        </div>
                        <div class="col-md-5 mt-3">
                            <label for="to_date" class="form-label">To Date:</label>
                            <input type="date" class="form-control" id="to_date" name="to_date" required>
                        </div>
                        <div class="col-md-2 mt-3">
                            <button type="submit" class="btn btn-success rounded-pill w-100">Generate Report</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if(isset($from_date) && isset($to_date))
    <div class="card border-0 mt-4">
        <div class="card-body">
            <h5 class="card-title">Department-wise Cash Movement Details</h5>
            <p>Date Period: {{ $from_date }} to {{ $to_date }}</p>

            @if($shops->isEmpty())
                <div class="alert alert-warning" role="alert">
                    No shops found.
                </div>
            @else
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Department Type</th>
                            @foreach ($shops as $shop)
                                <th>{{ $shop->name }}</th>
                            @endforeach
                            <th>Total</th> <!-- New Total Column -->
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (['normal', 'other_taking', 'fuel'] as $departmentType)
                            <tr>
                                <td>{{ ucfirst(str_replace('_', ' ', $departmentType)) }} Department Total</td>
                                @php
                                    $departmentTypeTotal = 0;
                                @endphp
                                @foreach ($shops as $shop)
                                    <td>{{ $shopDepartmentTotals[$shop->id][$departmentType] ?? 0 }}</td>
                                    @php
                                        $departmentTypeTotal += $shopDepartmentTotals[$shop->id][$departmentType] ?? 0;
                                    @endphp
                                @endforeach
                                <td>{{ $departmentTypeTotal }}</td> 
                            </tr>
                        @endforeach
                        <tr>
                            <td>Other Incomes</td>
                            @foreach ($shops as $shop)
                                <td>{{ $shopTotalsByDate[$shop->id] ?? 0 }}</td>
                            @endforeach
                            <td>
                                @php
                                    $otherIncomesTotal = array_sum($shopTotalsByDate);
                                @endphp
                                {{ $otherIncomesTotal }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            @endif

        </div>
    </div>
    @endif
    
</div>
@endsection
