<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Payment Sales Details</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
    @include('includes.header')
    <div class="container">
        <h2>Edit Payment Sale</h2>
        <form action="{{ route('paymentsales.update', $paymentSale->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="payment_method_id">Payment Method:</label>
                <select name="payment_method_id" id="payment_method_id" required>
                    @foreach($paymentMethods as $paymentMethod)
                        <option value="{{ $paymentMethod->id }}" {{ $paymentMethod->id == $paymentSale->payment_method_id ? 'selected' : '' }}>
                            {{ $paymentMethod->payment_method }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="amount">Amount:</label>
                <input type="text" id="amount" name="amount" value="{{ $paymentSale->amount }}" required>
            </div>
            <button type="submit">Update Payment Sale</button>
        </form>
    </div>
</body>
</html>
