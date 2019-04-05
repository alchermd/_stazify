@extends('layouts.dashboard')

@section ('content')
    <div class="my-3 my-md-5">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <form action="{{ route('company.verify.request', ['user' => auth()->id()]) }}" method="post"
                          class="card"
                          enctype="multipart/form-data">
                        @csrf

                        <div class="card-header">
                            <h3 class="card-title">Request for validation</h3>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="form-group">
                                        <label for="title" class="form-label">Message</label>
                                        <textarea type="text"
                                                  class="form-control {{ $errors->has('message') ? ' is-invalid' : '' }}"
                                                  placeholder="In a couple of sentences, describe what the attached files are and how it verifies your company's authenticity."
                                                  rows="5"
                                                  name="message" id="message" required>{{ old('message') }}</textarea>

                                        @if ($errors->has('message'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('message') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <input type="file"
                                               accept=".png, .jpg, .jpeg, .pdf, .doc, .docx, .zip"
                                               class="form-control-file {{ $errors->has('attachment') ? ' is-invalid' : '' }}"
                                               id="attachment" name="attachment" required>

                                        <small class="form-text text-muted">
                                            We accept JPG, PNG, PDF, and DOC formats. You also send a zip file if you
                                            need to send multiple files.
                                        </small>

                                        @if ($errors->has('attachment'))
                                            <span class="invalid-feedback" role="alert" style="display: block;">
                                                <strong>{{ $errors->first('attachment') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <button class="btn btn-primary" type="submit">
                                            <span class="fa fa-check"></span> Submit Request
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
