@extends('auth.default')

@section('title', 'Resend Verification')

@section('content')

<div class="form-content">
    <img src="{{ asset('assets/apps/img/logo.png') }}" class="mb-3" alt="Packer" width="120">
    <h1 class="title mt-3">Change Password</h1>
    <p class="subtitle">Please input your new password below.</p>
    <form class="text-left" id="form" action="{{ url('/api/change-password') }}" method="POST">
        @csrf
        <div class="form">
            <input type="hidden" name="email" value="{{ Crypt::decryptString(Request::segment(count(Request::segments()))) }}">
            <div id="password-field" class="field-wrapper input mb-2">
                <div class="d-flex justify-content-between">
                    <label for="password">PASSWORD</label>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan Password Anda">
                <a href="javascript:void(0);" onclick=""><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" id="toggle-password" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></a>
            </div>
            <div class="d-sm-flex justify-content-between">
                <div class="field-wrapper">
                    <button type="submit" class="btn btn-primary" value="">Continue</button>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection

@section('script')

<script>

    @if (Session::has('success'))
    Swal.fire('Good job!', "{{ Session::get('success') }}", 'success');
    @endif

    @if (Session::has('error'))
    Swal.fire('Oops!', "{{ Session::get('error') }}", 'error');
    @endif

    $(function () {

        var validator = $('#form').validate({
            rules: {
                password: {
                    required: true,
                },
            }
        });

        $('#form').on('submit', function(e) {

            if ($(this).valid()) {
                blockUI();
            }

        });

    });

</script>

@endsection