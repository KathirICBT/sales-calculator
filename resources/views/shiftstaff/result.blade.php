<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
</head>
<body>
    @include('includes.header')
    <div class="container">
        <h2>Search Results</h2>
        @if($staffDetails !== null && count($staffDetails) > 0)
            <table>
                <thead>
                    <tr>
                        <th>Staff Name</th>
                        <th>Shift Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($staffDetails as $staffDetail)
                        <tr>
                            <td>{{ $staffDetail['staff_name'] }}</td>
                            <td>{{ $staffDetail['shift_date'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No shifts found for the selected date range.</p>
        @endif
        <a href="{{ route('shiftstaff.search') }}" class="common-link">Back to Search</a>
    </div>

</body>
</html>
