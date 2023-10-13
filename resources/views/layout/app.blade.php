<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pyi Twinn Phyit Map Testing</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />

    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
</head>

<body>

    @yield('content')

    <!-- Modals -->
    @include('partials.modals')

    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBmm7ex7_rqj5yZOphwWqDu5IeyTiqkeFE&libraries=geometry&callback=Function.prototype">
    </script>
    {{-- <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDD0r-G7HwtXNLmUFm6kIpdC9ga_NOdmiY&libraries=geometry&callback=Function.prototype">
    </script> --}}
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
    <script src="{{ asset('js/main.js') }}"></script>

    @stack('scripts')
</body>

</html>
