@extends('layouts.frontend.default')

@section('title', 'Cara Kerja')

@section('content')

<!-- ***** Service Area End ***** -->
<section id="service" class="section service-area pt_150 pb_50">
    <div class="container">
        <div class="row how-it-work-pc">
            <div class="col-12 col-lg-12 mt-5 mb-3">
                <!-- Content Inner -->
                <div class="content-inner text-center">
                    <!-- Section Heading -->
                    <div class="section-heading text-center mb-3">
                        <h3 class="text-capitalize font-weight-bold" style="font-size: 40px;">Gimana sih cara kerja packer?</h3>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4">
                <!-- Single Service -->
                <div class="single-service text-center p-4">
                    <span><img src="{{ asset('assets/apps/img/works-sec3.png') }}" alt=""></span>
                    <!-- <h2>3</h2> -->
                    <h3 class="my-3 font-weight-bold">3. Update</h3>
                    <p class="text-truncate" style="display: none;">Barang yang sudah melalui proses pengecekan akan segara di update ke dalam stok inventory Packer, dengan begitu seller akan langsung bisa melihat stok produk di dalam sistem Packer!</p>
                    <a class="service-detail">Stok masuk ke sistem packer</a><br>
                    <a class="service-btn mt-1" href="javascript:void(0);" data-toggle="tooltip" data-placement="right" title="Barang yang sudah melalui proses pengecekan akan segara di update ke dalam stok inventory Packer, dengan begitu seller akan langsung bisa melihat stok produk di dalam sistem Packer!">Read More</a>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4">
                <!-- Single Service -->
                <div class="single-service text-center p-4">
                    <span><img src="{{ asset('assets/apps/img/works-sec2.png') }}" alt=""></span>
                    <!-- <h2>2</h2> -->
                    <h3 class="my-3 font-weight-bold">2. Periksa</h3>
                    <a class="service-detail">Packer periksa barangmu</a><br>
                    <p class="text-truncate" style="display: none;">Barang seller yang sudah masuk di gudang Packer akan di check oleh tim yang profesional. Jika barang yang di kirim tidak sesuai / menyalahi aturan, akan di kembalikan ke Seller.</p>
                    <a class="service-btn mt-1" href="javascript:void(0);" data-toggle="tooltip" data-placement="right" title="Barang seller yang sudah masuk di gudang Packer akan di check oleh tim yang profesional. Jika barang yang di kirim tidak sesuai / menyalahi aturan, akan di kembalikan ke Seller.">Read More</a>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4">
                <!-- Single Service -->
                <div class="single-service text-center p-4">
                    <span><img src="{{ asset('assets/apps/img/works-sec1.png') }}" alt=""></span>
                    <!-- <h2>1</h2> -->
                    <h3 class="my-3 font-weight-bold">1. Kirim</h3>
                    <p class="text-truncate" style="display: none;">Seller tentukan dulu produk apa yang akan dikirimkan ke gudang Packer, nanti nya seller bisa memilih apakah produk akan dikirim sendiri atau menggunakan jasa pickup dari Packer.</p>
                    <a class="service-detail">Kirim barangmu ke packer</a><br>
                    <a class="service-btn mt-1" href="javascript:void(0);" data-toggle="tooltip" data-placement="right" title="Seller tentukan dulu produk apa yang akan dikirimkan ke gudang Packer, nanti nya seller bisa memilih apakah produk akan dikirim sendiri atau menggunakan jasa pickup dari Packer.">Read More</a>
                </div>
            </div>
        </div>
        <div class="row how-it-work-mobile">
            <div class="col-12 col-lg-12 mt-5 mb-3">
                <!-- Content Inner -->
                <div class="content-inner text-center">
                    <!-- Section Heading -->
                    <div class="section-heading text-center mb-3">
                        <h3 class="text-capitalize font-weight-bold" style="font-size: 40px;">Gimana sih cara kerja packer?</h3>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4">
                <!-- Single Service -->
                <div class="single-service text-center p-4">
                    <span><img src="{{ asset('assets/apps/img/works-sec1.png') }}" alt=""></span>
                    <h3 class="my-3 font-weight-bold">1. Kirim</h3>
                    <p class="text-truncate" style="display: none;">Seller tentukan dulu produk apa yang akan dikirimkan ke gudang Packer, nanti nya seller bisa memilih apakah produk akan dikirim sendiri atau menggunakan jasa pickup dari Packer.</p>
                    <a class="service-detail">Kirim barangmu ke packer</a><br>
                    <a class="service-btn mt-2" href="javascript:void(0);" data-toggle="tooltip" data-placement="right" title="Seller tentukan dulu produk apa yang akan dikirimkan ke gudang Packer, nanti nya seller bisa memilih apakah produk akan dikirim sendiri atau menggunakan jasa pickup dari Packer.">Read More</a>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4">
                <!-- Single Service -->
                <div class="single-service text-center p-4">
                    <span><img src="{{ asset('assets/apps/img/works-sec2.png') }}" alt=""></span>
                    <h3 class="my-3 font-weight-bold">2. Periksa</h3>
                    <p class="text-truncate" style="display: none;">Barang seller yang sudah masuk di gudang Packer akan di check oleh tim yang profesional. Jika barang yang di kirim tidak sesuai / menyalahi aturan, akan di kembalikan ke Seller.</p>
                    <a class="service-detail">Packer periksa barangmu</a><br>
                    <a class="service-btn mt-2" href="javascript:void(0);" data-toggle="tooltip" data-placement="right" title="Barang seller yang sudah masuk di gudang Packer akan di check oleh tim yang profesional. Jika barang yang di kirim tidak sesuai / menyalahi aturan, akan di kembalikan ke Seller.">Read More</a>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4">
                <!-- Single Service -->
                <div class="single-service text-center p-4">
                    <span><img src="{{ asset('assets/apps/img/works-sec3.png') }}" alt=""></span>
                    <h3 class="my-3 font-weight-bold">3. Update</h3>
                    <p class="text-truncate" style="display: none;">Barang yang sudah melalui proses pengecekan akan segara di update ke dalam stok inventory Packer, dengan begitu seller akan langsung bisa melihat stok produk di dalam sistem Packer!</p>
                    <a class="service-detail">Stok masuk ke sistem pakcer</a><br>
                    <a class="service-btn mt-2" href="javascript:void(0);" data-toggle="tooltip" data-placement="right" title="Barang yang sudah melalui proses pengecekan akan segara di update ke dalam stok inventory Packer, dengan begitu seller akan langsung bisa melihat stok produk di dalam sistem Packer!">Read More</a>
                </div>
            </div>
        </div>
        <div class="row mt-1 how-it-work-mobile">
            <div class="col-12 col-md-6 col-lg-4">
                <!-- Single Service -->
                <div class="single-service text-center p-4">
                    <span><img src="{{ asset('assets/apps/img/works-sec4.png') }}" alt=""></span>
                    <h3 class="my-3 font-weight-bold">4. Sistem Integrasi</h3>
                    <p class="text-truncate" style="display: none;">Untuk setiap orderan seller nanti nya akan langsung terintergrasi dengan sistem Packer, jadi seller cukup proses setiap orderan melalui sistem Packer.</p>
                    <a class="service-detail">Penjualan online/offline masuk ke sistem packer</a><br>
                    <a class="service-btn mt-2 sistem-terintegrasi" href="javascript:void(0);">Read More</a>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4">
                <!-- Single Service -->
                <div class="single-service text-center p-4">
                    <span><img src="{{ asset('assets/apps/img/works-sec5.png') }}" alt=""></span>
                    <h3 class="my-3 font-weight-bold">5. Packing</h3>
                    <p class="text-truncate" style="display: none;">Orderan yang sudah di pilih akan langsung di Packing oleh tim Profesional Packer. Nah, untuk Packing sendiri Seller bisa juga memilih packaging yang di inginkan bahkan meminta tim Packer untuk melakukan pengecekan produk2 sebelum di kirim!</p>
                    <a class="service-detail">Packer packing orderanmu</a><br>
                    <a class="service-btn mt-2" href="javascript:void(0);" data-toggle="tooltip" data-placement="right" title="Orderan yang sudah di pilih akan langsung di Packing oleh tim Profesional Packer. Nah, untuk Packing sendiri Seller bisa juga memilih packaging yang di inginkan bahkan meminta tim Packer untuk melakukan pengecekan produk2 sebelum di kirim!">Read More</a>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4">
                <!-- Single Service -->
                <div class="single-service text-center p-4">
                    <span><img src="{{ asset('assets/apps/img/works-sec6.png') }}" alt=""></span>
                    <h3 class="my-3 font-weight-bold">6. Antar</h3>
                    <p class="text-truncate" style="display: none;">Jika orderan sudah di Packing dengan rapi, Tim Packer akan langsung mengirimkan produk2 jualan seller ke ekspedisi yang di pilih oleh Seller. Produk yang di kirimkan ke ekspedisi akan selalu di jaga dengan hati2 supaya akan sampai dengan selamat ke customer :D</p>
                    <a class="service-detail">Orderan dipickup oleh kurir</a><br>
                    <a class="service-btn mt-2" href="javascript:void(0);" data-toggle="tooltip" data-placement="right" title="Jika orderan sudah di Packing dengan rapi, Tim Packer akan langsung mengirimkan produk2 jualan seller ke ekspedisi yang di pilih oleh Seller. Produk yang di kirimkan ke ekspedisi akan selalu di jaga dengan hati2 supaya akan sampai dengan selamat ke customer :D">Read More</a>
                </div>
            </div>
        </div>
        <div class="row mt-1 how-it-work-pc">
            <div class="col-12 col-md-6 col-lg-4">
                <!-- Single Service -->
                <div class="single-service text-center p-4">
                    <span><img src="{{ asset('assets/apps/img/works-sec6.png') }}" alt=""></span>
                    <h3 class="my-3 font-weight-bold">6. Antar</h3>
                    <p class="text-truncate" style="display: none;">Jika orderan sudah di Packing dengan rapi, Tim Packer akan langsung mengirimkan produk2 jualan seller ke ekspedisi yang di pilih oleh Seller. Produk yang di kirimkan ke ekspedisi akan selalu di jaga dengan hati2 supaya akan sampai dengan selamat ke customer :D</p>
                    <a class="service-detail">Orderan dipickup oleh kurir</a><br>
                    <a class="service-btn mt-2" href="javascript:void(0);" data-toggle="tooltip" data-placement="right" title="Jika orderan sudah di Packing dengan rapi, Tim Packer akan langsung mengirimkan produk2 jualan seller ke ekspedisi yang di pilih oleh Seller. Produk yang di kirimkan ke ekspedisi akan selalu di jaga dengan hati2 supaya akan sampai dengan selamat ke customer :D">Read More</a>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4">
                <!-- Single Service -->
                <div class="single-service text-center p-4">
                    <span><img src="{{ asset('assets/apps/img/works-sec5.png') }}" alt=""></span>
                    <h3 class="my-3 font-weight-bold">5. Packing</h3>
                    <p class="text-truncate" style="display: none;">Orderan yang sudah di pilih akan langsung di Packing oleh tim Profesional Packer. Nah, untuk Packing sendiri Seller bisa juga memilih packaging yang di inginkan bahkan meminta tim Packer untuk melakukan pengecekan produk2 sebelum di kirim!</p>
                    <a class="service-detail">Packer packing orderanmu</a><br>
                    <a class="service-btn mt-2" href="javascript:void(0);" data-toggle="tooltip" data-placement="right" title="Orderan yang sudah di pilih akan langsung di Packing oleh tim Profesional Packer. Nah, untuk Packing sendiri Seller bisa juga memilih packaging yang di inginkan bahkan meminta tim Packer untuk melakukan pengecekan produk2 sebelum di kirim!">Read More</a>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-4">
                <!-- Single Service -->
                <div class="single-service text-center p-4">
                    <span><img src="{{ asset('assets/apps/img/works-sec4.png') }}" alt=""></span>
                    <h3 class="my-3 font-weight-bold">4. Sistem Intergrasi</h3>
                    <p class="text-truncate" style="display: none;">Untuk setiap orderan seller nanti nya akan langsung terintergrasi dengan sistem Packer, jadi seller cukup proses setiap orderan melalui sistem Packer.</p>
                    <a class="service-detail">Penjualan online/offline masuk ke sistem packer</a><br>
                    <a class="service-btn mt-2 sistem-terintegrasi" href="javascript:void(0);">Read More</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ***** Service Area End ***** -->

@endsection