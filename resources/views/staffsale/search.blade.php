<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Staff Sales</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
    @include('includes.header')
    <div class="container">
        <h2>Search Staff Sales</h2>
        <form action="{{ route('staffsale.searchResult') }}" method="POST" class="staff-form">
            @csrf
            <div class="form-group">
                <label for="staff_id">Select Staff:</label>
                <select name="staff_id" id="staff_id" required>
                    <option value="">Select a Staff</option>
                    @foreach ($staffs as $staff)
                        <option value="{{ $staff->id }}">{{ $staff->staff_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="date">Date:</label>
                <input type="date" name="date" id="date" required>
            </div>
            <button type="submit" class="btn">Search</button>
        </form>
    </div>
</body>
</html>
