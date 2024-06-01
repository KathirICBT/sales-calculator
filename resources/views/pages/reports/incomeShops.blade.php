@extends('layouts.layout')

@section('content')
<div class="container-fluid">
    <x-content-header title="Cash Movement Details Report" />
    <x-alert-message />

    <div class="row">
        <div class="col-12">
            <div class="card border-0">
                <div class="card-body">
                    <h4 class="card-title">Shop Income Details Report</h4>
                    <form method="POST" action="{{ route('reports.generateIncomeShops') }}" class="row g-3">
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

    {{-- @if(isset($from_date) && isset($to_date)) --}}
        <div class="card border-0 mt-3">
            <div class="card-header">
                <h5 class="card-title">
                    Shop-wise Cash Movement Details
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
                <div class="form-group">
                    <input type="text" id="searchInput" class="form-control" placeholder="Search Shop">
                </div>
                <table class="table table-bordered" id="reportTable">
                    <thead>
                        <tr>
                            <th>Shop</th>
                            <th>Total Income</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($shops as $shop)
                        <tr>
                            @if(isset($from_date) && isset($to_date))
                            <td><a href="{{ route('reports.shopDetails', ['shop' => $shop->id, 'from_date' => $from_date, 'to_date' => $to_date]) }}">{{ $shop->name }}</a></td>
                            @else
                            {{-- <td>{{ $shop->name }}</a></td> --}}
                            <td><a href="{{ route('reports.allshopDetails', ['shop' => $shop->id]) }}">{{ $shop->name }}</a></td>
                            @endif
                            <td>{{ $shopTotalIncome[$shop->id] ?? 0 }}</td>
                           
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    {{-- @endif --}}
</div>
@endsection


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Search functionality
        $("#searchInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#reportTable tbody tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>
