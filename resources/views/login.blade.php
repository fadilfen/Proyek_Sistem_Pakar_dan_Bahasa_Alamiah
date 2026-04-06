<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>
    <div class="container">
        <div class="box-left">
            <img src="{{ asset('storage/gambar/profil.png') }}" alt="Profile" class="profile-img">
        </div>
        <div class="box-right">
            <div class="form-container">
                <h2 class="title">Login</h2>
                @if(session('error'))
                    <div class="error-message">{{ session('error') }}</div>
                @endif
                @if(session('success'))
                    <div class="success-message">{{ session('success') }}</div>
                @endif
                <form action="{{ route('login.submit') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <input type="text" name="username" placeholder="Username" required>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" placeholder="Password" required>
                    </div>
                    <button type="submit" class="btn-submit">Login</button>
                </form>
                <div class="link-text">
                    Belum punya akun? <a href="{{ route('daftar') }}">Daftar</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
