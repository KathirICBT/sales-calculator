<!-- resources/views/shifts/index.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shift Records</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
    @include('includes.header')
    <div class="container">
        <h2>Shift Records</h2>
        <table>
            <thead>
                <tr>
                    <th>Shop</th>
                    <th>Staff</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($shifts as $shift)
                <tr>
                    <td>{{ $shift->shop->name }}</td>
                    <td>{{ $shift->staff->staff_name }}</td>
                    <td>
                        <a href="{{ route('shifts.edit', $shift->id) }}">Edit</a>
                        <form method="post" action="{{ route('shifts.destroy', $shift->id) }}" id="deleteForm_{{ $shift->id }}" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete-button" style="color: white; border: none; background: red; cursor: pointer;" onclick="return confirm('Are you sure you want to delete this staff member?')" >Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div>
            <button type="button" class="back" onclick="window.location.href='{{ route('shifts.create') }}'">Add Shift</button>
            <a href="{{ route('shifts.search') }}" class="common-link">Search</a>
        </div>
    </div>
</body>
</html>
