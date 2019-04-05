@php($company = auth()->user())

<form class="card"
      action="/home/companies/{{ $company->id }}"
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
                    <label class="form-label" for="company_name">Company Name</label>
                    <input type="text"
                           class="form-control {{ $errors->has('company_name') ? ' is-invalid' : '' }}"
                           placeholder="Company Name"
                           name="company_name"
                           id="company_name"
                           value="{{ old('company_name') ?? $company->company_name }}"
                           required>

                    @if ($errors->has('company_name'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('company_name') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="col-sm-6 col-md-6">
                <div class="form-group">
                    <label class="form-label" for="website">Website</label>
                    <input type="url"
                           class="form-control {{ $errors->has('website') ? ' is-invalid' : '' }}"
                           placeholder="Website URL"
                           name="website"
                           id="website"
                           value="{{ old('website') ?? $company->website }}">

                    @if ($errors->has('website'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('website') }}</strong>
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
                              required>{{ old('address') ?? $company->address }}</textarea>

                    @if ($errors->has('address'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('address') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="col-md-4">
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
                               value="{{ old('contact_number') ?? substr($company->contact_number, 4) }}"
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

            <div class="col-sm-6 col-md-4">
                <div class="form-group">
                    <label for="industry_id"
                           class="form-label">Industry</label>

                    <select name="industry_id" id="industry_id"
                            class="custom-select {{ $errors->has('industry_id') ? ' is-invalid' : '' }}">
                        <option disabled selected>Select Industry...</option>

                        @foreach ($industries as $industry)
                            <option value="{{ $industry->id }}"
                                {{ old('industry_id') === $industry->id ? 'selected' : $company->industry->id === $industry->id ? 'selected' : '' }}>
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
                    <label class="form-label" for="about">About Us</label>

                    <textarea id="about"
                              class="form-control{{ $errors->has('about') ? ' is-invalid' : '' }}"
                              placeholder="Tell us something about your company."
                              rows="7" name="about" required>{{ old('about') ?? $company->about }}</textarea>

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
