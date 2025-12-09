@extends('layouts.blank')

@section('content')
<div class="form-container">
    <h2 class="auth-title">{{ __('Verify Your Email Address') }}</h2>

    <div>
        @if (session('resent'))
            <div class="error-text" style="color:green;margin-bottom:10px;">{{ __('A fresh verification link has been sent to your email address.') }}</div>
        @endif

        <p>{{ __('Before proceeding, please check your email for a verification link.') }}</p>
        <p>{{ __('If you did not receive the email') }},</p>

        <form method="POST" action="{{ route('verification.resend') }}">
            @csrf
            <div class="form-actions">
                <button type="submit" class="btn-primary">{{ __('Resend Verification Email') }}</button>
            </div>
        </form>
    </div>
</div>
@endsection
