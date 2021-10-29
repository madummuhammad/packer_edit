<!doctype html>
    <html class="no-js" lang="en">

    <head>

        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="facebook-domain-verification" content="1u6xii4j7bz20dqe72m6j6ez8e8e9j" />

        <!-- SEO Meta Description -->
        <meta name="description" content="">
        <meta name="author" content="Themeland">

        <!-- Title  -->
        <title>@yield('title') | {{ env('APP_NAME') }}</title>

        <!-- Favicon  -->
        <link rel="icon" href="{{ url('assets/frontend/img/favicon.png') }}">

        <!-- ***** All CSS Files ***** -->

        <!-- Style css -->
        <link rel="stylesheet" href="{{ url('assets/frontend/css/style.css') }}">

        <!-- Responsive css -->
        <link rel="stylesheet" href="{{ url('assets/frontend/css/responsive.css') }}">

        <style>
        .welcome-area {
            background: rgba(0, 0, 0, 0) url("") no-repeat fixed center center / cover;
        }

        .fade-in {
            animation: fadeIn ease 3s;
            -webkit-animation: fadeIn ease 3s;
            -moz-animation: fadeIn ease 3s;
            -o-animation: fadeIn ease 3s;
            -ms-animation: fadeIn ease 3s;
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }

        @-moz-keyframes fadeIn {
            0% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }

        @-webkit-keyframes fadeIn {
            0% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }

        @-o-keyframes fadeIn {
            0% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }

        @-ms-keyframes fadeIn {
            0% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }

        .number {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-color: rgba(23, 92, 255, 0.1);
            line-height: 60px;
            color: #175cff;
            text-align: center;
            font-size: 1.25rem;
            font-weight: bold;
            margin-left: auto;
            margin-right: auto;
        }

        .grid-wrapper {
            display: grid;
            grid-gap: 30px;
            place-items: center;
            place-content: center;
        }

        .grid-col-auto {
            grid-template-columns: repeat(auto-fill, minmax(280px, .1fr));
            grid-template-rows: auto;
        }

        .grid-col-1 {
            grid-template-columns: repeat(1, auto);
            grid-template-rows: repeat(1, auto);
        }

        .grid-col-2 {
            grid-template-columns: repeat(2, auto);
            grid-template-rows: repeat(1, auto);
        }

        .grid-col-3 {
            grid-template-columns: repeat(3, auto);
            grid-template-rows: repeat(1, auto);
        }

        .grid-col-4 {
            grid-template-columns: repeat(4, auto);
            grid-template-rows: repeat(1, auto);
        }

        .selected-content {
            text-align: center;
            border-radius: 3px;
            box-shadow: 0 2px 4px 0 rgba(219, 215, 215, 0);
            border: solid 2px transparent;
            background: #fff;
            max-width: 280px;
            height: 330px;
            padding: 15px;
            display: grid;
            grid-gap: 15px;
            place-content: center;
            transition: .3s ease-in-out all;
        }

        .selected-content img {
            width: 230px;
            margin: 0 auto;
        }

        .selected-content h4 {
            font-size: 16px;
            letter-spacing: -0.24px;
            text-align: center;
            color: #1f2949;
        }

        .selected-content h5 {
            font-size: 14px;
            line-height: 1.4;
            text-align: center;
            color: #686d73;
        }

        .selected-label {
            position: relative;
        }

        .selected-label input {
            display: none;
        }

        .selected-label .icon {
            width: 20px;
            height: 20px;
            border: solid 2px #e3e3e3;
            border-radius: 50%;
            position: absolute;
            top: 15px;
            left: 15px;
            transition: .3s ease-in-out all;
            transform: scale(1);
            z-index: 1;
        }

        .selected-label .icon:before {
            content: "\f00c";
            position: absolute;
            width: 100%;
            height: 100%;
            font-family: "Font Awesome 5 Free";
            font-weight: 900;
            font-size: 12px;
            color: #000;
            text-align: center;
            opacity: 0;
            transition: .2s ease-in-out all;
            transform: scale(2);
        }

        .selected-label input:checked+.icon {
            background: #3057d5;
            border-color: #3057d5;
            transform: scale(1.2);
        }

        .selected-label input:checked+.icon:before {
            color: #fff;
            opacity: 1;
            transform: scale(.8);
        }

        .selected-label input:checked~.selected-content {
            box-shadow: 0 2px 4px 0 rgba(219, 215, 215, 0.5);
            border: solid 2px #3057d5;
        }
    </style>
    <script>
      !function(f,b,e,v,n,t,s)
      {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
          n.callMethod.apply(n,arguments):n.queue.push(arguments)};
          if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
          n.queue=[];t=b.createElement(e);t.async=!0;
          t.src=v;s=b.getElementsByTagName(e)[0];
          s.parentNode.insertBefore(t,s)}(window, document,'script',
              'https://connect.facebook.net/en_US/fbevents.js');
          fbq('init', '280454956862540');
          fbq('track', 'PageView');
      </script>
      <noscript><img height="1" width="1" style="display:none"
          src="https://www.facebook.com/tr?id=280454956862540&ev=PageView&noscript=1"
          /></noscript>
          <!-- End Facebook Pixel Code -->

      </head>

      <body class="homepage-1 rtl">

        <!--====== Preloader Area Start ======-->
        @include('layouts.frontend.components.preloader')
        <!--====== Preloader Area End ======-->
