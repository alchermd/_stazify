@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h2 class="text-center">Create a Student Account</h2>
                    </div>

                    <div class="card-body" id="app">
                        <form method="POST" action="/register/student" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="account_type" value="1">

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
                                               name="email" value="{{ old('email') ?? $email }}" required autofocus>

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
                                    <span class="fa fa-user"></span> Personal Details
                                </h3>
                                <hr>

                                <div class="form-group row">
                                    <label for="first_name"
                                           class="col-md-4 col-form-label text-md-right">First Name</label>

                                    <div class="col-md-6">
                                        <input id="first_name" type="text"
                                               placeholder="Juan"
                                               class="form-control{{ $errors->has('first_name') ? ' is-invalid' : '' }}"
                                               name="first_name" value="{{ old('first_name') }}" required>

                                        @if ($errors->has('first_name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('first_name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="last_name"
                                           class="col-md-4 col-form-label text-md-right">Last Name</label>

                                    <div class="col-md-6">
                                        <input id="last_name" type="text"
                                               placeholder="Dela Cruz"
                                               class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}"
                                               name="last_name" value="{{ old('last_name') }}" required>

                                        @if ($errors->has('last_name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('last_name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="age"
                                           class="col-md-4 col-form-label text-md-right">Age</label>

                                    <div class="col-md-6">
                                        <input id="age" type="number"
                                               placeholder="19"
                                               min="15"
                                               class="form-control{{ $errors->has('age') ? ' is-invalid' : '' }}"
                                               name="age" value="{{ old('age') }}" required>

                                        @if ($errors->has('age'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('age') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="address" class="col-md-4 col-form-label text-md-right">Address</label>

                                    <div class="col-md-6">
                                        <textarea id="address"
                                                  placeholder="Kawit, Cavite"
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
                                    <label for="about" class="col-md-4 col-form-label text-md-right">About Me</label>

                                    <div class="col-md-6">
                                        <textarea id="about"
                                                  class="form-control{{ $errors->has('about') ? ' is-invalid' : '' }}"
                                                  placeholder="Tell us something about yourself."
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
                            </div>

                            <div class="mt-5">
                                <h3 class="font-weight-bold">
                                    <span class="fa fa-cogs"></span> Technical Information
                                </h3>
                                <hr>

                                <div class="form-group row">
                                    <label for="school" class="col-md-4 col-form-label text-md-right">School</label>

                                    <div class="col-md-6">
                                        <input id="school" type="text"
                                               placeholder="University of the Philippines"
                                               class="form-control{{ $errors->has('school') ? ' is-invalid' : '' }}"
                                               name="school" value="{{ old('school') }}" required>

                                        @if ($errors->has('school'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('school') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="course_id" class="col-md-4 col-form-label text-md-right">Course</label>

                                    <div class="col-md-6">
                                        <select name="course_id" id="course_id"
                                                class="custom-select {{ $errors->has('course_id') ? ' is-invalid' : '' }}">
                                            <option selected disabled>Select Course...</option>

                                            @foreach ($courses as $course)
                                                <option value="{{ $course->id }}"
                                                    {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                                    {{ $course->name }}
                                                </option>
                                            @endforeach
                                        </select>

                                        @if ($errors->has('course_id'))
                                            <div class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('course_id') }}</strong>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="resume" class="col-md-4 col-form-label text-md-right">Resumé /
                                        CV</label>

                                    <div class="col-md-6">
                                        <input type="file"
                                               accept=".pdf"
                                               class="form-control-file {{ $errors->has('resume') ? ' is-invalid' : '' }}"
                                               id="resume" name="resume">

                                        <small class="form-text text-muted">
                                            We accept PDF files.
                                        </small>

                                        @if ($errors->has('resume'))
                                            <span class="invalid-feedback" role="alert" style="display: block;">
                                                <strong>{{ $errors->first('resume') }}</strong>
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
