<!-- resources/views/departments/index.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Departments</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}"> <!-- Link to your CSS file -->
</head>
<body>

    <div class="container">
        <h2>Departments</h2>

        @if(session('success'))
            <div class="success-message">{{ session('success') }}</div>
        @endif

        <table>
            <thead>
                <tr>
                    <th>Department Name</th>
                    <th>Other Taking</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($departments as $department)
                    <tr>
                        <td>{{ $department->dept_name }}</td>
                        <td>{{ $department->other_taking ? 'Yes' : 'No' }}</td>
                        <td>
    <a href="{{ route('departments.edit', $department->id) }}">Edit</a>
    <form method="post" action="{{ route('departments.destroy', $department->id) }}" style="display: inline;">
        @csrf
        @method('delete')
        <button type="submit" style="color: white; border: none; background: red; cursor: pointer;">Delete</button>
    </form>
</td>

                    </tr>
                @endforeach
            </tbody>
        </table>

        <a href="{{ route('departments.create') }}" class="create-department-link">Create New Department</a>
    </div>

</body>
</html>
