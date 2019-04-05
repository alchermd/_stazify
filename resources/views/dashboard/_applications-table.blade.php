<li class="list-separated-item">
    <div class="row align-items-center">
        <div class="col-auto">
            <span class="avatar avatar-md d-block"
                  style="background-image: url('{{ $application->user->avatar_url  }}')"></span>
        </div>
        <div class="col">
            <div>
                <a href="/home/students/{{ $application->user->id }}"
                   class="{{ $application->isCancelled() ? 'text-muted' : 'text-inherit' }}">
                    {{ $application->user->first_name }} {{ $application->user->last_name }}
                </a>
            </div>
            <small class="d-block item-except text-sm text-muted h-1x">{{ $application->user->course->name }}</small>
        </div>

        <div class="col">
            <div>
                <a href="/home/jobs/{{ $application->jobpost->id }}" class="text-inherit">
                    {{ $application->jobpost->title  }}
                </a>
            </div>
            <small class="d-block item-except text-sm text-muted h-1x">
                Posted {{ $application->jobpost->created_at->toFormattedDateString() }}
            </small>
        </div>


        <div class="col-auto">
            <div class="item-action dropdown">
                <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-more-vertical"></i></a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a href="{{ route('applications.show', ['application' => $application->id]) }}" class="dropdown-item"><i
                            class="dropdown-icon fe fe-eye"></i> View Application </a>
                    <a href="/home/students/{{ $application->user->id }}" class="dropdown-item"><i
                            class="dropdown-icon fe fe-users"></i> Visit Student Profile </a>
                    <a href="{{ route('messages.create', ['recipient_email' => $application->user->email]) }}" class="dropdown-item"><i
                            class="dropdown-icon fe fe-message-square"></i> Send Student a Message</a>
                </div>
            </div>
        </div>
    </div>
</li>
