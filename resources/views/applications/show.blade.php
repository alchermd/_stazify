@extends('layouts.dashboard')

@section('content')
    <div class="my-3 my-md-5">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header mt-2">
                            <h2>Application Information (#{{ $application->id }})</h2>
                        </div>

                        <div class="card-body">
                            <p>
                                <span class="avatar"
                                      style="background-image: url('{{ $application->user->avatar_url }}')"></span>
                                <a href="/home/students/{{ $application->user->id }}"><strong>{{ $application->user->name }}</strong></a>
                                applied to <a
                                        href="/home/jobs/{{ $application->jobpost->id }}">{{ $application->jobpost->title }}</a>.
                            </p>

                            <p>
                                <em>
                                    <small>Application sent
                                        <strong>{{ $application->created_at->toFormattedDateString() }}.</strong>
                                        ({{$application->created_at->diffForHumans()}})
                                    </small>
                                </em>

                                @forelse($application->changelogs as $changelog)
                                    <br>

                                    <em>
                                        <small>
                                            {{ $changelog->message }}
                                            <strong>{{ $changelog->created_at->toFormattedDateString() }}.</strong>
                                            ({{ $changelog->created_at->diffForHumans() }})
                                        </small>
                                    </em>
                                @empty
                                    ...
                                @endforelse
                            </p>

                            <hr>

                            @if ($msg = $application->message)
                                <h3>Application Letter:</h3>

                                <p>
                                    {!!  e($msg) !!}
                                </p>
                            @else
                                <h4><em>No application letter provided.</em></h4>
                            @endif

                            <hr>

                            <div class="btn-list mt-4 text-right">
                                @if (!$application->isCancelled() && $application->isPending())
                                    @if (auth()->user()->isStudent())
                                        <form class="d-inline-block"
                                              action="{{ route('applications.delete', ['application' => $application->id]) }}"
                                              method="post">
                                            @csrf
                                            @method('delete')

                                            <button type="button" class="btn btn-danger" data-toggle="modal"
                                                    data-target="#cancelModal">
                                                <span class="fe fe-alert-triangle"></span>
                                                Cancel Application
                                            </button>

                                            @component('components.confirm-modal')
                                                @slot('modalId')
                                                    cancelModal
                                                @endslot

                                                @slot('category')
                                                    danger
                                                @endslot

                                                @slot('body')
                                                    Are you sure you want to cancel this application?
                                                    This process is <strong>IRREVERSIBLE</strong> and you
                                                    <strong>CAN'T APPLY</strong> to this jobpost again.
                                                @endslot
                                            @endcomponent
                                        </form>
                                    @elseif (auth()->user()->isCompany())
                                        <form class="d-inline-block"
                                              action="/home/applications/{{ $application->id }}/reject"
                                              method="post">
                                            @csrf

                                            <input type="hidden" name="student_id"
                                                   value="{{ $application->user->id }}">

                                            <button type="button" class="btn btn-danger" data-toggle="modal"
                                                    data-target="#deleteModal">
                                                <span class="fe fe-x"></span>
                                                Reject Application
                                            </button>

                                            @component('components.confirm-modal')
                                                @slot('modalId')
                                                    deleteModal
                                                @endslot

                                                @slot('body')
                                                    Are you sure you want to reject this application?
                                                @endslot
                                            @endcomponent

                                        </form>

                                        <form class="d-inline-block"
                                              action="/home/applications/{{ $application->id }}/accept"
                                              method="post">
                                            @csrf

                                            <input type="hidden" name="student_id"
                                                   value="{{ $application->user->id }}">

                                            <button type="button" class="btn btn-success" data-toggle="modal"
                                                    data-target="#acceptModal">
                                                <span class="fe fe-x"></span>
                                                Accept Application
                                            </button>

                                            @component('components.confirm-modal')
                                                @slot('modalId')
                                                    acceptModal
                                                @endslot

                                                @slot('category')
                                                    success
                                                @endslot

                                                @slot('body')
                                                    Are you sure you want to accept this application?
                                                @endslot
                                            @endcomponent

                                        </form>
                                    @endif
                                @else
                                    @if (auth()->user()->isCompany() && !$application->isCancelled())
                                        <p class="btn btn-secondary" data-toggle="modal"
                                           data-target="#edit-application-status">
                                            <span class="fa fa-exchange"></span>
                                            Change Status
                                        </p>

                                        <div class="modal fade text-left" id="edit-application-status" tabindex="-1"
                                             role="dialog">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <form action="{{ route('applications.change-status', ['application' => $application->id]) }}"
                                                          method="post">
                                                        @csrf

                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Change Application Status</h5>
                                                        </div>

                                                        <div class="modal-body" style="font-size: 18px">
                                                            <p class="lead">
                                                                Are you sure you want to set this application's status
                                                                to
                                                                @if ($application->isAccepted())
                                                                    <span class="text-danger">rejected</span>
                                                                @else
                                                                    <span class="text-success">accepted</span>
                                                                @endif
                                                                ?
                                                            </p>

                                                            <label for="message">Reason for change (Optional)</label>
                                                            <textarea name="message"
                                                                      id="message"
                                                                      class="form-control"
                                                                      placeholder="This is because..."
                                                                      rows="7"></textarea>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Close
                                                            </button>

                                                            <button type="submit" class="btn btn-primary">Save changes
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    @if ($application->isAccepted())
                                        <p class="btn btn-outline-success disabled">Application has been accepted.</p>
                                    @else
                                        <p class="btn btn-outline-danger disabled">Application has
                                            been {{ $application->isCancelled() ? 'cancelled' : 'rejected'  }}.</p>
                                    @endif

                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
