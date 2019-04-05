@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Choose Account Type</div>
                
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-6">
                            <a href="/register/student" class="btn btn-primary">Student Registration</a>
                        </div>
                        <div class="col-md-6">
                            <a href="/register/company" class="btn btn-secondary">Company Registration</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
