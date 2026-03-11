@extends('layouts.reader')

@section('content')

<div class="login-page">

    {{-- Left Side --}}
    <div class="login-left">
        <div class="login-left-content">
            <div class="login-brand">📚 MyLibrary</div>
            <h2 class="login-headline">Join Our Reading Community</h2>
            <p class="login-sub">Create your free account and start exploring thousands of books today.</p>

            <div class="login-features">
                <div class="login-feature">
                    <span class="lf-icon">📖</span>
                    <div>
                        <div class="lf-title">Rent Books</div>
                        <div class="lf-desc">Read for a limited time at a low cost</div>
                    </div>
                </div>
                <div class="login-feature">
                    <span class="lf-icon">🛒</span>
                    <div>
                        <div class="lf-title">Buy Books</div>
                        <div class="lf-desc">Own your favorites forever</div>
                    </div>
                </div>
                <div class="login-feature">
                    <span class="lf-icon">🔖</span>
                    <div>
                        <div class="lf-title">My Library</div>
                        <div class="lf-desc">Track all your books in one place</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Right Side --}}
    <div class="login-right">
        <div class="login-form-wrap">

            <a href="{{ route('books.index') }}" class="login-back">← Back</a>

            <h1 class="login-title">Create Account</h1>
            <p class="login-hint">Join as a reader — free forever.</p>

            @if($errors->any())
                <div class="login-error">⚠️ {{ $errors->first() }}</div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="login-form">
                @csrf

                <div class="login-field">
                    <label>Full Name</label>
                    <input type="text" name="name" placeholder="Your name"
                           required value="{{ old('name') }}">
                </div>

                <div class="login-field">
                    <label>Email</label>
                    <input type="email" name="email" placeholder="you@example.com"
                           required value="{{ old('email') }}">
                </div>

                <div class="login-field">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="••••••••"
                           required minlength="8">
                </div>

                <div class="login-field">
                    <label>Confirm Password</label>
                    <input type="password" name="password_confirmation"
                           placeholder="••••••••" required>
                </div>

                <button type="submit" class="login-btn">Create Account →</button>

                <p style="text-align:center; font-size:0.85rem; color:#9ca3af; margin-top:8px;">
                    Already have an account?
                    <a href="{{ route('login') }}" style="color:#4f46e5; text-decoration:none;">Sign in</a>
                </p>

            </form>

        </div>
    </div>

</div>

@endsection
