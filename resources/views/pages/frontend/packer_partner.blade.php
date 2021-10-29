@extends('layouts.frontend.default')

@section('title', 'Mitra Gudang')

@section('content')

<!--====== Contact Area Start ======-->
<section id="contact" class="contact-area bg-grey ptb_150">
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-12 col-lg-6 mt-5 pt-5">
                <!-- Section Heading -->
                <div class="section-heading text-center mb-3 mitra-title">
                    <h2 class="text-capitalize" style="font-size: 30px;">Mau bermitra dengan packer?</h2>
                </div>
                <!-- Service Thumb -->
                <div class="section-thumb mx-auto pt-4 pt-lg-0 mitra-img">
                    <img src="{{ asset('assets/apps/img/partner-sec1.png') }}" alt="" style="height: 100%; width: 100%">
                </div>
            </div>
            <div class="col-12 col-lg-6 pt-4 pt-lg-0">

                <!-- Contact Box -->
                <div class="contact-box">
                    @if ($message = Session::get('message'))
                    <div class="alert alert-success alert-block mt-4">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                    @endif
                    @if ($error = Session::get('error'))
                    <div class="alert alert-danger alert-block mt-4">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $error }}</strong>
                    </div>
                    @endif
                    <!-- Contact Form -->
                    <form id="contactform" method="POST" action="{{url('kirimemail')}}">
                        {{csrf_field()}}
                        <div class="row m-2 card shadow pb-5 mt-5">
                            <div class="col-12 pt-3">
                                <div class="form-group pl-1" id="name">
                                    <label for="" class="ml-2">Nama</label>
                                    <input type="text" class="form-control border" name="name" placeholder="">
                                    <div class="invalid-feedback">*Nama wajib diisi</div>
                                </div>
                                <div class="form-group pl-1">
                                    <style>
                                        input[type=number]::-webkit-inner-spin-button,
                                        input[type=number]::-webkit-outer-spin-button {
                                            -webkit-appearance: none;
                                            margin: 0;
                                        }
                                    </style>
                                    <label for="" class="ml-2">Nomor Telepon</label>
                                    <div class="input-group mb-3" id="nomor_hp">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">+62</span>
                                        </div>
                                        <input oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" type="number" maxlength="13" class="form-control border" name="phone" placeholder="">
                                        <div class="invalid-feedback">*Nomor telepon wajib diisi</div>
                                    </div>
                                </div>
                                <div class="form-group pl-1" id="warehouse_address">
                                    <label for="" class="ml-2">Alamat Gudang</label>
                                    <input type="text" class="form-control border" name="warehouse_address" placeholder="">
                                    <div class="invalid-feedback">*Alamat gudang wajib diisi</div>
                                </div>
                                <div class="form-group pl-1" id="warehouse_area">
                                    <label for="" class="ml-2">Luasan Gudang (m2)</label>
                                    <input type="number" class="form-control border" name="warehouse_area" id="luaan" placeholder="">
                                    <div class="invalid-feedback">*Luasan gudang wajib diisi</div>
                                </div>
                                <script>
                                    $('input[type=number]').on('mousewheel', function(e) {
                                        $(e.target).blur();
                                    });
                                </script>
                                <div class=" text-left" id="warehouse_facility">
                                    <label for="" class="ml-2 pl-1">Fasilitas Gudang</label>
                                    <div class="row card shadow ml-1 mr-1 p-2">
                                        <div class="col-lg-6">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="checkbox1" name="warehouse_facility[]" value="Wifi">
                                                <label class="custom-control-label" for="checkbox1">Wifi</label>
                                            </div>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="checkbox2" name="warehouse_facility[]" value="Kipas Angin/ AC">
                                                <label class="custom-control-label" for="checkbox2">Kipas Angin/ AC</label>
                                            </div>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="checkbox3" name="warehouse_facility[]" value="CCTV">
                                                <label class="custom-control-label" for="checkbox3">CCTV</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="checkbox4" name="warehouse_facility[]" value="RAK">
                                                <label class="custom-control-label" for="checkbox4">Rak</label>
                                            </div>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="checkbox5" name="warehouse_facility[]" value="Meja dan Kursi">
                                                <label class="custom-control-label" for="checkbox5">Meja dan Kursi</label>
                                            </div>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="checkbox6" name="warehouse_facility[]" value="Perkantoran">
                                                <label class="custom-control-label" for="checkbox6">Perkantoran</label>
                                            </div>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="checkbox7" name="warehouse_facility[]" value="Kosong">
                                                <label class="custom-control-label" for="checkbox7">Kosong</label>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="invalid-feedback">*Fasilitas gudang wajib pilih salah satu</div>
                                </div>
                                <div class="text-left mt-3" id="warehouse_vehicle">
                                    <label for="" class="ml-2 pl-1">Akses Kendaraan</label>
                                    <div class="row card shadow ml-1 mr-1 p-2">
                                        <div class="col-lg-6">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="checkbox8" name="warehouse_vehicle[]" value="Fuso">
                                                <label class="custom-control-label" for="checkbox8">Fuso</label>
                                            </div>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="checkbox9" name="warehouse_vehicle[]" value="Mobil Pickup">
                                                <label class="custom-control-label" for="checkbox9">Mobil Pickup</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="checkbox10" name="warehouse_vehicle[]" value="Wing Box">
                                                <label class="custom-control-label" for="checkbox10">Wing Box</label>
                                            </div>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="checkbox11" name="warehouse_vehicle[]" value="Container 20ft">
                                                <label class="custom-control-label" for="checkbox11">Container 20ft</label>
                                            </div>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" id="checkbox12" name="warehouse_vehicle[]" value="Container 40ft">
                                                <label class="custom-control-label" for="checkbox12">Container 40ft</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback">*Akses kendaraan wajib pilih salah satu</div>
                                </div>
                                <div class="text-left pl-2 pr-2 mt-3" id="warehouse_type">
                                    <label for="" class="pl-1">Tipe Gudang</label>
                                    <div class="form-group">
                                        <select class="form-control border" id="sel1" name="warehouse_type">
                                            <option value="" selected disabled>-- Pilih Tipe Gudang --</option>
                                            <option value="Ruko">Ruko</option>
                                            <option value="Pergudangan">Pergudangan</option>
                                        </select>
                                    </div>
                                    <div class="invalid-feedback">*Tipe gudang wajib pilih salah satu</div>
                                </div>
                                <div class="text-left pl-2 pr-2 mt-3" id="is_flood_free">
                                    <label for="" class="pl-1">Bebas Banjir?</label>
                                    <div class="form-group">
                                        <select class="form-control border" name="is_flood_free">
                                            <option value="" selected disabled>-- Bebas Banjir? --</option>
                                            <option value="Ya">Ya</option>
                                            <option value="Tidak">Tidak</option>
                                        </select>
                                    </div>
                                    <div class="invalid-feedback">*Bebas banjir wajib pilih salah satu</div>
                                </div>
                                <div class="text-left pl-2 pr-2 mt-3" id="is_parking_free">
                                    <label for="" class="pl-1">Bebas Parkir?</label>
                                    <div class="form-group">
                                        <select class="form-control border" name="is_parking_free">
                                            <option value="" selected disabled>-- Bebas Parkir? --</option>
                                            <option value="Ya">Ya</option>
                                            <option value="Tidak">Tidak</option>
                                        </select>
                                    </div>
                                    <div class="invalid-feedback">*Bebas parkir wajib pilih salah satu</div>
                                </div>
                                <div class="text-left pl-2 pr-2 mt-3" id="warehouse_ownership">
                                    <label for="" class="pl-1">Kepemilikan Gudang</label>
                                    <div class="form-group">
                                        <select class="form-control border" name="warehouse_ownership">
                                            <option value="" selected disabled>-- Pilih Kepemilikan Gudang --</option>
                                            <option value="Milik Pribadi">Milik Pribadi</option>
                                            <option value="Sewa">Sewa</option>
                                        </select>
                                    </div>
                                    <div class="invalid-feedback">*Kepemilikan gudang wajib pilih salah satu</div>
                                </div>
                                <div class="col-12 pt-1">
                                    <button id="button_mitra" type="button" class="btn btn-bordered active btn-block mt-3"><span class="text-white pr-3"><i class="fas fa-paper-plane"></i></span>Daftar Mitra Gudang</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <p class="form-message"></p>
                </div>
            </div>
        </div>
    </div>
</section>
<!--====== Contact Area End ======-->

@endsection