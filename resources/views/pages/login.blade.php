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
                        <div class="col-lg-4 col-md-0"></div>
                        <div class="col-lg-4 col-md-8">
                            <div class="left-part form-wrap">
                                <div class="banner-form">
                                    <h5>Login here</h5>
                                    <p>Populate login form.</p>
                                    <form action method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <input name="email" type="text" class="form-control" id="email"
                                                   placeholder="Email" required>
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
                                        <button type="submit" class="btn button">Login</button>
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

@endsection