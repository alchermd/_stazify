@extends('layouts.dashboard')

@section('content')
    <div class="my-3 my-md-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card card-profile">
                        <div class="card-header"
                             style="background-color: darkslategray"></div>

                        <div class="card-body text-center">
                            <img class="card-profile-img" src="{{ $company->avatar_url }}">
                            <h3 class="mb-3">
                                {{ $company->company_name }}
                                @if ($company->isCompanyVerified())
                                    <span class="fe fe-check text-success" title="This company is verified"></span>
                                @elseif (auth()->id() === $company->id)
                                    <br>

                                    <a href="{{ route('company.verify.request.create') }}" class="btn btn-info btn-sm">
                                        Request for Verification
                                    </a>
                                @endif
                            </h3>

                            <p class="mb-3">
                                <span class="fa fa-cogs"></span> {{ $company->industry->name }}
                            </p>

                            <p class="mb-4">
                                <span class="fa fa-globe"></span>
                                <a href="{{ $company->website }}">{{ $company->website }}</a>
                            </p>

                            @if (auth()->user()->id !== $company->id)
                                <a href="{{ route('messages.create', ['recipient_email' => $company->email ]) }}"
                                   class="btn btn-outline-primary btn-sm">
                                    <span class="fa fa-envelope"></span> Message
                                </a>

                                @if (auth()->user()->isStudent())
                                    <button class="btn btn-outline-info btn-sm"
                                            id="like-button"
                                            style="display: {{ !auth()->user()->likes->contains($company) ? '' : 'none' }}">
                                        <span class="fa fa-thumbs-up"></span>
                                        <span class="like-count">
                                        </span>
                                        <span id="like-button-text">Like</span>
                                    </button>

                                    <button class="btn btn-info btn-sm"
                                            id="unlike-button"
                                            style="display: {{ auth()->user()->likes->contains($company) ? '' : 'none' }}">
                                        <span class="fa fa-thumbs-up"></span>
                                        <span class="like-count">
                                        </span>
                                        <span id="like-button-text">Unlike</span>
                                    </button>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-lg-8" dusk="company-info-card">
                    <div class="card">
                        <div class="card-header">
                            <h2 class="card-text">
                                Company Information
                            </h2>
                        </div>

                        <div class="card-body" style="font-size: 1.2em;">
                            <div>
                                <p>
                                    <strong>Official Name: </strong> {{ $company->company_name }}
                                </p>

                                <p>
                                    <strong>Address: </strong> <br>
                                    {!! nl2br($company->address) !!}
                                </p>

                                <p>
                                    <strong>Industry: </strong> {{ $company->industry->name }}
                                </p>

                                <p>
                                    <strong>About Us: </strong> <br>
                                    {!! nl2br($company->about) !!}
                                </p>
                            </div>

                            <hr>

                            <div>
                                <h3>Contact</h3>

                                <p>
                                    <strong>E-mail address:</strong>
                                    <a href="mailto:{{ $company->email }}">{{ $company->email }}</a>
                                </p>

                                <p>
                                    <strong>Contact Number:</strong>
                                    {{ $company->contact_number }}
                                </p>

                                <p>
                                    @if ($link = $company->website)
                                        <a href="{{ $link }}" class="btn btn-info">
                                            <span class="fa fa-external-link"></span> Company Website
                                        </a>
                                    @else
                                        span.
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    @if (auth()->user()->id === $company->id)
                        @include ('company-profile.edit')
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    @parent

    <script>
        const likeButton = document.getElementById('like-button');
        const unlikeButton = document.getElementById('unlike-button');
        const likeCountTexts = document.querySelectorAll('.like-count');
        likeCountTexts.forEach(e => {
            e.innerHTML = '{{ $company->likers->count() }}';
        });

        likeButton.addEventListener('click', () => {
            likeButton.setAttribute('disabled', 'true');
            unlikeButton.removeAttribute('disabled');

            fetch('{{ route('company.like', ['company' => $company->id]) }}', {
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector("meta[name='csrf-token']").getAttribute('content')
                },
                method: "POST"
            })
                .then(() => {
                    likeButton.style.display = 'none';
                    unlikeButton.style.display = '';

                    likeCountTexts.forEach(e => {
                        e.innerHTML = Number.parseInt(e.innerHTML) + 1;
                    });
                })
                .catch(err => console.log(err));
        });

        unlikeButton.addEventListener('click', () => {
            unlikeButton.setAttribute('disabled', 'true');
            likeButton.removeAttribute('disabled');

            fetch('{{ route('company.unlike', ['company' => $company->id]) }}', {
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector("meta[name='csrf-token']").getAttribute('content')
                },
                method: "POST"
            })
                .then(() => {
                    unlikeButton.style.display = 'none';
                    likeButton.style.display = '';

                    likeCountTexts.forEach(e => {
                        e.innerHTML = Number.parseInt(e.innerHTML) - 1;
                    });
                })
                .catch(err => console.log(err));
        });
    </script>
@endsection
