@extends ('layouts.front')

@section ('title', 'For Companies')

@section ('content')
    <div class="jumbotron company-jumbotron">
        <div class="container text-white translucent-background">
            <h1 class="display-4  home-shadow-text">Solve your problems with us.</h1>
            <p class="lead">
                With Stazify, you can find your next set of talented interns without the hassle and
                effort. Other job boards offer you a myriad of students from different backgrounds. What we have are
                ICT students &mdash; nothing more, nothing less. And they're waiting for you!
            </p>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-sm-8">
                <h2 class="mt-4 mb-4 display-5 h1 font-weight-bold">Find your solutions on Stazify</h2>

                <div style="font-size: 1.2em;">
                    <p>
                        We are a web app, a service, and a community, wherein you can easily search for dedicated
                        students taking up internships and IT Capstones that your company need. We provide you a
                        streamlined
                        way to
                        find a solution for your company problem and reduce your company expenses.
                    </p>
                    <p>
                        It all starts with you &#8212; you can help students to work with a real world of business
                        domain.
                        Give students the opportunity to explore
                        your field and gain experience. Your company will experience reduced time, effort and money for
                        hiring <em>soon to be</em> IT
                        experts. Project the best outcome for your company with the usability in mind.
                    </p>
                    <p>
                        Be <strong>safe, sure, and secured</strong> in finding potential candidates. Start by clicking
                        the
                        button below ⬇️
                    </p>
                </div>
                <p class="mt-4">
                    <a class="btn btn-primary btn-lg" href="/register/company">
                        <span class="fa fa-plus"></span>
                        Create a Company Account
                    </a>
                </p>
            </div>

            <div class="col-sm-4">
                <h2 class="mt-4 mb-4 text-center">Company Features</h2>
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold">
                        Create Jobposts <span>✔️</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold">
                        Track the Reach of Your Listings <span>✔️</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center font-weight-bold">
                        Browse Student Profiles <span>✔️</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection
