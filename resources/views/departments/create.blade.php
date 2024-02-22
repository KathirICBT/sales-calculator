<!-- resources/views/departments/create.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Department</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>

    <div class="container">
        <h2>Add Department</h2>

        @if(session('success'))
            <div class="alert success">{{ session('success') }}</div>
        @endif

        <form method="post" class="department-form" action="{{ route('departments.store') }}" >
            @csrf <!-- This is a CSRF token for security -->

            <div class="form-group">
                <label for="name">Department Name:</label>
                <input type="text" name="dept_name" required>
            </div>

            <div class="form-group">
                <label for="other_taking">Other Taking:</label>
                <input type="checkbox" name="other_taking" value="1">
            </div>

            <button type="submit" class="btn">Add Department</button>
<div>
           
            <button type="submit" class="btn modify-button" href="{{ route('departments.index') }}">Modify</button>
        
        </div>
        </form>
    </div>

</body>
</html>
