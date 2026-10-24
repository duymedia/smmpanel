@include('clients.theme-4.layouts.header')
@include('clients.theme-4.layouts.navbar')
<div class="wrapper-content">
    <div class="wrapper-content__header"></div>
    <div class="wrapper-content__body">
        @yield('content')
    </div>
</div>
@include('clients.theme-4.layouts.footer')
