<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <!-- style -->
    <link href="{{ mix('css/style.css') }}" rel="stylesheet">
    <!-- endstyle -->
</head>

<body class="antialiased bg-base-100 overscroll-none">
    <header class="sticky top-0 z-40">
        @include('pages.landing.auth.navbar-login')
    </header>

    <main class="main-container bg-base-100">
        @auth
        @yield('content')
        @endauth
    </main>
    <footer class="footer-center bg-base-200 text-base-content p-4">
        <aside>
            <p>Copyright ©
                <script>
                    document.write(new Date().getFullYear())
                </script> - Bannn
            </p>
        </aside>
    </footer>

</body>

</html>
