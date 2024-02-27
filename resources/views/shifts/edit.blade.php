<!-- resources/views/edit_sales.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Shift Details</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
    @include('includes.header')
    <div class="container">
        <h2>Edit Shift</h2>
        @if(session('success'))
            <div class="alert" style="color: green;">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('shifts.update', $shift->id) }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="shop_id" style="display: inline;margin-right:20px;">Shop:</label>
                <select name="shop_id" id="shop_id">
                    @foreach($shops as $shop)
                        <option value="{{ $shop->id }}" {{ $shop->id == $shift->shop_id ? 'selected' : '' }}>
                            {{ $shop->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="staff_id" style="display: inline;margin-right:20px;">Staff:</label>
                <select name="staff_id" id="staff_id">
                    @foreach($staffs as $staff)
                        <option value="{{ $staff->id }}" {{ $staff->id == $shift->staff_id ? 'selected' : '' }}>
                            {{ $staff->staff_name}}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="back">Update Shift</button>
            <a href="{{ route('shifts.index') }}" class="back">Back</a>
        </form>
    </div>
</body>
</html>
