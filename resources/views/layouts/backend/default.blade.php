<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">

    <title>{{ env('APP_NAME') }} - @yield('title')</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/backend/assets/img/favicon.ico') }}"/>

    <link href="{{ asset('assets/backend/assets/css/loader.css') }}" rel="stylesheet" type="text/css" />
    
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:400,600,700" rel="stylesheet">
    <link href="{{ asset('assets/backend/assets/css/plugins.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/backend/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM STYLES -->
    <link href="{{ asset('assets/backend/assets/css/plugins.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/backend/assets/css/scrollspyNav.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/backend/plugins/animate/animate.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/backend/plugins/apex/apexcharts.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/backend/plugins/autocomplete/autocomplete.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/backend/plugins/bootstrap-range-Slider/bootstrap-slider.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/backend/plugins/bootstrap-select/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/backend/plugins/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/backend/plugins/dropify/dropify.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/backend/plugins/editors/markdown/simplemde.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/backend/plugins/file-upload/file-upload-with-preview.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/backend/plugins/flatpickr/flatpickr.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/backend/plugins/font-icons/fontawesome/css/fontawesome.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/backend/plugins/font-icons/fontawesome/css/regular.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/backend/plugins/fullcalendar/fullcalendar.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/backend/plugins/jquery-step/jquery.steps.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/backend/plugins/jquery-ui/jquery-ui.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/backend/plugins/loaders/custom-loader.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/backend/plugins/notification/snackbar/snackbar.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/backend/plugins/noUiSlider/nouislider.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/backend/plugins/perfect-scrollbar/perfect-scrollbar.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/backend/plugins/pricing-table/css/component.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/backend/plugins/select2/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/backend/plugins/sweetalerts/sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/backend/plugins/table/datatable/datatables.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/backend/plugins/table/datatable/dt-global_style.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/backend/plugins/tagInput/tags-input.css') }}" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL PLUGINS/CUSTOM STYLES -->

    <!-- BEGIN APP LEVEL PLUGIN/CUSTOM STYLES -->
    <style>

        .select2-dropdown {
            z-index: 1060;
        }

    </style>
    @yield('style')
    <!-- END APP LEVEL PLUGIN/CUSTOM STYLES -->

