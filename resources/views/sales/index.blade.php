<!-- resources/views/sales/index.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Records</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
    @include('includes.header')
    <div class="container">
        <h2>Sales Records</h2>
        <table>
            <thead>
                <tr>
                    <th>Department</th>
                    <th>Staff</th>
                    <th>Shop</th>
                    <th>Amount</th>
                    <th>Payment Method</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sales as $sale)
                <tr>
                    <td>{{ $sale->department->dept_name }}</td>
                    <td>{{ $sale->staff->staff_name }}</td>
                    <td>{{ $sale->shop->name }}</td>
                    <td>{{ $sale->amount }}</td>
                    <td>{{ $sale->payment_method }}</td>
                    <td>
                        <a href="{{ route('sales.edit', $sale->id) }}">Edit</a>
                        <form method="post" action="{{ route('sales.destroy', $sale->id) }}" id="deleteForm_{{ $sale->id }}" style="display: inline;">
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
        <button type="button" class=" back " onclick="window.location.href='{{ route('sales.search') }}'">Search</button>
        <button type="button" class=" back " onclick="window.location.href='{{ route('sales.create') }}'">Add sales</button>
        </div>
    </div>
</body>
</html>
