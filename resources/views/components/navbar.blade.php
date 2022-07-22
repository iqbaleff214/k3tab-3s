<nav class="main-header navbar navbar-expand navbar-navy navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        {{-- <li class="nav-item d-none d-sm-inline-block"> --}}
        {{-- <a href="{{ route('home') }}" class="nav-link">Home</a> --}}
        {{-- </li> --}}
        {{-- <li class="nav-item d-none d-sm-inline-block"> --}}
        {{-- <a href="#" class="nav-link">Contact</a> --}}
        {{-- </li> --}}
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

        <!-- Dropdown Menu -->
        <li class="nav-item dropdown">
            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false" v-pre>
                {{ Auth::user()->name }}
            </a>

            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                @if (in_array(Auth::user()->role, ['ADMIN', 'SUPERVISOR']))
                <form id="truncate-form" action="{{ route('admin.truncate') }}" method="POST" class="d-hidden-mini">
                    @csrf
                    <a class="dropdown-item" href="{{ route('admin.truncate') }}"
                        onclick="event.preventDefault();justConfirm(this)">
                        Reset Data
                    </a>
                </form>
                @endif
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-hidden-mini">
                    @csrf
                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault();logoutConfirm(this)">
                        {{ __('Logout') }}
                    </a>
                </form>
            </div>
        </li>
        <li class="nav-item ml-2">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button" title="fullscreen">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
    </ul>
</nav>
