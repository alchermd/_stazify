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
                                    <strong>{{ $message->sender->name  }}</strong>
                                    @if ( $message->sender->isCompany() &&  $message->sender->isCompanyVerified())
                                        <span class="fe fe-check text-success"
                                              title="This company is verified"></span>
                                    @endif
                                    &lt;{{ $message->sender->email }}&gt;
                                    {{ $message->created_at->toFormattedDateString() }}.
                                    <span class="text-danger">
                                        Trashed {{ $message->deleted_at->toFormattedDateString() }}
                                    </span>
                                </small>
                            </p>

                            <p style="font-size: 1.5rem">{!!  nl2br($message->body) !!}</p>

                            <hr>

                            <div class="mt-4 text-right">
                                <form action="{{ route('trashed-messages.delete', ['message' => $message->id ]) }}"
                                      method="post" class="d-inline-block">
                                    @csrf
                                    @method('delete')

                                    <button class="btn btn-danger mr-2" type="button" data-toggle="modal"  data-target="#deleteModal">
                                        <span class="fe fe-trash"></span>
                                        Delete Permanently
                                    </button>

                                    @component('components.confirm-modal')
                                        @slot('modalId')
                                            deleteModal
                                        @endslot

                                        @slot('category')
                                            danger
                                        @endslot

                                        @slot('body')
                                            Are you sure you want to permanently delete this message?
                                        @endslot
                                    @endcomponent
                                </form>

                                <form action="{{ route('trashed-messages.update', ['message' => $message->id]) }}"
                                      method="post" class="d-inline-block">
                                    @csrf
                                    @method('patch')

                                    <button class="btn btn-primary mr-2" type="submit">
                                        <span class="fe fe-refresh-cw"></span>
                                        Restore
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
