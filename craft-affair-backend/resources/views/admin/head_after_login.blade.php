<div class="container-fluid">
    <a href="{{ route('admin.dashboard') }}" class="navbar-brand mr-0 mr-md-2 logo">
        <img src="{{ asset('images/logo.png') }}" alt="Logo">
    </a>

    <ul class="navbar-nav flex-row ml-auto d-flex align-items-center list-unstyled topnav-menu mb-0">
        <li class="dropdown user-link">
            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button"
                aria-haspopup="false" aria-expanded="false">
                <i class="far fa-cog"></i>
                <span class="noti-icon-badge"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right dropdown-lg">
                <a href="{{ url('admin/profile-user',auth()->user()->id) }}" class="dropdown-item"> <i class="fal fa-user"></i> {{__('level.my_profile')}}</a>
                <div class="dropdown-divider"></div>
                <a href="{{ route('admin.logout') }}" class="dropdown-item"><i class="fal fa-sign-out"></i> {{__('level.logout')}}</a>
            </div>
        </li>
    </ul>
</div>