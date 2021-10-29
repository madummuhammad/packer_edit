@extends('layouts.backend.default')

@section('title', 'Warehouse')

@section('content')

<div class="card">
    <div class="card-header bg-light">
        <div class="d-flex justify-content-between align-items-baseline p-0">
            <div class="card-title p-0 m-0">Warehouse</div>
        </div>
    </div>
    <div class="table-div">
        <div class="table-responsive">
            <table id="dataGrid" class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Action</th>
                        <th>Warehouse</th>
                        <th>Provinsi</th>
                        <th>Kabupaten / Kota</th>
                        <th>Type</th>
                        <th>Size (P x L x T)</th>
                        <th>Available</th>
                        <th>Price</th>
                        <th>Custom Price</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Table Body -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="add-to-cart-modal" tabindex="-1" role="dialog" aria-labelledby="title" aria-hidden="true">
    <form id="form">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-secondary" id="title">Add To Cart</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="error">
                        <!-- Error Placeholder -->
                    </div>
                    <input type="hidden" id="space_id" name="space_id">
                    <div class="form-group">
                        <label for="qty">Quantity <span style="color: red;">*</span></label>
                        <input type="number" class="form-control" id="qty" name="qty" placeholder="Quantity">
                    </div>
                    <div class="form-group" style="display: none;">
                        <label for="duration">Duration (month) <span style="color: red;">*</span></label>
                        <input type="number" class="form-control" id="duration" name="duration" placeholder="Duration">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="btn_submit">
                        Submit
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection

@section('script')

<script>

    $(function () {

        var dataGrid = $('#dataGrid').DataTable({
            dom: "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>><'table-responsive'tr><'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
            oLanguage: {
                oPaginate: { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
                sInfo: "Showing page _PAGE_ of _PAGES_",
                sSearch: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                sSearchPlaceholder: "Search...",
                sLengthMenu: "Results :  _MENU_",
            },
            stripeClasses: [],
            lengthMenu: [7, 10, 20, 50],
            pageLength: 7,
            processing: true,
            serverSide: true,
            order: [[0, 'ASC']],
            ajax: {
                url: `/api/datatable/space`,
                method: "GET",
                headers: {
                    "Authorization": "Bearer {{ Session::get('api_token') }}"
                },
            },
            columns: [
                {
                    data: 'id',
                    width: '35px',
                    sClass: 'text-center',
                },
                {
                    data: "id",
                    width: '35px',
                    sClass: 'text-center',
                    orderable: false,
                    render: function (data, type, row) {
                        return `
                            <a href="javascript:void(0);" class="p-0" onclick="onAddToCart(${data})">
                                <svg viewBox="0 0 24 24" width="19" height="19" stroke="#3b3f5c" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                            </a>
                        `;
                    },
                },
                {
                    data: 'warehouse_name',
                    width: '35px',
                },
                {
                    data: 'provinsi_name',
                    width: '35px',
                },
                {
                    data: 'kabupaten_name',
                    width: '35px',
                },
                {
                    data: 'space_type_name',
                    width: '35px',
                },
                {
                    data: 'size',
                    width: '35px',
                },
                {
                    data: 'stock',
                    width: '35px',
                    sClass: 'text-center',
                },
                {
                    data: 'price',
                    width: '35px',
                    sClass: 'text-right',
                    render: function (data, type, row) {
                        return data ? "Rp. " + parseInt(data).formatMoney(0, 3, '.') : "Rp. 0";
                    },
                },
                {
                    data: 'custom_price',
                    width: '35px',
                    sClass: 'text-right',
                    render: function (data, type, row) {
                        return data ? "Rp. " + parseInt(data).formatMoney(0, 3, '.') : "Rp. 0";
                    },
                },
                {
                    data: 'created_at',
                    width: '35px',
                    visible: false,
                    render: function (data, type, row) {
                        return moment(data).format('DD/MM/YYYY HH:mm');
                    },
                },
                {
                    data: 'updated_at',
                    width: '35px',
                    visible: false,
                    render: function (data, type, row) {
                        return moment(data).format('DD/MM/YYYY HH:mm');
                    },
                },
            ]
        });

        var validator = $('#add-to-cart-modal').find('#form').validate();

        $('#add-to-cart-modal').find('#form').on('submit', async function(e) {

            e.preventDefault();

            if ($(this).valid()) {

                blockUI();

                var url = `/api/cart`;

                var form = $('#add-to-cart-modal').find('#form')[0];
                var data = new FormData(form);

                await axios.post(url, data, {
                    headers: {
                        "Authorization": "Bearer {{ Session::get('api_token') }}",
                        "content-type": "multipart/form-data"
                    },
                })
                .then(function (res) {
                    console.log('response', res.data);
                    if (res.data.status == true) {
                        $('#add-to-cart-modal').modal('hide');
                        unblockUI();
                        Swal.fire('Good job!', res.data.message, 'success');
                    } else {
                        unblockUI();
                        Swal.fire('Oops!', res.data.message, 'error');
                    }
                })
                .catch(function (err) {
                    console.log('error', err.response);
                    if (err.response) {
                        $('#add-to-cart-modal').find('#error').html(`
                            <div class="alert alert-danger" role="alert">
                                ${err.response.data.message}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        `).show('fast');
                    }
                    unblockUI();
                    Swal.fire('Oops!', 'Something went wrong...', 'error');
                });

                $('#dataGrid').DataTable().ajax.reload(null, false);
                
                getCart();

            }

        });

    });

    async function onAddToCart(id) {

        blockUI();

        $('#add-to-cart-modal').find('#title').text('Add To Cart');

        $('#add-to-cart-modal').find('#error').html(``);

        $('#add-to-cart-modal').find('#space_id').val(id);

        $('#add-to-cart-modal').find('#qty')
            .val(1)
            .TouchSpin({ initval: 1 })
            .rules('add', { required: true });

        $('#add-to-cart-modal').find('#duration')
            .val(1)
            .rules('add', { required: true });

        $('#add-to-cart-modal').modal('show');

        unblockUI();

    }

</script>

@endsection
