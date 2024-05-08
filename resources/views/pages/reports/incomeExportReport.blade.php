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
                        @foreach (['normal', 'fuel'] as $departmentType)
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
                            <td align="right">{{ number_format($value, 2) }}</td>
                            @endforeach
                                <td align="right">{{ number_format($departmentTypeTotal, 2) }}</td>
                            @php
                            $columnTotals[count($shops)] += $departmentTypeTotal;
                            @endphp
                        </tr>
                        @endforeach
                        

                    

                    
                        <tr>
                            <td><strong style="color:coral">Total Cash Inflow</strong></td>
                            @foreach ($columnTotals as $total)
                            <td align="right"><strong style="color:coral">{{ number_format($total, 2) }}</strong></td>                           
                            @endforeach
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>

                    
                        <tr>
                            <th style="color:forestgreen">Purchase</th>
                        </tr>
                       
                        @php
                            $purchaseColumnTotals = array_fill(0, count($shops), 0); // Initialize column totals array
                            $purchaseTotalAll = 0; // Initialize overall purchase total
                        @endphp

                        @foreach ($purchasereport as $purchaseType => $purchaseTypeData)
                            @if ($purchaseType !== 'Expense' && $purchaseType !== 'Other Payment')
                                <tr>
                                    <td>{{ $purchaseType }}</td>
                                    @php
                                        $purchaseTypeTotal = 0; // Initialize purchase type total
                                    @endphp

                                    @foreach ($shops as $index => $shop)
                                        @php
                                            $value = $purchaseTypeData['data'][$shop->id] ?? 0; // Get purchase amount for current shop
                                            $purchaseTypeTotal += $value; // Increment purchase type total
                                            $purchaseColumnTotals[$index] += $value; // Increment column total for current shop
                                        @endphp
                                        <td align="right">{{ number_format($value, 2) }}</td>
                                    @endforeach
                                    <td align="right">{{ number_format($purchaseTypeTotal, 2) }}</td>
                                </tr>
                            @endif
                        @endforeach

                        <tr>
                            <td><strong style="color: coral">Total Purchase</strong></td>

                            @foreach ($purchaseColumnTotals as $total)
                                @php
                                    $purchaseTotalAll += $total; // Accumulate the total purchases
                                @endphp
                                <td align="right"><strong style="color:coral">{{ number_format($total, 2) }}</strong></td>  <!-- Display shop's total -->
                            @endforeach
                            <td align="right"><strong style="color:coral">{{ number_format($purchaseTotalAll, 2) }}</strong></td>  <!-- Display overall total -->
                        </tr>

                    


   

                    
                        <tr>
                            <td>&nbsp;</td>
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
                                <td align="right"><strong style="color:coral">{{ number_format($netCashFlow, 2) }}</strong></td>
                            @endforeach
                            <td align="right"><strong style="color:coral">{{ number_format($grossProfitColumnTotal, 2) }}</strong></td>

                        </tr>
                        
                        
                        
                        

                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                      
                        <tr>
                            <td><strong style="color: coral">Shop Margin %</strong></td>
                            @php
                                $shopMarginTotal = 0;
                                $normaltotal=0;
                                $shopsaletotal=0;// Initialize shop margin total
                            @endphp
                            
                            @foreach ($shops as $shop)
                                @php
                                    $normalValue = $shopDepartmentTotals[$shop->id]['normal'] ?? 0;
                                    $shopSaleValue = $purchasereport['Shop Sale']['data'][$shop->id] ?? 0;
                                    $shopMargin = $normalValue != 0 ?( ($normalValue - $shopSaleValue) / $normalValue)*100 : 0; // Calculate shop margin for Shop Sale
 
                                    $normaltotal+=$normalValue;
                                    $shopsaletotal+=$shopSaleValue;
                                @endphp
                                <td>{{ number_format($shopMargin, 2) }}%</td>
                            @endforeach
                            @php
                                $shopMarginTotal = $normaltotal != 0 ?( ($normaltotal - $shopsaletotal) / $normaltotal)*100 : 0;
                            @endphp

                            
                            <td><strong style="color: coral">{{ number_format($shopMarginTotal, 2) }}%</strong></td> 
                        </tr>
                        

                        <tr>
                            <td><strong style="color: coral">Fuel Margin %</strong></td>
                            @php
                                $fuelMarginTotal = 0;
                                $fueltotal=0;
                                $fuelsaletotal=0; // Initialize fuel margin total
                            @endphp
                            
                            @foreach ($shops as $shop)
                                @php
                                    $normalValue = $shopDepartmentTotals[$shop->id]['fuel'] ?? 0;
                                    $fuelSaleValue = $purchasereport['Fuel']['data'][$shop->id] ?? 0;
                                    $fuelMargin = $normalValue != 0 ? (($normalValue - $fuelSaleValue) / $normalValue) * 100 : 0; // Calculate fuel margin for Shop Sale
                                    $fueltotal += $normalValue; 
                                    $fuelsaletotal += $fuelSaleValue; // Accumulate fuel margin total
                                @endphp
                                <td>{{ number_format($fuelMargin, 2) }}%</td>
                            @endforeach
                            @php
                                $fuelMarginTotal = $fueltotal != 0 ?( ($fueltotal - $fuelsaletotal) / $fueltotal)*100 : 0;
                            @endphp
                            <td><strong style="color: coral">{{ number_format($fuelMarginTotal, 2) }}%</strong></td>
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

                        @foreach ($expenseReport as $subCategory => $subCategoryData)
                            <tr>
                                <td>{{ $subCategory }}</td>
                                @php
                                $subCategoryTotal = 0;
                                @endphp
                                @foreach ($shops as $index => $shop)
                                {{-- <td>{{ $subCategoryData['data'][$shop->id] ?? 0 }}</td> --}}
                                <td align="right">{{ number_format($subCategoryData['data'][$shop->id] ?? 0 , 2) }}</td>
                                @php
                                $subCategoryTotal += $subCategoryData['data'][$shop->id] ?? 0;
                                $outflowColumnTotals[$index] += $subCategoryData['data'][$shop->id] ?? 0;
                                @endphp
                                @endforeach
                                {{-- <td>{{ $subCategoryTotal }}</td> --}}
                                <td align="right">{{ number_format($subCategoryTotal , 2) }}</td>
                                
                            </tr>                       
                        @endforeach
                        {{-- @foreach ($expenseReport as $purchaseType => $purchaseTypeData)
                           
                                <tr>
                                    <td>{{ $purchaseType }}</td>
                                    @php
                                        $subCategoryTotal = 0;
                                        // $subcategoryColumnTotals=[]; // Initialize purchase type total
                                    @endphp

                                    @foreach ($shops as $index => $shop)
                                        @php
                                            $value = $purchaseTypeData['data'][$shop->id] ?? 0; // Get purchase amount for current shop
                                            $subCategoryTotal += $value; // Increment purchase type total
                                            $subcategoryColumnTotals[$index] += $value; // Increment column total for current shop
                                        @endphp
                                        <td>{{ $value }}</td> <!-- Display purchase amount for current shop -->
                                    @endforeach

                                    <td>{{ $subCategoryTotal }}</td> <!-- Display total for current purchase type -->
                                </tr>
                            
                        @endforeach --}}


                        

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
                                <td align="right"><strong style="color:coral">{{ number_format($expenseValue, 2) }}</strong></td>                                
                            @endforeach
                                <td align="right"><strong style="color:coral">{{ number_format($totalExpenses, 2) }}</strong></td>
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
                                <td align="right"><strong style="color:coral">{{ number_format($netProfit, 2) }}</strong></td>
                            @endforeach
                                <td align="right"><strong style="color:coral">{{ number_format($totalProfit, 2) }}</strong></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="{{ count($shops) + 2 }}" style="color:forestgreen">Other Incomes</td>
                        </tr>
                        
                        
                        
                        <tr>
                            <td>Direct Incomes Total</td>
                            @php
                            $directIncomesTotalAll = 0;
                            @endphp
                            @foreach ($shops as $shop)
                                @php
                                $value = $shopDirectIncomeTotals[$shop->id] ?? 0;
                                $directIncomesTotalAll += $value;
                                @endphp                                
                                <td align="right">{{ number_format($value, 2) }}</td>
                            @endforeach                            
                            <td align="right">{{ number_format($directIncomesTotalAll, 2) }}</td>
                        </tr>
                        <tr>
                            <td>Calculated Incomes Total</td>
                            @php
                            $calculatedIncomesTotalAll = 0;
                            @endphp
                            @foreach ($shops as $shop)
                                @php
                                $value = $shopCalculatedIncomeTotals[$shop->id] ?? 0;
                                $calculatedIncomesTotalAll += $value;
                                @endphp
                                <td align="right">{{ number_format($value, 2) }}</td>
                            @endforeach
                            
                            <td align="right">{{ number_format($calculatedIncomesTotalAll, 2) }}</td>
                        </tr>
                        
                        <tr>
                            <td> <strong style="color: coral">Other Incomes Total</strong></td>
                            @php
                            $otherIncomesTotalAll = 0;
                            @endphp
                            @foreach ($shops as $shop)
                                @php
                                $value = $shopOtherIncomeTotals[$shop->id] ?? 0;
                                $otherIncomesTotalAll += $value;
                                @endphp
                                <td align="right"><strong style="color: coral">{{ number_format($value, 2) }}</strong></td>
                            @endforeach
                            
                            <td align="right"><strong style="color: coral">{{ number_format($otherIncomesTotalAll, 2) }}</strong></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                        
                        <tr>
                            <td><strong style="color: coral">Profit Before Tax</strong></td>
                            @php
                                $profitBeforeTaxTotal = $totalProfit + $otherIncomesTotalAll;
                            @endphp
                            @foreach ($shops as $index => $shop)
                                @php
                                    $profitBeforeTax = $columnTotals[$index] - $purchaseColumnTotals[$index] - $outflowColumnTotals[$index]+ ($shopOtherIncomeTotals[$shop->id] ?? 0);
                                @endphp                                
                                <td align="right"><strong style="color: coral">{{ number_format($profitBeforeTax, 2) }}</strong></td>
                            @endforeach                            
                            <td align="right"><strong style="color: coral">{{ number_format($profitBeforeTaxTotal, 2) }}</strong></td>
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
                            <td align="right">{{ number_format($subCategoryData['data'][$shop->id] ?? 0 , 2) }}</td>
                            @php
                            $subCategoryTotal += $subCategoryData['data'][$shop->id] ?? 0;
                            $outflowColumnTotals[$index] += $subCategoryData['data'][$shop->id] ?? 0;
                            @endphp
                            @endforeach
                                <td align="right">{{ number_format($subCategoryTotal, 2) }}</td>
                            @php
                            $outflowColumnTotals[count($shops)] += $subCategoryTotal;
                            @endphp
                        </tr>
                        @endif
                        @endforeach
                        <tr>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td><strong style="color: coral">Profit After Tax</strong></td>
                            @php
                                $profitBeforeTaxTotal = $totalProfit + $otherIncomesTotalAll;
                                $incomeTaxTotal = $outflowColumnTotals[count($shops)] ?? 0;
                                $profitAfterTaxTotal = $profitBeforeTaxTotal - $incomeTaxTotal;
                            @endphp
                            @foreach ($shops as $index => $shop)
                                @php
                                    $profitBeforeTax =  $columnTotals[$index] - $purchaseColumnTotals[$index] + ($shopOtherIncomeTotals[$shop->id] ?? 0);
                                    $incomeTax = $outflowColumnTotals[$index] ?? 0;
                                    $profitAfterTax = $profitBeforeTax - $incomeTax;
                                @endphp                                
                                <td align="right"><strong style="color: coral">{{ number_format($profitAfterTax, 2) }}</strong></td>
                                
                            @endforeach                            
                            <td align="right"><strong style="color: coral">{{ number_format($profitAfterTaxTotal, 2) }}</strong></td>
                        </tr>
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    @endif
   
   
   
     
@endsection



