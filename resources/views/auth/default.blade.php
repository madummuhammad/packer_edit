<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">

    <title>{{ env('APP_NAME') }} - @yield('title')</title>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico"/>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="{{ asset('assets/backend/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/backend/assets/css/plugins.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/backend/assets/css/authentication/form-2.css') }}" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BEGIN CUSTOM STYLE FILE -->
    <link href="{{ asset('assets/backend/assets/css/elements/alert.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/backend/assets/css/forms/theme-checkbox-radio.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/backend/assets/css/forms/switches.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/backend/plugins/sweetalerts/sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <!-- END CUSTOM STYLE FILE -->

    <!-- BEGIN APP LEVEL PLUGIN/CUSTOM STYLES -->
    <style>

        .btn-primary {
            background-color: #ffac0c !important;
            border-color: #ffac0c;
            box-shadow: 0 10px 20px -10px #ffac0c;
        }

    </style>
    @yield('style')
    <!-- END APP LEVEL PLUGIN/CUSTOM STYLES -->

</head>
<body class="form">

    <div class="form-container outer">

        <div class="form-form">

            <div class="form-form-wrap">

                <div class="form-container">
                    
                @yield('content')

                </div>
                
            </div>

        </div>

    </div>

    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="{{ asset('assets/backend/assets/js/libs/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('assets/backend/bootstrap/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/backend/bootstrap/js/bootstrap.min.js') }}"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->
    
    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
    <script src="{{ asset('assets/backend/assets/js/authentication/form-2.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/blockui/jquery.blockUI.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/input-mask/jquery.inputmask.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/sweetalerts/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery-validate/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery-validate/additional-methods.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/axios/axios.min.js') }}"></script>
    <script src="{{ asset('assets/apps/js/backend.js') }}"></script>
    <!-- END PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->

    <!-- BEGIN APP LEVEL PLUGINS/CUSTOM SCRIPTS -->
    @yield('script')
    <!-- END APP LEVEL PLUGINS/CUSTOM SCRIPTS -->

</body>

</html>