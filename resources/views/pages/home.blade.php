<!doctype html>
<html lang="en">
<head>
<!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="author" content="Milos Milosevic">
    <meta name="description" content="Track electricity consumption in your buildings!">
    <meta name="robots" content="index, follow">

    <title>KiloWatts</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('assets-home/css/bootstrap.min.css') }}">

    <!-- Custom Css -->
    <link rel="stylesheet" type="text/css" href="assets-home/css/main.css">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700,800%7COpen+Sans:400,600,600i" rel="stylesheet">

    <!-- Favicon -->
    <link rel="icon" href="favicon.ico">
</head>
<body>

<!-- Header -->
<header class="navbar-abs nav-style-3">
    <nav class="navbar navbar-expand-lg markesia-nav absolute-nav">
        <div class="container">
            <a class="navbar-brand" href="#">
                <h1 style="font-size: 5.0rem; color: #fff;"><img width="75px;" src="{{ asset('assets-home/images/logo/transparent-logo.png') }}" alt="live-check-logo" /> KiloWatts</h1>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="ti-menu"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    @if( ! $user)
                        <li class="menu-item nav-button">
                            <a class="nav-link" href>Register</a>
                        </li>
                        <li class="menu-item nav-button">
                            <a class="nav-link" href=>Login</a>
                        </li>
                    @else
                        <li class="menu-item nav-button">
                            <a class="nav-link" href>Dashboard</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
</header>
<!-- Header End -->

<!-- Banner -->
<div class="banner primary-bg call-to-action-bg">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="banner-wrap">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="left-part form-wrap">
                                <div class="banner-content">
                                    <h1>Track electricity consumption in your buildings!</h1>
                                    <h6>We <b>provide</b> a <b>service</b> to track statistics of your electricity usage.</h6>
                                    <a href="#" class="button">Register</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="right-part form-wrap">
                                <div class="banner-form" style="padding: 54px 26px;">
                                    <h5>Registration form!</h5>
                                    <p>Use self-awareness to reduce your bills.</p>
                                    <form action method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <input name="first_name" type="text" class="form-control" id="lastName"
                                                   placeholder="Last Name" required>
                                        </div>
                                        @error('first_name')
                                        <span class="text-danger" style="margin-bottom: 10px; margin-top: -10px; display: block; font-size: 13px;">{{ $message }}</span>
                                        @enderror
                                        <div class="form-group">
                                            <input name="last_name" type="text" class="form-control" id="firstName"
                                                   placeholder="First Name" required>
                                        </div>
                                        @error('last_name')
                                        <span class="text-danger" style="margin-bottom: 10px; margin-top: -10px; display: block; font-size: 13px;">{{ $message }}</span>
                                        @enderror
                                        <div class="form-group">
                                            <input name="email" type="email" class="form-control" id="exampleInputEmail1"
                                                   placeholder="Enter Address" required>
                                        </div>
                                        @error('email')
                                        <span class="text-danger" style="margin-bottom: 10px; margin-top: -10px; display: block; font-size: 13px;">{{ $message }}</span>
                                        @enderror
                                        <div class="form-group">
                                            <input name="password" type="password" class="form-control" id="password"
                                                   placeholder="Password" required>
                                        </div>
                                        @error('password')
                                        <span class="text-danger" style="margin-bottom: 10px; margin-top: -10px; display: block; font-size: 13px;">{{ $message }}</span>
                                        @enderror
                                        <div class="form-group">
                                            <input name="password_confirmation" type="password" class="form-control" id="passwordConfirmation"
                                                   placeholder="Confirm Password" required>
                                        </div>
                                        <button type="submit" class="btn button">Register Now</button>
                                    </form>
                                    <span class="shadow"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Banner End -->

