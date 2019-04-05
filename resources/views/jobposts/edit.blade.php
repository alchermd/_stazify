@extends('layouts.dashboard')

@section ('content')
    <div class="my-3 my-md-5">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <form action="/home/jobs/{{ $jobpost->id }}" method="post" class="card">
                        @csrf
                        @method('put')

                        <div class="card-header">
                            <h3 class="card-title">Edit Jobpost</h3>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="form-group">
                                        <label for="title" class="form-label">Title</label>
                                        <input type="text"
                                               class="form-control {{ $errors->has('title') ? ' is-invalid' : '' }}"
                                               value="{{ old('title')  ?? $jobpost->title }}"
                                               placeholder="Web Development Internship"
                                               name="title" id="title" required>

                                        @if ($errors->has('title'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('title') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea
                                            rows="5"
                                            class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }}"
                                            placeholder="An internship position for CS/IT students with web development skills."
                                            name="description" id="description"
                                            required>{{ old('description') ?? $jobpost->description }}</textarea>

                                        @if ($errors->has('description'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('description') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="qualifications" class="form-label">Qualifications</label>
                                        <textarea
                                            rows="7"
                                            class="form-control {{ $errors->has('qualifications') ? ' is-invalid' : '' }}"
                                            name="qualifications" id="qualifications"
                                            required>{{ old('qualifications') ?? $formatter->renderQualifications() }}</textarea>
                                        <small class="form-text text-muted">
                                            <strong>NOTE:</strong>
                                            Separate each qualification by a new line by pressing <code>ENTER</code>.
                                        </small>


                                        @if ($errors->has('qualifications'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('qualifications') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="required_skills" class="form-label">Required Skills</label>
                                        <textarea
                                            rows="7"
                                            class="form-control {{ $errors->has('required_skills') ? ' is-invalid' : '' }}"
                                            name="required_skills" id="required_skills"
                                            required>{{ old('required_skills') ?? $formatter->renderSkills() }}</textarea>
                                        <small class="form-text text-muted">
                                            <strong>NOTE:</strong>
                                            Separate each qualification by a new line by pressing <code>ENTER</code>.
                                        </small>


                                        @if ($errors->has('required_skills'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('required_skills') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label class="form-label">Deadline</label>
                                        <div class="row gutters-xs">
                                            <div class="col-5">
                                                <select name="deadline_month" class="form-control custom-select"
                                                        required>
                                                    <option value="">Month</option>

                                                    @for ($i = 1; $i <= 12; $i++)
                                                        <option
                                                            value="{{ $i }}" {{ old('deadline_month') == $i ? 'selected' : $jobpost->deadline->month == $i ? 'selected' : '' }}>{{ date("F", mktime(0, 0, 0, $i, 1)) }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                            <div class="col-3">
                                                <select name="deadline_day" class="form-control custom-select" required>
                                                    <option value="">Day</option>
                                                    @for ($i = 1; $i <= 31; $i++)
                                                        <option
                                                            value="{{ $i }}" {{ old('deadline_day') == $i ? 'selected' : $jobpost->deadline->day == $i ? 'selected' : '' }}>{{ $i }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                            <div class="col-4">
                                                <select name="deadline_year" class="form-control custom-select"
                                                        required>
                                                    <option value="">Year</option>
                                                    @for ($i = 0; $i < 3; $i++)
                                                        @php ($year = Carbon\Carbon::now()->year + $i)
                                                        <option
                                                            value="{{ $year }}" {{ old('deadline_year') == $year ? 'selected' : $jobpost->deadline->year == $year ? 'selected' : ''}}>
                                                            {{ $year}}
                                                        </option>
                                                    @endfor
                                                </select>
                                            </div>

                                            <div class="col-auto">
                                                @if ($errors->has('deadline'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('deadline') }}</strong>
                                                    </span>
                                                @endif

                                                @if ($errors->has('deadline_month'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('deadline_month') }}</strong>
                                                    </span>
                                                @endif

                                                @if ($errors->has('deadline_day'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('deadline_day') }}</strong>
                                                    </span>
                                                @endif

                                                @if ($errors->has('deadline_year'))
                                                    <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('deadline_year') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <button class="btn btn-primary" type="submit">
                                            <span class="fa fa-check"></span> Update
                                        </button>
                                    </div>
                                </div>

                                <div class="col-lg-4">

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
