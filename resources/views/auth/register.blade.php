@extends('layouts.app')
@section('title', 'Register')

@section('content')
<div style="display:flex; justify-content:center; align-items:center; min-height: 100vh;">
    <div style="width: 400px; padding: 40px; background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius);">
        <div style="text-align: center; margin-bottom: 30px;">
            <div class="brand-icon" style="margin: 0 auto 16px;">
                <i class="bi bi-mortarboard-fill"></i>
            </div>
            <h3 style="font-family: 'Syne', sans-serif; font-weight: 700; color: #fff;">Register</h3>
            <p style="color: var(--muted); font-size: 13px;">Create a new account</p>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger" style="background: rgba(248,113,113,0.15); border: 1px solid var(--red); color: var(--red); font-size: 13px; padding: 10px; border-radius: var(--radius-sm);">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="form-group">
                <label class="form-label">Name</label>
                <input type="text" name="name" class="form-control-custom" placeholder="John Doe" value="{{ old('name') }}" required autofocus>
            </div>
            <div class="form-group">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control-custom" placeholder="name@example.com" value="{{ old('email') }}" required>
            </div>
            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control-custom" placeholder="••••••••" required>
            </div>
            <div class="form-group">
                <label class="form-label">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control-custom" placeholder="••••••••" required>
            </div>
            <button type="submit" class="btn-primary-custom" style="width: 100%; justify-content: center; margin-top: 10px;">Register</button>
        </form>
        
        <div style="text-align: center; margin-top: 20px; font-size: 13px;">
            <span style="color: var(--muted);">Already have an account?</span> 
            <a href="{{ route('login') }}" style="color: var(--accent); text-decoration: none; font-weight: 600;">Sign in here</a>
        </div>
    </div>
</div>
@endsection
