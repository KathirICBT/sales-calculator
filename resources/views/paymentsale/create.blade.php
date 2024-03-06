<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add PaymentSales Details</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
@include('includes.header')
    <div class="container">
        <h2>Add PaymentSales Details</h2>
        @if(session('success'))
                <div class="alert" style="color: green;">{{ session('success') }}</div>
        @endif


        <form method="post" action="{{ route('paymentsale.store') }}">
            @csrf

            <div class="form-group">
                <label for="paymentmethod_id" style="display: inline; margin-right:20px;">Payment Method:</label>
                <select name="paymentmethod_id" id="paymentmethod_id" required >
                    <option value="" >Select a Payment Method</option>
                    @foreach($paymentmethods as $paymentmethod)
                        <option value="{{ $paymentmethod->id }}" >{{ $paymentmethod->payment_method }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="amount" style="display: inline;" >Amount:</label>
                <input type="text" id="amount" name="amount" required>
            </div>

            <button type="submit" class="back">Submit</button>
            
        </form>


    </div>
    
</body>
</html>

