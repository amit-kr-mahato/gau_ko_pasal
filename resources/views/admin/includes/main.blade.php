@include('admin.includes.header')
@include('admin.includes.sidebar')

@yield('content')

@stack('scripts')


@include('admin.includes.footer')