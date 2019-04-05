@extends('layouts.dashboard')

@section('content')
    <div class="my-3 my-md-5">
        <div class="container">
            <div class="page-header">
                <h2>
                    Jobs Search Results
                </h2>
            </div>

            <hr>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        @if ($jobposts)
                            <div class="card-status bg-blue mb-2"></div>
                            <div class="card-header">
                                <p class="card-text lead">{{ $jobposts->count() }} search results.</p>
                            </div>
                        @else
                            <div class="card-status bg-red mb-2"></div>
                        @endif

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-outline table-vcenter text-nowrap card-table">
                                    <thead>
                                    <tr>
                                        <th></th>
                                        <th>Company</th>
                                        <th>Job Title</th>
                                        <th>Deadline</th>
                                        <th>Applicants</th>
                                        <th>Posted</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse ($jobposts as $jobpost)
                                        <tr>
                                            <td>
                                                <span class="avatar"
                                                      style="background-image: url('{{ $jobpost->user->avatar_url }}')"></span>
                                            </td>
                                            <td>
                                                <a href="/home/companies/{{ $jobpost->user->id }}">
                                                    {{ $jobpost->user->name }}
                                                </a>
                                            </td>
                                            <td>
                                                <a href="/home/jobs/{{ $jobpost->id }}">
                                                    {{ $jobpost->title }}
                                                </a>
                                            </td>
                                            <td>
                                                {{ $jobpost->deadline->diffForHumans() }}
                                            </td>
                                            <td class="text-center">
                                                {{ $jobpost->applications->count() }}
                                            </td>
                                            <td>
                                                {{ $jobpost->created_at->toFormattedDateString() }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr class="text-center">
                                            <td colspan="100">
                                                <h3 class="card-text  mt-3 mb-3">
                                                    No jobs found.
                                                </h3>
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
