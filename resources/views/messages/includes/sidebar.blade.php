<div class="col-md-3">
    <h3 class="page-title mb-5">Messages</h3>

    <div>
        <div class="list-group list-group-transparent mb-0">
            <a href="{{ route('messages.index') }}"
               class="list-group-item list-group-item-action d-flex align-items-center
                {{ starts_with(url()->current(), route('messages.index')) &&
                   !starts_with(url()->current(), route('sent-messages.index')) &&
                   !starts_with(url()->current(), route('trashed-messages.index')) ?
                   'active' : ''}}">

                <span class="icon mr-3"><i class="fe fe-inbox"></i></span>Inbox
                <span class="ml-auto badge badge-primary">
                    <span>{{ $unreadMessagesCount === 0 ? 'No' : $unreadMessagesCount }} unread messages</span>
                </span>
            </a>
            <a href="{{ route('sent-messages.index') }}" class="list-group-item list-group-item-action d-flex align-items-center
                {{ starts_with(url()->current(), route('sent-messages.index'))  ?
                   'active' : ''}}">

                <span class="icon mr-3"><i class="fe fe-send"></i></span>Outbox
                <span class="ml-auto badge badge-success">
                    <span>{{ $sentMessagesCount === 0 ? 'Empty' : $sentMessagesCount }}</span>
                </span>
            </a>
            <a href="{{ route('trashed-messages.index') }}" class="list-group-item list-group-item-action d-flex align-items-center
                {{ starts_with(url()->current(), route('trashed-messages.index'))  ?
                   'active' : ''}}">
                <span class="icon mr-3"><i class="fe fe-trash-2"></i></span>Trash
                <span class="ml-auto badge badge-danger">
                    <span>{{ $trashedMessagesCount === 0 ? 'Empty' : $trashedMessagesCount }}</span>
                </span>
            </a>
        </div>

        <div class="mt-6">
            <a href="{{ route('messages.create') }}" class="btn btn-secondary btn-block">Compose new Email</a>
        </div>
    </div>
</div>
