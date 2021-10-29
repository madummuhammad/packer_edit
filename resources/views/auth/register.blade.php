<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <title>{{ env('APP_NAME') }} | Register</title>

        <!-- core:css -->
        <link rel="stylesheet" href="{{ asset('assets/backend/vendors/core/core.css') }}" />
        <!-- endinject -->

        <!-- plugin css for this page -->
        <!-- end plugin css for this page -->

        <!-- inject:css -->
        <link rel="stylesheet" href="{{ asset('assets/backend/fonts/feather-font/css/iconfont.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/backend/vendors/flag-icon-css/css/flag-icon.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('assets/backend/vendors/select2/select2.min.css') }}">
        <!-- endinject -->

        <!-- Layout styles -->  
        <link rel="stylesheet" href="{{ asset('assets/backend/css/demo_1/style.css') }}" />
		<link rel="stylesheet" href="{{ asset('assets/apps/css/backend.css') }}" />
        <!-- End layout styles -->

        <link rel="shortcut icon" href="{{ asset('favicon.png') }}" />

    </head>

    <body>

        <div class="main-wrapper">
            <div class="page-wrapper full-page">
                <div class="page-content d-flex align-items-center justify-content-center background">
                    <div class="row w-100 mx-0 auth-page">
                        <div class="col-md-8 col-xl-6 mx-auto">
                            <div class="card">
                                <div class="row">
                                    <div class="col-md-4 pr-md-0">
                                        <div class="auth-left-wrapper bg-image"></div>
                                    </div>
                                    <div class="col-md-8 pl-md-0">
                                        <div class="auth-form-wrapper px-4 py-4 mt-2 mb-2 ml-2 mr-1">
                                            <a href="{{ url('') }}" class="noble-ui-logo d-block mb-2">P<span>acker</span></a>
                                            <h5 class="text-muted font-weight-normal mb-4">Buat akun hanya dalam 1 menit.</h5>
                                            @if (Session::has('success'))
                                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                {{ Session::get('success') }}
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            @endif
                                            @if (Session::has('error'))
                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                {{ Session::get('error') }}
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            @endif
                                            @if ($errors->any())
                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                Error:
                                                <ul class="mb-0">
                                                    @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            @endif
                                            <form class="forms-sample" id="form" action="{{ url('sign-up') }}" method="POST">
                                                @csrf
                                                <div class="form-group">
                                                    <label for="fullname">Fullname <span style="color: red;">*</span></label>
                                                    <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Masukkan nama anda">
                                                </div>
                                                <div class="form-group">
                                                    <label for="phone">Phone <span style="color: red;">*</span></label>
                                                    <input type="number" class="form-control" id="phone" name="phone" placeholder="Masukkan nomor telepon anda">
                                                </div>
                                                <div class="form-group">
                                                    <label for="username">Email <span style="color: red;">*</span></label>
                                                    <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan email anda">
                                                </div>
                                                <div class="form-group">
                                                    <label for="password">Password <span style="color: red;">*</span></label>
                                                    <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password anda">
                                                </div>
                                                <div class="form-group">
                                                    <label for="provinsi_id">Provinsi <span style="color: red;">*</span></label>
                                                    <select class="select2-single form-control" id="provinsi_id">
                                                        <option value="" selected disabled>-- Please Select --</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="kabupaten_id">Kabupaten <span style="color: red;">*</span></label>
                                                    <select class="select2-single form-control" id="kabupaten_id" name="kabupaten_id">
                                                        <option value="" selected disabled>-- Please Select --</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="address">Address <span style="color: red;">*</span></label>
                                                    <textarea class="form-control" id="address" name="address" cols="30" rows="10" placeholder="Masukkan alamat anda"></textarea>
                                                </div>
                                                <div class="mt-4 d-flex justify-content-between">
                                                    <button type="submit" class="btn btn-primary btn-block text-white" id="btn_submit">
                                                        <span class="spinner-border spinner-border-sm mr-2" id="spinner" role="status" aria-hidden="true" style="display: none;"></span>
                                                        Register
                                                    </button>
                                                </div>
                                            </form>
                                            <p class="d-block mt-3 text-muted">Already have an account? <a href="{{ url('login') }}">Sign in</a></p>
                                            <hr class="mt-4 mb-4">
										    <!-- <p class="text-muted text-center"> Copyright © <a href="https://farizrachmanyusuf.com" target="_blank">Fariz Rachman Yusuf</a> 2021 </p> -->
										    <p class="text-muted text-center">&copy; Copyrights 2021 {{ env('APP_NAME') }} All rights reserved.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- core:js -->
        <script src="{{ asset('assets/backend/vendors/core/core.js') }}"></script>
        <!-- endinject -->

        <!-- plugin js for this page -->
        <script src="{{ asset('assets/backend/vendors/feather-icons/feather.min.js') }}"></script>
        <script src="{{ asset('assets/backend/vendors/inputmask/jquery.inputmask.min.js') }}"></script>
        <script src="{{ asset('assets/backend/vendors/jquery-validation/jquery.validate.min.js') }}"></script>
        <script src="{{ asset('assets/backend/vendors/select2/select2.min.js') }}"></script>
        <script src="{{ asset('assets/vendor/jquery-blockui/jquery.blockUI.js') }}"></script>
        <!-- end plugin js for this page -->

        <!-- inject:js -->
        <script src="{{ asset('assets/backend/js/template.js') }}"></script>
        <script src="{{ asset('assets/backend/js/select2.js') }}"></script>
        <script src="{{ asset('assets/apps/js/backend.js') }}"></script>
        <!-- endinject -->

        <!-- custom js for this page -->
        <script>
        
        $(async function () {

            var masterProvince = await sendRequest(`/api/province`);
            provinceOption = `<option value="" selected disabled>-- Please Select --</option>`;
            masterProvince.map((e) => { provinceOption += `<option value="${e.id}">${e.name}</option>`; });
            $('#provinsi_id').empty().html(provinceOption);

            // var masterCity = await sendRequest(`/api/city`);
            cityOption = `<option value="" selected disabled>-- Please Select --</option>`;
            // masterCity.map((e) => { cityOption += `<option value="${e.id}">${e.value}</option>`; });
            $('#kabupaten_id').empty().html(cityOption).attr('disabled', true);

            var validator = $('#form').validate({
                rules: {
                    fullname: {
                        required: true
                    },
                    username: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: true
                    },
                    provinsi_id: {
                        required: true
                    },
                    kabupaten_id: {
                        required: true
                    },
                    address: {
                        required: true
                    },
                    postal_code: {
                        required: true
                    },
                }
            });

            $('#form').on('submit', function(e) {

                if ($(this).valid()) {
                    $(this).find('#btn_submit').attr('disabled', true);
                    $(this).find('#spinner').show('fast');
                }

            });

            $('#provinsi_id').on('change', async function(e) {

                var provinsiId = $(this).val();

                if (provinsiId) {

                    var masterCity = await sendRequest(`/api/city?provinsi_id=${provinsiId}`);
                    cityOption = `<option value="" selected disabled>-- Please Select --</option>`;
                    masterCity.map((e) => { cityOption += `<option value="${e.id}">${e.name}</option>`; });
                    $('#kabupaten_id').empty().html(cityOption).attr('disabled', false);

                }

            });

        });

        function sendRequest(url, method, data) {
            var d = $.Deferred();
            method = method || "GET";
            $.ajax(url, {
                method: method || "GET",
                headers: {
                    "Authorization": "Bearer {{ Session::get('api_token') }}"
                },
                data: data,
                cache: false,
                xhrFields: { withCredentials: true },
            }).done(function(result) {
                console.log(result);
                d.resolve(method === "GET" ? result.data : result);
            }).fail(function(xhr) {
                console.error(xhr);
                d.reject(xhr.responseJSON ? xhr.responseJSON.Message : xhr.statusText);
            });
            return d.promise();
        }
        
        </script>
        <!-- end custom js for this page -->

    </body>

</html>
