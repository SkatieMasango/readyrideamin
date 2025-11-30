<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <title>Ready Ride - Ride Sharing App</title>
        <meta name="description" content="Ready Ride - Ride Sharing App" />
        <link rel="shortcut icon" href="assets/images/logo/favicon.svg" type="image/f-icon" />

        <!-- Remix Icon -->
        {{-- <link rel="stylesheet" href="{{ 'assets/css/remixicon.css'}}"> --}}
        <link rel="stylesheet" href="assets/css/remixicon.css" />
        <!-- bootstraph -->
        {{-- <link rel="stylesheet" href="{{ 'assets/css/bootstrap.css'}}"> --}}
        <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
        <!-- Swiper Slider -->
       {{-- <link rel="stylesheet" href="{{ 'assets/css/swiper-bundle.min.css'}}"> --}}
        <link rel="stylesheet" href="assets/css/swiper-bundle.min.css" />
        <!-- Aos Animation -->
        {{-- <link rel="stylesheet" href="{{ 'assets/css/aos.css'}}"> --}}
        <link rel="stylesheet" href="assets/css/aos.css" />
        <!-- User's CSS Here -->
        {{-- <link rel="stylesheet" href="{{ 'assets/css/style.css'}}"> --}}
        <link rel="stylesheet" href="assets/css/style.css" />
    </head>
    <body>
        <!-- Header Start -->
        <header class="header">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <!-- Nav Start -->
                        <nav class="nav d-block p-0 m-0">
                            <div class="header__wrapper">
                                <!-- Header Logo -->
                                <div class="header__logo">
                                    <a href="index.html">
                                        <img src="assets/images/logo/logo-white.svg" alt="logo" />
                                    </a>
                                </div>
                                <!-- Header Menu Start -->
                                <div class="header__menu">
                                    <ul class="main__menu">
                                        <li><a class="active" href="index.html">Home</a></li>
                                        <li>
                                            <a href="#">About us</a>
                                        </li>
                                        <li><a href="#">Contact us</a></li>
                                        <li><a href="#">Privacy policy</a></li>

                                    </ul>
                                </div>
                                <!-- Header Menu End -->

                                <div class="header__right">
                                    <a href="#" class="rs-btn rs-btn-primary">Get The App</a>
                                    <a href="{{ route('dashboard')}}" class="rs-btn rs-btn-white">Go to Admin</a>
                                    <!-- Header Toggle -->
                                    <div class="header__toggle" data-bs-toggle="offcanvas" data-bs-target="#headerOffcanvas">
                                        <div class="toggle__bar"></div>
                                    </div>
                                </div>
                                <!-- Header Right List End -->
                            </div>
                        </nav>
                        <!-- Nav End -->
                    </div>
                </div>
            </div>
        </header>
        <!-- Header End -->

        <!-- Banner Section Start -->
        <section class="banner__section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="hero__text" data-aos="fade-up" data-aos-duration="700">
                            <h4 class="subtitle">
                                <span class="img__group">
                                    <img src="assets/images/user/avatar-01.png" alt="avatar" />
                                    <img src="assets/images/user/avatar-02.png" alt="avatar" />
                                    <img src="assets/images/user/avatar-03.png" alt="avatar" />
                                </span>
                                <span class="star">
                                    <i class="ri-star-fill"></i>
                                    <i class="ri-star-fill"></i>
                                    <i class="ri-star-fill"></i>
                                    <i class="ri-star-fill"></i>
                                    <i class="ri-star-fill"></i>
                                </span>
                                10k+ Reviews
                            </h4>
                            <h1 class="title">
                                The Only App <br />
                                You Need to Get <br />
                                Around Town Effortlessly
                            </h1>
                            <p class="desc">
                                Fast, affordable, and secure transportation with real-time tracking and multiple ride options — powered by our locally trusted platform.
                            </p>
                            <div class="btn__group">
                                <a href="#"><img src="assets/images/app-store-icon.png" alt="app" /></a>
                                <a href="#"><img src="assets/images/play-store-icon.png" alt="play" /></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="banner__thumb" data-aos="fade-up" data-aos-duration="800">
                            <img src="assets/images/banner/banner-thumb.png" alt="banner-thumb" />
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Banner Section End -->

        <!-- Why Choose Section Start -->
        <section class="choose__section py-60 py-sm-50">
            <div class="container">
                <div class="row align-items-center gy-5">
                    <div class="col-lg-5 col-md-6">
                        <div class="choose__thumb" data-aos="fade-up" data-aos-duration="800">
                            <img src="assets/images/choose/choose-thumb.jpg" alt="choose" />
                        </div>
                    </div>
                    <div class="col-lg-7 col-md-6">
                        <div class="section__title mb-25" data-aos="fade-up" data-aos-duration="700">
                            <h2 class="title">
                                Built for <br />
                                Seamless Journeys
                            </h2>
                            <p class="desc">
                                Customers can utilize the customer app to conveniently browse products, make purchases, track orders, and stay updated s, experience and fostering
                                brand loyalty.
                            </p>
                        </div>
                        <!-- List Item -->
                        <ul class="list__item" data-aos="fade-up" data-aos-duration="800">
                            <li>
                                <div class="icon">
                                    <img src="assets/images/choose/choose-icon-01.png" alt="icon" />
                                </div>
                                Live Ride Tracking
                            </li>
                            <li>
                                <div class="icon">
                                    <img src="assets/images/choose/Multiple-Ride-Options.png" alt="icon" />
                                </div>
                                Multiple Ride Options
                            </li>
                            <li>
                                <div class="icon">
                                    <img src="assets/images/choose/Cashless-Payments.png" alt="icon" />
                                </div>
                                Cashless Payments
                            </li>
                            <li>
                                <div class="icon">
                                    <img src="assets/images/choose/Instant-Notifications.png" alt="icon" />
                                </div>
                                Instant Notifications
                            </li>
                            <li>
                                <div class="icon">
                                    <img src="assets/images/choose/Ratings-&-Feedback.png" alt="icon" />
                                </div>
                                Ratings & Feedback
                            </li>
                            <li>
                                <div class="icon">
                                    <img src="assets/images/choose/Smart-Ride-Matching.png" alt="icon" />
                                </div>
                                Smart Ride Matching
                            </li>
                            <li>
                                <div class="icon">
                                    <img src="assets/images/choose/In-App-Chatting.png" alt="icon" />
                                </div>
                                In App Chatting
                            </li>
                            <li>
                                <div class="icon">
                                    <img src="assets/images/choose/Ride-History-&-Receipts.png" alt="icon" />
                                </div>
                                Ride History & Receipts
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
        <!-- Why Choose Section End -->

        <!-- App Section Start -->
        <section class="app__section py-60 py-sm-50">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="app__wrapper" data-aos="fade-up" data-aos-duration="800">
                            <div class="content__area">
                                <div class="section__title mb-25 text-white">
                                    <h2 class="title">
                                        Move Smarter <br />
                                        With Our Ride App
                                    </h2>
                                    <p class="desc">Take control of your travel with flexible ride options, real-time tracking, and simple payments — all in one app.</p>
                                </div>
                                <div class="appArea__flex">
                                    <div class="app__area">
                                        <div class="qr__code">
                                            <img src="assets/images/apps/qr-code-01.png" alt="qr" />
                                        </div>
                                        <div class="content">
                                            <div class="apps">
                                                <img src="assets/images/apps/app-store.png" alt="app" />
                                            </div>
                                            <a href="#" class="rs-btn rs-btn-primary">Download</a>
                                        </div>
                                    </div>
                                    <div class="app__area">
                                        <div class="qr__code">
                                            <img src="assets/images/apps/qr-code-01.png" alt="qr" />
                                        </div>
                                        <div class="content">
                                            <div class="apps">
                                                <img src="assets/images/apps/play-store.png" alt="app" />
                                            </div>
                                            <a href="#" class="rs-btn rs-btn-primary">Download</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="app__thumb">
                                <img src="assets/images/apps/apps-thumb.png" alt="apps" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- App Section End -->

        <!-- Feature Section Start -->
        <section class="feature__section py-60 py-sm-50">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <!-- Fearure Arapper -->
                        <div class="feature__wrapper" data-aos="fade-up" data-aos-duration="800">
                            <div class="section__title text-white text-center mb-0">
                                <h4 class="title how-ready">How Ready To Ride Works</h4>
                                <h5 class="subtitle">Book, Ride, Arrive!</h5>
                                <p class="desc">
                                    Our ride-share app makes transportation easy, convenient, and reliable for everyone. Follow these simple steps to get started today!
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" data-aos="fade-up" data-aos-duration="800">
                    <div class="col-lg-4 col-md-4 col-sm-6">
                        <div class="featureCard">
                            <div class="feature__head">
                                <div class="number">1</div>
                                <div class="icon">
                                    <img src="assets/images/feature/feature-icon-01.png" alt="icon" />
                                </div>
                            </div>
                            <div class="content">
                                <h4>Download & Install The App</h4>
                                <p>Get the app from the App Store or Google Play.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6">
                        <div class="featureCard">
                            <div class="feature__head">
                                <div class="number">2</div>
                                <div class="icon">
                                    <img src="assets/images/feature/feature-icon-02.png" alt="icon" />
                                </div>
                            </div>
                            <div class="content">
                                <h4>Sign Up or Log In</h4>
                                <p>Create your profile or log in to access ride services.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6">
                        <div class="featureCard">
                            <div class="feature__head">
                                <div class="number">3</div>
                                <div class="icon">
                                    <img src="assets/images/feature/feature-icon-03.png" alt="icon" />
                                </div>
                            </div>
                            <div class="content">
                                <h4>Set Pickup & Drop-off Locations</h4>
                                <p>Enter your destination and confirm your pickup point.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6">
                        <div class="featureCard">
                            <div class="feature__head">
                                <div class="number">4</div>
                                <div class="icon">
                                    <img src="assets/images/feature/feature-icon-04.png" alt="icon" />
                                </div>
                            </div>
                            <div class="content">
                                <h4>Choose Your Ride Option</h4>
                                <p>Select from economy, premium, or shared rides based on your needs.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6">
                        <div class="featureCard">
                            <div class="feature__head">
                                <div class="number">5</div>
                                <div class="icon">
                                    <img src="assets/images/feature/feature-icon-05.png" alt="icon" />
                                </div>
                            </div>
                            <div class="content">
                                <h4>Confirm & Track Your Ride</h4>
                                <p>Get matched with a driver, see their details, and track their arrival in real time.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6">
                        <div class="featureCard">
                            <div class="feature__head">
                                <div class="number">6</div>
                                <div class="icon">
                                    <img src="assets/images/feature/feature-icon-06.png" alt="icon" />
                                </div>
                            </div>
                            <div class="content">
                                <h4>Enjoy a Safe & Comfortable Ride</h4>
                                <p>Relax as your driver takes you to your destination.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Feature Section End -->

        <!-- Discover Section Start -->
        <section class="discover__section py-60 py-sm-50">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="discover__wrapper" data-aos="fade-up" data-aos-duration="800">
                            <div class="content__area">
                                <div class="section__title mb-0 text-white">
                                    <h2 class="title">
                                        Discover, <br />
                                        Ride & Arrive with Ease!
                                    </h2>
                                    <p class="desc mt-25">
                                        From quick commutes to premium rides, get everywhere you need to go—safely, affordably, and on time. Book, track, and enjoy hassle-free
                                        rides with seamless in-app payments.
                                    </p>
                                </div>
                            </div>
                            <div class="discover__thumb">
                                <img src="assets/images/discover/discover-thumb.png" alt="discover" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Discover Section End -->

        <!-- Who we are Section Start -->
        <section class="whoWeare__section py-60 py-sm-50">
            <div class="container">
                <div class="row">
                    <div class="col-lg-5 col-md-6">
                        <div class="wrapper__area" data-aos="fade-up" data-aos-duration="800">
                            <div class="thumb">
                                <img src="assets/images/who-we-are/thumb-01.jpg" alt="thumb" />
                            </div>
                            <div class="section__title mb-0 mt-25">
                                <h2 class="title text-primary">Our Story</h2>
                                <p class="desc">
                                    We are a locally rooted mobility solution built to connect people, reduce traffic congestion, and create earning opportunities. Our mission is
                                    to redefine transport with innovation, fairness, and convenience.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7 col-md-6">
                        <div class="wrapper__area pt-90" data-aos="fade-up" data-aos-duration="800">
                            <div class="section__title mb-25">
                                <h2 class="title text-primary">Who We Are</h2>
                                <p class="desc">
                                    We are a locally rooted mobility solution built to connect people, reduce traffic congestion, and create earning opportunities. Our mission is
                                    to redefine transport with innovation, fairness, and convenience.
                                </p>
                            </div>
                            <div class="thumb thumb__2">
                                <img src="assets/images/who-we-are/thumb-01.jpg" alt="thumb" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Who we are Section End -->

        <!-- CtaBox Section Start -->
        <section class="ctaBox__section py-60 py-sm-50">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="cta__wrapper" data-aos="fade-up" data-aos-duration="800">
                            <div class="cta__thumb">
                                <img src="assets/images/cta/cta-thumb.jpg" alt="cta" />
                            </div>
                            <div class="content__area">
                                <div class="section__title mb-0 text-white">
                                    <h4 class="subtitle">Join Now</h4>
                                    <h2 class="title">REGISTER AS Diver</h2>
                                    <p class="desc">Flexible, robust, and user-friendly—your learning solution for the future</p>
                                </div>
                                <div class="btn__group">
                                    <a href="#" class="rs-btn rs-btn-primary">Register Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- CtaBox Section End -->

        <!-- Testimonial Section Start -->
        <section class="testimonial__section py-60 py-sm-50">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="section__title text-center" data-aos="fade-up" data-aos-duration="800">
                            <h2 class="title">Our User Review</h2>
                            <p>
                                From certified courses to study kits, get everything you need to sharpen your skills and advance your career. Browse, purchase, and start learning
                                instantly with seamless in-app transactions.
                            </p>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="testimonial__inner" data-aos="fade-up" data-aos-duration="800">
                            <div class="swiper testimonial__slider">
                                <div class="swiper-wrapper">
                                    <!-- Slide -->
                                    <div class="swiper-slide">
                                        <!-- testimonialCard -->
                                        <div class="testimonialCard">
                                            <div class="avatar">
                                                <img src="assets/images/testimonial/avatar-01.png" alt="avatar" />
                                            </div>
                                            <div class="testimonialCard__content">
                                                <div class="header__flex">
                                                    <div class="">
                                                        <h5 class="title">Ralph Edwards</h5>
                                                        <div class="rating">
                                                            <i class="ri-star-fill active"></i>
                                                            5.0
                                                        </div>
                                                    </div>
                                                    <div class="date">01/04/2025</div>
                                                </div>
                                                <p>
                                                    I am proud to say that a few months after taking this course... I passed my exam and am now an AWS Certified Cloud Practitioner!
                                                    This content was exactly what was included in the CCP exam.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Slide -->
                                    <div class="swiper-slide">
                                        <!-- testimonialCard -->
                                        <div class="testimonialCard">
                                            <div class="avatar">
                                                <img src="assets/images/testimonial/avatar-02.png" alt="avatar" />
                                            </div>
                                            <div class="testimonialCard__content">
                                                <div class="header__flex">
                                                    <div class="">
                                                        <h5 class="title">Marvin McKinney</h5>
                                                        <div class="rating">
                                                            <i class="ri-star-fill active"></i>
                                                            5.0
                                                        </div>
                                                    </div>
                                                    <div class="date">01/04/2025</div>
                                                </div>
                                                <p>
                                                    I am proud to say that a few months after taking this course... I passed my exam and am now an AWS Certified Cloud Practitioner!
                                                    This content was exactly what was included in the CCP exam.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Slide -->
                                    <div class="swiper-slide">
                                        <!-- testimonialCard -->
                                        <div class="testimonialCard">
                                            <div class="avatar">
                                                <img src="assets/images/testimonial/avatar-01.png" alt="avatar" />
                                            </div>
                                            <div class="testimonialCard__content">
                                                <div class="header__flex">
                                                    <div class="">
                                                        <h5 class="title">Ralph Edwards</h5>
                                                        <div class="rating">
                                                            <i class="ri-star-fill active"></i>
                                                            5.0
                                                        </div>
                                                    </div>
                                                    <div class="date">01/04/2025</div>
                                                </div>
                                                <p>
                                                    I am proud to say that a few months after taking this course... I passed my exam and am now an AWS Certified Cloud Practitioner!
                                                    This content was exactly what was included in the CCP exam.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Slide -->
                                    <div class="swiper-slide">
                                        <!-- testimonialCard -->
                                        <div class="testimonialCard">
                                            <div class="avatar">
                                                <img src="assets/images/testimonial/avatar-02.png" alt="avatar" />
                                            </div>
                                            <div class="testimonialCard__content">
                                                <div class="header__flex">
                                                    <div class="">
                                                        <h5 class="title">Marvin McKinney</h5>
                                                        <div class="rating">
                                                            <i class="ri-star-fill active"></i>
                                                            5.0
                                                        </div>
                                                    </div>
                                                    <div class="date">01/04/2025</div>
                                                </div>
                                                <p>
                                                    I am proud to say that a few months after taking this course... I passed my exam and am now an AWS Certified Cloud Practitioner!
                                                    This content was exactly what was included in the CCP exam.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Swiper Navigation -->
                            <div class="swiper__navigation swiper-slide">
                                <div class="testimonial-swipe-prev swiper-button-prev">
                                    <i class="ri-arrow-left-circle-line"></i>
                                </div>
                                <div class="testimonial-swipe-next swiper-button-next">
                                    <i class="ri-arrow-right-circle-line"></i>
                                </div>
                            </div>
                            <!-- Swiper Navigation -->
                            <div class="swiper__pagination">
                                <div class="testimonial-pagination"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Testimonial Section End -->

        <!-- Accordion Section Start -->
        <section class="accordion__section py-60 py-sm-50">
            <div class="container">
                <div class="row align-items-center gy-4">
                    <div class="col-lg-6 col-md-6">
                        <div class="accordion__thumb" data-aos="fade-up" data-aos-duration="800">
                            <img src="assets/images/faq/faq-thumb.png" alt="faq" />
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6" data-aos="fade-up" data-aos-duration="800">
                        <div class="section__title mb-25">
                            <h2 class="title">
                                Frequently <br />
                                <span>Asked Questions</span>
                            </h2>
                        </div>
                        <div class="accordion__wrapper">
                            <div class="accordion" id="accordionExample">
                                <div class="accordion__item">
                                    <div class="accordion__header" id="headingOne">
                                        <button
                                            class="accordion-button"
                                            type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#collapseOne"
                                            aria-expanded="true"
                                            aria-controls="collapseOne"
                                        >
                                            How do I track my order?
                                        </button>
                                    </div>
                                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <div class="accordion__content">
                                                <p>
                                                    Lorem ipsum dolor, sit amet consectetur adipisicing elit. Minima expedita nesciunt explicabo velit sequi facere maiores illo
                                                    dolores in veritatis doloribus delectus non, amet temporibus, recusandae porro eum ullam possimus.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion__item">
                                    <div class="accordion__header" id="headingTwo">
                                        <button
                                            class="accordion-button collapsed"
                                            type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#collapseTwo"
                                            aria-expanded="false"
                                            aria-controls="collapseTwo"
                                        >
                                            Do you offer international shipping?
                                        </button>
                                    </div>
                                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <div class="accordion__content">
                                                <p>
                                                    Lorem ipsum dolor, sit amet consectetur adipisicing elit. Minima expedita nesciunt explicabo velit sequi facere maiores illo
                                                    dolores in veritatis doloribus delectus non, amet temporibus, recusandae porro eum ullam possimus.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion__item">
                                    <div class="accordion__header" id="headingThree">
                                        <button
                                            class="accordion-button collapsed"
                                            type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#collapseThree"
                                            aria-expanded="false"
                                            aria-controls="collapseThree"
                                        >
                                            How can I contact customer support?
                                        </button>
                                    </div>
                                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <div class="accordion__content">
                                                <p>
                                                    Lorem ipsum dolor, sit amet consectetur adipisicing elit. Minima expedita nesciunt explicabo velit sequi facere maiores illo
                                                    dolores in veritatis doloribus delectus non, amet temporibus, recusandae porro eum ullam possimus.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion__item">
                                    <div class="accordion__header" id="headingFour">
                                        <button
                                            class="accordion-button collapsed"
                                            type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#collapseFour"
                                            aria-expanded="false"
                                            aria-controls="collapseFour"
                                        >
                                            Can I change my order after it has been placed?
                                        </button>
                                    </div>
                                    <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <div class="accordion__content">
                                                <p>
                                                    Lorem ipsum dolor, sit amet consectetur adipisicing elit. Minima expedita nesciunt explicabo velit sequi facere maiores illo
                                                    dolores in veritatis doloribus delectus non, amet temporibus, recusandae porro eum ullam possimus.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Accordion Section End -->

        <!-- Footer Section Start -->
        <footer class="footer__section">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <a href="#" class="footer__logo">
                            <img src="assets/images/logo/logo-white.svg" alt="logo" />
                        </a>
                        <div class="footer__content text-center">
                            <p>Elevate Your Business with Innovative Web, App, and Software Solutions. Partner for Excellence in Tech.</p>
                            <div class="link">
                                <a href="tel:+8801937203743">
                                    <img src="assets/images/call-icon.png" alt="icon" />
                                    +8801937203743
                                </a>
                                <a href="mailto:razinsoftltd@gmail.com">
                                    <img src="assets/images/email-icon.png" alt="icon" />
                                    razinsoftltd@gmail.com
                                </a>
                            </div>
                            <div class="social__icon">
                                <div class="icon__list">
                                    <a href="#"><i class="ri-twitter-fill"></i></a>
                                    <a href="#"><i class="ri-facebook-fill"></i></a>
                                    <a href="#"><i class="ri-linkedin-fill"></i></a>
                                </div>
                            </div>
                            <ul class="footer__link">
                                <li><a href="#">About Us</a></li>
                                <li><a href="#">Contact Us</a></li>
                                <li><a href="#">Terms & Conditions</a></li>
                                <li><a href="#">Service Policy</a></li>
                            </ul>
                        </div>
                        <div class="footer__copyright text-center">
                            <p>2025 Razinsoft All Right Reserved</p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- Footer Section End -->

        <!-- Header menu Flyout -->
        <div class="custom__offcanvas offcanvas offcanvas-start" tabindex="-1" id="headerOffcanvas">
            <!-- Haeder Start -->
            <div class="offcanvas__header">
                <div class="brand-logo">
                    <a href="index.html">
                        <img src="assets/images/logo/logo.svg" alt="logo" />
                    </a>
                </div>
                <button type="button" class="btn__close" data-bs-dismiss="offcanvas">
                    <i class="ri-close-large-line"></i>
                </button>
            </div>
            <!-- Haeder End -->
            <div class="offcanvas__body p-0">
                <ul class="offcanvas-nav-menu">
                    <li><a href="index.html">Home</a></li>
                    <li><a href="#">About us</a></li>
                    <li><a href="#">Contact Us</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                    <li class="btn__group">
                        <a href="#" class="rs-btn rs-btn-primary">Get The App</a>
                        <a href="{{ route('dashboard')}}" class="rs-btn rs-btn-outline">Go to Admin</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- Header menu Flyout -->

        <!-- JS -->
        <script src="assets/js/jquery-3.7.1.min.js"></script>
        <!-- bootstrap js -->
        <script src="assets/js/bootstrap.min.js"></script>
        <!-- swiper slider -->
        <script src="assets/js/swiper-bundle.min.js"></script>
        <!-- Aos animation -->
        <script src="assets/js/aos.js"></script>
        <!-- Smooth Scroll -->
        <script src="assets/js/smooth-scroll.js"></script>
        <!-- main js -->
        <script src="assets/js/scripts.js"></script>
    </body>
</html>
