@extends ('layouts.error')

@section ('content')
    <div class="display-1 text-muted mb-5"><i class="si si-exclamation"></i> 400</div>
    <h1 class="h2 mb-3">Oops.. You just found an error page..</h1>
    <p class="h4 text-muted font-weight-normal mb-7">We are sorry but your request contains bad syntax and cannot be
        fulfilled&hellip;</p>
    <a class="btn btn-primary" href="javascript:history.back()">
        <i class="fe fe-arrow-left mr-2"></i>Go back
    </a>
@endsection