@extends('layouts.dashboard')

@section('content')
    <div class="my-3 my-md-5">
        <div class="container">
            <div class="row">
                @include ('messages.includes.sidebar')

                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                Sent Messages
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="card">
                                @if ($messages->isEmpty())
                                    <h3 class="text-center mt-5">Outbox Empty</h3>
                                @else
                                    <table class="table card-table table-vcenter table-hover">
                                        <thead>
                                        <tr>
                                            <th></th>
                                            <th><strong>Recipient</strong></th>
                                            <th><strong>Subject</strong></th>
                                            <th class="text-right"><strong>Sent</strong></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($messages as $message)
                                            <tr>
                                                <td><img src="{{ $message->recipient->avatar_url }}" alt="" class="h-8">
                                                </td>
                                                <td>
                                                    <a href="/home/companies/{{ $message->recipient->id }}">
                                                        {{ $message->recipient->name }}
                                                        @if ( $message->recipient->isCompany() &&  $message->recipient->isCompanyVerified())
                                                            <span class="fe fe-check text-success"
                                                                  title="This company is verified"></span>
                                                        @endif
                                                    </a>
                                                </td>
                                                <td>
                                                    <a href="{{ route('sent-messages.show', ['message' => $message->id]) }}">
                                                        <strong>{{ $message->subject }}</strong>
                                                    </a>
                                                </td>
                                                <td class="text-right text-muted d-none d-md-table-cell text-nowrap">
                                                    {{ $message->created_at->diffForHumans() }}
                                                </td>
                                            </tr>
                                        </tbody>
                                        @endforeach
                                    </table>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

