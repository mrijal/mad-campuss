@extends('layouts.app')
@section('title', 'Login')

@section('content')
    <div style="display:flex; justify-content:center; align-items:center; min-height: 100vh;">
        <div
            style="width: 400px; padding: 40px; background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius);">
            <div style="text-align: center; margin-bottom: 30px;">
                <div class="brand-icon" style="margin: 0 auto 16px;">
                    <i class="bi bi-mortarboard-fill"></i>
                </div>
                <h3 style="font-family: 'Syne', sans-serif; font-weight: 700; color: #fff;">MadUniv Login</h3>
                <p style="color: var(--muted); font-size: 13px;">Sign in to your account</p>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger"
                    style="background: rgba(248,113,113,0.15); border: 1px solid var(--red); color: var(--red); font-size: 13px; padding: 10px; border-radius: var(--radius-sm);">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control-custom" placeholder="name@example.com"
                        value="{{ old('email') }}" required autofocus>
                </div>
                <div class="form-group">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control-custom" placeholder="••••••••" required>
                </div>
                <button type="submit" class="btn-primary-custom"
                    style="width: 100%; justify-content: center; margin-top: 10px;">Sign In</button>
            </form>

            <!-- <div style="text-align: center; margin-top: 20px; font-size: 13px;">
                    <span style="color: var(--muted);">Don't have an account?</span> 
                    <a href="" style="color: var(--accent); text-decoration: none; font-weight: 600;">Register here</a>
                </div> -->
        </div>
    </div>
@endsection