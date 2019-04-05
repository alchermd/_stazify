<div class="header bg-dark text-white py-4">
    <div class="container">
        <div class="d-flex">
            <a class="navbar-brand text-white" href="/"
               style="font-size: 24px; font-family: 'Leckerli One'; letter-spacing: 2.5px; font-weight: lighter;">
                Stazify
            </a>
            <div class="d-flex order-lg-2 ml-auto">
                <div class="dropdown d-none d-md-flex">
                    @include ('layouts.includes._notifications')
                </div>
                <div class="dropdown">
                    <a href="#" class="nav-link pr-0 leading-none" data-toggle="dropdown">
                                <span class="avatar"
                                      style="background-image: url('{{ auth()->user()->avatar_url }}')"></span>
                        <span class="ml-2 d-none d-lg-block">
                                <span
                                    class="text-white">
                                    {{ auth()->user()->company_name ?? auth()->user()->full_name }}
                                    @if (auth()->user()->isCompany() && auth()->user()->isCompanyVerified())
                                        <span class="fe fe-check text-success" title="This company is verified"></span>
                                    @endif
                                </span>

                                    <small class="text-muted d-block mt-1">
                                        {{ auth()->user()->account_type == 1 ? 'Student' : 'Company' }}
                                    </small>
                                </span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                        @if (auth()->user()->isStudent())
                            <a class="dropdown-item" href="/home/students/{{ auth()->id() }}">
                                <i class="dropdown-icon fe fe-user"></i> Profile
                            </a>
                        @elseif (auth()->user()->isCompany())
                            <a class="dropdown-item" href="/home/companies/{{ auth()->id() }}">
                                <i class="dropdown-icon fe fe-user"></i> Profile
                            </a>
                        @endif
                        <a class="dropdown-item" href="{{ route('settings.summary') }}">
                            <i class="dropdown-icon fe fe-settings"></i> Settings
                        </a>
                        <a class="dropdown-item" href="{{ route('messages.index') }}">
                            <i class="dropdown-icon fe fe-mail"></i> Inbox
                        </a>
                        <div class="dropdown-divider"></div>

                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            <i class="dropdown-icon fe fe-log-out"></i> Sign out
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                              style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
            <a href="#" class="header-toggler d-lg-none ml-3 ml-lg-0" data-toggle="collapse"
               data-target="#headerMenuCollapse">
                <span class="header-toggler-icon"></span>
            </a>
        </div>
    </div>
</div>
