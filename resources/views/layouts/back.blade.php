<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Stazify</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Leckerli+One|Source+Sans+Pro:300,300i,400,400i,500,500i,600,600i,700,700i&amp;subset=latin-ext">

    @section('css')
        <link href="{{ asset('css/pace.css') }}" rel="stylesheet">
        <link href="/css/dashboard.css" rel="stylesheet"/>
        <link href="/plugins/charts-c3/plugin.css" rel="stylesheet"/>
        <link href="/plugins/maps-google/plugin.css" rel="stylesheet"/>

        <style>
            .nav-item > a.nav-link:hover {
                color: yellow !important;
            }

            li.nav-item > a.nav-link.active.text-white {
                color: yellow !important;
            }

            .invalid-feedback {
                display: block;
            }
        </style>
    @show
</head>

<body class="">
<div class="page">
    @yield ('child-template')
</div>

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js"></script>
    <script src="/js/require.min.js"></script>
    <script>
        requirejs.config({
            baseUrl: '.'
        });
    </script>
    <script src="/js/dashboard.js"></script>
    <script src="/plugins/charts-c3/plugin.js"></script>
    <script src="/plugins/maps-google/plugin.js"></script>
    <script src="/plugins/input-mask/plugin.js"></script>
@show
</body>

</html>
