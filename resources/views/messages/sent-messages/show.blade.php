@extends('layouts.dashboard')

@section('content')
    <div class="my-3 my-md-5">
        <div class="container">
            <div class="row">
                @include ('messages.includes.sidebar')

                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><strong>{{ $message->subject }}</strong></h3>
                            <p></p>
                        </div>
                        <div class="card-body">
                            <p>
                                <span class="avatar"
                                      style="background-image: url({{ $message->sender->avatar_url }})"></span>
                                <small>
                                    <strong>
                                        {{ $message->sender->name  }}
                                        @if ( $message->sender->isCompany() &&  $message->sender->isCompanyVerified())
                                            <span class="fe fe-check text-success"
                                                  title="This company is verified"></span>
                                        @endif
                                    </strong>
                                    &lt;{{ $message->sender->email }}&gt;
                                </small>

                                <span class="fe fe-arrow-right"></span>

                                <span class="avatar"
                                      style="background-image: url({{ $message->recipient->avatar_url }})"></span>
                                <small>
                                    <strong>
                                        {{ $message->recipient->name  }}
                                        @if ( $message->recipient->isCompany() &&  $message->recipient->isCompanyVerified())
                                            <span class="fe fe-check text-success"
                                                  title="This company is verified"></span>
                                        @endif
                                    </strong>
                                    &lt;{{ $message->recipient->email }}&gt;
                                </small>

                                (<em>{{ $message->created_at->toFormattedDateString() }}</em>)
                            </p>

                            <p style="font-size: 1.5rem">{!!  nl2br($message->body) !!}</p>

                            <hr>

                            <div class="text-right">
                                <a href="{{ route('messages.create', [
                                        'recipient_email' => $message->recipient->email,
                                        'subject' => 'Follow up: ' . $message->subject
                                    ])}}"
                                   class="btn btn-primary">Follow Up</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
