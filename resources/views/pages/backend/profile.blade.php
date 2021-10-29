@extends('layouts.backend.default')

@section('title', 'Profile')

@section('style')

<link href="{{ asset('assets/backend/plugins/dropify/dropify.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/backend/assets/css/users/account-setting.css') }}" rel="stylesheet">

@endsection

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card form-div">
            <input type="hidden" id="id" name="id">
            <form class="" id="form">
                <div class="card-header bg-light">
                    <div class="d-flex justify-content-between align-items-baseline p-0">
                        <div class="card-title p-0 m-0">User Management</div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="username">Email</label>
                            <input type="email" class="form-control mb-4" id="username" placeholder="Email" value="">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="password">Password</label>
                            <input type="password" class="form-control mb-4" id="password" placeholder="Password" value="">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="fullname">Fullname</label>
                            <input type="text" class="form-control mb-4" id="fullname" placeholder="Fullname" value="">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control mb-4" id="phone" placeholder="Phone" value="">
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <button type="submit" class="btn btn-primary btn-sm" id="btn-submit">
                        Confirm Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('script')

<script src="{{ asset('assets/backend/assets/js/users/account-settings.js') }}"></script>

<script>

    $(function () {

        getUserProfile();

        var validator = $('#form').validate();

        $('#form').on('submit', async function(e) {

            e.preventDefault();

            if ($(this).valid()) {

                blockUI();

                var form = $('#form')[0];
                var data = new FormData(form);

                var id = $('#id').val();

                var url = `/api/user/${id}`;

                await axios.post(url, data, {
                    headers: {
                        "Authorization": "Bearer {{ Session::get('api_token') }}",
                        "content-type": "multipart/form-data"
                    },
                })
                .then(function (res) {
                    console.log('response', res.data);
                    if (res.data.status == true) {
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
                        $('#error').html(`
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

                getUserProfile();

            }

        });

    });

    async function getUserProfile() {

        blockUI();

        await axios.get(`/api/profile`, {
            headers: {
                "Authorization": "Bearer {{ Session::get('api_token') }}",
            },
        })
        .then(function (res) {

            console.log('response', res.data);

            if (res.status == 200) {

                var data = res.data.data;

                $('.form-div').find('#id').val(data ? data.id : null);

                $('.form-div').find('#username')
                    .val(data ? data.username : null)
                    .rules('add', { required: true });

                $('.form-div').find('#password')
                    .val(null)
                    .rules('add', { required: false });

                $('.form-div').find('#fullname')
                    .val(data ? data.fullname : null)
                    .rules('add', { required: true });

                $('.form-div').find('#phone')
                    .val(data ? data.phone : null)
                    .rules('add', { required: true });

            } else {
                
                // TODO

            }
        })
        .catch(function (err) {

            console.log('error', err.response);

            if (err.response) {

                // TODO
                
            }

        });

        unblockUI();

    }

</script>

@endsection
