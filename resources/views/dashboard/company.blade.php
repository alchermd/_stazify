@php ($company = auth()->user())

<div class="row row-cards">
    <div class="col-6 col-sm-4 col-lg-2">
        <div class="card">
            <div class="card-body p-3 text-center">
                <div class="text-right text-info">
                    <a href="/home/jobs" class="text-azure">
                        <span class="fa fa-list"></span>
                    </a>
                    &nbsp;
                    <a href="/home/jobs/new" class="text-azure">
                        <span class="fa fa-plus"></span>
                    </a>
                </div>
                <div class="h1 m-0">{{ $jobsPostedCount }}</div>
                <div class="text-muted mb-4">Jobs Posted</div>
            </div>
        </div>
    </div>

    <div class="col-6 col-sm-4 col-lg-2">
        <div class="card">
            <div class="card-body p-3 text-center">
                <div class="text-right text-info">
                    <a href="/home/applications" class="text-azure">
                        <span class="fa fa-list"></span>
                    </a>
                </div>
                <div class="h1 m-0" dusk="application-count">{{ $applicationCount }}</div>
                <div class="text-muted mb-4">Applications</div>
            </div>
        </div>
    </div>
</div>

<hr>

<div class="row row-cards">
    <div class="col-md-6">
        <div class="card">
            <div class="card-status bg-success"></div>

            <div class="card-header">
                <h3 class="card-title">Accepted Applicants</h3>
            </div>

            <div class="card-body o-auto" style="height: 20rem" dusk="accepted-applicants">
                <ul class="list-unstyled list-separated">
                    @forelse ($company->acceptedApplications() as $application)
                        @include ('dashboard._applications-table')
                    @empty
                        <li class="list-separated-item">
                            <p class="lead text-center">None so far!</p>
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-status bg-red"></div>

            <div class="card-header">
                <h3 class="card-title">
                    Rejected Applicants
                    <span class="fa fa-question-circle text-blue" data-container="body" data-toggle="popover"
                          data-placement="top"
                          data-content="Blurred out name means the application has been cancelled.">
                    </span>
                </h3>
            </div>

            <div class="card-body o-auto" style="height: 20rem" dusk="rejected-applicants">
                <ul class="list-unstyled list-separated">
                    @forelse ($company->rejectedApplications() as $application)
                        @include ('dashboard._applications-table')
                    @empty
                        <li class="list-separated-item">
                            <p class="lead text-center">None so far!</p>
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
