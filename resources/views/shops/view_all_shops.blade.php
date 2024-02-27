<!-- resources/views/staff/index.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Shops</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}"> <!-- Link to your CSS file -->
    {{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}
</head>
<body>
    
@include('includes.header')

    <div class="container">
        <h2>All Shops</h2>

        @if(session('success'))
            <div class="success-message">{{ session('success') }}</div>
        @endif

        <table>
            <thead>
                <tr>
                    <th>Shop Name</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($shops as $shop)
                    <tr>
                        <td>{{ $shop->name }}</td>
                        <td>{{ $shop->phone }}</td>
                        <td>{{ $shop->address }}</td>
                        <td>
                            <a href="{{ route('shop.update_view', $shop->id) }}" class="kathir_button">Update</a>
                            
                            <form method="POST" action="{{ route('shop.destroy', $shop->id) }}" style="display: inline;">
                                @csrf
                                @method('delete')
                                <button onclick="return confirm('Are you sure you want to delete this staff member?')" type="submit" class="delete_button">Delete</button>
                                
                            </form>
                            {{-- <a href="{{ route('staff.edit', $staff->id) }}">Edit</a>
                            <form method="post"  style="display: inline;" action="{{ route('staff.destroy', $staff->id) }}">
                                @csrf
                                @method('delete')
                                <button onclick="return confirm('Are you sure you want to delete this staff member?')" type="submit" style="color: white; border: none; background: red; cursor: pointer;">Delete</button>
                            </form> --}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <a href="{{ route('shop.add') }}" class="common-link" class="kathir_button">Add Shop</a>
        <a href="{{ route('shop.search') }}" class="common-link" class="kathir_button">Search</a>
    </div>

</body>
</html>


