<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        @yield('pwa')

        <script src="//ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="apple-mobile-web-app-status-bar-style" content="default">

        <link rel="apple-touch-icon" href="./icon-120.png" sizes="120x120"/>
        <link rel="apple-touch-icon" href="./icon-180.png" sizes="180x180"/>

        <link href="/css/nosfilter-pwa.css" rel="stylesheet" type="text/css">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>nosFilter</title>
    </head>
    @yield('content')
</html>
