@php ($company = auth()->user())

<div class="page-header">
    <h2>
        My Job Posts
        <a href="/home/jobs/new" class="text-azure ml-2"><span class="fa fa-plus"></span></a>
    </h2>
</div>

<hr>

<div class="row">
    <div class="col-12">
        <div class="card">
            @if ($company->jobposts->count())
                <div class="card-status bg-blue mb-2"></div>
                <div class="card-header">
                    <p class="card-text lead">
                        You have a total of {{ $company->jobposts->count() }} jobs posted. <br>
                        <span class="small">Note: blurred out rows means that the jobpost has been closed.</span>
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
                            <th>Job Title</th>
                            <th class="text-center">Posted</th>
                            <th class="text-center">Deadline</th>
                            <th class="text-center">Applicants</th>
                            <th class="text-center">Preferred # of Applicants</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($company->getJobposts() as $jobpost)
                            <tr class="{{ $jobpost->isClosed() ? 'text-danger text-muted' : '' }}">
                                <td>
                                    <a href="/home/jobs/{{ $jobpost->id }}"
                                       class="text-inherit">{{ $jobpost->title }}</a>
                                </td>
                                <td>
                                    <p class="text-center">{{ $jobpost->created_at->toFormattedDateString() }}</p>
                                </td>
                                <td>
                                    <p class="text-center">{{ $jobpost->deadline->diffForHumans() }}</p>
                                </td>
                                <td class="text-center">
                                    <p class="text-center">{{ $jobpost->applications->count() }}</p>
                                </td>
                                <td class="text-center">
                                    <p class="text-center">{{ $jobpost->getPreferredApplicants() ?? 'N/A' }}</p>
                                </td>
                            </tr>
                        @empty
                            <tr class="text-center">
                                <td colspan="100">
                                    <h3 class="card-text  mt-3 mb-3">
                                        No jobs yet. <a class="text-blue" href="/home/jobs/new">Create one?</a>
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
