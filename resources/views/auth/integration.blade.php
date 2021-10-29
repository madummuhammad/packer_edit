@extends('auth.default')

@section('title', 'Integration')

@php

$path = '/api/v2/shop/auth_partner';
$timestamp = time();
$baseString = env('SHOPEE_CLIENT_ID') . $path . $timestamp;
$sign = hash_hmac('sha256', $baseString, env('SHOPEE_CLIENT_SECRET'));

@endphp

@section('content')

<div class="form-content">
    <img src="{{ asset('assets/apps/img/logo.png') }}" class="mb-3" alt="Packer" width="120">
    <h1 class="title mt-3">Integration for {{ Request::segment(count(Request::segments())) }}.</h1>
    <p class="subtitle"></p>
    @if (Request::segment(count(Request::segments())) == "tokopedia")
    <form class="text-left" id="form">
        <input type="hidden" id="platform_slug" name="platform_slug" value="{{ Request::segment(count(Request::segments())) }}">
        <div class="form">
            <div id="client_id-field" class="field-wrapper input">
                <label for="client_id">Client ID</label>
                <input type="text" class="form-control" id="client_id" name="client_id" placeholder="Enter your Tokopedia Client ID">
            </div>
            <div id="client_secret-field" class="field-wrapper input">
                <label for="client_secret">Client Secret</label>
                <input type="text" class="form-control" id="client_secret" name="client_secret" placeholder="Enter your Tokopedia Client Secret">
            </div>
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary btn-block text-white" id="btn-submit">
                    Authorize Tokopedia
                </button>
            </div>
        </div>
    </form>
    @elseif (Request::segment(count(Request::segments())) == "shopee")
    <div class="d-flex justify-content-between">
        <a href="https://partner.shopeemobile.com/api/v2/shop/auth_partner?partner_id={{ env('SHOPEE_CLIENT_ID') }}&redirect={{ env('APP_URL') }}/api/integration/shopee/callback?token={{ Session::get('api_token') }}&sign={{ $sign }}&timestamp={{ $timestamp }}" type="button" class="btn btn-primary btn-block text-white" id="btn-submit">
            <span class="spinner-border spinner-border-sm mr-2" id="spinner" role="status" aria-hidden="true" style="display: none;"></span>
            Authorize Shopee
        </a>
    </div>
    @elseif (Request::segment(count(Request::segments())) == "blibli")
    <form class="text-left" id="form">
        <input type="hidden" id="platform_slug" name="platform_slug" value="{{ Request::segment(count(Request::segments())) }}">
        <div class="form">
            <div id="name-field" class="field-wrapper input">
                <label for="name">Seller ID</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter your Blibli Seller ID">
            </div>
            <div id="key-field" class="field-wrapper input">
                <label for="name">API Seller Key</label>
                <input type="text" class="form-control" id="key" name="key" placeholder="Enter your Blibli API Seller Key">
            </div>
            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-primary btn-block text-white" id="btn-submit">
                    <span class="spinner-border spinner-border-sm mr-2" id="spinner" role="status" aria-hidden="true" style="display: none;"></span>
                    Authorize Blibli
                </button>
            </div>
        </div>
    </form>
    @endif
</div>

@endsection

@section('script')

<script>

    $(function () {

        @if (Request::segment(count(Request::segments())) == "tokopedia")

        var validator = $('#form').validate();

        $('#client_id').rules('add', { required: true });
        $('#client_secret').rules('add', { required: true });

        $('#form').on('submit', async function(e) {

            e.preventDefault();

            if ($(this).valid()) {

                $('#btn-submit').attr('disabled', true);
                $('#spinner').show('fast');

                var url = `/api/integration/{{ Request::segment(count(Request::segments())) }}/oauth`;

                var form = $(this)[0];
                var data = new FormData(form);

                await axios.post(url, data, {
                    headers: {
                        "Authorization": "Bearer {{ Session::get('api_token') }}",
                        "content-type": "multipart/form-data"
                    },
                }).then(function (res) {
                    console.log('response', res.data);
                    if (res.status == 200) {
                        $('#btn-submit').attr('disabled', false);
                        $('#spinner').hide('fast');
                        Swal.fire('Good job!', res.data.message, 'success').then(function (e) {
                            window.location = '/admin/main/integration';
                        });
                    } else {
                        $('#btn-submit').attr('disabled', false);
                        $('#spinner').hide('fast');
                        Swal.fire('Oops!', res.data.message, 'error');
                    }
                })
                .catch(function (err) {
                    console.log('error', err.response);
                    $('#btn-submit').attr('disabled', false);
                    $('#spinner').hide('fast');
                    Swal.fire('Oops!', err.response.data.message, 'error');
                });
                
            }

        });

        @elseif (Request::segment(count(Request::segments())) == "blibli")

        var validator = $('#form').validate();

        $('#name').rules('add', { required: true });
        $('#key').rules('add', { required: true });

        $('#form').on('submit', async function(e) {

            e.preventDefault();

            if ($(this).valid()) {

                $('#btn-submit').attr('disabled', true);
                $('#spinner').show('fast');

                var url = `/api/integration/{{ Request::segment(count(Request::segments())) }}/oauth`;

                var form = $(this)[0];
                var data = new FormData(form);

                await axios.post(url, data, {
                    headers: {
                        "Authorization": "Bearer {{ Session::get('api_token') }}",
                        "content-type": "multipart/form-data"
                    },
                }).then(function (res) {
                    console.log('response', res.data);
                    if (res.status == 200) {
                        $('#btn-submit').attr('disabled', false);
                        $('#spinner').hide('fast');
                        Swal.fire('Good job!', res.data.message, 'success').then(function (e) {
                            window.location = '/admin/main/integration';
                        });
                    } else {
                        $('#btn-submit').attr('disabled', false);
                        $('#spinner').hide('fast');
                        Swal.fire('Oops!', res.data.message, 'error');
                    }
                })
                .catch(function (err) {
                    console.log('error', err.response);
                    $('#btn-submit').attr('disabled', false);
                    $('#spinner').hide('fast');
                    Swal.fire('Oops!', err.response.data.message, 'error');
                });
                
            }

        });

        @endif

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

@endsection