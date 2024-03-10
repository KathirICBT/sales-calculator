<!-- resources/views/paymentsale/edit.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Payment Sale</title>
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
                <label for="staff_id" style="display: inline; margin-right:20px;"> Staff:</label>
                <select name="staff_id" id="staff_id" required >
                    <option value="" >Select Staff</option>
                    @foreach($staffs as $staff)
                        <option value="{{ $staff->id}}" {{ $staff->id == $paymentSale->staff_id ? 'selected' : '' }}>
                            {{ $staff->staff_name}}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="paymentmethod_id">Payment Method:</label>
                <select name="paymentmethod_id" id="paymentmethod_id" required>
                    @foreach($paymentMethods as $paymentMethod)
                        <option value="{{ $paymentMethod->id }}" {{ $paymentMethod->id == $paymentSale->paymentmethod_id ? 'selected' : '' }}>
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
