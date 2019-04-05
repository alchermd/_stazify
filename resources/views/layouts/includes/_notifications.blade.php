<a class="nav-link icon" data-toggle="dropdown">
    <i class="fe fe-bell"></i>
    @if (!auth()->user()->unreadNotifications->isEmpty())
        <span class="nav-unread"></span>
    @endif
</a>
<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
    @forelse (auth()->user()->unreadNotifications as $notification)
        <div class="dropdown-item d-flex">
            <a href="{{ $notification->data['image_link'] }}"
               class="avatar mr-3 align-self-center"
               style="background-image: url({{ $notification->data['image'] }})"></a>

            <div>
                <a href="{{ $notification->data['message_link'] }}" class="text-inherit">
                    {!! $notification->data['message'] !!}
                </a>
                <div class="small text-muted">{{ $notification->created_at->diffForHumans() }}</div>
            </div>
        </div>
    @empty
        <span class="dropdown-item">No notifications.</span>
    @endforelse

    @if (!auth()->user()->unreadNotifications->isEmpty())
        <div class="dropdown-divider"></div>
            <form action="/home/notifications" method="post">
                @csrf
                @method ('delete')

                <input type="submit" class="dropdown-item text-center text-muted-dark" value="Mark all as read">
            </form>
    @endif
</div>
