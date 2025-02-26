<!DOCTYPE html>
    <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Wordle Buster</title>
        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-2J2NHLC493"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());

            gtag('config', 'G-2J2NHLC493');
        </script>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <link href="https://i.imgur.com/whUlUOW.png" rel="icon shortcut" sizes="3232">
    </head>
    <body class="antialiased">
    <div id="app"></div>
    </body>
</html>
