@extends('auth.default')

@section('title', 'Login')

@section('content')

<div class="form-content">
    <a href="{{ url('') }}"><img src="{{ asset('assets/apps/img/logo.png') }}" class="mb-3" alt="Packer" width="120"></a>
    <h1 class="title mt-3">Sign In</h1>
    <p class="subtitle">Log in to your account to continue.</p>
    <form class="text-left" id="form" action="{{ url('sign-in') }}" method="POST">
        @csrf
        <div class="form">
            <div id="username-field" class="field-wrapper input">
                <label for="username">EMAIL</label>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan Email Anda">
            </div>
            <div id="password-field" class="field-wrapper input mb-2">
                <div class="d-flex justify-content-between">
                    <label for="password">PASSWORD</label>
                    <a href="{{ url('forgot-password') }}" class="forgot-pass-link">Forgot Password?</a>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan Password Anda">
                <a href="javascript:void(0);" onclick=""><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" id="toggle-password" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg></a>
            </div>
            <div class="d-sm-flex justify-content-between">
                <div class="field-wrapper">
                    <button type="submit" class="btn btn-primary" value="">Log In</button>
                </div>
            </div>
            <p class="signup-link">Belum punya akun? <a href="https://api.whatsapp.com/send?phone=6282112033911">Daftar Sekarang!</a></p>
        </div>
    </form>
</div>

@endsection

@section('script')

<!-- <script>

    @if (Session::has('success'))
    Swal.fire('Good job!', "{{ Session::get('success') }}", 'success');
    @endif

    @if (Session::has('error'))
    Swal.fire('Oops!', "{{ Session::get('error') }}", 'error');
    @if (Session::get(('error')) == 'Maaf! Mohon melakukan verifikasi email terlebih dahulu...')
    $('.subtitle').after(`
        <div class="alert alert-light-primary text-left border-0 mb-4" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><svg viewBox="0 0 24 24" width="19" height="19" stroke="#4361ee" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg></button>
            Bila anda belum menerima email, kirim ulang email verifikasi anda <a href="{{ url('resend-verification') }}">disini</a>!</button>
        </div>
    `);
    @endif
    @endif

    var url = new URL(window.location.href);
    
    if (url.searchParams.get('username')) $('#form').find('#username').val(url.searchParams.get('username'));

    $(function () {

        var validator = $('#form').validate({
            rules: {
                username: {
                    required: true,
                    email: true,
                },
                password: {
                    required: true,
                }
            }
        });

        $('#form').on('submit', function(e) {

            if ($(this).valid()) {
                blockUI();
            }

        });

    });

</script> -->

@endsection