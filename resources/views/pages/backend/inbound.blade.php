@extends('layouts.backend.default')

@section('title', 'Inbound')

@section('content')

<div class="card">
    <div class="card-header bg-light">
        <div class="d-flex justify-content-between align-items-baseline p-0">
            <div class="card-title p-0 m-0">Inbound</div>
            <div>
                <button type="button" class="btn btn-primary btn-sm" id="btn-create" onclick="onUpdateOrCreate();">
                    Create
                </button>
            </div>
        </div>
    </div>
    <div class="form-div" style="display: none;">
        <input type="hidden" id="id" name="id">
        <form id="form">
            <div class="card-body">
                <div id="error">
                    <!-- Error Placeholder -->
                </div>
                <div class="form-group">
                    <label for="user_id">User <span style="color: red;">*</span></label>
                    <select class="select2-single form-control" id="user_id" name="user_id">
                        <option value="" selected disabled>-- Please Select --</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="warehouse_id">Warehouse <span style="color: red;">*</span></label>
                    <select class="select2-single form-control" id="warehouse_id" name="warehouse_id">
                        <option value="" selected disabled>-- Please Select --</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="status_id">Status <span style="color: red;">*</span></label>
                    <select class="select2-single form-control" id="status_id" name="status_id">
                        <option value="" selected disabled>-- Please Select --</option>
                    </select>
                </div>
                <div class="mb-3" id="items">
                    <!-- Placeholder -->
                </div>
                <button type="button" class="btn btn-danger btn-sm btn-block" onclick="onAddItem();">
                    Add Item
                </button>
            </div>
            <div class="card-footer text-right">
                <button type="button" class="btn btn-secondary btn-sm" onclick="$('.form-div').hide('slow'); $('.table-div').show('slow');">
                    Back
                </button>
                <button type="submit" class="btn btn-primary btn-sm" id="btn-submit">
                    Submit
                </button>
            </div>
        </form>
    </div>
    <div class="table-div">
        <div class="card-body">
            <div class="d-flex flex-inline filter-div">
                <div class="form-group">
                    <select class="form-control form-control-sm select2-single" id="filter-user_id" onchange="$('#dataGrid').DataTable().draw();">
                        <option value="" selected disabled>-- Select User --</option>
                    </select>
                </div>
                <div class="form-group ml-1">
                    <input type="text" class="form-control form-control-sm flatpickr" id="filter-start_date" placeholder="Start Date">
                </div>
                <div class="form-group ml-1">
                    <input type="text" class="form-control form-control-sm flatpickr" id="filter-end_date" placeholder="End Date">
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table id="dataGrid" class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Action</th>
                        <th>User</th>
                        <th>Warehouse</th>
                        <th>Provinsi</th>
                        <th>Kabupaten / Kota</th>
                        <th>Status</th>
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

<div class="modal fade" id="detail-modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Inbound</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="accordion-parent" class="no-icons">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header" style="cursor: pointer;">
                                    <section class="mb-0 mt-0">
                                        <div role="menu" class="" data-toggle="collapse" data-target="#accordion-detail" aria-expanded="true" aria-controls="accordion-detail">
                                            Informasi Dasar
                                        </div>
                                    </section>
                                </div>
                                <div id="accordion-detail" class="collapse show" aria-labelledby="headingOne4" data-parent="#accordion-parent">
                                    <div class="card-body">
                                        <div>
                                            <p class="mb-0 text-primary">No. Invoice</p>
                                            <p id="id-text">-</p>
                                        </div>
                                        <div>
                                            <p class="mb-0 text-primary">Pengguna</p>
                                            <p id="user_name-text">-</p>
                                        </div>
                                        <div>
                                            <p class="mb-0 text-primary">Status</p>
                                            <p id="status_name-text">-</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-header">
                                    <section class="mb-0 mt-0">
                                        <div>
                                            Daftar Produk
                                        </div>
                                    </section>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered mb-4">
                                            <thead>
                                                <tr>
                                                    <th>Produk</th>
                                                    <th>Qty</th>
                                                    <th>Berat</th>
                                                </tr>
                                            </thead>
                                            <tbody id="items">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')

