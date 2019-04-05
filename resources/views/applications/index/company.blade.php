@extends('layouts.dashboard')

@section('content')
    <div class="my-3 my-md-5">
        <div class="container">
            <div class="page-header">
                <h2>Applications</h2>
            </div>

            <hr>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        @if ($applications->count())
                            <div class="card-status bg-blue mb-2"></div>
                            <div class="card-header">
                                <p class="card-text lead">
                                    You have a total of {{ $applications->count() }} applicants.
                                </p>
                            </div>
                        @else
                            <div class="card-status bg-red mb-2"></div>
                        @endif

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-outline table-vcenter text-nowrap card-table">
                                    <thead>
                                    <tr>
                                        <th class="text-center w-1"><i class="icon-people"></i></th>
                                        <th>Name</th>
                                        <th>Job Applied</th>
                                        <th class="text-center">Application Date</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center"><i class="icon-settings"></i></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse ($applications as $application)
                                        @php ($student = $application->user)
                                        @php ($jobpost = $application->jobpost)
                                        <tr>
                                            <td class="text-center">
                                                <div class="avatar d-block"
                                                     style="background-image: url({{ $student->avatar_url }})">
                                                </div>
                                            </td>
                                            <td>
                                                <div>{{ $student->first_name }} {{ $student->last_name }}</div>
                                                <div class="small text-muted">
                                                    {{ $student->school }}
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <a class="text-inherit"
                                                       href="/home/jobs/{{ $jobpost->id }}">{{ $jobpost->title }}</a>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <a href="{{ route('applications.show', ['application' => $application->id]) }}">
                                                    {{ $application->created_at->toFormattedDateString() }}
                                                    ({{ $application->created_at->diffForHumans() }})
                                                </a>
                                            </td>
                                            <td class="text-center">
                                                @if ($application->isCancelled())
                                                    <span class="text-danger">CANCELLED</span>
                                                @else
                                                    <span class="text-primary">ACTIVE</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <div class="item-action">
                                                    <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i
                                                                class="fe fe-more-vertical"></i></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a href="{{ route('applications.show', ['application' => $application->id]) }}"
                                                           class="dropdown-item">
                                                            <i class="dropdown-icon fe fe-eye"></i> View Application
                                                        </a>
                                                        <a href="/home/students/{{ $student->id }}"
                                                           class="dropdown-item">
                                                            <i class="dropdown-icon fe fe-users"></i>
                                                            Visit Student Profile
                                                        </a>
                                                        <a href="{{ route('messages.create', ['recipient_email' => $application->user->email]) }}"
                                                           class="dropdown-item">
                                                            <i class="dropdown-icon fe fe-message-square"></i>
                                                            Send Student a Message
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr class="text-center">
                                            <td colspan="100">
                                                <h3 class="card-text  mt-3 mb-3">No active applicants.</h3>
                                            </td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
