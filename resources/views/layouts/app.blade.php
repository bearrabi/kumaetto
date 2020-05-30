<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @yield('header')
</head>
<body>
    <div id="app">
        @yield('navbar')
        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
