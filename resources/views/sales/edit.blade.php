<!-- resources/views/edit_sales.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Sales Details</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
    @include('includes.header')
    <div class="container">
        <h2>Edit Sales Details</h2>

        <!-- Form for editing sales details -->
        <form method="post" action="{{ route('sales.update', $sale->id) }}">
            @csrf
            @method('PUT') <!-- Use PUT method for update -->

            <div class="form-group">
                <label for="dept_id" style="display: inline;margin-right:20px;">Department:</label>
                <select name="dept_id" id="dept_id">
                    @foreach($departments as $department)
                        <option value="{{ $department->id }}" {{ $department->id == $sale->dept_id ? 'selected' : '' }}>{{ $department->dept_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="staff_id" style="display: inline;margin-right:20px;"">Staff:</label>
                <select name="staff_id" id="staff_id">
                    @foreach($staffs as $staff)
                        <option value="{{ $staff->id }}" {{ $staff->id == $sale->staff_id ? 'selected' : '' }}>{{ $staff->staff_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="shop_id" style="display: inline; margin-right:20px;">Shop:</label>
                <select name="shop_id" id="shop_id" >
                    @foreach($shops as $shop)
                        <option value="{{ $shop->id }}" {{ $shop->id == $sale->shop_id ? 'selected' : '' }}>{{ $shop->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="amount" style="display: inline;">Amount:</label>
                <input type="text" id="amount" name="amount" value="{{ $sale->amount }}" required>
            </div>

            <button type="submit" class="btn modify-button">Update</button>
            <button type="button" class="btn modify-button" onclick="window.location.href='{{ route('sales.index') }}'">Cancel</button>
        </form>
    </div>
</body>
</html>