</head>
<body>

    @php
        $admin = [1, 2];
        $mitra = [4];
        $user = [3];
    @endphp

    @include('layouts.backend.components.navbar')

    <!--  BEGIN MAIN CONTAINER  -->
    <div class="main-container" id="container">

        <div class="overlay"></div>
        <div class="search-overlay"></div>

        @include('layouts.backend.components.sidebar')
        
        <!--  BEGIN CONTENT AREA  -->
        <div id="content" class="main-content">

            <div class="layout-px-spacing">

                <div class="layout-top-spacing">

                @yield('content')    

                </div>

            </div>
            
            @include('layouts.backend.components.footer')

        </div>
        <!--  END CONTENT AREA  -->

    </div>
    <!-- END MAIN CONTAINER -->

    <!-- START GLOBAL MODAL AREA -->

    <div class="modal fade" id="topup-modal" tabindex="-1" role="dialog" aria-labelledby="title" aria-hidden="true">
        <input type="hidden" id="id" name="id">
        <form id="form">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-secondary" id="title">Top Up</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="error">
                            <!-- Error Placeholder -->
                        </div>
                        <div class="form-group">
                            <label for="amount">Amount <span style="color: red;">*</span></label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Rp.</div>
                                </div>
                                <input type="number" class="form-control" id="amount" name="amount" placeholder="Amount">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="payment_method">Payment Method</label>
                            <select class="form-control" id="payment_method" name="payment_method">
                                <option value="" selected disabled>-- Please Select --</option>
                                <option value="GOPAY">GOPAY</option>
                                <option value="MANDIRI">Bank Mandiri</option>
                                <option value="BCA">Bank Central Asia</option>
                            </select>
                        </div>
                        <div class="form-group" id="payment-method-instruction">
                            
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">
                            Submit
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- END GLOBAL MODAL AREA -->

    <!-- BEGIN GLOBAL MANDATORY SCRIPTS -->
    <script src="{{ asset('assets/backend/assets/js/libs/jquery-3.1.1.min.js') }}"></script>
    <script src="{{ asset('assets/backend/bootstrap/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/backend/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/backend/assets/js/app.js') }}"></script>
    <script src="{{ asset('assets/backend/assets/js/scrollspyNav.js') }}"></script>
    <script src="{{ asset('assets/backend/assets/js/custom.js') }}"></script>
    <!-- END GLOBAL MANDATORY SCRIPTS -->

    <!-- BEGIN PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->
    <script src="{{ asset('assets/backend/plugins/apex/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/autocomplete/jquery.autocomplete.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/autocomplete/jquery.mockjax.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/blockui/jquery.blockUI.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/bootstrap-maxlength/bootstrap-maxlength.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/bootstrap-multiselect/bootstrap-multiselect.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/bootstrap-range-Slider/bootstrap-rangeSlider.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/bootstrap-select/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/countdown/jquery.countdown.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/counter/jquery.countTo.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/dropify/dropify.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/editors/markdown/simplemde.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/file-upload/file-upload-with-preview.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/flatpickr/flatpickr.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/font-icons/feather/feather.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/fullcalendar/moment.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/fullcalendar/fullcalendar.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/input-mask/jquery.inputmask.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/jquery-step/jquery.steps.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/notification/snackbar/snackbar.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/noUiSlider/nouislider.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/select2/select2.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/sweetalerts/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/table/datatable/datatables.js') }}"></script>
    <script src="{{ asset('assets/backend/plugins/tagInput/tags-input.js') }}"></script>
    <script src="{{ asset('assets/vendor/axios/axios.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/format-money/format-money.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery-validate/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery-validate/additional-methods.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/qrcode/qrcode.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/barcode/barcode.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/tawkto/tawkto.js') }}"></script>
    <script src="{{ asset('assets/apps/js/backend.js') }}"></script>
    <!-- END PAGE LEVEL PLUGINS/CUSTOM SCRIPTS -->

    <script>

        $(document).ready(function() {
            App.init();
        });

        const userId = parseInt("{{ Session::get('id') }}");
        const roleId = parseInt("{{ Session::get('role_id') }}");

        const admin = [1, 2];

        const isAdmin = admin.includes(roleId);

        const date = new Date();
        const today = new Date(date.getFullYear(), date.getMonth(), date.getDate());

        console.log('session', { user_id: userId, role_id: roleId, is_admin: isAdmin });

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

        const dataActivity = { activity: `View ${window.location.pathname}` };

        sendRequest(`/api/user-log`, "POST", dataActivity);

        getCart();

        async function getCart() {
            await axios.get(`/api/cart`, {
                headers: {
                    "Authorization": "Bearer {{ Session::get('api_token') }}",
                },
            })
            .then(function (res) {
                console.log('response', res.data);
                if (res.status == 200) {
                    var data = res.data.data;
                    var html = ``;
                    data.items.map((e) => {
                        html += `
                            <a href="javascript:void(0);" class="dropdown-item disabled">
                                <div class="icon"></div>
                                <div class="content">
                                    <p>${e.description}</p>
                                    <p class="sub-text text-muted">${e.qty} x ${e.price ? "Rp. " + parseInt(e.price).formatMoney(0, 3, '.') : "Rp. 0"}</p>
                                </div>
                            </a>
                        `;
                    });
                    $('#cartIndicator').html(`<span class="badge badge-danger counter" style="background">${data.items.length}</span>`);
                    $('#cartButton').find('.dropdown-body').html(html).removeClass('text-center');
                } else {
                    var html = `
                        <a href="javascript:void(0);" class="dropdown-item disabled">
                            <div class="content">
                                <p>Your cart is empty</p>
                            </div>
                        </a>
                    `;
                    $('#cartButton').find('.dropdown-body').html(html);
                }
            })
            .catch(function (err) {
                console.log('error', err.response);
                if (err.response) {
                    var html = `
                        <a href="javascript:void(0);" class="dropdown-item disabled">
                            <div class="content">
                                <p>Your cart is empty</p>
                            </div>
                        </a>
                    `;
                    $('#cartButton').find('.dropdown-body').html(html);
                }
            });
        }

        getProfile();

        async function getProfile() {
            await axios.get(`/api/profile`, {
                headers: {
                    "Authorization": "Bearer {{ Session::get('api_token') }}",
                },
            })
            .then(function (res) {
                console.log('response', res.data);
                if (res.status == 200) {
                    var data = res.data.data;
                    $('#myBalance').text(data.balance ? "IDR " + parseInt(data.balance).formatMoney(0, 3, '.') : "IDR 0");
                } else {
                    $('#myBalance').text("IDR 0");
                }
            })
            .catch(function (err) {
                console.log('error', err.response);
                if (err.response) {
                    $('#myBalance').text("IDR 0");
                }
            });
        }

        async function getFilter(url, selector, placeholder) {

            await axios.get(url, {
                headers: {
                    "Authorization": "Bearer {{ Session::get('api_token') }}",
                },
            })
            .then(function (res) {
                console.log('response', res.data);
                if (res.status == 200) {
                    var data = res.data.data;
                    var html = `<option value="" selected disabled>-- ${placeholder} --</option>`;
                    data.map((e) => {
                        var name = null;
                        if (e.hasOwnProperty('value')) name = e.value;
                        if (e.hasOwnProperty('name')) name = e.name;
                        if (e.hasOwnProperty('fullname')) name = e.fullname;
                        html += `<option value="${e.id}">${name}</option>`;
                    });
                    $(selector).html(html);
                } else {
                    var html = `<option value="" selected disabled>-- ${placeholder} --</option>`;
                    $(selector).html(html);
                }
            })
            .catch(function (err) {
                console.log('error', err);
                if (err.response) {
                    var html = `<option value="" selected disabled>-- ${placeholder} --</option>`;
                    $(selector).html(html);
                }
            });

        }

        $('#payment_method').on('change', function (e) {

            var paymentMethod = $(this).val();

            if (paymentMethod) {

                if (paymentMethod == 'GOPAY') {

                    var html = `
                        <div class="text-left">
                            <p>Untuk cara pembayaran dapat dilihat pada tautan berikut: <a href="https://www.gojek.com/blog/gopay/bayar-lebih-mudah-pakai-go-pay/">Link</a></p>
                        </div>
                        <div class="text-center">
                            <img src="https://images.tokopedia.net/img/cache/500-square/product-1/2018/11/8/39617213/39617213_91fd0f0c-03c2-43b4-861a-64e9f04e8f24_700_700.jpeg" alt="GOPAY" width="200">
                        </div>
                    `;

                } else if (paymentMethod = 'MANDIRI') {

                    var html = `
                        <div class="text-left">
                            <p>Untuk cara pembayaran dapat dilihat pada tautan berikut: <a href="https://www.bankmandiri.co.id/livin/edukasi/cara-transfer-antar-bank">Link</a></p>
                        </div>
                    `;

                } else if (paymentMethod = 'BCA') {

                    var html = `
                        <div class="text-left">
                            <p>Untuk cara pembayaran dapat dilihat pada tautan berikut: <a href="https://www.bankmandiri.co.id/livin/edukasi/cara-transfer-antar-bank">Link</a></p>
                        </div>
                    `;

                }

                $('#payment-method-instruction').html(html);

            }

        });

        $('#topup-modal').find('#form').on('submit', async function (e) {
            e.preventDefault();
            if ($(this).valid()) {
                blockUI();
                var url = `/api/topup`;
                var form = $('#topup-modal').find('#form')[0];
                var data = new FormData(form);
                await axios.post(url, data, {
                    headers: {
                        "Authorization": "Bearer {{ Session::get('api_token') }}",
                        "content-type": "multipart/form-data"
                    },
                })
                .then(function (res) {
                    console.log('response', res.data);
                    if (res.data.status == true) {
                        $('#topup-modal').modal('hide');
                        window.location = '/admin/user/topup-history';
                        unblockUI();
                        Swal.fire('Good job!', res.data.message, 'success');
                    } else {
                        unblockUI();
                        Swal.fire('Oops!', res.data.message, 'error');
                    }
                })
                .catch(function (err) {
                    console.log('error', err.response);
                    if (err.response) {
                        $('#topup-modal').find('#error').html(`
                            <div class="alert alert-danger" role="alert">
                                ${err.response.data.message}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        `).show('fast');
                    }
                    unblockUI();
                    Swal.fire('Oops!', 'Something went wrong...', 'error');
                });
            }
        });

    </script>

    <!-- BEGIN APP LEVEL PLUGINS/CUSTOM SCRIPTS -->
    @yield('script')
    <!-- END APP LEVEL PLUGINS/CUSTOM SCRIPTS -->

</body>

</html>