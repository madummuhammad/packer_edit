@extends('layouts.frontend.default')

@section('title', 'Halaman Utama')

@section('content')

<!-- ***** Welcome Area Start ***** -->
<section id="home" class="section welcome-area bg-overlay overflow-hidden d-flex align-items-center">
    <div class="container">
        <div class="row align-items-center">
            <!-- Welcome Intro Start -->
            <div class="col-12 col-md-7">
                <div class="welcome-intro text-right">
                    <h2 class="text-dark font-weight-bold">Gudang Online untuk Bisnis Online-mu</h2>
                    <p class="text-dark my-4">Tidak perlu takut jualan online, Packer punya solusinya</p>
                    <!-- Buttons -->
                    <div class="button-group">
                        <a href="https://api.whatsapp.com/send?phone=6282260001709&amp;text=Hallo%20Packer%20Indonesia!%0ASaya%20mau%20tau%20lebih%20lanjut" target="_blank" class="btn btn-bordered-white text-dark text-center align-middle" style="border: 2px solid #343a40 !important;">Coba Gratis</a>
                        <a href="https://www.youtube.com/watch?v=SjHx3b4mMQ8" target="_blank" class="btn btn-bordered-white text-dark text-center align-middle" style="border: 2px solid #343a40 !important;"><i class="fas fa-play-circle contact-icon mr-md-2"></i>Play Video</a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-5">
                <!-- Welcome Thumb -->
                <div class="welcome-thumb-wrapper mt-5 mt-md-0">
                    <span class="welcome-thumb-1">
                        <img class="welcome-animation d-block ml-auto" src="{{ asset('assets/apps/img/thumb_1.png') }}" alt="" style="height: 380px;">
                    </span>
                    <span class="welcome-thumb-2">
                        <img class="welcome-animation d-block" src="{{ asset('assets/apps/img/thumb_2.png') }}" alt="" style="height: 220px;">
                    </span>
                    <span class="welcome-thumb-3" style="top: 55%; left: 65%;">
                        <img class="welcome-animation d-block" src="{{ asset('assets/apps/img/thumb_3.png') }}" alt="" style="height: 200px;">
                    </span>
                    <!--                     <span class="welcome-thumb-4">
                        <img class="welcome-animation d-block" src="{{ asset('assets/apps/img/thumb_4.png') }}" alt="">
                    </span> -->
                    <span class="welcome-thumb-5">
                        <img class="welcome-animation d-block" src="{{ asset('assets/apps/img/thumb_5.png') }}" alt="" style="height: 90px;">
                    </span>
                    <span class="welcome-thumb-6">
                        <img class="welcome-animation d-block" src="{{ asset('assets/apps/img/thumb_6.png') }}" alt="" style="height: 90px;">
                    </span>
                </div>
            </div>
        </div>
    </div>
    <!-- Shape Bottom -->
    <div class="shape shape-bottom">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" preserveAspectRatio="none" fill="#FFFFFF">
            <path class="shape-fill" d="M421.9,6.5c22.6-2.5,51.5,0.4,75.5,5.3c23.6,4.9,70.9,23.5,100.5,35.7c75.8,32.2,133.7,44.5,192.6,49.7
            c23.6,2.1,48.7,3.5,103.4-2.5c54.7-6,106.2-25.6,106.2-25.6V0H0v30.3c0,0,72,32.6,158.4,30.5c39.2-0.7,92.8-6.7,134-22.4
            c21.2-8.1,52.2-18.2,79.7-24.2C399.3,7.9,411.6,7.5,421.9,6.5z"></path>
        </svg>
    </div>
</section>
<!-- ***** Welcome Area End ***** -->

