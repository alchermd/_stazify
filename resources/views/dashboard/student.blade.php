<div class="row row-cards row-deck">
    <div class="col-md-6 col-lg-4">
        <div class="card">
            <div class="card-status bg-orange"></div>

            <div class="card-header">
                <h3 class="card-title">Pending Applications</h3>
            </div>

            <div class="card-body o-auto" style="height: 15rem" dusk="pending-applications">
                <ul class="list-unstyled list-separated">
                    @forelse ($pendingApplications as $application)
                        @include ('dashboard._applications-column')
                    @empty
                        <li class="list-separated-item">
                            <p class="text-center lead">No applications ...</p>
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-4">
        <div class="card">
            <div class="card-status bg-success"></div>

            <div class="card-header">
                <h3 class="card-title">Accepted Applications</h3>
            </div>

            <div class="card-body o-auto" style="height: 15rem" dusk="accepted-applications">
                <ul class="list-unstyled list-separated">
                    @forelse ($acceptedApplications as $application)
                        @include ('dashboard._applications-column')
                    @empty
                        <li class="list-separated-item">
                            <p class="text-center lead">No applications ...</p>
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-4">
        <div class="card">
            <div class="card-status bg-red"></div>

            <div class="card-header">
                <h3 class="card-title">Rejected Applications</h3>
            </div>

            <div class="card-body o-auto" style="height: 15rem" dusk="rejected-applications">
                <ul class="list-unstyled list-separated">
                    @forelse ($rejectedApplications as $application)
                        @include ('dashboard._applications-column')
                    @empty
                        <li class="list-separated-item">
                            <p class="text-center lead">No applications ...</p>
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