<!-- Service Tab -->
<div id="about-us" class="service-tab">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" href="#search" role="tab" data-toggle="tab">
                            <img src="assets-home/images/undraw_growth_analytics_8btt.png" style="height: 80px;" alt="confirmation">
                            <span>Track Consumption</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#link" role="tab" data-toggle="tab">
                            <img src="assets-home/images/undraw_Calculator_0evy.png" style="height: 80px; " alt="multiple">
                            <span>Save Energy</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#email" role="tab" data-toggle="tab">
                            <img src="assets-home/images/undraw_statistic_chart_38b6.png" style="height: 80px;" alt="statistics">
                            <span>Usage Statistics</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#cpa" role="tab" data-toggle="tab">
                            <img src="assets-home/images/undraw_wallet_aym5.png" style="height: 80px;" alt="locations">
                            <span>Reduce Bills</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="section-padding-120">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="tab-content service-tab-content">
                    <div role="tabpanel" class="tab-pane fade in active show" id="search">
                        <div class="row">
                            <div class="col-lg-6 order-lg-2">
                                <div class="tab-image">
                                    <img src="assets-home/images/undraw_growth_analytics_8btt.png" class="img-fluid"
                                         alt="confirmation" style="height: 350px; display: block; margin: 0 auto;">
                                </div>
                            </div>
                            <div class="col-lg-6 order-lg-1">
                                <div class="single-tab-content">
                                    <h3>Track Consumption</h3>
                                    <p>Track your daily consumption of every appliance that you own in every building, floor and room.
                                    You can add as many appliances as you want. We provide a simple REST API that you can integrate with all
                                    appliances that you own.</p>
                                    <p>This will give you insights into the usage of your electricity, which can lead to being
                                        more self-aware of saving energy and reducing your electricity bills.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="link">
                        <div class="row">
                            <div class="col-lg-6 order-lg-2">
                                <div class="tab-image">
                                    <img src="assets-home/images/undraw_Calculator_0evy.png" class="img-fluid"
                                         alt="multiple" style="height: 350px; display: block; margin: 0 auto;">
                                </div>
                            </div>
                            <div class="col-lg-6 order-lg-1">
                                <div class="single-tab-content">
                                    <h3>Save Energy</h3>
                                    <p>With this application, you can reduce energy consumption and in which hours or which appliance
                                    consumes a lot of electric energy.</p>
                                    <p>Just connect every appliance that you own with our REST API and start saving energy today.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="email">
                        <div class="row">
                            <div class="col-lg-6 order-lg-2">
                                <div class="tab-image">
                                    <img src="assets-home/images/undraw_statistic_chart_38b6.png" class="img-fluid"
                                         alt="statistics" style="height: 350px; display: block; margin: 0 auto;">
                                </div>
                            </div>
                            <div class="col-lg-6 order-lg-1">
                                <div class="single-tab-content">
                                    <h3>Usage Statistics</h3>
                                    <p>Our application provides all sorts of charts that will enable you to track electricity consumption for every
                                    appliance that you own. You can check with groups of appliances consume most electric energy and also track on which days
                                    or exact hours the consumption is the highest.</p>
                                    <p>This will allow you to act upon our data and maybe switch for more green energy appliances or use them with more self-awareness.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="cpa">
                        <div class="row">
                            <div class="col-lg-6 order-lg-2">
                                <div class="tab-image">
                                    <img src="assets-home/images/undraw_wallet_aym5.png" class="img-fluid"
                                         alt="locations" style="height: 350px; display: block; margin: 0 auto;">
                                </div>
                            </div>
                            <div class="col-lg-6 order-lg-1">
                                <div class="single-tab-content">
                                    <h3>Reduce Bills</h3>
                                    <p>Maybe the biggest advantage of this application would be to reduce energy bills for your buildings, apartments or
                                    multiple offices that you own. You can expect drops of 10-20% easily.</p>
                                    <p>Start tracking your energy consumption and get immediately calculate your expected bills for this month or the whole year in advance.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Service Tab End -->

<!-- Footer -->
<footer>
    <div class="footer-bg">
        <div class="footer-top">
            <div class="container">
                <div class="row"></div>
            </div>
        </div>
    </div>
    <div class="copyright-footer">
        <div class="container">
            <div class="row">
                <div class="col">
                    <p class="copyright-text">Copyright © {{ date('Y') }} KiloWatts</p>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- Footer End -->

<!-- JS Libraries -->
<script src="{{ asset('assets-home/js/jquery.min.js') }}"></script>
<script src="{{ asset('assets-home/js/bootstrap.min.js')}}"></script>
</body>
</html>