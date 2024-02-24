<!-- resources/views/sales/delete_confirmation.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Sales Details</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
    @include('includes.header')
    <div class="container">
        <h2>Delete Sales Details</h2>
        <p>Are you sure you want to delete this sales record?</p>
        <!-- Form for confirming deletion -->
        <form method="post" action="{{ route('sales.destroy', $sale->id) }}">
            @csrf
            @method('DELETE')
            <button type="submit" class="back" style="color: white; border: none; background: red; cursor: pointer;">Confirm Delete</button>
            <button type="button" class="back" onclick="window.location.href='{{ route('sales.index') }}'">Cancel</button>
        </form>
    </div>
</body>
</html>
