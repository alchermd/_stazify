@extends('layouts.dashboard')

@section('content')
    <div class="my-3 my-md-5">
        <div class="container">
            <div class="page-header">
                <h2>
                    Student Search Results
                </h2>
            </div>

            <hr>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        @if ($students)
                            <div class="card-status bg-blue mb-2"></div>
                            <div class="card-header">
                                <p class="card-text lead">{{ $students->count() }} search results.</p>
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
                                        <th>Student Name</th>
                                        <th>Email</th>
                                        <th>Address</th>
                                        <th>School</th>
                                        <th>Course</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse ($students as $student)
                                        <tr>
                                            <td>
                                                <span class="avatar"
                                                      style="background-image: url('{{ $student->avatar_url }}')"></span>
                                            </td>
                                            <td>
                                                <a href="/home/companies/{{ $student->id }}">{{ $student->name }}</a>
                                            </td>
                                            <td>
                                                <a href="{{ route('messages.create', ['recipient_email' => $student->email]) }}">
                                                    {{ $student->email }}
                                                </a>
                                            </td>
                                            <td>
                                                {{ $student->address }}
                                            </td>
                                            <td>
                                                {{ $student->school }}
                                            </td>
                                            <td>
                                                {{ $student->course->name }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr class="text-center">
                                            <td colspan="100">
                                                <h3 class="card-text  mt-3 mb-3">
                                                    No students found.
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
