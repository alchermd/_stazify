@extends('layouts.dashboard')

@section('content')
    <div class="my-3 my-md-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card card-profile" dusk="student-profile-card">
                        <div class="card-header"
                             style="background-color: lightblue"></div>
                        <div class="card-body text-center">
                            <img class="card-profile-img" src="{{ $student->avatar_url }}">
                            <h3 class="mb-3">{{ $student->first_name }} {{ $student->last_name }}</h3>
                            <p class="mb-3">
                                <span class="fa fa-tree"></span> {{ $student->age }} years old
                            </p>
                            <p class="mb-3">
                                <span class="fa fa-book"></span> {{ $student->course->name }}
                            </p>
                            <p class="mb-4">
                                <span class="fa fa-graduation-cap"></span> {{ $student->school }}
                            </p>
                            @if (auth()->user()->id !== $student->id)
                                <a href="{{ route('messages.create', ['recipient_email' => $student->email ]) }}"
                                   class="btn btn-outline-primary btn-sm">
                                    <span class="fa fa-envelope"></span> Message
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card" dusk="student-info-card">
                        <div class="card-header">
                            <h2 class="card-text">Student Information</h2>
                        </div>

                        <div class="card-body" style="font-size: 1.2em;">
                            <div>
                                <p>
                                    <strong>Last Name:</strong> {{ $student->last_name }} <br>
                                    <strong>First Name:</strong> {{ $student->first_name }}
                                </p>

                                <p>
                                    <strong>Age: </strong> {{ $student->age }}
                                </p>

                                <p>
                                    <strong>Address: </strong> <br>
                                    {!! nl2br($student->address) !!}
                                </p>

                                <p>
                                    <strong>About Me: </strong> <br>
                                    {!! nl2br($student->about) !!}
                                </p>

                                @if ($link = $student->resume_url)
                                    <a class="btn btn-primary" href="{{ $link }}">
                                        <span class="fa fa-download"></span> Download Resumé
                                    </a>
                                @else
                                    <p class="text-info">
                                        <em>{{ $student->first_name }} hasn't uploaded a resumé yet.</em>
                                    </p>
                                @endif
                            </div>

                            <hr>

                            <div>
                                <h3>Contact</h3>

                                <p>
                                    <strong>E-mail address:</strong>
                                    <a href="mailto:{{ $student->email }}">{{ $student->email }}</a>
                                </p>

                                <p>
                                    <strong>Contact Number:</strong>
                                    {{ $student->contact_number }}
                                </p>
                            </div>
                        </div>
                    </div>
                    @if (auth()->user()->id === $student->id)
                        @include('student-profile.edit')
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
