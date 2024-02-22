<!-- resources/views/departments/delete.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Department</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>

@include('includes.header')
    <h2>Delete Department</h2>

    <p>Are you sure you want to delete the department '{{ $department->dept_name }}'?</p>

    <form method="post" action="{{ route('departments.destroy', $department->id) }}">
        @csrf
        @method('delete')

        <button type="submit">Yes, delete</button>
        <a href="{{ route('departments.index') }}">Cancel</a>
    </form>

</body>
</html>