<!-- ***** Service Area End ***** -->
<section class="section service-area bg-grey" style="padding-top: 70px; padding-bottom: 30px;">
    <!-- Shape Top -->
    <div class="shape shape-top">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" preserveAspectRatio="none" fill="#FFFFFF">
            <path class="shape-fill" d="M421.9,6.5c22.6-2.5,51.5,0.4,75.5,5.3c23.6,4.9,70.9,23.5,100.5,35.7c75.8,32.2,133.7,44.5,192.6,49.7
            c23.6,2.1,48.7,3.5,103.4-2.5c54.7-6,106.2-25.6,106.2-25.6V0H0v30.3c0,0,72,32.6,158.4,30.5c39.2-0.7,92.8-6.7,134-22.4
            c21.2-8.1,52.2-18.2,79.7-24.2C399.3,7.9,411.6,7.5,421.9,6.5z"></path>
        </svg>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-6 col-lg-3 mb-3">
                <!-- Single Service -->
                <div class="single-service service-gallery m-0 overflow-hidden">
                    <!-- Service Thumb -->
                    <div class="service-thumb text-center" style="height: 240px;">
                        <a href="#"><img src="{{ asset('assets/apps/img/home-sec1-4.png') }}" alt="" width="240"></a>
                    </div>
                    <!-- Service Content -->
                    <div class="service-content bg-white py-1" style="height: 100px;">
                        <h4 class="font-weight-bold py-3" style="font-size: 18px;">Biaya Gudang dan Karyawan Mahal?</h4>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-3 mb-3">
                <!-- Single Service -->
                <div class="single-service service-gallery m-0 overflow-hidden">
                    <!-- Service Thumb -->
                    <div class="service-thumb text-center" style="height: 240px;">
                        <a href="#"><img src="{{ asset('assets/apps/img/home-sec1-3.png') }}" alt="" width="240"></a>
                    </div>
                    <!-- Service Content -->
                    <div class="service-content bg-white py-1" style="height: 100px;">
                        <h4 class="font-weight-bold py-3" style="font-size: 18px;">Punya Bisnis Online tapi Jauh dari Lokasi Strategis?</h4>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-3 mb-3">
                <!-- Single Service -->
                <div class="single-service service-gallery m-0 overflow-hidden">
                    <!-- Service Thumb -->
                    <div class="service-thumb text-center" style="height: 240px;">
                        <a href="#"><img src="{{ asset('assets/apps/img/home-sec1-2.png') }}" alt="" width="240"></a>
                    </div>
                    <!-- Service Content -->
                    <div class="service-content bg-white py-1" style="height: 100px;">
                        <h4 class="font-weight-bold py-3" style="font-size: 18px;">Pengen Berlibur tapi harus Urus Orderan?</h4>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-3 mb-3">
                <!-- Single Service -->
                <div class="single-service service-gallery m-0 overflow-hidden">
                    <!-- Service Thumb -->
                    <div class="service-thumb text-center" style="height: 240px;">
                        <a href="#"><img src="{{ asset('assets/apps/img/home-sec1-1.png') }}" alt="" width="240"></a>
                    </div>
                    <!-- Service Content -->
                    <div class="service-content bg-white py-1" style="height: 100px;">
                        <h4 class="font-weight-bold py-3" style="font-size: 18px;">Punya Bisnis Online tapi Kerja Kantoran?</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ***** Service Area End ***** -->

<!-- ***** Content Area Start ***** -->
<section class="section content-area" style="padding-top: 100px; padding-bottom: 0px;">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-12 col-lg-12">
                <div class="section-heading text-center" style="margin-bottom: 10px;">
                    <p class="text-capitalize mb-3 tenang" style="font-size: 30px;">Tenang, Gak perlu pusing lagi, Kini ada</p>
                    <!-- <h2 class="text-capitalize" style="color: #fcaf1d;">Packer</h2> -->
                </div>
            </div>
            <div class="col-12 col-lg-12" style="padding-top: 0px;">
                <div class="section-content text-center">
                    <img src="{{ url('assets/apps/img/logo.png') }}" alt="brand-logo" class="mb-3" style="height: 90px; border-radius: 10%;">
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ***** Content Area End ***** -->

<!-- ***** Content Area Start ***** -->
<section class="section content-area">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-12 col-lg-12">
                <!-- Service Thumb -->
                <div class="service-thumb mx-auto pt-4 pt-lg-0">
                    <img src="{{ asset('assets/apps/img/home-sec3.gif') }}" alt="">
                </div>
            </div>
            <div class="col-12 col-lg-12 btn-cara-kerja-kami">
                <div class="content-inner text-center pt-sm-4 pt-lg-0 mt-sm-5 mt-lg-0 align-middle">
                    <!-- Buttons -->
                    <div class="button-group">
                        <a href="{{ url('/cara-kerja') }}" class="btn btn-bordered-white text-dark text-center align-middle" style="border: 2px solid #343a40 !important;">Cara Kerja Kami</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ***** Content Area End ***** -->

@include('layouts.frontend.components.section_review', ['title' => 'Testimonial'])

@include('layouts.frontend.components.section_call_to_action', ['title' => 'Ingin tahu lebih lanjut?', 'subtitle' => null, 'color' => 'bg-grey'])

@endsection