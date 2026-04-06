<!DOCTYPE html>
<html>
<head>
    <title>Daftar</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>
    <div class="container">
        <div class="box-left">
            <img src="{{ asset('storage/gambar/profil.png') }}" alt="Profile" class="profile-img">
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
