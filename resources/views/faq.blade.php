@extends ('layouts.front')

@section('title', 'FAQ / About')

@section ('content')
    <div class="jumbotron faq-jumbotron">
        <div class="container text-white translucent-background">
            <h1 class="display-4  home-shadow-text">Frequently Asked Questions</h1>
            <p class="lead">We all have questions. Lets get some of yours answered.</p>
        </div>
    </div>

    <div class="container mb-3">
        <div class="row">
            <div class="col-sm-8 offset-2">
                <h2 class="mt-4 mb-4 display-5 h1 font-weight-bold text-center">So I was thinking ...</h2>

                <ul class="list-group">
                    <li class="list-group-item h3"
                        data-toggle="collapse"
                        data-target="#collapseFAQ1">
                        How do I start using Stazify?
                    </li>
                    <div class="collapse" id="collapseFAQ1">
                        <li class="list-group-item">
                            <p>
                                Once you have registered for a <a href="/register/students">student account</a>, you
                                need to
                                confirm your account by following the instructions included with the e-mail sent to the
                                e-mail address you registered with. After the confirmation process, you can now start
                                using
                                <a href="/home">Stazify</a>!
                            </p>

                            <p>
                                Are you company? Please visit the <a href="/companies">companies</a> page for more
                                information.
                            </p>
                        </li>
                    </div>


                    <li class="list-group-item h3"
                        data-toggle="collapse"
                        data-target="#collapseFAQ2">
                        How much does posting a job listing cost?
                    </li>
                    <div class="collapse" id="collapseFAQ2">
                        <li class="list-group-item">
                            <p>
                                Absolutely free! <sup>*</sup>
                            </p>
                            <p>
                                As a company, you can post as many job listings as you need to fill your
                                vacancies. Students are also allowed to send applications to multiple jobs.
                            </p>
                            <p>
                                <small><sup>*</sup> may change without prior notice.</small>
                            </p>
                        </li>
                    </div>

                    <li class="list-group-item h3"
                        data-toggle="collapse"
                        data-target="#collapseFAQ3">
                        How do I contact a company directly?
                    </li>
                    <div class="collapse" id="collapseFAQ3">
                        <li class="list-group-item">
                            <p>
                                You can either use the <a href="{{ route('messages.create') }}">messaging system</a> by
                                searching
                                for the company and clicking the <strong>"Message"</strong> button.

                                Alternatively, the company's e-mail address, website, and contact number are also seen
                                at
                                their profile (if provided).
                            </p>
                        </li>
                    </div>
                </ul>
            </div>
        </div>
    </div>
@endsection
