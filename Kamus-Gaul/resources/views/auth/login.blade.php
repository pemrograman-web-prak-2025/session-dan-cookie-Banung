@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="form-container">
    <div class="form-header">
        <h2>Login</h2>
        <p>Masuk ke akun Kamus Gaul Anda</p>
    </div>
    
    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif
    
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" class="form-control" value="{{ old('username') }}" required autofocus>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" class="form-control" required>
        </div>
        <div class="form-group remember-me">
            <label>
                <input type="checkbox" name="remember"> Remember Me
            </label>
        </div>
        <div class="form-footer">
            <button type="submit" class="btn btn-primary btn-block">Login</button>
            <p>Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a></p>
        </div>
    </form>
</div>
@endsection