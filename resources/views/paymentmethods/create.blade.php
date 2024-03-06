<!-- resources/views/payment_methods/create.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Payment Method</title>
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h2>Add Payment Method</h2>
        @if(session('success'))
            <div class="success-message">{{ session('success') }}</div>
        @endif
        <form action="{{ route('paymentmethod.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="payment_method">Payment Method:</label>
                <input type="text" id="payment_method" name="payment_method" required>
            </div>
            <button type="submit" class="btn">Add Payment Method</button>
            <button type="submit" class="btn" onclick="window.location.href='{{ route('paymentmethod.index') }}'">Modify</button>
        </form>
    </div>
</body>
</html>
