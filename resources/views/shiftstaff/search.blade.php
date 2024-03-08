<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Staff Shifts</title>
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
</head>
<body>
    @include('includes.header')
    <div class="container">
        <h2>Search Staff Shifts</h2>
        <form method="GET" action="{{ route('shiftstaff.results') }}">
            @csrf
            <div class="form-group">
                <label for="start_date">Start Date</label>
                <input type="date" id="start_date" name="start_date" required>
            </div>
            <div class="form-group">
                <label for="end_date">End Date</label>
                <input type="date" id="end_date" name="end_date" required>
            </div>
            <button type="submit" class="btn">Search</button>
        </form>
    </div>

</body>
</html>
