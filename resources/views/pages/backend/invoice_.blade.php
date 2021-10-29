@extends('layouts.backend.default')

@section('title', 'Invoice')

@section('style')

<link href="{{ asset('assets/backend/assets/css/apps/invoice.css') }}" rel="stylesheet">

@endsection

@section('content')

<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="app-hamburger-container">
            <div class="hamburger"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu chat-menu d-xl-none"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg></div>
        </div>
        <div class="doc-container">
            <div class="tab-title">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-12">
                        <div class="search">
                            <input type="text" class="form-control" placeholder="Search...">
                        </div>
                        <ul class="nav nav-pills inv-list-container d-block" id="pills-tab" role="tablist">
                            <!-- Placeholder: Invoice -->
                        </ul>
                    </div>
                </div>
            </div>
            <div class="invoice-container">
                <div class="invoice-inbox">
                    <div class="invoice-header-section">
                        <h4 class="inv-number"></h4>
                        <div class="invoice-action">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-printer action-print" data-toggle="tooltip" data-placement="top" data-original-title="Reply"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                        </div>
                    </div>
                    <div class="" id="ct">
                        <div class="invoice-1">
                            <div class="content-section  animated animatedFadeInUp fadeInUp">
                                <div class="row inv--head-section">
                                    <div class="col-sm-6 col-12">
                                        <h3 class="in-heading">INVOICE</h3>
                                    </div>
                                    <div class="col-sm-6 col-12 align-self-center text-sm-right">
                                        <div class="company-info">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-hexagon"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path></svg>
                                            <h5 class="inv-brand-name">Packer</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row inv--detail-section">
                                <div class="col-sm-7 align-self-center">
                                    <p class="inv-to">Invoice To</p>
                                </div>
                                <div class="col-sm-5 align-self-center  text-sm-right order-sm-0 order-1">
                                    <p class="inv-detail-title">From : XYZ Company</p>
                                </div>
                                <div class="col-sm-7 align-self-center">
                                    <p class="inv-customer-name">Jesse Cory</p>
                                    <p class="inv-street-addr">405 Mulberry Rd. Mc Grady, NC, 28649</p>
                                    <p class="inv-email-address">redq@company.com</p>
                                </div>
                                <div class="col-sm-5 align-self-center  text-sm-right order-2">
                                    <p class="inv-list-number"><span class="inv-title">Invoice Number : </span> <span class="inv-number">[invoice number]</span></p>
                                    <p class="inv-created-date"><span class="inv-title">Invoice Date : </span> <span class="inv-date">20 Aug 2019</span></p>
                                    <p class="inv-due-date"><span class="inv-title">Due Date : </span> <span class="inv-date">26 Aug 2019</span></p>
                                </div>
                            </div>
                            <div class="row inv--product-table-section">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead class="">
                                                <tr>
                                                    <th scope="col">S.No</th>
                                                    <th scope="col">Items</th>
                                                    <th class="text-right" scope="col">Qty</th>
                                                    <th class="text-right" scope="col">Unit Price</th>
                                                    <th class="text-right" scope="col">Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>Electric Shaver</td>
                                                    <td class="text-right">20</td>
                                                    <td class="text-right">$300</td>
                                                    <td class="text-right">$2800</td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td>Earphones</td>
                                                    <td class="text-right">49</td>
                                                    <td class="text-right">$500</td>
                                                    <td class="text-right">$7000</td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td>Wireless Router</td>
                                                    <td class="text-right">30</td>
                                                    <td class="text-right">$500</td>
                                                    <td class="text-right">$3500</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-sm-5 col-12 order-sm-0 order-1">
                                    <div class="inv--payment-info">
                                        <div class="row">
                                            <div class="col-sm-12 col-12">
                                                <h6 class=" inv-title">Payment Info:</h6>
                                            </div>
                                            <div class="col-sm-4 col-12">
                                                <p class=" inv-subtitle">Bank Name: </p>
                                            </div>
                                            <div class="col-sm-8 col-12">
                                                <p class="">Bank of America</p>
                                            </div>
                                            <div class="col-sm-4 col-12">
                                                <p class=" inv-subtitle">Account Number : </p>
                                            </div>
                                            <div class="col-sm-8 col-12">
                                                <p class="">1234567890</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-7 col-12 order-sm-1 order-0">
                                    <div class="inv--total-amounts text-sm-right">
                                        <div class="row">
                                            <div class="col-sm-8 col-7">
                                                <p class="">Sub Total: </p>
                                            </div>
                                            <div class="col-sm-4 col-5">
                                                <p class="">$13300</p>
                                            </div>
                                            <div class="col-sm-8 col-7">
                                                <p class="">Tax Amount: </p>
                                            </div>
                                            <div class="col-sm-4 col-5">
                                                <p class="">$700</p>
                                            </div>
                                            <div class="col-sm-8 col-7">
                                                <p class=" discount-rate">Discount : <span class="discount-percentage">5%</span> </p>
                                            </div>
                                            <div class="col-sm-4 col-5">
                                                <p class="">$700</p>
                                            </div>
                                            <div class="col-sm-8 col-7 grand-total-title">
                                                <h4 class="">Grand Total : </h4>
                                            </div>
                                            <div class="col-sm-4 col-5 grand-total-amount">
                                                <h4 class="">$14000</h4>
                                            </div>
                                        </div>
                                    </div>
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

