{{--============================================== call the html header  --}}
@include('admin/static/htmlheader')

{{-- call the footer --}}
{{-- @include('admin/static/footer') --}}


{{--============================================== call the header --}}
@include('admin/static/header')
    
    <div class="container">
        @yield('content')
    </div>


{{--============================================== call the html footer --}}
@include('admin/static/htmlfooter')