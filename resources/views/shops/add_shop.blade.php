<!-- resources/views/staff/addStaff.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Registration</title>
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
</head>
<body>
@include('includes.header')
<div class="container">
    <h2>Shop Registration</h2>
    @if(session('success'))
        <div class="alert success">{{ session('success') }}</div>
    @endif       
    
    <form method="post" action="{{ route('shop.store') }}">
        @csrf
        <div class="form-group">
            <label for="name">Shop Name: </label>
            <input type="text" id="name" name="name" class="getnew">
            @error('name')
                <span class="error-alert">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="phone">Phone: </label>
            <input type="text" id="phone" name="phone">
        </div>
        <div class="form-group">
            <label for="address">Address: </label>
            <textarea id="address" name="address" rows="5" class="getfont"></textarea>
        </div>

        <button type="submit" class="btn">Register</button>
        {{-- <button type="button" class="btn modify-button">Modify</button> --}}

    </form>
</div>

</body>
</html>
