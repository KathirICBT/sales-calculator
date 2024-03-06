<!-- resources/views/payment_methods/index.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Methods</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
    @include('includes.header')
    <div class="container">
        <h2>Payment Methods</h2>
        <table>
            <thead>
                <tr>
                    <th>Payment Method</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($paymentMethods as $paymentMethod)
                <tr>
                    <td>{{ $paymentMethod->payment_method }}</td>
                    <td>
                        <a href="{{ route('paymentmethod.edit', $paymentMethod->id) }}">Edit</a>
                        <form method="post" action="{{ route('paymentmethod.destroy', $paymentMethod->id) }}" id="deleteForm_{{ $paymentMethod->id }}" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="delete-button" onclick="return confirm('Are you sure you want to delete this payment method?')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div>
            <button type="button" class="back" onclick="window.location.href='{{ route('paymentmethod.create') }}'">Add Payment Method</button>
            
        </div>
    </div>
</body>
</html>
