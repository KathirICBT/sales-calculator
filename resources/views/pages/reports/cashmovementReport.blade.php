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
                {{-- <table class="table table-bordered">
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
                            <td>Loan</td>
                            @foreach ($shops as $shop)
                                <td>{{ $LoanTotals[$shop->id] ?? 0 }}</td>
                            @endforeach
                            <td>
                                @php
                                    $LoanTotalsAll = array_sum($LoanTotals);
                                @endphp
                                {{ $LoanTotalsAll }}
                            </td>
                        </tr>
                        <tr>
                            <td>Other Incomes</td>
                            @foreach ($shops as $shop)
                                <td>{{ $shopOtherIncomeTotals[$shop->id] ?? 0 }}</td>
                            @endforeach
                            <td>
                                @php
                                    $otherIncomesTotal = array_sum($shopOtherIncomeTotals);
                                @endphp
                                {{ $otherIncomesTotal }}
                            </td>
                        </tr>
                       
                    </tbody>
                </table> --}}
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Cash In Flows</th>
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
                            <td>Loan</td>
                            @php
                                $loanTotalAll = 0;
                            @endphp
                            @foreach ($shops as $shop)
                                <td>{{ $LoanTotals[$shop->id] ?? 0 }}</td>
                                @php
                                    $loanTotalAll += $LoanTotals[$shop->id] ?? 0;
                                @endphp
                            @endforeach
                            <td>{{ $loanTotalAll }}</td>
                        </tr>
                        <tr>
                            <td>Other Incomes</td>
                            @php
                                $otherIncomesTotalAll = 0;
                            @endphp
                            @foreach ($shops as $shop)
                                <td>{{ $shopOtherIncomeTotals[$shop->id] ?? 0 }}</td>
                                @php
                                    $otherIncomesTotalAll += $shopOtherIncomeTotals[$shop->id] ?? 0;
                                @endphp
                            @endforeach
                            <td>{{ $otherIncomesTotalAll }}</td>
                        </tr>
                        <tr>
                            <td><strong>Total of All</strong></td>
                            @foreach ($shops as $shop)
                                <td>&nbsp;</td> <!-- Leave blank cells for individual shop totals -->
                            @endforeach
                            <td>
                                <strong>
                                    @php
                                        $grandTotal = $otherIncomesTotalAll + $loanTotalAll + $departmentTypeTotal;
                                    @endphp
                                    {{ $grandTotal }}
                                </strong>
                            </td>
                        </tr>
                        <tr><td></td></tr>
                        <tr><th>Cash Out Flows</th></tr>
                        {{-- @foreach ($reportData['supplier'] as $item)
                            <tr>
                                <td>{{ $item['sub_category'] }}</td>
                                @foreach ($shops as $shop)
                                    <td>{{ $item['shop_totals'][$shop->id] ?? 0 }}</td>
                                @endforeach
                                <td>{{ $item['total'] }}</td>
                            </tr>
                            @endforeach

                            <!-- Display rows for 'Income Tax' expenses -->
                            <tr><th>Income Tax</th></tr>
                            @foreach ($reportData['income_tax'] as $item)
                            <tr>
                                <td>{{ $item['sub_category'] }}</td>
                                @foreach ($shops as $shop)
                                    <td>{{ $item['shop_totals'][$shop->id] ?? 0 }}</td>
                                @endforeach
                                <td>{{ $item['total'] }}</td>
                            </tr>
                        @endforeach --}}
                        <!-- Display rows for 'Supplier' expenses -->
                        <!-- Display rows for 'Supplier' expenses -->
                        <!-- Display rows for 'Supplier' expenses -->
                            <!-- Display rows for 'Supplier' expenses -->
<!-- Display rows for 'Supplier' expenses -->
<!-- Display rows for 'Supplier' expenses -->
@foreach ($reportData['supplier'] as $categoryId => $item)
    <tr>
        <td>{{ $item['name'] }}</td>
        @foreach ($shops as $shop)
            <td>{{ $item['shop_totals'][$shop->id] ?? 0 }}</td>
        @endforeach
        <td>{{ $item['total'] }}</td>
    </tr>
@endforeach

<!-- Display rows for 'Income Tax' expenses -->
<tr><th colspan="{{ count($shops) + 2 }}">Income Tax</th></tr>
@foreach ($reportData['income_tax'] as $categoryId => $item)
    <tr>
        <td>{{ $item['name'] }}</td>
        @foreach ($shops as $shop)
            <td>{{ $item['shop_totals'][$shop->id] ?? 0 }}</td>
        @endforeach
        <td>{{ $item['total'] }}</td>
    </tr>
@endforeach






                    </tbody>
                </table>
                
                
         
                
            @endif

        </div>
    </div>
    @endif
    
</div>
@endsection
