@extends('layouts.dashboard')

@section('content')
    <div class="my-3 my-md-5">
        <div class="container">
            <div class="row">
                @include ('settings.includes.sidebar')

                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-text">Summary</h2>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                @if (auth()->user()->isStudent())
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-body text-center">
                                                <div class="text-left text-info">
                                                    <span class="fe fe-send" style="font-size: 23px"></span>
                                                </div>

                                                <h1 class="font-weight-bold display-1 text-info">
                                                    {{ auth()->user()->applications->count() }}
                                                </h1>
                                                <p class="lead">
                                                    <strong>Total Applications Sent</strong>
                                                </p>
                                            </div>
                                            <div class="card-footer">
                                                <code> {{ auth()->user()->created_at->toFormattedDateString() }}</code>
                                                &mdash; <code>{{ \Carbon\Carbon::now()->toFormattedDateString() }}</code>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-body text-center">
                                                <div class="text-left text-info">
                                                    <span class="fe fe-activity" style="font-size: 23px"></span>
                                                </div>

                                                <h1 class="font-weight-bold display-1 text-info">
                                                    {{ auth()->user()->profile_views }}
                                                </h1>

                                                <p class="lead">
                                                    <strong>Total Reach</strong>
                                                </p>
                                            </div>
                                            <div class="card-footer">
                                                Includes views and clicks on your profile page.
                                            </div>
                                        </div>
                                    </div>
                                @elseif (auth()->user()->isCompany())
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-body text-center">
                                                <div class="text-left text-info">
                                                    <span class="fe fe-book" style="font-size: 23px"></span>
                                                </div>

                                                <h1 class="font-weight-bold display-1 text-info">
                                                    {{ auth()->user()->jobposts->count() }}
                                                </h1>
                                                <p class="lead">
                                                    <strong>Total Jobs Posted</strong>
                                                </p>
                                            </div>
                                            <div class="card-footer">
                                                <code> {{ auth()->user()->created_at->toFormattedDateString() }}</code>
                                                &mdash; <code>{{ \Carbon\Carbon::now()->toFormattedDateString() }}</code>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-body text-center">
                                                <div class="text-left text-info">
                                                    <span class="fe fe-activity" style="font-size: 23px"></span>
                                                </div>

                                                <h1 class="font-weight-bold display-1 text-info">
                                                    {{ auth()->user()->profile_views + auth()->user()->jobpost_views }}
                                                </h1>

                                                <p class="lead">
                                                    <strong>Total Reach</strong>
                                                </p>
                                            </div>
                                            <div class="card-footer">
                                                Includes views and clicks on your job posts and profile.
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
