<div class="header bg-azure-dark text-white collapse d-lg-flex p-0" id="headerMenuCollapse">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-3 text-right ml-auto">
                <button class="btn btn-info" data-toggle="modal"  data-target="#searchModal">
                    <span class="fe fe-search"></span> Search
                </button>

                @include('modals.search-modal')
            </div>

            <div class="col-lg order-lg-first">
                <ul class="nav nav-tabs border-0 flex-column flex-lg-row">
                    <li class="nav-item">
                        <a href="/home"
                           class="text-white nav-link {{ request()->path() == 'home'  ? 'active' : '' }}">
                            <i class="fe fe-home"></i>
                            Home
                        </a>
                    </li>

                    @if (auth()->user()->isCompany())
                        <li class="nav-item dropdown">
                            <a href="javascript:void(0)"
                               class="text-white nav-link {{ starts_with(request()->path(), "home/jobs") ? 'active' : '' }} {{ starts_with(request()->path(), "home/applications") ? 'active' : '' }}"
                               data-toggle="dropdown">
                                <i class="fe fe-list"></i>
                                My Posts
                            </a>

                            <div class="dropdown-menu dropdown-menu-arrow">
                                <a href="/home/jobs" class="dropdown-item ">Jobs</a>
                                <a href="/home/applications" class="dropdown-item ">Applications</a>
                            </div>
                        </li>

                    @elseif (auth()->user()->isStudent())
                        <li class="nav-item">
                            <a href="javascript:void(0)"
                               class="text-white nav-link {{ starts_with(request()->path(), "home/jobs") ? 'active' : '' }} {{ starts_with(request()->path(), "home/applications") ? 'active' : '' }}"
                               data-toggle="dropdown">
                                <i class="fe fe-list"></i>
                                Jobs
                            </a>

                            <div class="dropdown-menu dropdown-menu-arrow">
                                <a href="/home/jobs" class="dropdown-item ">Find Jobs</a>
                                <a href="/home/applications" class="dropdown-item ">Applications</a>
                            </div>
                        </li>
                    @endif

                    <li class="nav-item">
                        <a href="{{ route('messages.index') }}"
                           class="text-white nav-link {{ starts_with(request()->path(), "home/messages") ? 'active' : '' }}">
                            <i class="fe fe-inbox"></i>
                            Messages
                        </a>
                        @if ($unreadMessagesCount)
                            <span class="badge badge-info"> {{ $unreadMessagesCount }}</span>
                        @endif
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
