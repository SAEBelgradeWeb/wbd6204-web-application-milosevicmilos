<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="Milos Milosevic">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta name="description" content="Track electricity consumption in your buildings!">
    <meta name="robots" content="noindex">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'KiloWatts') }} - Application</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset(mix('css/app.css')) }}">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}">
</head>
<body>

<noscript>
    <strong>We're sorry but Kilo Watts application doesn't work properly without JavaScript enabled. Please enable it to continue.</strong>
</noscript>

<div id="app"></div>

<!-- JS -->
<script src="{{ asset(mix('js/app.js')) }}"></script>

</body>
</html>
