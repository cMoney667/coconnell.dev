@props(['title' => null])
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ (!is_null($title) ? " | " : '') . "Collin O'Connell" }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-12KS72RQ4T"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-12KS72RQ4T');
    </script>
</head>
<body hx-boost="true" hx-ext="preload">
    <a href="#main" class="vh">Skip to Content</a>
    <header>
        <h1 class="allcaps">Collin O'Connell</h1>
        <nav class="tool-bar">
            <a href="{{ route('home') }}" preload>Home</a>
{{--            | <a href="{{ route('about') }}" preload>About</a>--}}
        </nav>
    </header>
    <main id="main">
        {{ $slot }}
    </main>
    <footer>
        <p>
            Copyright &copy; {{ now()->format('Y') }} <a href="{{ route('home') }}">coconnell.dev</a>
        </p>
    </footer>
    <script src="https://unpkg.com/htmx.org/dist/ext/preload.js" defer></script>
</body>
</html>
