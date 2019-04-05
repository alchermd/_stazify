@extends('layouts.dashboard')

@section('content')
    <div class="my-3 my-md-5">
        <div class="container">
            <div class="page-header">
                <h2>
                    {{ auth()->user()->accountTypeName() }} Dashboard
                </h2>
            </div>

            <hr>

            @if (auth()->user()->isCompany())
                @include ('dashboard.company')
            @elseif (auth()->user()->isStudent())
                @include ('dashboard.student')
            @endif
        </div>
    </div>
@endsection
