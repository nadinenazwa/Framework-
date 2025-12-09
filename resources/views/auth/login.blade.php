@extends('layouts.blank')

@section('content')
<div class="form-container">
    <h2 class="auth-title">{{ __('Login') }}</h2>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="form-group">
            <label for="email">{{ __('Email Address') }}</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
            @error('email')
                <div class="error-text">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">{{ __('Password') }}</label>
            <input id="password" type="password" name="password" required autocomplete="current-password">
            @error('password')
                <div class="error-text">{{ $message }}</div>
            @enderror
        </div>

        <div class="remember-row">
            <label style="display:flex;align-items:center;gap:8px;">
                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('Remember Me') }}
            </label>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-primary">{{ __('Login') }}</button>
            @if (Route::has('password.request'))
                <a class="btn-link" href="{{ route('password.request') }}">{{ __('Forgot Your Password?') }}</a>
            @endif
        </div>
    </form>
</div>
@endsection
