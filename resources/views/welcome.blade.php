@extends ('layouts.front')

@section ('content')
    <!-- Masthead -->
    <header class="masthead text-white text-center">
        <div class="overlay"></div>
        <div class="container">
            <div class="row p-3">
                <div class="col-xl-10 mx-auto">
                    <h1 class="home-shadow-text d-none d-sm-block">
                        <em id="type" class="mb-2 display-2"></em> <br>
                        Are you an ICT student? <br>
                        These fields <u>demand</u> computer interns.
                    </h1>

                    <h1 class="home-shadow-text d-block d-sm-none">
                        Companies are <u>demanding</u> <br> ICT students.
                    </h1>

                    <p class="h3 mt-3 mb-5">
                        <em><strong>Stazify</strong> got you covered! <br>
                            Sign up below to get started.️</em> ⬇️
                    </p>
                </div>
                <div class="col-md-10 col-lg-8 col-xl-7 mx-auto">
                    <form action="/register/student" method="get" class="mb-3">
                        <div class="form-row">
                            <div class="col-12 col-md-9 mb-2 mb-md-0">
                                <input type="email" name="email" class="form-control form-control-lg"
                                       placeholder="Enter your email...">
                            </div>
                            <div class="col-12 col-md-3">
                                <button type="submit" class="btn btn-block btn-lg btn-primary">Sign up!</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="col-xl-9 mx-auto mt-3">
                    <a href="/companies" class="text-light home-shadow-text">
                        <u>Are you a company that needs interns?</u>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Icons Grid -->
    <section class="features-icons bg-light text-center">
        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="features-icons-item mx-auto mb-5 mb-lg-0 mb-lg-3">
                        <div class="features-icons-icon d-flex">
                            <i class="icon-user-follow m-auto text-primary"></i>
                        </div>
                        <h3>Register</h3>
                        <p class="lead mb-0">Start by creating a <a href="/register/student">student account</a>.
                            Registration is free!</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="features-icons-item mx-auto mb-5 mb-lg-0 mb-lg-3">
                        <div class="features-icons-icon d-flex">
                            <i class="icon-organization m-auto text-primary"></i>
                        </div>
                        <h3>Browse</h3>
                        <p class="lead mb-0">
                            Once <a href="/login">logged in</a>, start applying to our partner companies for
                            internships.
                        </p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="features-icons-item mx-auto mb-0 mb-lg-3">
                        <div class="features-icons-icon d-flex">
                            <i class="icon-speech m-auto text-primary"></i>
                        </div>
                        <h3>Connect</h3>
                        <p class="lead mb-0">
                            Use our messaging system and track your project or application status.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Image Showcases -->
    <section class="showcase">
        <div class="container-fluid p-0">
            <div class="row no-gutters">

                <div class="col-lg-6 order-lg-2 text-white showcase-img"
                     style="background-image: url('img/bg-showcase-1.jpg');"></div>
                <div class="col-lg-6 order-lg-1 my-auto showcase-text">
                    <h2>Practicum & Internships</h2>
                    <p class="lead mb-0">Finding a good, reputable company to render your practicum is a delicate
                        process.
                        We sweat the small stuff and partnered with companies that will truly train, improve, and enrich
                        your skill set.</p>
                </div>
            </div>
            <div class="row no-gutters">
                <div class="col-lg-6 text-white showcase-img"
                     style="background-image: url('img/bg-showcase-2.jpg');"></div>
                <div class="col-lg-6 my-auto showcase-text">
                    <h2>Feel at Home</h2>
                    <p class="lead mb-0">
                        Whether it's searching for companies, messaging other students, or doing an advance query on
                        job listings depending on certain criteria, we make sure that you have all the tools you need
                        to find your next gig.
                    </p>
                </div>
            </div>
            <div class="row no-gutters">
                <div class="col-lg-6 order-lg-2 text-white showcase-img"
                     style="background-image: url('img/bg-showcase-3.jpg');"></div>
                <div class="col-lg-6 order-lg-1 my-auto showcase-text">
                    <h2>By Students, for Students</h2>
                    <p class="lead mb-0">We've built this website with the goal of making things easier for our fellow
                        students. We were once in your shoes; we know, we've been there!</p>
                </div>
            </div>
        </div>
    </section>

    <section class="features-icons text-center">
        <div class="container">
            <h2 class="mb-5">Our Partners</h2>
            <div class="row">
                <div class="col-lg-4">
                    <div class="features-icons-item mx-auto mb-5 mb-lg-0 mb-lg-3">
                        <img src="{{ asset('img/company1.png') }}" class="img-fluid">
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="features-icons-item mx-auto mb-5 mb-lg-0 mb-lg-3">
                        <img src="{{ asset('img/company2.png') }}" class="img-fluid">
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="features-icons-item mx-auto mb-5 mb-lg-0 mb-lg-3">
                        <img src="{{ asset('img/company3.png') }}" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="testimonials text-center bg-dark text-white">
        <div class="container">
            <h2 class="mb-5">Testimonials</h2>
            <div class="row">
                <div class="col-lg-4">
                    <div class="testimonial-item mx-auto mb-5 mb-lg-0">
                        <img class="img-fluid rounded-circle mb-3" src="img/testimonials-1.jpg" alt="">
                        <h5>Raymond Pagtalunan</h5>
                        <p class="font-weight-light mb-0">"I found a company for my internship within a week without
                            sifting
                            through uninterested companies. Thanks, Stazify!"</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="testimonial-item mx-auto mb-5 mb-lg-0">
                        <img class="img-fluid rounded-circle mb-3" src="img/testimonials-2.jpg" alt="">
                        <h5>Bernadette Tolentino</h5>
                        <p class="font-weight-light mb-0">"Stazify made it easy for us to find a reputable company.
                            All the communication is done within the website, making the experience more
                            streamlined."</p>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="testimonial-item mx-auto mb-5 mb-lg-0">
                        <img class="img-fluid rounded-circle mb-3" src="img/testimonials-3.jpg" alt="">
                        <h5>Jessa Domingo</h5>
                        <p class="font-weight-light mb-0">"With Stazify, we've been able to focus on honing our skills
                            instead of finding a company that matches our needs"</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="call-to-action text-white text-center">
        <div class="overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-xl-9 mx-auto">
                    <h2 class="mb-4">Ready to get started? Sign up now!</h2>
                </div>
                <div class="col-md-10 col-lg-8 col-xl-7 mx-auto">
                    <form action="/register/student" method="get">
                        <div class="form-row">
                            <div class="col-12 col-md-9 mb-2 mb-md-0">
                                <input type="email" name="email" class="form-control form-control-lg"
                                       placeholder="Enter your email...">
                            </div>
                            <div class="col-12 col-md-3">
                                <button type="submit" class="btn btn-block btn-lg btn-primary">Sign up!</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/typeit/5.10.7/typeit.min.js"></script>
    <script>
        new TypeIt('#type', {
            strings: [
                "Finance & Accounting",
                "Administration",
                "Engineering",
                "Arts & Sports",
                "Customer Service",
                "Education",
                "IT & Software",
                "Legal",
                "Sciences"
            ],
            speed: 100,
            breakLines: false,
            autoStart: true,
            loop: true,
            nextString: 1000,
        });
    </script>
@endsection
