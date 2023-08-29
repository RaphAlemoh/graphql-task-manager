<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{env('APP_NAME')}}</title>

    @vite('resources/css/app.css')
    <style>
        html {
            scroll-padding-top: 3.5rem;
        }

        header {
            padding-top: 9.5rem;
            padding-bottom: 6rem;
        }

        section {
            padding-top: 9rem;
            padding-bottom: 9rem;
        }
    </style>

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

</head>

<body class="antialiased">
    <div id="app">
        <router-view></router-view>
    </div>
    @vite('resources/js/app.js')
</body>

</html>