<script>

    var productIndex = 0;

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
            order: [[0, 'DESC']],
            ajax: {
                url: `/api/datatable/inbound`,
                method: "GET",
                headers: {
                    "Authorization": "Bearer {{ Session::get('api_token') }}"
                },
                data: function(data) {

                    data.filter = {};

                    var userId = $('#filter-user_id').val();
                    if (userId) data.filter.user_id = userId;

                    var startDate = $('#filter-start_date').val();
                    if (startDate) data.filter.start_date = startDate;

                    var endDate = $('#filter-end_date').val();
                    if (endDate) data.filter.end_date = endDate;

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
                        html = `
                            <a href="javascript:void(0);" class="p-0" type="button" onclick="onView(${data})">
                                <svg viewBox="0 0 24 24" width="19" height="19" stroke="#ffac0c" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
                            </a>
                        `;
                        if (isAdmin) 
                            html += `
                                &nbsp;
                                <a href="javascript:void(0);" class="p-0" type="button" onclick="onUpdateOrCreate(${data})">
                                    <svg viewBox="0 0 24 24" width="19" height="19" stroke="#4361ee" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                </a>
                                &nbsp;
                                <a href="javascript:void(0);" class="p-0" type="button" onclick="onDelete(${data})">
                                    <svg viewBox="0 0 24 24" width="19" height="19" stroke="#e7515a" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                </a>
                            `;
                        return html;
                    },
                },
                {
                    data: 'user_name',
                    width: '35px',
                    visible: isAdmin ? true : false,
                },
                {
                    data: 'warehouse_name',
                    width: '35px',
                },
                {
                    data: 'provinsi_name',
                    width: '35px',
                    visible: false,
                },
                {
                    data: 'kabupaten_name',
                    width: '35px',
                    visible: false,
                },
                {
                    data: 'status_name',
                    width: '35px',
                    render: function (data, type, row) {
                        var color = 'badge-success';
                        if (row.status_id == 1) color = 'badge-primary';
                        if (row.status_id == 2) color = 'badge-info';
                        if (row.status_id == 3) color = 'badge-secondary';
                        if (row.status_id == 5) color = 'badge-danger';
                        return `<span class="badge ${color} p-1">${data}</span>`;
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
                    render: function (data, type, row) {
                        return moment(data).format('DD/MM/YYYY HH:mm');
                    },
                },
            ]
        });

        var validator = $('.form-div').find('#form').validate();

        $('.form-div').find('#form').on('submit', async function(e) {

            e.preventDefault();

            if ($(this).valid()) {

                blockUI();

                var form = $('.form-div').find('#form')[0];
                var data = new FormData(form);

                var id = $('.form-div').find('#id').val();

                var url = `/api/inbound`;
                if (id) url = `/api/inbound/${id}`;

                await axios.post(url, data, {
                    headers: {
                        "Authorization": "Bearer {{ Session::get('api_token') }}",
                        "content-type": "multipart/form-data"
                    },
                })
                .then(function (res) {
                    console.log('response', res.data);
                    if (res.data.status == true) {
                        $('.form-div').hide('slow');
                        $('.table-div').show('slow');
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
                        $('.form-div').find('#error').html(`
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

            }

        });

        if (isAdmin == false) $('#filter-user_id').parent().hide();

        getFilter(`/api/user`, '#filter-user_id', 'Select User');

    });

    async function onAddItem() {

        productIndex++;

        var itemsHtml = `
            <div class="card mt-3" id="items-${productIndex}">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-baseline p-0">
                        <a href="javascript:void(0);" class="p-0" type="button" onclick="onDeleteItem(${productIndex})">
                            <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="#e7515a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="items-${productIndex}-product_id">Product <span style="color: red;">*</span></label>
                        <select class="select2-single form-control" id="items-${productIndex}-product_id" name="items[${productIndex}][product_id]">
                            <option value="" selected disabled>-- Please Select --</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="items-${productIndex}-qty">Qty <span style="color: red;">*</span></label>
                        <input type="number" class="form-control" id="items-${productIndex}-qty" name="items[${productIndex}][qty]" placeholder="Qty">
                    </div>
                </div>
            </div>
        `;
        $('.form-div').find('#items').append(itemsHtml);
        $('.select2-single').select2();

        var product = await sendRequest(`/api/product`);
        productOption = `<option value="" selected disabled>-- Please Select --</option>`;
        product.map((e) => { productOption += `<option value="${e.id}">${e.name} - ${e.sku}</option>`; });
        $('.form-div').find(`#items-${productIndex}-product_id`).empty().html(productOption);

    }

    async function onView(id) {

        var data = await sendRequest(`/api/inbound/${id}`);
        console.log(data);

        $('#detail-modal').find('#id-text').text(data.id);
        $('#detail-modal').find('#user_name-text').text(data.user_name);
        $('#detail-modal').find('#status_name-text').text(data.status_name);

        var html = ``;

        data.items.map((e) => {

            html += `
                <tr>
        			<td>
        				<p class="mb-0"><b>${e.name}</b></p>
        				<p class="mb-0">SKU: ${e.sku}</p>
        			</td>
        			<td>
        				<p class="mb-0 text-right">x ${e.qty}</p>
        			</td>
        			<td>
        				<p class="mb-0 text-right">${parseInt(e.weight).formatMoney(0, 2, '.')} gram</p>
        				<p class="mb-0 text-right text-muted">(${parseInt(e.weight * e.qty).formatMoney(0, 2, '.')} gram)</p>
        			</td>
        		</tr>
            `;

        });

        $('#detail-modal').find('#items').html(html);

        $('#detail-modal').modal('show');

    }

    async function onUpdateOrCreate(id = null) {

        blockUI();

        var data = null;

        if (id) data = await sendRequest(`/api/inbound/${id}`);
        console.log(data);

        var user = await sendRequest(`/api/user`);
        var userOption = `<option value="" selected disabled>-- Please Select --</option>`;
        user.map((e) => { userOption += `<option value="${e.id}">${e.fullname}</option>`; });
        $('.form-div').find('#user_id').empty().html(userOption);

        var warehouse = await sendRequest(`/api/warehouse`);
        var warehouseOption = `<option value="" selected disabled>-- Please Select --</option>`;
        warehouse.map((e) => { warehouseOption += `<option value="${e.id}">${e.name}</option>`; });
        $('.form-div').find('#warehouse_id').empty().html(warehouseOption);

        var inboundStatus = await sendRequest(`/api/inbound-status`);
        var inboundStatusOption = `<option value="" selected disabled>-- Please Select --</option>`;
        inboundStatus.map((e) => { inboundStatusOption += `<option value="${e.id}">${e.value}</option>`; });
        $('.form-div').find('#status_id').empty().html(inboundStatusOption);

        if (isAdmin) $('.form-div').find('#user_id').parent().show('fast');
        else $('.form-div').find('#user_id').parent().hide('fast');

        if (isAdmin) $('.form-div').find('#status_id').parent().show('fast');
        else $('.form-div').find('#status_id').parent().hide('fast');

        $('.form-div').find('#error').html(``);

        $('.form-div').find('#id').val(id);

        $('.form-div').find('#user_id')
            .val(isAdmin ? (data ? data.user_id : null) : userId)
            .trigger('change.select2')
            .rules('add', { required: true });

        $('.form-div').find('#warehouse_id')
            .val(data ? data.warehouse_id : null)
            .trigger('change.select2')
            .rules('add', { required: true });

        $('.form-div').find('#status_id')
            .val(data ? data.status_id : 1)
            .trigger('change.select2')
            .rules('add', { required: true });

        productIndex = 0;

        $('.form-div').find('#items').empty();

        if (data) {

            data.items.map(async (e) => {

                productIndex++;

                var itemsHtml = `
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="items-${productIndex}-product_id">Product <span style="color: red;">*</span></label>
                                <select class="select2-single form-control" id="items-${productIndex}-product_id" name="items[${productIndex}][product_id]">
                                    <option value="" selected disabled>-- Please Select --</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="items-${productIndex}-qty">Qty <span style="color: red;">*</span></label>
                                <input type="number" class="form-control" id="items-${productIndex}-qty" name="items[${productIndex}][qty]" placeholder="Qty">
                            </div>
                        </div>
                    </div>
                `;
                $('.form-div').find('#items').append(itemsHtml);
                $('.select2-single').select2();

                var product = await sendRequest(`/api/product`);
                productOption = `<option value="" selected disabled>-- Please Select --</option>`;
                product.map((e) => { productOption += `<option value="${e.id}">${e.name} - ${e.sku}</option>`; });
                $('.form-div').find(`#items-${productIndex}-product_id`).empty().html(productOption);

                $('.form-div').find(`#items-${productIndex}-product_id`).val(e.product_id).trigger('change');
                $('.form-div').find(`#items-${productIndex}-qty`).val(e.qty).trigger('change');

            });

        } else {

            var itemsHtml = `
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="items-${productIndex}-product_id">Product <span style="color: red;">*</span></label>
                            <select class="select2-single form-control" id="items-${productIndex}-product_id" name="items[${productIndex}][product_id]">
                                <option value="" selected disabled>-- Please Select --</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="items-${productIndex}-qty">Qty <span style="color: red;">*</span></label>
                            <input type="number" class="form-control" id="items-${productIndex}-qty" name="items[${productIndex}][qty]" placeholder="Qty">
                        </div>
                    </div>
                </div>
            `;
            $('.form-div').find('#items').html(itemsHtml);
            $('.select2-single').select2();

            var product = await sendRequest(`/api/product`);
            productOption = `<option value="" selected disabled>-- Please Select --</option>`;
            product.map((e) => { productOption += `<option value="${e.id}">${e.name} - ${e.sku}</option>`; });
            $('.form-div').find(`#items-${productIndex}-product_id`).empty().html(productOption);

        }

        $('.form-div').show('slow');
        $('.table-div').hide('slow');

        unblockUI();

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

                await axios.delete(`/api/inbound/${id}`, {
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

                $('#dataGrid').DataTable().ajax.reload(null, false);

            }

        });

    }

</script>

@endsection