<!--         <a href="https://api.whatsapp.com/send?phone=6282260001709&amp;text=Hallo%20Packer%20Indonesia!%0ASaya%20mau%20tau%20lebih%20lanjut" target="_blank" id="whatsapp">
            <i class="fab fa-whatsapp"></i>
        </a> -->
        <div id="whatsapp-bg">
        </div>
        <div id="whatsapp-svg">
            <i class="fab fa-whatsapp text-white"></i>
        </div>
        <a href="https://api.whatsapp.com/send?phone=6282260001709&amp;text=Hallo%20Packer%20Indonesia!%0ASaya%20mau%20tau%20lebih%20lanjut" target="_blank" id="whatsapp" style="color: transparent;">
            Whatsapp
        </a>
        <!--====== Scroll To Top Area Start ======-->
        <div id="scrollUp" title="Scroll To Top">
            <i class="fas fa-arrow-up"></i>
        </div>


        <!--====== Scroll To Top Area End ======-->

        <div class="main overflow-hidden">

            <!-- ***** Header Start ***** -->
            @include('layouts.frontend.components.header')
            <!-- ***** Header End ***** -->

            @yield('content')

            <!--====== Footer Area Start ======-->
            @include('layouts.frontend.components.footer')
            <!--====== Footer Area End ======-->

            <!--====== Modal Responsive Menu Area Start ======-->
            <div id="menu" class="modal fade p-0">
                <div class="modal-dialog dialog-animated">
                    <div class="modal-content h-100">
                        <div class="modal-header" data-dismiss="modal">
                            Menu <i class="far fa-times-circle icon-close"></i>
                        </div>
                        <div class="menu modal-body">
                            <div class="row w-100">
                                <div class="items p-0 col-12 text-center"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--====== Modal Responsive Menu Area End ======-->
        </div>

        <!-- ***** All jQuery Plugins ***** -->

        <!-- jQuery(necessary for all JavaScript plugins) -->
        <script src="{{ asset('assets/frontend/js/jquery/jquery-3.5.1.min.js') }}"></script>

        <!-- Bootstrap js -->
        <script src="{{ asset('assets/backend/bootstrap/js/popper.min.js') }}"></script>
        <script src="{{ asset('assets/backend/bootstrap/js/bootstrap.min.js') }}"></script>
    <!-- <script src="{{ asset('assets/frontend/js/bootstrap/popper.min.js') }}"></script>
        <script src="{{ asset('assets/frontend/js/bootstrap/bootstrap.min.js') }}"></script> -->

        <!-- Plugins js -->
        <script src="{{ asset('assets/frontend/js/plugins/plugins.min.js') }}"></script>

        <!-- Active js -->
        <script src="{{ asset('assets/frontend/js/active.js') }}"></script>

        <!-- Tawk.to Script -->
        <!-- <script src="{{ asset('assets/vendor/tawkto/tawkto.js') }}"></script> -->

        <script>
            $(function() {
                if ($('[data-toggle="tooltip"]').length) {
                    $('[data-toggle="tooltip"]').tooltip({
                        html: true
                    });
                }
            })
        </script>
        <p id="demo"></p>
        <script>
            $(document).ready(function() {
                var screen = $(window).width();
                $('.sistem-terintegrasi').tooltip({
                    title: "Untuk setiap orderan seller nanti nya akan langsung terintergrasi dengan sistem Packer, jadi seller cukup proses setiap orderan melalui sistem Packer.",
                    html: true,
                    placement: "right"
                });
                if (screen > 575) {
                    $('.sistem-terintegrasi').on('mouseover', function() {
                        $('.sistem-terintegrasi').toggle(
                            $('.sistem-terintegrasi').show(),
                            $('.tooltip').css('margin-top', '60px'),
                            $('.arrow').css('margin-top', '-110px'),
                            );
                    })
                } else {
                    $('.sistem-terintegrasi').on('mouseover', function() {
                        $('.sistem-terintegrasi').toggle(
                            $('.sistem-terintegrasi').show(),
                            $('.tooltip').css('margin-top', '170px'),
                            $('.arrow').css('margin-top', '-340px'),
                            );
                    })
                }
            });
        </script>
        <script>
          !function(f,b,e,v,n,t,s)
          {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
              n.callMethod.apply(n,arguments):n.queue.push(arguments)};
              if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
              n.queue=[];t=b.createElement(e);t.async=!0;
              t.src=v;s=b.getElementsByTagName(e)[0];
              s.parentNode.insertBefore(t,s)}(window, document,'script',
                  'https://connect.facebook.net/en_US/fbevents.js');
              fbq('init', '280454956862540');
              fbq('track', 'PageView');
          </script>
          <noscript><img height="1" width="1" style="display:none"
              src="https://www.facebook.com/tr?id=280454956862540&ev=PageView&noscript=1"
              /></noscript>
              <!-- End Facebook Pixel Code -->
              <!-- Facebook Pixel Code -->
    <!--        <script>

        function angka(e) {
          if (!/^[0-9]+$/.test(e.value)) {
            e.value = e.value.substring(0,e.value.length-1);
        }
    }
</script> -->

@yield('script')

</body>

</html>