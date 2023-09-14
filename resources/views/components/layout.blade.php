@props(['title' => null])
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ (!is_null($title) ? " | " : '') . "Collin O'Connell" }}</title>
    @vite(['resources/css/app.css'])
</head>
<body>
    <header>
        <h1 class="allcaps">Collin O'Connell</h1>
        <nav class="tool-bar">
            <a href="{{ route('home') }}">Home</a> |
            <a href="{{ route('about') }}">About</a>
        </nav>
    </header>
    <main>
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
