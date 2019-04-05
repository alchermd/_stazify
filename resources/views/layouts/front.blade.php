<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="alchermd <johnalcherdoloiras@gmail.com>">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} - @yield('title', 'Providing ICT students internship opportunities.')</title>

    @section ('css')
        <link href="{{ asset('css/pace.css') }}" rel="stylesheet">
        <link href="/css/app.css" rel="stylesheet"/>

        <!-- Custom fonts for this template -->
        <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.css"
              rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Roboto|Lato:300,400,700,300italic,400italic,700italic|Leckerli+One"
              rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="/css/landing-page.css"
              rel="stylesheet">
    @show
</head>

<body>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="/"
           style="font-size: 32px; font-family: 'Leckerli One'; letter-spacing: 3px; font-weight: lighter;">
            Stazify
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a href="/companies"
                       class="btn btn-outline-light bg-dark text-white navbar-text mr-1 mb-lg-0 mb-md-2">
                        Are you a company?
                    </a>
                </li>

                @auth
                    <li class="nav-item">
                        <a class="btn btn-primary" href="{{ url('/home') }}">Home</a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="btn btn-primary mr-1 mb-lg-0 mb-md-2" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-secondary" href="{{ route('register') }}">Register</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

@yield('content')

<!-- Footer -->
<footer class="footer bg-white">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 h-100 text-center text-lg-left my-auto">
                <ul class="list-inline mb-2">
                    <li class="list-inline-item">
                        <a href="/companies">For Companies</a>
                    </li>
                    <li class="list-inline-item">&sdot;</li>
                    <li class="list-inline-item">
                        <a href="/faq">FAQ</a>
                    </li>
                    <li class="list-inline-item">&sdot;</li>
                    <li class="list-inline-item">
                        <a href="/feedback">Feedback</a>
                    </li>
                    <li class="list-inline-item">&sdot;</li>
                    <li class="list-inline-item">
                        <a href="{{ route('pages.tos') }}">Terms of Use</a>
                    </li>
                </ul>
                <p class="text-muted small mb-4 mb-lg-0">&copy; Stazify 2018. All Rights Reserved.</p>
            </div>
            <div class="col-lg-6 h-100 text-center text-lg-right my-auto">
                <ul class="list-inline mb-0">
                    <li class="list-inline-item mr-3">
                        <a href="#">
                            <i class="fa fa-facebook fa-2x fa-fw"></i>
                        </a>
                    </li>
                    <li class="list-inline-item mr-3">
                        <a href="#">
                            <i class="fa fa-twitter fa-2x fa-fw"></i>
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a href="#">
                            <i class="fa fa-linkedin fa-2x fa-fw"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</footer>

@section ('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script src="/js/app.js"></script>
@show
</body>

</html>
