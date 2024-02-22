<!-- resources/views/departments/edit.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Department</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
    <div class="container">
        <h2>Edit Department</h2>

        @if(session('success'))
            <div class="alert" style="color: green;">{{ session('success') }}</div>
        @endif

        <form method="post" action="{{ route('departments.update', $department->id) }}" class="department-form">
            @csrf
            @method('put')

            <div class="form-group">
                <label for="dept_name">Department Name:</label>
                <input type="text" id="dept_name" name="dept_name" value="{{ $department->dept_name }}" required>
            </div>

            <div class="form-group">
                <label for="other_taking">Other Taking:</label>
                <input type="checkbox" id="other_taking" name="other_taking" value="1" {{ $department->other_taking ? 'checked' : '' }}>
            </div>

            
            <div class="form-group">
                <button type="submit" class="btn">Update Department</button>
                <a href="{{ route('departments.index') }}" class="modify-button">Back to Departments</a>
            </div>
        </form>
    </div>
</body>

</html>
