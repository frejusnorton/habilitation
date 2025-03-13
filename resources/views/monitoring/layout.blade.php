<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ url('boostrap.min.css') }}">
    <link rel="stylesheet" href="{{ url('charts.js') }}">
    <meta http-equiv="refresh" content="900">
</head>

<body>
    <div class="container">
        @yield('content')
    </div>

    <script src="{{ url('charts.js') }}"></script>
    <script src="{{ url('jquery.min.js') }}"></script>

    @yield('scripts')
</body>

</html>
