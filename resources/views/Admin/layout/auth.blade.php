<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="{{ $title ?? 'Admin' }}" />
    <meta name="robots" content="noindex, nofollow" />
    <meta name="theme-color" content="#ffffff" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/global/images/favicon.ico') }}" />
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/global/images/favicon-32x32.png') }}" />
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/global/images/favicon-16x16.png') }}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/global/images/apple-touch-icon.png') }}" />
    {{-- <link rel="manifest" href="{{ asset('site.webmanifest') }}" /> --}}

    <title>{{ empty($title) ? '' : $title . ' | ' }}{{ setting('site_title') }}</title>

    <!-- Stylesheets -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=Syne:wght@700;800&display=swap"
        rel="stylesheet" />
    <link href="{{ asset('assets/admin/css/style.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/global/css/login.css') }}" rel="stylesheet" />
    @stack('css')

    <!-- CSRF Token (Laravel) -->
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<body>
    @include('admin.layout.components.alerts')
    @yield('content')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/admin/js/script.js') }}"></script>
    @stack('js')
</body>

</html>
