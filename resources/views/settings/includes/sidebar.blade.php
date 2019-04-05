<div class="col-md-3">
    <h3 class="page-title mb-5">Account Settings</h3>
    <div>
        <div class="list-group list-group-transparent mb-0">
            <a href="{{ route('settings.summary') }}"
               class="list-group-item list-group-item-action d-flex align-items-center
                    {{ ends_with(url()->current(), 'summary') ? 'active' : '' }}">
                <span class="icon mr-3"><i class="fe fe-heart"></i></span> Summary
            </a>
            <a href="{{ route('settings.password') }}"
               class="list-group-item list-group-item-action d-flex align-items-center
                    {{ ends_with(url()->current(), 'password') ? 'active' : '' }}">
                <span class="icon mr-3"><i class="fe fe-clipboard"></i></span> Password
            </a>
            <a href="{{ route('settings.notification') }}" class="list-group-item list-group-item-action d-flex align-items-center
                    {{ ends_with(url()->current(), 'notifications') ? 'active' : '' }}">
                <span class="icon mr-3"><i class="fe fe-alert-circle"></i></span> Notifications
            </a>
        </div>
    </div>
</div>
