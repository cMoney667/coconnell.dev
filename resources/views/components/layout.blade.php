@props(['title' => null])
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ (!is_null($title) ? " | " : '') . "Collin O'Connell" }}</title>
    @vite(['resources/css/app.css'])
</head>
<body hx-boost="true">
    <a href="#main" class="vh">Skip to Content</a>
    <header>
        <h1 class="allcaps">Collin O'Connell</h1>
        <nav class="tool-bar">
            <a href="{{ route('home') }}">Home</a> |
            <a href="{{ route('about') }}">About</a>
        </nav>
    </header>
    <main id="main">
        {{ $slot }}
    </main>
    <footer>
        <p>
            Copyright &copy; {{ now()->format('Y') }}
        </p>
    </footer>
    @vite(['resources/js/app.js'])
</body>
</html>
