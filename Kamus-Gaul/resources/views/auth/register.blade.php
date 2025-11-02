@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="form-container">
    <div class="form-header">
        <h2>Register</h2>
        <p>Buat akun Kamus Online Anda</p>
    </div>
    
    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif
    
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="form-group">
            <label for="full_name">Nama Lengkap</label>
            <input type="text" id="full_name" name="full_name" class="form-control" value="{{ old('full_name') }}" required autofocus>
        </div>
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" id="username" name="username" class="form-control" value="{{ old('username') }}" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="password_confirmation">Konfirmasi Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
        </div>
        <div class="form-footer">
            <button type="submit" class="btn btn-primary btn-block">Register</button>
            <p>Sudah punya akun? <a href="{{ route('login') }}">Login</a></p>
        </div>
    </form>
</div>
@endsection