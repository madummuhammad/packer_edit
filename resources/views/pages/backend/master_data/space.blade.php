@extends('layouts.backend.default')

@section('title', 'Space')

@section('content')

<div class="card">
    <div class="card-header bg-light">
        <div class="d-flex justify-content-between align-items-baseline p-0">
            <div class="card-title p-0 m-0">Space</div>
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
                <div class="form-row">
                    <div class="form-group col-md-12">
                        <label for="warehouse_id">Warehouse <span style="color: red;">*</span></label>
                        <select class="select2-single form-control" id="warehouse_id" name="warehouse_id">
                            <option value="" selected disabled>-- Please Select --</option>
                        </select>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="space_type_id">Type <span style="color: red;">*</span></label>
                        <select class="select2-single form-control" id="space_type_id" name="space_type_id">
                            <option value="" selected disabled>-- Please Select --</option>
                        </select>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="size">Size (l x w x h)</label>
                        <input type="text" class="form-control" id="size" name="size" placeholder="Size (l x w x h)">
                    </div>
                    <div class="form-group col-md-12">
                        <label for="stock">Stock</label>
                        <input type="number" class="form-control" id="stock" name="stock" placeholder="Stock">
                    </div>
                    <div class="form-group col-md-12">
                        <label for="price">Price</label>
                        <input type="number" class="form-control" id="price" name="price" placeholder="Price">
                    </div>
                    <div class="form-group col-md-12">
                        <div class="mb-3" id="items">
                            <!-- Placeholder -->
                        </div>
                        <button type="button" class="btn btn-danger btn-block" id="btn-add" onclick="onAddItem();">
                            Add Custom Price
                        </button>
                    </div>
                </div>
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
        <div class="table-responsive">
            <table id="dataGrid" class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Action</th>
                        <th>Partner</th>
                        <th>Warehouse</th>
                        <th>Type</th>
                        <th>Size</th>
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

@endsection

@section('script')

<script>

    var userIndex = 0;

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
                            <a href="javascript:void(0);" class="p-0" type="button" onclick="onUpdateOrCreate(${data})">
                                <svg viewBox="0 0 24 24" width="19" height="19" stroke="#4361ee" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                            </a>
                            &nbsp;
                            <a href="javascript:void(0);" class="p-0" type="button" onclick="onDelete(${data})">
                                <svg viewBox="0 0 24 24" width="19" height="19" stroke="#e7515a" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                            </a>
                        `;
                    },
                },
                {
                    data: 'partner_name',
                    width: '35px',
                },
                {
                    data: 'warehouse_name',
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

                var url = `/api/space`;
                if (id) url = `/api/space/${id}`;

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

        $('.form-div').find('#provinsi_id').on('change', async function(e) {

            var provinsiId = $(this).val();

            if (provinsiId) {

                var city = await sendRequest(`/api/city?provinsi_id=${provinsiId}`);
                var cityOption = `<option value="" selected disabled>-- Please Select --</option>`;
                city.map((e) => { cityOption += `<option value="${e.id}">${e.name}</option>`; });
                $('.form-div').find('#kabupaten_id').empty().html(cityOption).attr('disabled', false);

            }

        });

    });

    async function onAddItem() {

        userIndex++;

        var itemsHtml = `
            <div class="card mt-3" id="items-${userIndex}">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-baseline p-0">
                        <a href="javascript:void(0);" class="p-0" type="button" onclick="onDeleteItem(${userIndex})">
                            <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="#e7515a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="items-${userIndex}-user_id">User <span style="color: red;">*</span></label>
                            <select class="select2-single form-control" id="items-${userIndex}-user_id" name="items[${userIndex}][user_id]">
                                <option value="" selected disabled>-- Please Select --</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="items-${userIndex}-price">Price <span style="color: red;">*</span></label>
                            <input type="number" class="form-control" id="items-${userIndex}-price" name="items[${userIndex}][price]" placeholder="Price">
                        </div>
                    </div>
                </div>
            </div>
        `;
        $('.form-div').find('#items').append(itemsHtml);
        $('.select2-single').select2();

        var user = await sendRequest(`/api/user`);
        var userOption = `<option value="" selected disabled>-- Please Select --</option>`;
        user.map((e) => { userOption += `<option value="${e.id}">${e.fullname}</option>`; });
        $('.form-div').find(`#items-${userIndex}-user_id`).empty().html(userOption);

    }

    async function onUpdateOrCreate(id = null) {

        blockUI();

        var data = null;

        if (id) data = await sendRequest(`/api/space/${id}`);
        console.log(data);

        var warehouse = await sendRequest(`/api/warehouse`);
        var warehouseOption = `<option value="" selected disabled>-- Please Select --</option>`;
        warehouse.map((e) => { warehouseOption += `<option value="${e.id}">${e.name}</option>`; });
        $('.form-div').find('#warehouse_id').empty().html(warehouseOption);

        var spaceType = await sendRequest(`/api/space-type`);
        var spaceTypeOption = `<option value="" selected disabled>-- Please Select --</option>`;
        spaceType.map((e) => { spaceTypeOption += `<option value="${e.id}">${e.value}</option>`; });
        $('.form-div').find('#space_type_id').empty().html(spaceTypeOption);

        $('.form-div').find('#error').html(``);

        $('.form-div').find('#id').val(id);

        $('.form-div').find('#warehouse_id')
            .val(data ? data.warehouse_id : null)
            .trigger('change')
            .rules('add', { required: true });

        $('.form-div').find('#space_type_id')
            .val(data ? data.space_type_id : null)
            .trigger('change')
            .rules('add', { required: true });

        $('.form-div').find('#size')
            .val(data ? data.size : null)
            .rules('add', { required: true });

        $('.form-div').find('#stock')
            .val(data ? data.stock : null)
            .rules('add', { required: true });

        $('.form-div').find('#price')
            .val(data ? data.price : null)
            .rules('add', { required: true });

        userIndex = 0;

        $('.form-div').find('#items').empty();

        if (data) {

            data.items.map(async (e) => {

                userIndex++;

                var itemsHtml = `
                    <div class="card mt-3" id="items-${userIndex}">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-baseline p-0">
                                <a href="javascript:void(0);" class="p-0" type="button" onclick="onDeleteItem(${userIndex})">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="#e7515a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label for="items-${userIndex}-user_id">User <span style="color: red;">*</span></label>
                                    <select class="select2-single form-control" id="items-${userIndex}-user_id" name="items[${userIndex}][user_id]">
                                        <option value="" selected disabled>-- Please Select --</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="items-${userIndex}-price">Price <span style="color: red;">*</span></label>
                                    <input type="number" class="form-control" id="items-${userIndex}-price" name="items[${userIndex}][price]" placeholder="Price">
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                $('.form-div').find('#items').append(itemsHtml);
                $('.select2-single').select2();

                var user = await sendRequest(`/api/user`);
                var userOption = `<option value="" selected disabled>-- Please Select --</option>`;
                user.map((e) => { userOption += `<option value="${e.id}">${e.fullname}</option>`; });
                $('.form-div').find(`#items-${userIndex}-user_id`).empty().html(userOption);

                $('.form-div').find(`#items-${userIndex}-user_id`).val(e.user_id).trigger('change.select2');
                $('.form-div').find(`#items-${userIndex}-price`).val(e.price);

            });

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

                await axios.delete(`/api/space/${id}`, {
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
