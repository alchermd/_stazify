<div class="page-header">
    <h2>Available Jobs</h2>
</div>

<hr>

<div class="row">
    <div class="col-12">
        <div class="card">
            @if ($jobposts->count())
                <div class="card-status bg-blue mb-2"></div>
                <div class="card-header">
                    <p class="card-text lead">We found {{ $jobposts->count() }} available jobs for you.</p>
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
                            <th>Company</th>
                            <th>Job Title</th>
                            <th class="text-center">Posted</th>
                            <th class="text-center">Deadline</th>
                            <th class="text-center">Applicants</th>
                            <th class="text-center">Preferred # of Applicants</th>
                            <th class="text-center"><i class="icon-settings"></i></th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($jobposts as $jobpost)
                            @php ($company = $jobpost->user)
                            <tr>
                                <td class="text-center">
                                    <div class="avatar d-block"
                                         style="background-image: url({{ $company->avatar_url }})">
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        {{ $company->name }}
                                        @if ($company->isCompanyVerified())
                                            <span class="fe fe-check text-success"
                                                  title="This company is verified"></span>
                                        @endif
                                    </div>
                                    <div class="small text-muted">
                                        {{ $company->industry->name }}
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <a class="text-inherit"
                                           href="/home/jobs/{{ $jobpost->id }}">{{ $jobpost->title }}</a>
                                    </div>
                                </td>
                                <td class="text-center">{{ $jobpost->created_at->toFormattedDateString() }}</td>
                                <td class="text-center">{{ $jobpost->deadline->diffForHumans() }}</td>
                                <td class="text-center">
                                    {{ $jobpost->applications->count() }}
                                </td>
                                <td class="text-center">
                                    <p class="text-center">{{ $jobpost->getPreferredApplicants() ?? 'N/A' }}</p>
                                </td>
                                <td class="text-center">
                                    <div class="item-action">
                                        <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i
                                                class="fe fe-more-vertical"></i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a href="/home/jobs/{{ $jobpost->id }}" class="dropdown-item"><i
                                                    class="dropdown-icon fe fe-eye"></i> View Jobpost </a>
                                            <a href="/home/companies/{{ $company->id }}" class="dropdown-item"><i
                                                    class="dropdown-icon fe fe-users"></i> Visit Company Profile </a>
                                            <a href="{{ route('messages.create', ['recipient_email' => $company->email]) }}"
                                               class="dropdown-item"><i
                                                    class="dropdown-icon fe fe-message-square"></i> Send Company a
                                                Message</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr class="text-center">
                                <td colspan="100">
                                    <h3 class="card-text  mt-3 mb-3">No jobs available. Maybe try another time?</h3>
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
