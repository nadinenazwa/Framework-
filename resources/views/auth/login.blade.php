@extends('layouts.blank')

@section('content')
<div class="form-container auth-card" role="main" aria-labelledby="auth-title">
    <h1 id="auth-title" class="auth-title">RSHP UNAIR</h1>
    <div class="auth-subtitle" style="text-align:center">Rumah Sakit Hewan Pendidikan<br>Universitas Airlangga</div>

    <p class="auth-description" style="text-align:center">Silakan login untuk memulai sesi Anda</p>

    <form method="POST" action="{{ route('login') }}" novalidate>
        @csrf

        <div class="form-group input-icon">
            <label for="email" class="sr-only">Email</label>
            <i class="fa fa-envelope" aria-hidden="true"></i>
            <input id="email" placeholder="Email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus aria-required="true">
            @error('email')
                <div class="error-text">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group input-icon">
            <label for="password" class="sr-only">Password</label>
            <i class="fa fa-lock" aria-hidden="true"></i>
            <input id="password" placeholder="Password" type="password" name="password" required autocomplete="current-password" aria-required="true">
            @error('password')
                <div class="error-text">{{ $message }}</div>
            @enderror
        </div>

        <div class="remember-row">
            <label for="remember">
                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}> Ingat Saya
            </label>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-primary" aria-label="Masuk"> <i class="fa fa-sign-in-alt" style="margin-right:8px" aria-hidden="true"></i> Login</button>
        </div>

        <div class="auth-links" style="text-align:center">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}">Lupa Password?</a>
            @endif
            <a href="#">Daftar Akun Baru</a>
        </div>
    </form>

    <div class="auth-footer" style="text-align:center">© {{ date('Y') }} RSHP UNAIR. All rights reserved.</div>
</div>
@endsection
