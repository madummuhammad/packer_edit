@extends('layouts.backend.default')

@section('title', 'Product')

@section('content')

<div class="card">
    <div class="card-header bg-light">
        <div class="d-flex justify-content-between align-items-baseline p-0">
            <div class="card-title p-0 m-0">Product</div>
            <div>
                <button type="button" class="btn btn-secondary btn-sm" id="btn-import" onclick="onImport();" style="display: none;">
                    Import
                </button>
                <button type="button" class="btn btn-primary btn-sm" id="btn-create" onclick="onUpdateOrCreate();">
                    Create
                </button>
            </div>
        </div>
    </div>
    <div class="form-div" style="display: none;">
        <input type="hidden" id="id">
        <form id="form">
            <div class="card-body">
                <div id="error">
                    <!-- Error Placeholder -->
                </div>
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="user_id">User <span style="color: red;">*</span></label>
                        <select class="select2-single form-control" id="user_id" name="user_id">
                            <option value="" selected disabled>-- Please Select --</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="name">Name <span style="color: red;">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Name">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="sku">SKU</label>
                        <input type="text" class="form-control" id="sku" name="sku" placeholder="SKU">
                        <div id="skuHelp" class="form-text text-secondary">Leave blank for auto generate</div>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="length">Length <span style="color: red;">*</span></label>
                        <div class="input-group mb-2">
                            <input type="number" class="form-control" id="length" name="length" placeholder="Length">
                            <div class="input-group-append">
                                <div class="input-group-text">cm</div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="width">Width <span style="color: red;">*</span></label>
                        <div class="input-group mb-2">
                            <input type="number" class="form-control" id="width" name="width" placeholder="Width">
                            <div class="input-group-append">
                                <div class="input-group-text">cm</div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="height">Height <span style="color: red;">*</span></label>
                        <div class="input-group mb-2">
                            <input type="number" class="form-control" id="height" name="height" placeholder="Height">
                            <div class="input-group-append">
                                <div class="input-group-text">cm</div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="weight">Weight <span style="color: red;">*</span></label>
                        <div class="input-group mb-2">
                            <input type="number" class="form-control" id="weight" name="weight" placeholder="Weight">
                            <div class="input-group-append">
                                <div class="input-group-text">gram</div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="description">Description</label>
                        <!-- <input type="text" class="form-control" id="description" name="description" placeholder="Description"> -->
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>
                </div>
            </div>
            <div class="card-footer text-right">
                <button type="button" class="btn btn-secondary btn-sm" onclick="$('.form-div').hide('slow'); $('.table-div').show('slow');">
                    Back
                </button>
                <button type="submit" class="btn btn-primary btn-sm">
                    Submit
                </button>
            </div>
        </form>
    </div>
    <div class="table-div">
        <div class="card-body">
            <div class="d-flex flex-inline filter-div">
                <div class="form-group">
                    <select class="form-control form-control-sm select2-single" id="filter-platform_id" onchange="onPlatformSelect();">
                        <option value="" selected disabled>-- Select Platform --</option>
                    </select>
                </div>
                <div class="form-group ml-1">
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
                        <th>Name</th>
                        <th>SKU</th>
                        <th>Outbound Price</th>
                        <th>Size (P x L x T)</th>
                        <th>Weight</th>
                        <th>Description</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                    </tr>
                </thead>
                <tbody>
                    
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="barcode-modal" tabindex="-1" role="dialog" aria-labelledby="barcode-modal-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="barcode-modal-label">Barcode</h5>
            </div>
            <div class="modal-body">
                
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="outbound_price-modal" tabindex="-1" role="dialog" aria-labelledby="outbound_price-modal-label" aria-hidden="true">
    <input type="hidden" id="id">
    <form id="form">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="outbound_price-modal-label">Outbound Price</h5>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="outbound_price">Price <span style="color: red;">*</span></label>
                            <input type="number" class="form-control" id="outbound_price" name="outbound_price" placeholder="Price">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
                    <button class="btn btn-primary" type="submit">Submit</button>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection

@section('script')

