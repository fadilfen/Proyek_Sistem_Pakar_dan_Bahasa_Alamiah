<!DOCTYPE html>
<html>
<head>
    <title>Daftar</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>
    <div class="container">
        <div class="box-left">
            <svg class="profile-img" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="background: white; padding: 20px;">
                <circle cx="12" cy="8" r="4" fill="#36d6e5"/>
                <path d="M4 20C4 16.6863 6.68629 14 10 14H14C17.3137 14 20 16.6863 20 20" stroke="#36d6e5" stroke-width="3" stroke-linecap="round"/>
            </svg>
        </div>
        <div class="box-right">
            <div class="form-container">
                <h2 class="title">Daftar</h2>
                @if(session('error'))
                    <div class="error-message">{{ session('error') }}</div>
                @endif
                <div class="form-scroll">
                    <form action="{{ route('daftar.submit') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <input type="text" name="username" placeholder="Username" required>
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" placeholder="Password" required>
                        </div>
                        <div class="form-group">
                            <input type="text" name="nama_lengkap" placeholder="Nama Lengkap" required>
                        </div>
                        <div class="form-group">
                            <input type="number" name="umur" placeholder="Umur" required>
                        </div>
                        <div class="form-group">
                            <select name="jenis_kelamin" required>
                                <option value="">Pilih Jenis Kelamin</option>
                                <option value="Pria">Pria</option>
                                <option value="Wanita">Wanita</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <textarea name="alamat" placeholder="Alamat" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <input type="text" name="no_telepon" placeholder="No Telepon" required>
                        </div>
                        <button type="submit" class="btn-submit">Daftar</button>
                    </form>
                    <div class="link-text">
                        Sudah punya akun? <a href="{{ route('login') }}">Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
