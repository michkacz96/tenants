<nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm rounded-bottom">
    <div class="container">
        @guest
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Laravel') }}
        </a>
        @endguest

        @auth
        <a class="navbar-brand" href="{{ url('/dashboard') }}">
            {{ config('app.name', 'Laravel') }}
        </a>
        @endauth

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            
            <ul class="navbar-nav me-auto">
                @guest
                
                @endguest

                @auth
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdown04" data-bs-toggle="dropdown" aria-expanded="false">Properties</a>
                    <ul class="dropdown-menu" aria-labelledby="dropdown04">   
                        <li><a class="dropdown-item" href="/properties">Properties</a></li>
                        <li><a class="dropdown-item" href="/propdetails">Details</a></li>
                        <li><a class="dropdown-item" href="/formulas">Formulas</a></li>
                        <li><a class="dropdown-item" href="/utilitymeters">List of utility meters</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdown04" data-bs-toggle="dropdown" aria-expanded="false">Categories</a>
                    <ul class="dropdown-menu" aria-labelledby="dropdown04">
                        <li><a class="dropdown-item" href="/categories">Categories</a></li>
                        <li><a class="dropdown-item" href="/items">Goods and services</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdown04" data-bs-toggle="dropdown" aria-expanded="false">Contractors</a>
                    <ul class="dropdown-menu" aria-labelledby="dropdown04">   
                        <li><a class="dropdown-item" href="/tenants">Tenants</a></li>
                        <li><a class="dropdown-item" href="/suppliers">Suppliers</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="dropdown04" data-bs-toggle="dropdown" aria-expanded="false">Documents</a>
                    <ul class="dropdown-menu" aria-labelledby="dropdown04">   
                        <li><a class="dropdown-item" href="/purchases">Purchases</a></li>
                        <li><a class="dropdown-item" href="/sales">Sales</a></li>
                    </ul>
                </li>                
                @endauth
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ms-auto">
                <!-- Authentication Links -->
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    @endif

                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>