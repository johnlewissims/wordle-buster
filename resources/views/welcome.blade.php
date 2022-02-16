<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Wordle Buster</title>

        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        
        <link href="https://i.imgur.com/whUlUOW.png" rel="icon shortcut" sizes="3232">
    </head>
    <body class="antialiased">
        <div id="app"></div>
    </body>

    <script src="/js/app.js"></script>
</html>
