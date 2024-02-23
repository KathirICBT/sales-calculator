<!-- resources/views/layouts/app.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Department Management</title>
    <!-- Add your CSS stylesheets or any other head elements here -->
</head>
<body>

    <header style="background-color: #333; color: #fff; padding: 10px;">
        <h1>Department Management</h1>
    </header>

    <nav style="background-color: #eee; padding: 10px;">
        <a href="{{ route('departments.index') }}">Departments</a> |
        <a href="{{ route('departments.create') }}">Add Department</a>
        <!-- Add any other navigation links here -->
    </nav>

    <main style="padding: 20px;">
        @yield('content')
    </main>

    <footer style="background-color: #333; color: #fff; padding: 10px; text-align: center;">
        &copy; 2024 Your Company Name. All rights reserved.
    </footer>

</body>
</html>
