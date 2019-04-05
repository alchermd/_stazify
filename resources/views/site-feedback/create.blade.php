@extends ('layouts.front')

@section ('title', 'Feedback / Contact')

@section ('content')
    <div class="jumbotron feedback-jumbotron">
        <div class="container text-white translucent-background">
            <h1 class="display-4  home-shadow-text">Feedback</h1>
            <p class="lead">Do you have any questions? Suggestions? Your thoughts are valuable to us.</p>
        </div>
    </div>

    <div class="container mb-3">
        <div class="row">
            <div class="col-sm-8 offset-2">
                <h2 class="mt-4 mb-4 display-5 h1 font-weight-bold text-center">What I really want to say is ...</h2>
                <form action="/feedback" method="post">
                    @csrf

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email"
                               name="email"
                               id="email"
                               class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                               value="{{ old('email') }}">

                        @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea name="message"
                                  id="message"
                                  class="form-control {{ $errors->has('message') ? 'is-invalid' : '' }}"
                                  rows="10">{{ old('message') }}</textarea>

                        @if ($errors->has('message'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('message') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group custom-control custom-checkbox">
                        <input type="checkbox" name="reply_me" id="reply_me" class="custom-control-input">
                        <label for="reply_me" class="custom-control-label">Reply to my email</label>
                    </div>

                    <div class="form-group">
                        <input type="submit" value="Send" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
