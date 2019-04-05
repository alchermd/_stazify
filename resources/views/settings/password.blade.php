@extends('layouts.dashboard')

@section('content')
    <div class="my-3 my-md-5">
        <div class="container">
            <div class="row">
                @include ('settings.includes.sidebar')

                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-text">Password Settings</h2>
                        </div>

                        <div class="card-body">
                            <div class="form-label">Reset your Password</div>

                            <div class="row">
                                <div class="col-6">
                                    <form method="POST" action="{{ route('settings.password.change') }}">
                                        @csrf

                                        <div class="form-group">
                                            <label for="current_password">Current Password</label>

                                            <input type="password" class="form-control" name="current_password"
                                                   id="current_password" required>

                                            @if ($errors->has('current_password'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('current_password') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label for="new_password">New Password</label>

                                            <input type="password" class="form-control" name="new_password"
                                                   id="new_password" required>

                                            @if ($errors->has('new_password'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('new_password') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <div class="form-group">
                                            <label for="new_password_confirmation">Confirm New Password</label>

                                            <input type="password" class="form-control"
                                                   name="new_password_confirmation"
                                                   id="new_password_confirmation" required>
                                        </div>

                                        <div class="form-group">
                                            <input type="submit" value="Change Password" class="btn btn-primary">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
