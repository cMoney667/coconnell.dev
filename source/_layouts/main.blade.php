<!DOCTYPE html>
<html lang="{{ $page->language ?? 'en' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="canonical" href="{{ $page->getUrl() }}">
        <meta name="description" content="{{ $page->description }}">
        <title>{{ $page->title }}</title>
        <link rel="stylesheet" href="{{ mix('css/main.css', 'assets/build') }}">
        <script defer src="{{ mix('js/main.js', 'assets/build') }}"></script>
    </head>
    <body class="fullscreen">
        <header>
            <h1>Collin O'Connell</h1>
        </header>
        <main>
            @yield('body')
        </main>
        <footer>
            Copyright &copy; {{ date('Y') }} <a href="//coconnell.dev">coconnell.dev</a>
        </footer>
    </body>
</html>
