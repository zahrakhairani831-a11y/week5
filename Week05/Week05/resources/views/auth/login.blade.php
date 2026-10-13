@extends('layouts.guest')

@section('title', 'Masuk')

@section('content')
<div class="login-box">
    <h1>Inventory System</h1>
    <p class="muted">Silakan masuk untuk melanjutkan.</p>

    <form method="POST" action="{{ route('login.attempt') }}">
        @csrf

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" autofocus>
            @error('email')
                <small class="error">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password">
            @error('password')
                <small class="error">{{ $message }}</small>
            @enderror
        </div>

        <label class="check">
            <input type="checkbox" name="remember"> Ingat saya
        </label>

        <button type="submit" class="btn btn-block">Masuk</button>
    </form>
</div>
@endsection
