@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h2 class="text-center">Create a Company Account</h2>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="/register/company" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="account_type" value="2">

                            <div class="mt-3">
                                <h3 class="font-weight-bold">
                                    <span class="fa fa-laptop"></span> Login Credentials
                                </h3>
                                <hr>

                                <div class="form-group row">
                                    <label for="email"
                                           class="col-md-4 col-form-label text-md-right">E-mail Address</label>

                                    <div class="col-md-6">
                                        <input id="email" type="email"
                                               placeholder="myemail@example.com"
                                               class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                               name="email" value="{{ old('email') }}" required autofocus>

                                        @if ($errors->has('email'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password"
                                           class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                    <div class="col-md-6">
                                        <input id="password" type="password"
                                               placeholder="************"
                                               class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                               name="password" required>

                                        @if ($errors->has('password'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="password-confirm"
                                           class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                                    <div class="col-md-6">
                                        <input id="password-confirm" type="password" class="form-control"
                                               placeholder="************"
                                               name="password_confirmation" required>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-5">
                                <h3 class="font-weight-bold">
                                    <span class="fa fa-users"></span> Company Details
                                </h3>
                                <hr>

                                <div class="form-group row">
                                    <label for="company_name"
                                           class="col-md-4 col-form-label text-md-right">Company Name</label>

                                    <div class="col-md-6">
                                        <input id="company_name" type="text"
                                               placeholder="ACME Web Services"
                                               class="form-control{{ $errors->has('company_name') ? ' is-invalid' : '' }}"
                                               name="company_name" value="{{ old('company_name') }}" required>

                                        @if ($errors->has('company_name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('company_name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="address" class="col-md-4 col-form-label text-md-right">Address</label>

                                    <div class="col-md-6">
                                        <textarea id="address"
                                                  placeholder="Apalit, Pampanga"
                                                  class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}"
                                                  rows="5" name="address" required>{{ old('address') }}</textarea>

                                        @if ($errors->has('address'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('address') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="avatar" class="col-md-4 col-form-label text-md-right">Profile
                                        Picture</label>

                                    <div class="col-md-6">
                                        <input type="file"
                                               accept=".png, .jpg, .jpeg"
                                               class="form-control-file {{ $errors->has('avatar') ? ' is-invalid' : '' }}"
                                               id="avatar" name="avatar">

                                        <small class="form-text text-muted">
                                            We accept JPG and PNG formats.
                                        </small>

                                        @if ($errors->has('avatar'))
                                            <span class="invalid-feedback" role="alert" style="display: block;">
                                                <strong>{{ $errors->first('avatar') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="about" class="col-md-4 col-form-label text-md-right">About Us</label>

                                    <div class="col-md-6">
                                        <textarea id="about"
                                                  class="form-control{{ $errors->has('about') ? ' is-invalid' : '' }}"
                                                  placeholder="Tell us something about your company."
                                                  rows="7" name="about" required>{{ old('about') }}</textarea>

                                        @if ($errors->has('about'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('about') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="contact_number" class="col-md-4 col-form-label text-md-right">Contact
                                        Number</label>

                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">+639</span>
                                            </div>

                                            <contact-number
                                                placeholder="123456789"
                                                name="contact_number"
                                                id="contact_number"
                                                class="form-control {{ $errors->has('contact_number') ? ' is-invalid' : '' }}"
                                                value="{{ old('contact_number') }}"
                                                required>
                                            </contact-number>

                                            @if ($errors->has('contact_number'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('contact_number') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="website"
                                           class="col-md-4 col-form-label text-md-right">Website</label>

                                    <div class="col-md-6">
                                        <input id="website" type="text"
                                               class="form-control{{ $errors->has('website') ? ' is-invalid' : '' }}"
                                               name="website" value="{{ old('website') ?? "http://"}}">

                                        @if ($errors->has('website'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('website') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="industry_id"
                                           class="col-md-4 col-form-label text-md-right">Industry</label>

                                    <div class="col-md-6">
                                        <select name="industry_id" id="industry_id"
                                                class="custom-select {{ $errors->has('industry_id') ? ' is-invalid' : '' }}">
                                            <option disabled selected>Select Industry...</option>

                                            @foreach ($industries as $industry)
                                                <option value="{{ $industry->id }}"
                                                    {{ old('industry_id') === $industry->id ? 'selected' : '' }}>
                                                    {{ $industry->name }}
                                                </option>
                                            @endforeach
                                        </select>

                                        @if ($errors->has('industry_id'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('industry_id') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-0 mt-5">
                                <div class="col-md-6 offset-md-4">
                                    <input type="submit" class="btn btn-primary" value="Register">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('js')
    @parent

    <script src="/js/ContactNumber.js"></script>
@endsection
