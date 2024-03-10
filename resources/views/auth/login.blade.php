<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>the eXlents Report</title>


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />


    <link rel="stylesheet" href="{{ asset('css/app-style.css') }}">
</head>

<body>
    <div class="wrapper">
        <div class="form-wrapper signin-wrapper">
            <form action="{{ route('login') }}" method="post">
                @csrf
                <h1>Staff Login</h1>
                <div class="socials">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-google"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                </div>

                <input type="text" name="username" id="username" placeholder="Username" />                
                @error('username')
                    <span class="error-message">{{ $message }}</span>
                @enderror
                <input type="password" name="password" id="password" placeholder="Password" />
                @error('password')
                    <span class="error-message">{{ $message }}</span>
                @enderror                
                <a href="#">Forgot password?</a>
                <button type="submit" name="submit">Log In</button>
            </form>
        </div>

        <div class="overlay-wrapper">
            <div class="overlay">
                <div class="overlay-panel overlay-right">
                    <h1>Shop Owner</h1>
                    <p>Log in as a shop owner by clicking the button below.</p>
                    <button class="border signup-btn">Admin</button>
                </div>

                <div class="overlay-panel overlay-left">
                    <h1>Staff Login</h1>
                    <p>Log in as a shop staff by clicking the button below.</p>
                    <button class="border signin-btn">Staff</button>
                </div>
            </div>
        </div>

        <div class="form-wrapper signup-wrapper">
            <form action="#">
                <h1>Create Account</h1>

                <div class="socials">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-google"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                </div>

                <input type="text" placeholder="Name" required />
                <input type="email" placeholder="Email" required />
                <input type="password" placeholder="Password" required />
                <button>Sign Up</button>
            </form>
        </div>
    </div>

    <script src="{{ asset('js/app-script.js') }}"></script>
</body>

</html>