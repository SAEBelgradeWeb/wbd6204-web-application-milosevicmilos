<!-- Header -->
<header class="navbar-abs nav-style-3">
    <nav class="navbar navbar-expand-lg my-nav absolute-nav">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <h1><img src="{{ asset('assets-home/images/logo/transparent-logo.png') }}" alt="live-check-logo" /> KiloWatts</h1>
            </a>
            @if(request()->route()->uri === '/')
            <div class="">
                <ul class="navbar-nav ml-auto">
                    @if( ! $user)
                        <li class="menu-item nav-button">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                    @else
                        <li class="menu-item nav-button">
                            <a class="nav-link" href="{{ route('dashboard', '/') }}">Dashboard</a>
                        </li>
                    @endif
                </ul>
            </div>
            @endif
        </div>
    </nav>
</header>
<!-- Header End -->