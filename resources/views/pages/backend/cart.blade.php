@extends('layouts.backend.default')

@section('title', 'Cart')

@section('content')

<div class="card">
    <div class="card-header bg-light">
        <div class="d-flex justify-content-between align-items-baseline p-0">
            <div class="card-title p-0 m-0">Cart</div>
        </div>
    </div>
    <div class="table-div">
        <div class="table-responsive">
            <table id="dataGrid" class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Action</th>
                        <th>Description</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody id="dgBody">
                    <!-- Table Body -->
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">
        <div class="text-right">
            <button type="button" class="btn btn-secondary" id="btn-cancel_order">
                Cancel
            </button>
            <button type="button" class="btn btn-primary" id="btn-checkout">
                <span class="spinner-border spinner-border-sm mr-2" id="spinner" role="status" aria-hidden="true" style="display: none;"></span>
                Checkout
            </button>
        </div>
    </div>
</div>

@endsection

@section('script')

<script>

    $(function () {

        getCartItem();

        $('#btn-cancel_order').on('click', function (e) {

            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: "Clear All",
                denyButtonText: "Cancel",
            }).then(async (result) => {

                if (result.value) {

                    blockUI();

                    await axios.delete(`/api/cart`, {
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
                        Swal.fire('Oops!', 'Something went wrong...', 'error');
                    });

                    getCart();
                    getCartItem();

                    unblockUI();

                }

            });

        });

        $('#btn-checkout').on('click', function (e) {

            Swal.fire({
                title: "Are you sure to checkout?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: "Checkout",
                denyButtonText: "Cancel",
            }).then(async (result) => {

                if (result.value) {

                    blockUI();

                    var data = {};

                    await axios.post(`/api/order`, data, {
                        headers: {
                            "Authorization": "Bearer {{ Session::get('api_token') }}",
                        },
                    })
                    .then(function (res) {
                        if (res.data.status == true) {
                            Swal.fire('Good job!', res.data.message, 'success');
                            window.location = '/admin/main/invoice';
                        } else {
                            Swal.fire('Oops!', res.data.message, 'error');
                        }
                    })
                    .catch(function (err) {
                        Swal.fire('Oops!', 'Something went wrong...', 'error');
                    });

                    getCart();
                    getCartItem();

                    unblockUI();

                }

            });

        });

    });

    async function getCartItem() {

        var html = `
            <tr>
                <td class="text-center" colspan="6"><span class="spinner-border spinner-border-sm m-3" id="spinner" role="status" aria-hidden="true"></span></td>
            </tr>
        `;
        $('#dgBody').html(html);

        await axios.get(`/api/cart`, {
            headers: {
                "Authorization": "Bearer {{ Session::get('api_token') }}",
            },
        })
        .then(function (res) {
            console.log('response', res.data);
            if (res.status == 200) {
                var data = res.data.data;
                var html = ``;
                data.items.map((e) => {
                    html += `
                        <tr>
                            <td>${e.id}</td>
                            <td class="text-center">
                                <a href="javascript:void(0);" class="p-0" type="button" onclick="onDelete(${e.id})">
                                    <svg viewBox="0 0 24 24" width="19" height="19" stroke="#e7515a" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                </a>
                            </td>
                            <td>${e.description}</td>
                            <td class="text-center">${e.qty}</td>
                            <td>${e.price ? "Rp. " + parseInt(e.price).formatMoney(0, 3, '.') : "Rp. 0"}</td>
                            <td>${e.total_price ? "Rp. " + parseInt(e.total_price).formatMoney(0, 3, '.') : "Rp. 0"}</td>
                        </tr>
                    `;
                });
                $('#dgBody').html(html);
            } else {
                var html = `
                    <tr>
                        <td class="text-center" colspan="6">Your cart is empty</td>
                    </tr>
                `;
                $('#dgBody').html(html);
            }
        })
        .catch(function (err) {
            console.log('error', err.response);
            if (err.response) {
                var html = `
                    <tr>
                        <td class="text-center" colspan="6">Your cart is empty</td>
                    </tr>
                `;
                $('#dgBody').html(html);
            }
        });

    }

    async function onDelete(id) {

        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: "Delete",
            denyButtonText: "Cancel",
        }).then(async (result) => {

            if (result.value) {

                blockUI();

                await axios.delete(`/api/cart/${id}`, {
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
                    Swal.fire('Oops!', 'Something went wrong...', 'error');
                });

                unblockUI();
                

            }

        });

    }

</script>

@endsection
