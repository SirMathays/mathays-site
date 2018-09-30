<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    @if(empty($excludeVue)) <script src="{{ asset('js/admin.js') }}" defer></script> @endif

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
</head>
<body>
    @if(env('APP_ENV') != 'production')
        <div class="progress-bar progress-bar-striped bg-warning" style="height: 2em">
            <b>Development environment</b>
        </div>
    @endif
    <div id="admin">
        <main class="pb-4">
            @yield('content')
        </main>
    </div>
</body>
</html>