@extends('layouts.backend.default')

@section('title', 'Invoice')

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
                                        <div class="inv--head-section inv--detail-section">
                                            <div class="row">
                                                <div class="col-sm-6 col-12 mr-auto">
                                                    <div class="d-flex">
                                                        <img class="company-logo" src="{{ asset('assets/backend/assets/img/cork-logo.png') }}" alt="company">
                                                        <h3 class="in-heading align-self-center">{{ env('APP_NAME') }}</h3>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 text-sm-right">
                                                    <p class="inv-list-number"><span class="inv-title">Invoice : </span> <span class="inv-number"></span></p>
                                                </div>
                                                <div class="col-sm-6 align-self-center mt-3">
                                                    <div class="inv-qr mb-3"></div>
                                                    <p class="inv-street-addr">Company Name</p>
                                                    <p class="inv-email-address">info@company.com</p>
                                                    <p class="inv-phone">+62 816-1234-1234</p>
                                                </div>
                                                <div class="col-sm-6 text-sm-right">
                                                    <p class="inv-created-date"><span class="inv-title">Invoice Date : </span> <span class="inv-date"></span></p>
                                                    <p class="inv-created-date"><span class="inv-title">Status : </span> <span class="inv-status"></span></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="inv--detail-section inv--customer-detail-section">
                                            <div class="row">
                                                <div class="col-xl-8 col-lg-7 col-md-6 col-sm-4 align-self-center">
                                                    <p class="inv-to">Invoice To</p>
                                                </div>
                                                <div class="col-xl-4 col-lg-5 col-md-6 col-sm-8 align-self-center order-sm-0 order-1 inv--payment-info" style="display: none;">
                                                    <h6 class="inv-title">Payment Info:</h6>
                                                </div>
                                                <div class="col-xl-8 col-lg-7 col-md-6 col-sm-4">
                                                    <p class="inv-customer-name"></p>
                                                    <p class="inv-street-addr customer"></p>
                                                    <p class="inv-email-address customer"></p>
                                                </div>
                                                <div class="col-xl-4 col-lg-5 col-md-6 col-sm-8 col-12 order-sm-0 order-1" style="display: none;">
                                                    <div class="inv--payment-info">
                                                        <p><span class=" inv-subtitle">Bank Name:</span> <span></span></p>
                                                        <p><span class=" inv-subtitle">Account Number: </span> <span></span></p>
                                                        <p><span class=" inv-subtitle">SWIFT code:</span> <span></span></p>
                                                        <p><span class=" inv-subtitle">Country: </span> <span></span></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="inv--product-table-section">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead class="">
                                                        <tr>
                                                            <th scope="col">S.No</th>
                                                            <th scope="col">Items</th>
                                                            <th class="text-right" scope="col">Qty</th>
                                                            <th class="text-right" scope="col">Price</th>
                                                            <th class="text-right" scope="col">Amount</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <!-- Placeholder: Table Row -->
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>       
                                        <div class="inv--total-amounts">
                                            <div class="row mt-4">
                                                <div class="col-sm-5 col-12 order-sm-0 order-1">
                                                </div>
                                                <div class="col-sm-7 col-12 order-sm-1 order-0">
                                                    <div class="text-sm-right">
                                                        <div class="row">
                                                            <div class="col-sm-8 col-7">
                                                                <p class="">Sub Total: </p>
                                                            </div>
                                                            <div class="col-sm-4 col-5">
                                                                <p class="inv-subtotal">Rp. 0</p>
                                                            </div>
                                                            <!-- 
                                                            <div class="col-sm-8 col-7">
                                                                <p class="">Tax Amount: </p>
                                                            </div>
                                                            <div class="col-sm-4 col-5">
                                                                <p class="inv-tax">Rp. 0</p>
                                                            </div> 
                                                            -->
                                                            <div class="col-sm-8 col-7 grand-total-title">
                                                                <h4 class="">Grand Total : </h4>
                                                            </div>
                                                            <div class="col-sm-4 col-5 grand-total-amount">
                                                                <h4 class="inv-grandtotal">Rp. 0</h4>
                                                            </div>
                                                        </div>
                                                    </div>
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
                                    <a href="javascript:void(0);" class="btn btn-secondary btn-print action-print">Print</a>
                                </div>
                                <div class="col-xl-12 col-md-3 col-sm-6">
                                    <a href="javascript:void(0);" class="btn btn-secondary btn-print action-pay">Pay Invoice</a>
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

        var orderId = window.location.pathname.split("/").pop();

        await axios.get(`/api/order/${orderId}`, {
            headers: {
                "Authorization": "Bearer {{ Session::get('api_token') }}",
            },
        })
        .then(function (res) {
            console.log('response', res.data);
            if (res.status == 200) {
                var data = res.data.data;
                $('.inv-qr').empty();
                var qrcode = new QRCode(document.getElementsByClassName("inv-qr")[0], {
                    width : 90,
                    height : 90
                }).makeCode(data.invoice);
                $('.inv-list-number').find('.inv-number').text('#' + data.invoice);
                $('.inv-created-date').find('.inv-date').text(moment(data.created_at).format('DD MMM YYYY'));
                $('.inv-created-date').find('.inv-status').text(data.status_name);
                $('.inv-customer-name').text(data.user_name);
                if (data.user_data) $('.inv-street-addr.customer').text(`${data.user_data.address}, ${data.user_data.kabupaten_name}, ${data.user_data.provinsi_name}`);
                $('.inv-email-address.customer').text(data.user_email);
                var html = ``;
                data.items.map((e, i) => {
                    var item = i + 1;
                    html += `
                        <tr>
                            <th>${item}</th>
                            <th>${e.description}</th>
                            <th class="text-right">${e.qty ? parseInt(e.qty).formatMoney(0, 3, '.') : "0"}</th>
                            <th class="text-right">${e.price ? "Rp. " + parseInt(e.price).formatMoney(0, 3, '.') : "Rp. 0"}</th>
                            <th class="text-right">${e.total_price ? "Rp. " + parseInt(e.total_price).formatMoney(0, 3, '.') : "Rp. 0"}</th>
                        </tr>
                    `;
                });
                $('.table').find('tbody').html(html);
                $('.inv-subtotal').text(data.subtotal ? "Rp. " + parseInt(data.subtotal).formatMoney(0, 3, '.') : "Rp. 0");
                // $('.inv-tax').text(data.tax ? "Rp. " + parseInt(data.tax).formatMoney(0, 3, '.') : "Rp. 0");
                $('.inv-grandtotal').text(data.grandtotal ? "Rp. " + parseInt(data.grandtotal).formatMoney(0, 3, '.') : "Rp. 0");
                if (data.status_id == 1) $('#payInvoiceButton').show('fast');
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