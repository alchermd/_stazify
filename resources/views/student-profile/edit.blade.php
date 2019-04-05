@php($student = auth()->user())

<form class="card"
      action="/home/students/{{ $student->id }}"
      method="post"
      enctype="multipart/form-data">

    @csrf
    @method('PUT')

    <div class="card-header">
        <h3 class="card-text">Edit Profile</h3>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-sm-6 col-md-6">
                <div class="form-group">
                    <label class="form-label" for="first_name">First Name</label>
                    <input type="text"
                           class="form-control {{ $errors->has('first_name') ? ' is-invalid' : '' }}"
                           placeholder="First Name"
                           name="first_name"
                           id="first_name"
                           value="{{ old('first_name') ?? $student->first_name }}"
                           required>

                    @if ($errors->has('first_name'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('first_name') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="col-sm-6 col-md-6">
                <div class="form-group">
                    <label class="form-label" for="last_name">Last Name</label>
                    <input type="text"
                           class="form-control {{ $errors->has('last_name') ? ' is-invalid' : '' }}"
                           placeholder="Last Name"
                           name="last_name"
                           id="last_name"
                           value="{{ old('last_name') ?? $student->last_name }}">

                    @if ($errors->has('last_name'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('last_name') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label class="form-label" for="address">Address</label>

                    <textarea id="address"
                              placeholder="Kawit, Cavite"
                              class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}"
                              id="address"
                              name="address"
                              rows="5"
                              required>{{ old('address') ?? $student->address }}</textarea>

                    @if ($errors->has('address'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('address') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="col-md-5">
                <div class="form-group">
                    <label class="form-label" for="contact_number">Contact Number</label>

                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">+639</span>
                        </div>
                        <input type="number"
                               placeholder="123456789"
                               name="contact_number"
                               id="contact_number"
                               value="{{ old('contact_number') ?? substr($student->contact_number, 4) }}"
                               class="form-control {{ $errors->has('contact_number') ? ' is-invalid' : '' }}"
                               required>

                        @if ($errors->has('contact_number'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('contact_number') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-3">
                <div class="form-group">
                    <label class="form-label" for="age">Age</label>
                    <input type="number" min="0"
                           class="form-control {{ $errors->has('age') ? ' is-invalid' : '' }}"
                           placeholder="18"
                           name="age"
                           id="age"
                           value="{{ old('age') ?? $student->age }}">

                    @if ($errors->has('age'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('age') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="col-sm-6 col-md-4">
                <div class="form-group">
                    <label class="form-label" for="resume">Resume</label>

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

            <div class="col-sm-6 col-md-4">
                <div class="form-group">
                    <label class="form-label" for="course_id">Course</label>

                    <select name="course_id" id="course_id"
                            class="custom-select {{ $errors->has('course_id') ? ' is-invalid' : '' }}">
                        <option selected disabled>Select Course...</option>
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}"
                                {{ old('course_id') === $course->id  ? 'selected' :  $student->course->id === $course->id ? 'selected' : '' }}>
                                {{ $course->name }}
                            </option>
                        @endforeach
                    </select>

                    @if ($errors->has('course_id'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('course_id') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="col-sm-6 col-md-4">
                <div class="form-group">
                    <label class="form-label" for="school">School</label>

                    <input type="text"
                           placeholder="University of the Philippines"
                           name="school"
                           id="school"
                           value="{{ old('school') ?? $student->school }}"
                           class="form-control {{ $errors->has('school') ? ' is-invalid' : '' }}"
                           required>

                    @if ($errors->has('school'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('school') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="col-sm-6 col-md-4">
                <div class="form-group">
                    <label class="form-label" for="avatar">Profile Picture</label>

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

            <div class="col-md-12">
                <div class="form-group">
                    <label class="form-label" for="about">About Me</label>

                    <textarea id="about"
                              class="form-control{{ $errors->has('about') ? ' is-invalid' : '' }}"
                              placeholder="Tell us something about yourself."
                              rows="7" name="about" required>{{ old('about') ?? $student->about }}</textarea>

                    @if ($errors->has('about'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('about') }}</strong>
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="card-footer text-right">
        <input type="submit" class="btn btn-primary" value="Update Profile">
    </div>
</form>
