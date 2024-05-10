<!-- resources/views/pages/reports/shiftStaff.blade.php -->

@extends('layouts.layout')

@section('content')
<div class="container-fluid">
    <x-content-header title="Shifts of Particular Staff" />
    <x-alert-message />

    <div class="row">
        <div class="col-12">
            <div class="card border-0">
                <div class="card-body">
                    <h4 class="card-title">Shifts of Particular Staff</h4>
                    <form method="POST" action="{{ route('display.shifts') }}" class="row g-3">
                        @csrf
                        <div class="col-md-5 mt-3">
                            <label for="username" class="form-label">Search by Staff Username:</label>
                            <select id="username" name="username" class="form-select" required>
                                <option value="">Select Username</option>
                                @foreach($staffUsernames as $username)
                                    <option value="{{ $username }}">{{ $username }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 mt-3">
                            <button type="submit" class="btn btn-success rounded-pill w-100">Search</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if(isset($staff))
        <div class="card border-0 mt-3">
            <div class="card-header">
                <h5 class="card-title">Shifts for {{ $staff->staff_name }}</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            
                            <th>Start Date</th>
                            <th>Start Time</th>
                            <th>End Date</th>
                            <th>End Time</th>
                            <th>Shop</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($shifts as $shift)
                            <tr>
                                <td>{{ $shift->start_date }}</td>
                                <td>{{ $shift->start_time }}</td>
                                <td>{{ $shift->end_date }}</td>
                                <td>{{ $shift->end_time }}</td>
                                <td>{{ $shift->shop->name }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
@endsection
