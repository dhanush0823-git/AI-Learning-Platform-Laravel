@extends('layouts.app')

@section('title', 'Register - AI Learning Platform')

@push('styles')
<style>
    .auth-wrap { max-width: 520px; margin: 48px auto; padding: 0 16px; }
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
    .error-list { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; padding: 10px 12px; border-radius: 8px; margin-bottom: 14px; }
    .error-list ul { margin: 0; padding-left: 18px; }
    .auth-foot { margin-top: 14px; color: #374151; font-size: 14px; }
    .auth-foot a { color: #2563eb; text-decoration: none; }
</style>
@endpush

@section('content')
<section class="auth-wrap">
    <div class="auth-card">
        <h1>Create Account</h1>
        <p class="auth-sub">Join as a student and start learning.</p>

        @if ($errors->any())
            <div class="error-list">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register', [], false) }}">
            @csrf

            <div class="field">
                <label for="name">Full Name</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required>
            </div>

            <div class="field">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required>
            </div>

            <div class="field">
                <label for="department_id">Department</label>
                <select id="department_id" name="department_id" required>
                    <option value="">Select department</option>
                    @foreach ($departments as $department)
                        <option value="{{ $department->id }}" @selected(old('department_id') == $department->id)>
                            {{ $department->code }} - {{ $department->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="field">
                <label for="level">Learning Level</label>
                <select id="level" name="level" required>
                    <option value="beginner" @selected(old('level') === 'beginner')>Beginner</option>
                    <option value="intermediate" @selected(old('level') === 'intermediate')>Intermediate</option>
                    <option value="advanced" @selected(old('level') === 'advanced')>Advanced</option>
                </select>
            </div>

            <div class="field">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" required>
            </div>

            <div class="field">
                <label for="password_confirmation">Confirm Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required>
            </div>

            <button type="submit" class="btn-primary">Create Account</button>
        </form>

        <p class="auth-foot">
            Already have an account? <a href="{{ route('login') }}">Log in</a>
        </p>
    </div>
</section>
@endsection
