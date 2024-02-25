

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Update Shop</title>
        <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    </head>

    <body>
        <div class="container">
            <h2>Update Shop</h2>
            @if(session('success'))
                <div class="success-message">{{ session('success') }}</div>
            @endif
            <form method="POST" action="{{ route('shop.update', $shop->id) }}">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="shop_name">Shop Name</label>
                    <input type="text" id="shop_name" name="shop_name" value="{{ $shop->name }}">
                    @error('shop_name')
                        <span class="error-alert">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="text" id="phone" name="phone" value="{{ $shop->phone }}">
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" id="address" name="address" value="{{ $shop->address }}">
                </div>
                <button type="submit" class="btn">Update</button>
            </form>
        </div>
    </body>
</html>
