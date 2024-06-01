@extends('layouts.layout')

@section('content')
<div class="container-fluid">
    <x-content-header title="Shop Department Details" />
    <x-alert-message />

    <div class="row">
        <div class="col-12">
            <div class="card border-0">
                <div class="card-body">
                    <h4 class="card-title">{{ $shop->name }} Department Details</h4>
                    
                    <div class="row">
                        @foreach ($departmentData as $departmentType => $sales)
                            <div class="col-md-4 mb-3">
                                <h5>{{ ucfirst(str_replace('_', ' ', $departmentType)) }} Department</h5>
                                <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Department</th>
                                                <th>Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($sales as $sale)
                                                <tr>
                                                    <td>{{ $sale->department->dept_name }}</td>
                                                    <td align="right">{{ number_format($sale->amount, 2) }}</td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td><strong>Total</strong></td>
                                                <td align="right"><strong>{{ number_format($departmentTotals[$departmentType], 2) }}</strong></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @if(isset($from_date) && isset($to_date))
                        <a href="{{ route('reports.generateIncomeShops', ['from_date' => $from_date, 'to_date' => $to_date]) }}" class="btn btn-primary">Back to Report</a>
                    @else
                        <a href="{{ route('reports.incomeShop') }}" class="btn btn-primary">Back</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
