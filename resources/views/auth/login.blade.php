@extends('layouts.app')

@section('title', 'Login - AI Learning Platform')

@push('styles')
<style>
    .auth-wrap { max-width: 460px; margin: 48px auto; padding: 0 16px; }
    .auth-card { background: #fff; border: 1px solid #e5e7eb; border-radius: 12px; padding: 24px; }
    .auth-card h1 { margin: 0 0 8px; font-size: 24px; }
    .auth-sub { margin: 0 0 20px; color: #6b7280; }
    .field { margin-bottom: 14px; }
    .field label { display: block; margin-bottom: 6px; font-weight: 600; }
    .field input, .field select {
        width: 100%; border: 1px solid #d1d5db; border-radius: 8px; padding: 10px 12px; font-size: 14px;
    }
    .btn-primary {
        width: 100%; border: 0; border-radius: 8px; padding: 11px 14px; background: #2563eb; color: #fff; font-weight: 600;
    }
    .error-box { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; padding: 10px 12px; border-radius: 8px; margin-bottom: 14px; }
    .auth-foot { margin-top: 14px; color: #374151; font-size: 14px; }
    .auth-foot a { color: #2563eb; text-decoration: none; }
</style>
@endpush

@section('content')
<section class="auth-wrap">
    <div class="auth-card">
        <h1>Log In</h1>
        <p class="auth-sub">Access your student dashboard.</p>

        @if ($errors->any())
            <div class="error-box">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login', [], false) }}">
            @csrf

            <div class="field">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
            </div>

            <div class="field">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" required>
            </div>

            <button type="submit" class="btn-primary">Login</button>
        </form>

        <p class="auth-foot">
            New student? <a href="{{ route('register') }}">Create an account</a>
        </p>
    </div>
</section>
@endsection
