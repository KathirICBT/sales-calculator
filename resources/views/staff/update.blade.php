<!-- resources/views/staff/updateStaff.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Staff</title>
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
</head>
<body>

<div class="container">
    <h2>Update Staff</h2>
    @if(session('success'))
        <div class="success-message">{{ session('success') }}</div>
    @endif
    <form method="POST" action="{{ route('staff.update', $staff->id) }}">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="staff_name">Staff Name</label>
            <input type="text" id="staff_name" name="staff_name" value="{{ $staff->staff_name }}" required>
        </div>
        <div class="form-group">
            <label for="phone">Phone</label>
            <input type="text" id="phone" name="phonenumber" value="{{ $staff->phonenumber }}" required>
        </div>
        <div class="form-group">
            <label for="username">username</label>
            <input type="text" id="username" name="username" value="{{ $staff->username }}" required>
        </div>
        <div class="form-group">
            <label for="password">New Password</label>
            <input type="password" id="password" name="password" placeholder="Leave blank to keep current password">
        </div>
        <button type="submit" class="btn">Update</button>
        <a href="{{ route('staff.index') }}" class="modify-button">Back</a>
    </form>
</div>

</body>
</html>