<script src="{{ asset('assets/backend/assets/assets/js/apps/invoice.js') }}"></script>

<script>

    $(function () {

        getInvoice();

    });

    async function getInvoice() {

        await axios.get(`/api/order`, {
            headers: {
                "Authorization": "Bearer {{ Session::get('api_token') }}",
            },
        })
        .then(function (res) {
            console.log('response', res.data);
            if (res.status == 200) {
                var data = res.data.data;
                var html = ``;
                data.map((e) => {
                    html += `
                        <li class="nav-item" onclick="onView();">
                            <div class="nav-link list-actions" id="invoice-${e.id}" data-invoice-id="${e.id}">
                                <div class="f-m-body">
                                    <div class="f-head">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                                    </div>
                                    <div class="f-body">
                                        <p class="invoice-number">Invoice #${e.invoice}</p>
                                        <p class="invoice-customer-name"><span>To:</span> ${e.user_name}</p>
                                        <p class="invoice-generated-date">Date: ${moment(e.created_at).format('DD MMM YYYY HH:mm')}</p>
                                    </div>
                                </div>
                            </div>
                        </li>
                    `;
                });
                $('.inv-list-container').html(html);
            } else {
                var html = `
                    <div class="items text-center p-3">
                        <div class="item-content">
                            <p>No data</p>
                        </div>
                    </div>
                `;
                $('.inv-list-container').html(html);
            }
        })
        .catch(function (err) {
            console.log('error', err);
            if (err.response) {
                var html = `
                    <div class="items text-center p-3">
                        <div class="item-content">
                            <p>No data</p>
                        </div>
                    </div>
                `;
                $('.inv-list-container').html(html);
            }
        });

    }

    async function onInvoiceSelect(id) {

        await axios.get(`/api/order/${id}`, {
            headers: {
                "Authorization": "Bearer {{ Session::get('api_token') }}",
            },
        })
        .then(function (res) {
            console.log('response', res.data);
            if (res.status == 200) {
                var data = res.data.data;
                var html = ``;
                
                $('.inv-list-container').html(html);
            } else {
                var html = `
                    <div class="items text-center p-3">
                        <div class="item-content">
                            <p>No data</p>
                        </div>
                    </div>
                `;
                $('.inv-list-container').html(html);
            }
        })
        .catch(function (err) {
            console.log('error', err);
            if (err.response) {
                var html = `
                    <div class="items text-center p-3">
                        <div class="item-content">
                            <p>No data</p>
                        </div>
                    </div>
                `;
                $('.inv-list-container').html(html);
            }
        });

    }

    async function onPay() {

        var id = $('#id').val();

        if (id) {

            Swal.fire({
                title: "Are you sure to pay this invoice?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: "Pay Invoice",
                denyButtonText: "Cancel",
            }).then(async (result) => {

                if (result.value) {

                    blockUI();

                    var data = {
                        status_id: 2
                    };

                    await axios.post(`/api/order/${id}`, data, {
                        headers: {
                            "Authorization": "Bearer {{ Session::get('api_token') }}",
                        },
                    })
                    .then(function (res) {
                        if (res.data.status == true) {
                            Swal.fire('Good job!', res.data.message, 'success');
                        } else {
                            Swal.fire('Oops!', res.data.message, 'error');
                        }
                    })
                    .catch(function (err) {
                        Swal.fire('Oops!', err.response.data.error, 'error');
                    });

                    getProfile();

                    unblockUI();

                    $('#dataGrid').DataTable().ajax.reload(null, false);

                }

            });

        }

    }

    async function onConfirm(id) {

        if (id) {

            Swal.fire({
                title: "Are you sure to confirm this invoice?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: "Confirm",
                denyButtonText: "Cancel",
            }).then(async (result) => {

                if (result.value) {

                    blockUI();

                    var data = {
                        status_id: 4
                    };

                    await axios.post(`/api/order/${id}`, data, {
                        headers: {
                            "Authorization": "Bearer {{ Session::get('api_token') }}",
                        },
                    })
                    .then(function (res) {
                        if (res.data.status == true) {
                            Swal.fire('Good job!', res.data.message, 'success');
                        } else {
                            Swal.fire('Oops!', res.data.message, 'error');
                        }
                    })
                    .catch(function (err) {
                        Swal.fire('Oops!', err.response.data.error, 'error');
                    });

                    getProfile();

                    unblockUI();

                    $('#dataGrid').DataTable().ajax.reload(null, false);

                }

            });

        }

    }

    async function onCancel(id) {

        if (id) {

            Swal.fire({
                title: "Are you sure to cancel this invoice?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: "Confirm",
                denyButtonText: "Cancel",
            }).then(async (result) => {

                if (result.value) {

                    blockUI();

                    var data = {
                        status_id: 5
                    };

                    await axios.post(`/api/order/${id}`, data, {
                        headers: {
                            "Authorization": "Bearer {{ Session::get('api_token') }}",
                        },
                    })
                    .then(function (res) {
                        if (res.data.status == true) {
                            Swal.fire('Good job!', res.data.message, 'success');
                        } else {
                            Swal.fire('Oops!', res.data.message, 'error');
                        }
                    })
                    .catch(function (err) {
                        Swal.fire('Oops!', err.response.data.error, 'error');
                    });

                    getProfile();

                    unblockUI();

                    $('#dataGrid').DataTable().ajax.reload(null, false);

                }

            });

        }

    }

</script>

@endsection

