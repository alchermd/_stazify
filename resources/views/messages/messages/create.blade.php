@extends('layouts.dashboard')

@section('content')
    <div class="my-3 my-md-5">
        <div class="container">
            <div class="row">
                @include ('messages.includes.sidebar')

                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Compose new message</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('messages.store') }}" method="post">
                                @csrf

                                <div class="form-group">
                                    <div class="row align-items-center">
                                        <label for="recipient_email" class="col-sm-2">To:</label>
                                        <div class="col-sm-10">
                                            <input type="email" class="form-control" name="recipient_email"
                                                   id="recipient_email"
                                                   value="{{ $recipientEmail ?? old('recipient_email') }}" required>

                                            @if ($errors->has('recipient_email'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('recipient_email') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="row align-items-center">
                                        <label class="col-sm-2" for="subject">Subject:</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" name="subject" id="subject"
                                                   value="{{ $subject ?? old('subject') }}"
                                                   required>

                                            @if ($errors->has('subject'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('subject') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <textarea rows="10" class="form-control" name="body"
                                          required>{{ old('body') }}</textarea>

                                @if ($errors->has('body'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('body') }}</strong>
                                    </span>
                                @endif

                                <div class="btn-list mt-4 text-right">
                                    <button type="submit" class="btn btn-primary btn-space">Send message</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
