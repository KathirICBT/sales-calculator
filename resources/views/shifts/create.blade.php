<!-- resources/views/shifts.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Shifts</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
@include('includes.header')
    <div class="container">
        <h2>Manage Shifts</h2>
        @if(session('success'))
                <div class="alert" style="color: green;">{{ session('success') }}</div>
        @endif

        <form method="post" action="{{ route('shifts.store') }}">
            @csrf

            <div class="form-group">
                <label for="shop_id" style="display: inline;margin-right:20px;">Shop:</label>
                <select name="shop_id" id="shop_id">
                    @foreach($shops as $shop)
                        <option value="{{ $shop->id }}">{{ $shop->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="staff_id" style="display: inline;margin-right:20px;">Staff:</label>
                <select name="staff_id" id="staff_id">
                    @foreach($staffs as $staff)
                        <option value="{{ $staff->id }}">{{ $staff->staff_name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Add more fields related to shifts as needed -->

            <button type="submit" class="back">Add Shift</button>
            <button type="button" class="back" onclick="window.location.href='{{ route('shifts.index') }}'">View Shifts</button>
        </form>
    </div>
</body>
</html>
