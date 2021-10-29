
<!doctype html>
<html class="no-js" lang="en">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- SEO Meta Description -->
    <meta name="description" content="">
    <meta name="author" content="Themeland">

    <!-- Title  -->
    <title>{{ env('APP_NAME') }} - @yield('title')</title>

    <!-- Favicon  -->
    <link rel="icon" href="{{ asset('assets/frontend/img/favicon.png') }}">

    <!-- ***** All CSS Files ***** -->

    <!-- Style css -->
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/style.css') }}">

    <!-- Responsive css -->
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/responsive.css') }}">

</head>

<body class="error-page">

    <!--====== Preloader Area Start ======-->
    <div id="preloader">
        <!-- Digimax Preloader -->
        <div id="digimax-preloader" class="digimax-preloader">
            <!-- Loader Animation -->
            <div class="loader-animation">
                <div class="row h-100">
                    <!-- Single Loader -->
                    <div class="col-3 single-loader p-0">
                        <div class="loader-bg"></div>
                    </div>
                    <!-- Single Loader -->
                    <div class="col-3 single-loader p-0">
                        <div class="loader-bg"></div>
                    </div>
                    <!-- Single Loader -->
                    <div class="col-3 single-loader p-0">
                        <div class="loader-bg"></div>
                    </div>
                    <!-- Single Loader -->
                    <div class="col-3 single-loader p-0">
                        <div class="loader-bg"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--====== Preloader Area End ======-->

    @yield('content')


    <!-- ***** All jQuery Plugins ***** -->

    <!-- jQuery(necessary for all JavaScript plugins) -->
    <script src="{{ asset('assets/frontend/js/jquery/jquery-3.5.1.min.js') }}"></script>

    <!-- Bootstrap js -->
    <script src="{{ asset('assets/frontend/js/bootstrap/popper.min.js') }}"></script>
    <script src="{{ asset('assets/frontend/js/bootstrap/bootstrap.min.js') }}"></script>

    <!-- Plugins js -->
    <script src="{{ asset('assets/frontend/js/plugins/plugins.min.js') }}"></script>

    <!-- Active js -->
    <script src="{{ asset('assets/frontend/js/active.js') }}"></script>

</body>

</html>