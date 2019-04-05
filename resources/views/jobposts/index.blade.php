@extends('layouts.dashboard')

@section('content')
    <div class="my-3 my-md-5">
        <div class="container">
            @if (auth()->user()->isCompany())
                @include ('jobposts.companies.index')
            @elseif (auth()->user()->isStudent())
                @include ('jobposts.students.index')
            @endif
        </div>
    </div>
@endsection
