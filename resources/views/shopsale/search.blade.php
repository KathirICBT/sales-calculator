<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Search</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
    @include('includes.header')
    <div class="container">
    <h2>Sales Search</h2>
    <form action="{{ route('shopsale.searchResult') }}" method="POST"  > 
        @csrf 
        <div class="form-group">
        <label for="shop_id">Select Shop:</label>
        <select name="shop_id" id="shop_id" required>
            <option value="">Select a Shop</option>
            @foreach ($shops as $shop)
                <option value="{{ $shop->id }}">{{ $shop->name }}</option>
            @endforeach
        </select>
        </div>
        <div class="form-group">
        <label for="date">Date:</label>
        <input type="date" name="date" id="date" required>
        </div>

        <button type="submit" class="btn ">Search</button>
    </form>
</div>
    
</body>
</html>
