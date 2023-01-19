<!doctype html>
<html>
@include('admin.header_after_login')
<body>
    <div class="navbar navbar-expand flex-column flex-md-row align-items-center navbar-custom">
    @include('admin.head_after_login')
    </div>
    @include('admin.sidebar')
    <div class="main-content">
        @include('flash-message')
        @yield('content')
        <div class="col-sm-12 copyright">
            <p>©{{ date('Y') }} {{__('level.all_rights_reserved')}}  <a href="{{ route('admin.dashboard') }}">{{ config('app.name', 'Laravel') }}</a></p>
        </div>
    </div>
    @include('admin.footer_after_login')
    @stack('current-page-js')
    @include('js-flash-message')
</body>
</html>