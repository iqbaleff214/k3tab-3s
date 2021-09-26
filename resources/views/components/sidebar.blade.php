<aside class="main-sidebar sidebar-light-warning elevation-1">
    <!-- Brand Logo -->
    <a href="{{ route('home') }}" class="brand-link">
        <img src="{{ asset('3S.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">Smart Store Service</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="https://ui-avatars.com/api/?size=512&background=ffc107&name={{ auth()->user()->name }}" class="img-circle elevation-2 mt-1" alt="User Image">
            </div>
            <div class="info py-0 my-0">
                <a href="#" class="d-block font-weight-bold">{{ auth()->user()->name }}</a>
                <a href="#" class="d-block text-xs">{{ auth()->user()->role }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                @foreach($menus as $key => $val)
                <li class="nav-item">
                    <a href="{{ route($key) }}" class="nav-link {{ Route::is($val[2] ?? $key) ? 'active' : '' }}">
                        <i class="nav-icon {{ $val[1] }}"></i>
                        <p>{{ $val[0] }}</p>
                    </a>
                </li>
                @endforeach
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
