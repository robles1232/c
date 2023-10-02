<!DOCTYPE html>
<html lang="en">
@include('layouts.header')

<body>
    <!-- preloader area start -->
    <div id="preloader">
        <div class="loader"></div>
    </div>
    <!-- preloader area end -->
    <!-- page container area start -->
    <div class="page-container">
        @include('layouts.sidebar')
        <!-- main content area start -->
        <div class="main-content">

            @include('layouts.navbar')
            
            <div class="main-content-inner">
                @yield('content')
            </div>
        </div>
        <!-- main content area end -->
        @include('layouts.footer')
    </div>


    @include('layouts.script')
</body>

</html>