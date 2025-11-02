<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Kamus Gaul</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @stack('styles')
</head>
<body>
    <!-- Header -->
    <header>
        <div class="container">
            <div class="header-content">
                <a href="{{ route('home') }}" class="logo-link">
                    <h1 class="logo">
                        Kamus Gaul
                    </h1>
                </a>
                
                @auth
                    <div class="user-menu">
                        <span class="username">{{ Auth::user()->full_name }}</span>
                        <a href="{{ route('words.index') }}" class="btn btn-outline">Kelola Kata</a>
                        <a href="{{ route('logout') }}" class="btn btn-outline" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                @else
                    <nav>
                        <a href="{{ route('login') }}">Login</a>
                        <a href="{{ route('register') }}">Register</a>
                    </nav>
                @endauth
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container">
        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>