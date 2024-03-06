<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Sales Records</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
    @include('includes.header')
    <div class="container">
        <h2>Payment Sales Records</h2>
        <table>
            <thead>
                <tr>
                    <th>Payment Method</th>
                    <th>Amount</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($paymentSales as $paymentSale)
                <tr>
                    <td>{{ $paymentSale->paymentmethod->payment_method }}</td>
                    <td>{{ $paymentSale->amount }}</td>
                    <td>
                        <a href="{{ route('paymentsales.edit', $paymentSale->id) }}">Edit</a>
                        <form method="post" action="{{ route('paymentsales.destroy', $paymentSale->id) }}" id="deleteForm_{{ $paymentSale->id }}" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="delete-button" style="color: white; border: none; background: red; cursor: pointer;" onclick="return confirm('Are you sure you want to delete this staff member?')" >Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div >
            <button type="button" class="back" onclick="window.location.href='{{ route('paymentsale.create') }}'">Add Payment Sale</button>
            <button type="button" class="back" onclick="window.location.href='{{ route('paymentsales.index') }}'">Modify</button>
        </div>
    </div>
</body>
</html>
