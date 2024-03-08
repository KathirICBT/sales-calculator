<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Payment Methods</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
    @include('includes.header')
    <div class="container">
        <h2>Edit Payment Methods</h2>

        <form action="{{ route('paymentmethod.update', $paymentMethod->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="payment_method">Payment Method:</label>
                <input type="text" id="payment_method" name="payment_method" value="{{ $paymentMethod->payment_method }}" required>
            </div>
            <button type="submit" class="btn">Update</button>
            <button type="button" class="btn modify-button" onclick="window.location.href='{{ route('paymentmethod.index') }}'">Cancel</button>
        </form>
    </div>
</body>
</html>
