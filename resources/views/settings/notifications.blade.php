@extends('layouts.dashboard')

@section('content')
    <div class="my-3 my-md-5">
        <div class="container">
            <div class="row">
                @include ('settings.includes.sidebar')

                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-text">Notification Settings</h2>
                        </div>

                        <div class="card-body">
                            <div class="form-label">Update your Notification Preferences</div>

                            <form method="post" action="{{ route('settings.notification.update') }}">
                                @csrf
                                @method('patch')

                                <div class="form-group">
                                    <label class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input"
                                               name="wants_email_notifications"
                                                {{ $wantsEmailNotifications ? 'checked' : ''  }}>

                                        <span class="custom-control-label">
                                            I want to receive email notifications.
                                        </span>
                                    </label>
                                </div>

                                <div class="form-group">
                                    <input class="btn btn-primary" type="submit" value="Save">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
