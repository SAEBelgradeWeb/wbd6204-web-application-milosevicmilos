@extends('layouts.main-layout')

@section('content')

@include('partials.header')

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
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="right-part form-wrap">
                                <div class="banner-form">
                                    <h5>Register here</h5>
                                    <p>Populate registration form.</p>
                                    <form action method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <input name="first_name" type="text" class="form-control" id="lastName"
                                                   placeholder="Last Name" required>
                                        </div>
                                        @error('first_name')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <div class="form-group">
                                            <input name="last_name" type="text" class="form-control" id="firstName"
                                                   placeholder="First Name" required>
                                        </div>
                                        @error('last_name')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <div class="form-group">
                                            <input name="email" type="email" class="form-control" id="exampleInputEmail1"
                                                   placeholder="Enter Address" required>
                                        </div>
                                        @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                        <div class="form-group">
                                            <input name="password" type="password" class="form-control" id="password"
                                                   placeholder="Password" required>
                                        </div>
                                        @error('password')
                                        <span class="text-danger">{{ $message }}</span>
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
<div class="service-tab">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" href="#electricity-consumption" role="tab" data-toggle="tab">
                            <img src="{{ asset('assets-home/images/electricity-consumption.png') }}" alt="electricity-consumption">
                            <span>Track Consumption</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#save-energy" role="tab" data-toggle="tab">
                            <img src="{{ asset('assets-home/images/save-energy.png') }}" alt="save-energy">
                            <span>Save Energy</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#usage-statistics" role="tab" data-toggle="tab">
                            <img src="{{ asset('assets-home/images/usage-statistics.png') }}" alt="usage-statistics">
                            <span>Usage Statistics</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#reduce-bills" role="tab" data-toggle="tab">
                            <img src="{{ asset('assets-home/images/reduce-bills.png') }}" alt="reduce-bills">
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
                    <div role="tabpanel" class="tab-pane fade in active show" id="electricity-consumption">
                        <div class="row">
                            <div class="col-lg-6 order-lg-2">
                                <div class="tab-image">
                                    <img src="{{ asset('assets-home/images/electricity-consumption.png') }}" class="img-fluid"
                                         alt="confirmation" />
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
                    <div role="tabpanel" class="tab-pane fade" id="save-energy">
                        <div class="row">
                            <div class="col-lg-6 order-lg-2">
                                <div class="tab-image">
                                    <img src="{{ asset('assets-home/images/save-energy.png') }}" class="img-fluid"
                                         alt="multiple" />
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
                    <div role="tabpanel" class="tab-pane fade" id="usage-statistics">
                        <div class="row">
                            <div class="col-lg-6 order-lg-2">
                                <div class="tab-image">
                                    <img src="{{ asset('assets-home/images/usage-statistics.png') }}" class="img-fluid"
                                         alt="statistics" />
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
                    <div role="tabpanel" class="tab-pane fade" id="reduce-bills">
                        <div class="row">
                            <div class="col-lg-6 order-lg-2">
                                <div class="tab-image">
                                    <img src="{{ asset('assets-home/images/reduce-bills.png') }}" class="img-fluid"
                                         alt="locations" />
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

@endsection