<script>

    var dataGrid;

    $(function () {

        dataGrid = $('#dataGrid').DataTable({
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
                url: `/api/datatable/product`,
                method: "GET",
                headers: {
                    "Authorization": "Bearer {{ Session::get('api_token') }}"
                },
                data: function(data) {

                    data.filter = {};

                    var platformId = $('#filter-platform_id').val();
                    if (platformId) data.filter.platform_id = platformId;

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
                        var html = ``;
                        if (isAdmin)
                            html += `
                                <a href="javascript:void(0);" class="p-0" type="button" onclick="onUpdateOrCreateOutboundPrice(this)">
                                    <svg viewBox="0 0 24 24" width="19" height="19" stroke="#4361ee" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                                </a>
                            `;
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
                    data: 'name',
                    width: '35px',
                },
                {
                    data: 'sku',
                    width: '35px',
                    render: function (data, type, row) {
                        return `<a href="javascript:void(0);" type="button" onclick="onViewBarcode(this);">${data}</a>`;
                    },
                },
                {
                    data: 'outbound_price',
                    width: '35px',
                    sClass: 'text-right',
                    render: function (data, type, row) {
                        return data ? "Rp. " + parseInt(data).formatMoney(0, 3, '.') : "Rp. 0";
                    },
                },
                {
                    data: 'size',
                    width: '35px',
                },
                {
                    data: 'weight',
                    width: '35px',
                    sClass: 'text-right',
                    render: function (data, type, row) {
                        return data ? parseInt(data).formatMoney(0, 3, '.') + " gram" : "0 gram";
                    },
                },
                {
                    data: 'description',
                    width: '35px',
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

        var validator = $('.form-div').find('#form').validate();

        $('.form-div').find('#form').on('submit', async function(e) {

            e.preventDefault();

            if ($(this).valid()) {

                blockUI();

                var url = `/api/product`;

                var form = $('.form-div').find('#form')[0];
                var data = new FormData(form);

                var id = $('.form-div').find('#id').val();

                if (id) url = `/api/product/${id}`;

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
                        `).show();
                    }
                    unblockUI();
                    Swal.fire('Oops!', 'Something went wrong...', 'error');
                });

                $('#dataGrid').DataTable().ajax.reload(null, false);

            }

        });

        $('#outbound_price-modal').find('#form').on('submit', async function(e) {

            e.preventDefault();

            if ($(this).valid()) {

                blockUI();

                var form = $('#outbound_price-modal').find('#form')[0];
                var data = new FormData(form);

                var id = $('#outbound_price-modal').find('#id').val();

                var url = `/api/product/${id}`;

                await axios.post(url, data, {
                    headers: {
                        "Authorization": "Bearer {{ Session::get('api_token') }}",
                        "content-type": "multipart/form-data"
                    },
                })
                .then(function (res) {
                    console.log('response', res.data);
                    if (res.data.status == true) {
                        $('#outbound_price-modal').modal('hide');
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
                        $('#outbound_price-modal').find('#error').html(`
                            <div class="alert alert-danger" role="alert">
                                ${err.response.data.message}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        `).show();
                    }
                    unblockUI();
                    Swal.fire('Oops!', 'Something went wrong...', 'error');
                });

                $('#dataGrid').DataTable().ajax.reload(null, false);

            }

        });

        if (isAdmin == false) $('#filter-user_id').parent().hide();

        getFilter(`/api/platform`, '#filter-platform_id', 'Select Platform');
        getFilter(`/api/user`, '#filter-user_id', 'Select User');

    });

    async function onViewBarcode(selector) {

        var rowData = dataGrid.row($(selector).parents('tr')).data();

        console.log(rowData);

        $('#barcode-modal').find('.modal-body').html(`
            <div class="text-center">
                ${rowData.barcode}
            </div>
        `);

        $('#barcode-modal').modal('show');

    }

    async function onUpdateOrCreateOutboundPrice(selector) {

        var rowData = dataGrid.row($(selector).parents('tr')).data();

        console.log(rowData);

        $('#outbound_price-modal').find('#id').val(rowData.id);
        
        $('#outbound_price-modal').find('#outbound_price').val(rowData.outbound_price);

        $('#outbound_price-modal').modal('show');

    }

    async function onUpdateOrCreate(id = null) {

        blockUI();

        var data = null;

        if (id) data = await sendRequest(`/api/product/${id}`);
        console.log(data);

        var user = await sendRequest(`/api/user`);
        var userOption = `<option value="" selected disabled>-- Please Select --</option>`;
        user.map((e) => { userOption += `<option value="${e.id}">${e.fullname}</option>`; });
        $('.form-div').find('#user_id').empty().html(userOption);
        
        if (isAdmin) $('.form-div').find('#user_id').parent().show('fast');
        else $('.form-div').find('#user_id').parent().hide('fast');

        $('.form-div').find('#error').html(``);

        $('.form-div').find('#id').val(id);

        $('.form-div').find('#user_id')
            .val(isAdmin ? (data ? data.user_id : null) : userId)
            .trigger('change.select2')
            .rules('add', { required: true });

        $('.form-div').find('#name')
            .val(data ? data.name : null)
            .rules('add', { required: true });

        $('.form-div').find('#sku')
            .val(data ? data.sku : null)
            .attr('readonly', data ? data.platform_id != 1 ? true : false : false)
            .rules('add', { required: false });

        $('.form-div').find('#length')
            .val(data ? data.length : null)
            .rules('add', { required: true });

        $('.form-div').find('#width')
            .val(data ? data.width : null)
            .rules('add', { required: true });

        $('.form-div').find('#height')
            .val(data ? data.height : null)
            .rules('add', { required: true });

        $('.form-div').find('#weight')
            .val(data ? data.weight : null)
            .rules('add', { required: true });

        $('.form-div').find('#description')
            .val(data ? data.description : null)
            .rules('add', { required: false });

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

                await axios.delete(`/api/product/${id}`, {
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

    async function onImport() {

        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: "Import",
            denyButtonText: "Cancel",
        }).then(async (result) => {

            if (result.value) {

                blockUI();

                var id = $('#filter-platform_id').val();

                var platform = await sendRequest(`/api/platform/${id}`);

                await axios.get(`/api/integration/${platform.slug}/sync`, {
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

    async function onPlatformSelect() {

        var platformId = $('#filter-platform_id').val();

        if (platformId != 1) {

            $('#btn-import').show('fast');

        } else {

            $('#btn-import').hide('fast');

        }

        $('#dataGrid').DataTable().draw();

    }

</script>

@endsection
