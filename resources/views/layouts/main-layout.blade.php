<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="Milos Milosevic">
    <meta name="description" content="Track electricity consumption in your buildings!">
    <meta name="robots" content="index, follow">

    <title>KiloWatts</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('assets-home/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets-home/css/main.css') }}">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700,800%7COpen+Sans:400,600,600i" rel="stylesheet">

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('favicon.ico') }}">
</head>
<body>

@yield('content')

<!-- JS -->
<script src="{{ asset('assets-home/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets-home/js/bootstrap.min.js')}}"></script>

</body>
</html>