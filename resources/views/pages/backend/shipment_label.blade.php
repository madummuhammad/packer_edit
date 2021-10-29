@extends('layouts.backend.default')

@section('title', 'Shipment Label')

@section('style')

<link href="{{ asset('assets/backend/assets/css/apps/invoice-preview.css') }}" rel="stylesheet" type="text/css" />

@endsection

@section('content')

<div class="row invoice layout-top-spacing layout-spacing">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="doc-container">
            <div class="row">
                <div class="col-xl-9">
                    <div class="invoice-container">
                        <div class="invoice-inbox">
                            <div id="ct" class="">
                                <div class="invoice-00001">
                                    <div class="content-section">
                                        <div class="inv--head-section inv--detail-section" style="border: none;">
                                            <div class="row">
                                                <div class="col-sm-6 mr-auto pb-3" style="border-bottom: 1px solid #ebedf2">
                                                    <img class="company-logo" src="{{ asset('assets/apps/img/logo.png') }}" alt="company" style="width: 240px; height: 90px;">
                                                </div>
                                                <div class="col-sm-6 pb-3 text-sm-right" style="border-bottom: 1px solid #ebedf2">
                                                    <div class="platform-logo"></div>
                                                </div>
                                                <div class="col-sm-6 text-left" style="border-bottom: 1px solid #ebedf2">
                                                    <p class="py-2 mb-0 inv-no" style="font-size: 12px;"></p>
                                                </div>
                                                <div class="col-sm-6 text-right" style="border-bottom: 1px solid #ebedf2">
                                                    <p class="py-2 mb-0 inv-date" style="font-size: 12px;"></p>
                                                </div>
                                                <div class="col-sm-6 text-left py-3" style="border-bottom: 1px solid #ebedf2">
                                                    <div class="courier-logo"></div>
                                                </div>
                                                <div class="col-sm-6 text-right py-3" style="border-bottom: 1px solid #ebedf2">
                                                    <img src="" alt="" id="barcode">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="inv--detail-section inv--customer-detail-section">
                                            <div class="row">
                                                <div class="col-xl-8 col-lg-7 col-md-6 col-sm-4 align-self-center">
                                                    <p class="inv-to">Penerima</p>
                                                </div>
                                                <div class="col-xl-4 col-lg-5 col-md-6 col-sm-8 align-self-center text-right">
                                                    <p class="inv-to">Pengirim</p>
                                                </div>
                                                <div class="col-xl-8 col-lg-7 col-md-6 col-sm-4 receiver-div">
                                                    <p class="inv-customer-name"></p>
                                                    <p class="inv-street-addr"></p>
                                                    <!-- <p class="inv-email-address">redq@company.com</p> -->
                                                    <!-- <p class="inv-email-address phone">081617170074</p> -->
                                                </div>
                                                <div class="col-xl-4 col-lg-5 col-md-6 col-sm-8 col-12 sender-div text-right">
                                                    <p class="inv-customer-name"></p>
                                                    <p class="inv-street-addr"></p>
                                                    <!-- <p class="inv-email-address">redq@company.com</p> -->
                                                    <!-- <p class="inv-email-address phone">081617170074</p> -->
                                                </div>
                                            </div>
                                            
                                        </div>
                                        <div class="inv--note">
                                            <div class="row mt-4">
                                                <div class="col-sm-12 col-12 order-sm-0 order-1">
                                                    <p>Note: Thank you for doing Business with us.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3">
                    <div class="invoice-actions-btn">
                        <div class="invoice-action-btn">
                            <div class="row">
                                <div class="col-xl-12 col-md-3 col-sm-6">
                                    <a href="javascript:void(0);" class="btn btn-secondary btn-print  action-print">Print</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')

<script>

    $(function() {

        onView();

        $('.action-print').on('click', function(event) {
            event.preventDefault();
            /* Act on the event */
            window.print();
        });

    });

    async function onView() {

        var outboundId = window.location.pathname.split("/").pop();

        await axios.get(`/api/outbound/${outboundId}`, {
            headers: {
                "Authorization": "Bearer {{ Session::get('api_token') }}",
            },
        })
        .then(function (res) {
            console.log('response', res.data);
            if (res.status == 200) {
                var data = res.data.data;
                $('#barcode').JsBarcode(data.awb);
                $('.inv-no').text(data.invoice_number);
                $('.inv-date').text(moment(data.created_at).format('DD MMM YYYY'));
                if (data.platform_id != 1) $('.platform-logo').html(`<img class="company-logo" src="/assets/apps/img/${data.platform_logo}" alt="Platform Logo" style="width: 240px; height: 90px;">`);
                if (data.courier_logo) $('.courier-logo').html(`<img class="company-logo" src="${data.courier_logo}" alt="Courier Logo" style="width: 240px; height: 90px;">`);
                $('.sender-div').find('.inv-customer-name').text(data.user_name);
                $('.sender-div').find('.inv-street-addr').text(null);
                // $('.sender-div').find('.inv-email-address').text('test@gmail.com');
                // $('.sender-div').find('.phone').text('081617170074');
                $('.receiver-div').find('.inv-customer-name').text(data.name);
                $('.receiver-div').find('.inv-street-addr').text(data.address);
                // $('.sender-div').find('.inv-email-address').text('test@gmail.com');
                // $('.sender-div').find('.phone').text('081617170074');
            } else {
                Swal.fire('Oops!', res.data.message, 'error');
            }
        })
        .catch(function (err) {
            console.log('error', err);
            if (err.response) {
                Swal.fire('Oops!', err.response.data.message, 'error');
            }
        });

    }

</script>

@endsection