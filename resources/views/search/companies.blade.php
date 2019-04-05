@extends('layouts.dashboard')

@section('content')
    <div class="my-3 my-md-5">
        <div class="container">
            <div class="page-header">
                <h2>
                    Company Search Results
                </h2>
            </div>

            <hr>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        @if ($companies)
                            <div class="card-status bg-blue mb-2"></div>
                            <div class="card-header">
                                <p class="card-text lead">{{ $companies->count() }} search results.</p>
                            </div>
                        @else
                            <div class="card-status bg-red mb-2"></div>
                        @endif

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-outline table-vcenter text-nowrap card-table">
                                    <thead>
                                    <tr>
                                        <th></th>
                                        <th>Company Name</th>
                                        <th>Email</th>
                                        <th>Address</th>
                                        <th>Website</th>
                                        <th>Industry</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse ($companies as $company)
                                        <tr>
                                            <td>
                                                <span class="avatar"
                                                      style="background-image: url('{{ $company->avatar_url }}')"></span>
                                            </td>
                                            <td>
                                                <a href="/home/companies/{{ $company->id }}">
                                                    {{ $company->name }}
                                                    @if ($company->isCompanyVerified())
                                                        <span class="fe fe-check text-success" title="This company is verified"></span>
                                                    @endif
                                                </a>
                                            </td>
                                            <td>
                                                <a href="{{ route('messages.create', ['recipient_email' => $company->email]) }}">
                                                    {{ $company->email }}
                                                </a>
                                            </td>
                                            <td>
                                                {{ $company->address }}
                                            </td>
                                            <td>
                                                <a href="{{ $company->website }}" class="btn btn-outline-primary">
                                                    Open New Tab <span class="fe fe-external-link"></span>
                                                </a>
                                            </td>
                                            <td>
                                                {{ $company->industry->name }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr class="text-center">
                                            <td colspan="100">
                                                <h3 class="card-text  mt-3 mb-3">
                                                    No companies found.
                                                </h3>
                                            </td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
