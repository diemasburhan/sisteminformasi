<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Portal Login - Sistem Informasi LPKIA</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="auth-wrapper">

    <div class="auth-card">
        <div class="auth-header">
            <i class="fa-solid fa-graduation-cap fa-3x" style="color: var(--secondary); margin-bottom: 15px;"></i>
            <h2>Portal LPKIA</h2>
            <p>Silakan masuk untuk mengelola portal informasi</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <i class="fa-solid fa-circle-exclamation"></i>
                <ul style="list-style: none; padding-left: 0;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label class="form-label" for="email">Alamat Email</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="admin@lpkia.ac.id" required autofocus value="{{ old('email') }}">
            </div>

            <div class="form-group">
                <label class="form-label" for="password">Kata Sandi</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="••••••••" required>
            </div>

            <div class="form-group" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
                <label class="form-check">
                    <input type="checkbox" name="remember" id="remember">
                    <span>Ingat Saya</span>
                </label>
                <a href="{{ route('home') }}" style="font-size: 0.85rem; color: var(--primary); font-weight: 600;">Kembali ke Home</a>
            </div>

            <button type="submit" class="btn btn-primary" style="width: 100%; height: 45px; font-size: 1rem; border-radius: var(--border-radius);">
                Masuk Portal <i class="fa-solid fa-right-to-bracket"></i>
            </button>
        </form>
    </div>

</body>
</html>
