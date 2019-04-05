@extends('layouts.back')

@section ('child-template')
    <div class="page-main">
        @include ('layouts.includes.first-header')
        @include ('layouts.includes.second-header')

        <div class="container mt-2">
            @if (session('status'))
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    {{ session('status') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    </button>
                </div>
            @endif
        </div>

        @yield ('content')
    </div>

    <footer class="footer bg-dark text-white">
        <div class="container">
            <div class="row align-items-center flex-row-reverse">
                <div class="col-auto ml-lg-auto">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <ul class="list-inline list-inline-dots mb-0">
                                <li class="list-inline-item">
                                    <a class="text-white" href="#">
                                        <span class="fa fa-facebook"></span>
                                    </a>
                                </li>
                                <li class="list-inline-item">
                                    <a class="text-white" href="#">
                                        <span class="fa fa-twitter"></span>
                                    </a>
                                </li>
                                <li class="list-inline-item">
                                    <a class="text-white" href="#">
                                        <span class="fa fa-linkedin"></span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-auto mt-3 mt-lg-0 text-center">
                    &copy; Stazify 2018. All Rights Reserved.
                </div>
            </div>
        </div>
    </footer>
@endsection
