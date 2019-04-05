<li class="list-separated-item">
    <div class="row align-items-center">
        <div class="col-auto">
            <span class="avatar avatar-md d-block"
                  style="background-image: url('{{ $application->getCompany()->avatar_url  }}')"></span>
        </div>
        <div class="col">
            <div>
                <a href="/home/jobs/{{ $application->jobpost->id }}"
                   class="text-inherit">{{ $application->jobpost->title }}</a>
            </div>
            <small
                class="d-block item-except text-sm text-muted h-1x">{{ $application->getCompany()->company_name }}</small>
        </div>
        <div class="col-auto">
            <div class="item-action dropdown">
                <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-more-vertical"></i></a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a href="/home/jobs/{{ $application->jobpost->id }}" class="dropdown-item"><i
                            class="dropdown-icon fe fe-eye"></i> View Jobpost </a>
                    <a href="{{ route('applications.show', ['application' => $application->id]) }}"
                       class="dropdown-item">
                        <i class="dropdown-icon fe fe-book"></i> View Application </a>
                    </a>
                    <a href="/home/companies/{{ $application->getCompany()->id }}" class="dropdown-item"><i
                            class="dropdown-icon fe fe-users"></i> Visit Company Profile </a>
                    <a href="{{ route('messages.create', ['recipient_email' => $application->getCompany()->email]) }}"
                       class="dropdown-item"><i
                            class="dropdown-icon fe fe-message-square"></i> Send Company a Message</a>
                </div>
            </div>
        </div>
    </div>
</li>
