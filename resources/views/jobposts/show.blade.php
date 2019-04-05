@extends('layouts.dashboard')

@section('content')
    <div class="my-3 my-md-5">
        <div class="container">
            <div class="col-12">
                <div class="page-header">
                    <h3 class="page-title">{{ $jobpost->title }}</h3>
                </div>

                <div class="card">
                    <div class="card-status card-status-top bg-blue"></div>

                    <div class="card-header">
                        <p class="card-title">
                        <div class="small">
                            {{ $jobpost->created_at->toFormattedDateString() }} -
                            <span class="text-link">
                                <a href="{{ route('companies.show', ['company' => $jobpost->user->id]) }}">
                                    {{ $jobpost->user->company_name }}
                                </a>
                                @if ($jobpost->user->isCompanyVerified())
                                    <span class="fe fe-check text-success" title="This company is verified"></span>
                                @endif

                                @if (auth()->user()->jobposts->contains($jobpost))
                                    <br>

                                    <span>
                                        Total Views:
                                        <code class="font-weight-bold">{{ $jobpost->views }}</code>
                                    </span>
                                @endif
                            </span>
                        </div>
                    </div>

                    <div class="card-body">
                        <h4>Description</h4>
                        <p class="lead">{!! nl2br($jobpost->description) !!}</p>

                        <h4>Qualifications</h4>
                        <ul>
                            @foreach (json_decode($jobpost->qualifications) as $qualification)
                                <li>{{ $qualification }}</li>
                            @endforeach
                        </ul>

                        <h4>Required Skills</h4>

                        <ul>
                            @foreach ($jobpost->skills as $skill)
                                <li>{{ $skill->name }}</li>
                            @endforeach
                        </ul>


                        <h4>Deadline</h4>
                        <p>
                            {{ $jobpost->deadline->toFormattedDateString() }}
                            ({{ $jobpost->deadline->diffForHumans() }})
                        </p>

                        <h4>
                            Preferred # of Applicants:
                            <code class="font-weight-bold">{{ $jobpost->getPreferredApplicants() ?? 'N/A' }}</code>
                        </h4>
                    </div>

                    <div class="card-footer text-right">
                        @if ($jobpost->isClosed())
                            <button class="btn btn-outline-danger disabled">Jobpost has been closed!</button>
                        @else
                            @if (auth()->user()->isCompany())

                                <a href="/home/jobs/{{ $jobpost->id }}/edit" class="btn btn-info">
                                    <fa class="fa fa-edit"></fa>
                                    Edit
                                </a>

                                <form action="{{ route('jobpost.close', ['jobpost' => $jobpost->id]) }}" method="post"
                                      style="display: inline-block">
                                    @csrf
                                    @method('patch')

                                    <button type="button" class="btn btn-danger" data-toggle="modal"
                                            data-target="#deleteModal">
                                        <span class="fe fe-x"></span>
                                        Mark As Closed
                                    </button>

                                    @component('components.confirm-modal')
                                        @slot('modalId')
                                            deleteModal
                                        @endslot

                                        @slot('category')
                                            danger
                                        @endslot

                                        @slot('body')
                                            Are you sure you want to close this job?
                                        @endslot
                                    @endcomponent
                                </form>
                            @elseif (auth()->user()->isStudent())
                                @if (auth()->user()->applications->contains('jobpost_id', $jobpost->id))
                                    <button class="btn btn-outline-primary disabled">
                                        <span class="fa fa-smile-o"></span>
                                        Already applied!
                                    </button>
                                @else
                                    @include ('applications.create')
                                @endif
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
