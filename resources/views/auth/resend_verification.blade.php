@extends('auth.default')

@section('title', 'Resend Verification')

@section('content')

<div class="form-content">
    <img src="{{ asset('assets/apps/img/logo.png') }}" class="mb-3" alt="Packer" width="120">
    <h1 class="title mt-3">Resend Verification</h1>
    <p class="subtitle">Resend email verification.</p>
    <form class="text-left" id="form" action="{{ url('/api/resend-verification') }}" method="POST">
        @csrf
        <div class="form">
            <div id="email-field" class="field-wrapper input">
                <label for="email">EMAIL</label>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                <input type="text" class="form-control" id="email" name="email" placeholder="Masukkan Email Anda">
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
                email: {
                    required: true,
                    email: true,
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