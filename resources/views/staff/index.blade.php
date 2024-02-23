<!-- resources/views/staff/index.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Members</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}"> <!-- Link to your CSS file -->
</head>
<body>
    
@include('includes.header')

    <div class="container">
        <h2>Staff Members</h2>

        @if(session('success'))
            <div class="success-message">{{ session('success') }}</div>
        @endif

        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>phonenumber</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($staffs as $staff)
                    <tr>
                        <td>{{ $staff->staff_name }}</td>
                        <td>{{ $staff->phonenumber }}</td>
                        <td>
                            <a href="{{ route('staff.edit', $staff->id) }}">Edit</a>
                            <form method="post"  style="display: inline;" action="{{ route('staff.destroy', $staff->id) }}">
                                @csrf
                                @method('delete')
                                <button onclick="return confirm('Are you sure you want to delete this staff member?')" type="submit" style="color: white; border: none; background: red; cursor: pointer;">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <a href="{{ route('staff.addstaff') }}" class="common-link">Add New Staff Member</a>
        <a href="{{ route('staff.search') }}" class="common-link">Search</a>
    </div>

</body>
</html>
