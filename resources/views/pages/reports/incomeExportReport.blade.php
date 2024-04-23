@extends('layouts.layout')

@section('content')
<div class="container-fluid">
    <x-content-header title="Cash Movement Details Report" />
    <x-alert-message />

    <div class="row">
        <div class="col-12">
            <div class="card border-0">
                <div class="card-body">
                    <h4 class="card-title">Income Export Details Report</h4>
                    <form method="POST" action="{{ route('reports.generateIncomeExpo') }}" class="row g-3">
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
                            <label for="" class="form-label">Generate Report:</label>
                            <button type="submit" class="btn btn-success rounded-pill w-100">Report</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if(isset($from_date) && isset($to_date))
    <div class="card border-0 mt-3">
        <div class="card-header">
            <h5 class="card-title">
                Department-wise Cash Movement Details
            </h5>
            <h6 class="card-subtitle text-muted">
                <p>Date Period: {{ $from_date }} to {{ $to_date }}</p>
            </h6>
        </div>
        <div class="card-body">
            @if($shops->isEmpty())
            <div class="alert alert-warning" role="alert">
                No shops found.
            </div>
            @else

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="color:forestgreen">Cash In Flows</th>
                        @php
                        $columnTotals = array_fill(0, count($shops) + 1, 0);
                        @endphp
                        @foreach ($shops as $shop)
                        <th style="color:forestgreen">{{ $shop->name }}</th>
                        @endforeach
                        <th style="color:forestgreen">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach (['normal', 'other_taking', 'fuel'] as $departmentType)
                    <tr>
                        <td>{{ ucfirst(str_replace('_', ' ', $departmentType)) }} Department Total</td>
                        @php
                        $departmentTypeTotal = 0;
                        @endphp
                        @foreach ($shops as $index => $shop)
                        @php
                        $value = $shopDepartmentTotals[$shop->id][$departmentType] ?? 0;
                        $departmentTypeTotal += $value;
                        $columnTotals[$index] += $value;
                        @endphp
                        <td>{{ $value }}</td>
                        @endforeach
                        <td>{{ $departmentTypeTotal }}</td>
                        @php
                        $columnTotals[count($shops)] += $departmentTypeTotal;
                        @endphp
                    </tr>
                    @endforeach

                    <tr>
                        <td>Loan</td>
                        @php
                        $loanTotalAll = 0;
                        @endphp
                        @foreach ($shops as $index => $shop)
                        @php
                        $value = $LoanTotals[$shop->id] ?? 0;
                        $loanTotalAll += $value;
                        $columnTotals[$index] += $value;
                        @endphp
                        <td>{{ $value }}</td>
                        @endforeach
                        <td>{{ $loanTotalAll }}</td>
                        @php
                        $columnTotals[count($shops)] += $loanTotalAll;
                        @endphp
                    </tr>

                    <tr>
                        <td>Other Incomes</td>
                        @php
                        $otherIncomesTotalAll = 0;
                        @endphp
                        @foreach ($shops as $index => $shop)
                        @php
                        $value = $shopOtherIncomeTotals[$shop->id] ?? 0;
                        $otherIncomesTotalAll += $value;
                        $columnTotals[$index] += $value;
                        @endphp
                        <td>{{ $value }}</td>
                        @endforeach
                        <td>{{ $otherIncomesTotalAll }}</td>
                        @php
                        $columnTotals[count($shops)] += $otherIncomesTotalAll;
                        @endphp
                    </tr>

                    <tr>
                        <td><strong style="color:coral">Total Cash Inflow</strong></td>
                        @foreach ($columnTotals as $total)
                        <td><strong style="color:coral">{{ $total }}</strong></td>
                        @endforeach
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                    </tr>

                   
                    <tr>
                        <td>Purchase Total</td>
                        @php
                        $purchaseTotalAll = 0;
                        $purchaseColumnTotals = array_fill(0, count($shops), 0);
                        @endphp
                        @foreach ($report as $subCategory => $subCategoryData)
                        @if ($subCategory === 'Purchase'|| $subCategory === 'Purchases')
                                @foreach ($shops as $index => $shop)
                                    @php
                                    $value = $subCategoryData['data'][$shop->id] ?? 0;
                                    $purchaseTotalAll += $value;
                                    $purchaseColumnTotals[$index] += $value;
                                    @endphp
                                    <td>{{ $value }}</td>
                                @endforeach
                            @endif
                        @endforeach
                        <td>{{ $purchaseTotalAll }}</td>
                    </tr>
                    
                    <tr>
                        <td><strong style="color:coral">Total Purchase</strong></td>
                        @foreach ($purchaseColumnTotals as $total)
                            <td><strong style="color:coral">{{ $total }}</strong></td>
                        @endforeach
                        <td><strong style="color:coral">{{ $purchaseTotalAll }}</strong></td>
                    </tr>
                    
                    
                    
                    <tr>
                        <td><strong style="color: coral">Gross Profit</strong></td>
                        @php
                            $grossProfitColumnTotal = 0;
                        @endphp
                        @foreach ($shops as $index => $shop)
                            @php
                                $netCashFlow = $columnTotals[$index] - $purchaseColumnTotals[$index];
                                $grossProfitColumnTotal += $netCashFlow;
                            @endphp
                            <td><strong style="color: coral">{{ $netCashFlow }}</strong></td>
                        @endforeach
                        <td><strong style="color: coral">{{ $grossProfitColumnTotal }}</strong></td>
                    </tr>
                    
                    
                    
                    

                    <tr>
                        <td>&nbsp;</td>
                    </tr>

                    <tr>
                        <th style="color:forestgreen">Expenses</th>
                    </tr>

                    @php
                    $outflowColumnTotals = array_fill(0, count($shops) + 1, 0);
                    @endphp

                    @foreach ($report as $subCategory => $subCategoryData)
                    @if(($subCategoryData['supplier'] !== 'Income Tax')&&(!($subCategory === 'Purchase'|| $subCategory === 'Purchases')))
                    <tr>
                        <td>{{ $subCategory }}</td>
                        @php
                        $subCategoryTotal = 0;
                        @endphp
                        @foreach ($shops as $index => $shop)
                        <td>{{ $subCategoryData['data'][$shop->id] ?? 0 }}</td>
                        @php
                        $subCategoryTotal += $subCategoryData['data'][$shop->id] ?? 0;
                        $outflowColumnTotals[$index] += $subCategoryData['data'][$shop->id] ?? 0;
                        @endphp
                        @endforeach
                        <td>{{ $subCategoryTotal }}</td>
                    </tr>
                    @endif
                    @endforeach

                    

                    <tr>
                        <td><strong style="color: coral">Total Expenses</strong></td>
                        @php
                            $totalExpenses = 0;
                        @endphp
                        @foreach ($shops as $index => $shop)
                            @php
                                $expenseValue = $outflowColumnTotals[$index];
                                $totalExpenses += $expenseValue;
                            @endphp
                            <td><strong style="color: coral">{{ $expenseValue }}</strong></td>
                        @endforeach
                        <td><strong style="color: coral">{{ $totalExpenses }}</strong></td>
                    </tr>
                    
                    
                    
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                    <tr>
                        <td><strong style="color: coral">Profit</strong></td>
                        @php
                            $totalProfit = 0;
                        @endphp
                        @foreach ($shops as $index => $shop)
                            @php
                                $grossProfit = $columnTotals[$index] - $purchaseColumnTotals[$index];
                                $expenses = $outflowColumnTotals[$index];
                                $netProfit = $grossProfit - $expenses;
                                $totalProfit += $netProfit;
                            @endphp
                            <td><strong style="color: coral">{{ $netProfit }}</strong></td>
                        @endforeach
                        <td><strong style="color: coral">{{ $totalProfit }}</strong></td>
                    </tr>
                    
                    
                    

                    <tr>
                        <td>&nbsp;</td>
                    </tr>


                    <tr>
                        <th style="color:forestgreen">Income Tax</th>
                    </tr>

                    @foreach ($report as $subCategory => $subCategoryData)
                    @if ($subCategoryData['supplier'] === 'Income Tax')
                    <tr>
                        <td>{{ $subCategory }}</td>
                        @php
                        $subCategoryTotal = 0;
                        @endphp
                        @foreach ($shops as $index => $shop)
                        <td>{{ $subCategoryData['data'][$shop->id] ?? 0 }}</td>
                        @php
                        $subCategoryTotal += $subCategoryData['data'][$shop->id] ?? 0;
                        $outflowColumnTotals[$index] += $subCategoryData['data'][$shop->id] ?? 0;
                        @endphp
                        @endforeach
                        <td>{{ $subCategoryTotal }}</td>
                        @php
                        $outflowColumnTotals[count($shops)] += $subCategoryTotal;
                        @endphp
                    </tr>
                    @endif
                    @endforeach
                    <tr>
                        <td>&nbsp;</td>
                    </tr>
                    {{-- Aditional Capital --}}

                    <tr>
                        <td>Owner Additional Capital</td>
                        @php
                        $additionalCapitalTotalAll = 0;
                        $additionalCapitalColumnTotals = [];
                        @endphp
                        @foreach ($shops as $index => $shop)
                        @php
                        $value = $additionalCapitalTotals[$shop->id] ?? 0;
                        $additionalCapitalTotalAll += $value;
                        $additionalCapitalColumnTotals[] = $value;
                        echo '<td>' . $value . '</td>';
                        @endphp
                        @endforeach
                        <td>{{ $additionalCapitalTotalAll }}</td>
                    </tr>

                    @php
                    $additionalCapitalColumnTotals[] = $additionalCapitalTotalAll;
                    @endphp

                    {{-- Aditional Capital --}}

                    {{-- OWNER --}}

                    @php
                    $ownerWithdrawalTotals = array_fill(0, count($shops) + 1, 0);
                    @endphp

                    @foreach ($ownerCashMovement as $subCategory => $subCategoryData)
                    <tr>
                        <td>{{ $subCategory . " Withdrawal" }}</td>
                        @php
                        $subCategoryTotal = 0;
                        @endphp
                        @foreach ($shops as $index => $shop)
                        <td>{{ $subCategoryData['data'][$shop->id] ?? 0 }}</td>
                        @php
                        $amount = $subCategoryData['data'][$shop->id] ?? 0;
                        $subCategoryTotal += $amount;
                        $ownerWithdrawalTotals[$index] += $amount;
                        @endphp
                        @endforeach
                        <td>{{ $subCategoryTotal }}</td>
                        @php
                        $ownerWithdrawalTotals[count($shops)] += $subCategoryTotal;
                        @endphp
                    </tr>
                    @endforeach

                    <tr>
                        <td><strong style="color:coral">Owner Cash</strong></td>
                        @foreach ($additionalCapitalColumnTotals as $key => $additionalCapitalTotal)
                        @php
                        $ownerWithdrawalTotal = $ownerWithdrawalTotals[$key] ?? 0;
                        $ownerCash = $additionalCapitalTotal - $ownerWithdrawalTotal;
                        @endphp
                        <td><strong style="color:coral">{{ $ownerCash }}</strong></td>
                        @endforeach
                    </tr>

                    <tr>
                        <td>&nbsp;</td>
                    </tr>

                    <tr>
                        <td><strong style="color:rgb(90, 201, 0)">Master Net Cash Flow</strong></td>
                        @foreach ($additionalCapitalColumnTotals as $key => $additionalCapitalTotal)
                        @php
                        $columnTotal = $columnTotals[$key] ?? 0;
                        $outflowColumnTotal = $outflowColumnTotals[$key] ?? 0;
                        $ownerWithdrawalTotal = $ownerWithdrawalTotals[$key] ?? 0;
                        $masterNetCashFlow = $columnTotal - $outflowColumnTotal + $additionalCapitalTotal -
                        $ownerWithdrawalTotal;
                        @endphp
                        <td><strong style="color:rgb(90, 201, 0)">{{ $masterNetCashFlow }}</strong></td>
                        @endforeach
                    </tr>

                    {{-- OWNER --}}

                </tbody>
            </table>
            @endif
        </div>
    </div>
    @endif
</div>
@endsection