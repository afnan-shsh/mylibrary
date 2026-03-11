@extends('layouts.reader')

@section('content')

<div class="login-page">

    {{-- Left Side --}}
    <div class="login-left">
        <div class="login-left-content">
            <div class="login-brand">📚 MyLibrary</div>
            <h2 class="login-headline">Your World of Books Awaits</h2>
            <p class="login-sub">Sign in once — we'll take you exactly where you belong.</p>

            <div class="login-features">
                <div class="login-feature">
                    <span class="lf-icon">📖</span>
                    <div>
                        <div class="lf-title">Readers</div>
                        <div class="lf-desc">Browse, rent, and buy books</div>
                    </div>
                </div>
                <div class="login-feature">
                    <span class="lf-icon">🏛️</span>
                    <div>
                        <div class="lf-title">Libraries</div>
                        <div class="lf-desc">Manage your book collection</div>
                    </div>
                </div>
                <div class="login-feature">
                    <span class="lf-icon">✍️</span>
                    <div>
                        <div class="lf-title">Publishers</div>
                        <div class="lf-desc">Publish and track your books</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Right Side --}}
    <div class="login-right">
        <div class="login-form-wrap">

            <a href="{{ route('books.index') }}" class="login-back">← Back</a>

            <h1 class="login-title">Welcome back</h1>
            <p class="login-hint">Sign in and we'll redirect you automatically.</p>

            @if($errors->any())
                <div class="login-error">⚠️ {{ $errors->first() }}</div>
            @endif

            <form method="POST" action="/login" class="login-form">
                @csrf
                <div class="login-field">
                    <label>Email</label>
                    <input type="email" name="email" placeholder="you@example.com"
                           required value="{{ old('email') }}">
                </div>
                <div class="login-field">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="••••••••" required>
                </div>
                <button type="submit" class="login-btn">Sign In →</button>

                {{-- رابط التسجيل --}}
                <p style="text-align:center; font-size:0.85rem; color:#9ca3af; margin-top:12px;">
                    Don't have an account?
                    <a href="{{ route('register') }}" style="color:#4f46e5; font-weight:600; text-decoration:none;">
                        Create one →
                    </a>
                </p>
            </form>

        </div>
    </div>

</div>

@endsection
