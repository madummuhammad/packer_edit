@extends('layouts.backend.default')

@section('title', 'User Management')

@section('style')

<link href="{{ asset('assets/backend/assets/css/forms/theme-checkbox-radio.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/backend/assets/css/apps/contacts.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/backend/assets/css/widgets/modules-widgets.css') }}" rel="stylesheet" type="text/css" />

@endsection

@section('content')

<div class="row list-div">
    <div class="col-12">
        <div class="widget-content searchable-container list">
            <div class="row">
                <div class="col-xl-4 col-lg-5 col-md-5 col-sm-7 filtered-list-search layout-spacing align-self-center">
                    <form class="form-inline my-2 my-lg-0">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                            <input type="text" class="form-control product-search" id="input-search" placeholder="Search Contacts...">
                        </div>
                    </form>
                </div>
                <div class="col-xl-8 col-lg-7 col-md-7 col-sm-5 text-sm-right text-center layout-spacing align-self-center">
                    <div class="d-flex justify-content-sm-end justify-content-center">
                        <a href="javascript:void(0);" onclick="onUpdateOrCreate();"><svg id="btn-add-contact" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-plus"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line></svg></a>
                        <div class="switch align-self-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-list view-list active-view"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3" y2="6"></line><line x1="3" y1="12" x2="3" y2="12"></line><line x1="3" y1="18" x2="3" y2="18"></line></svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-grid view-grid"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                        </div>
                    </div>
                </div>
            </div>
            <div class="searchable-items list">
                <div class="items items-header-section">
                    <div class="item-content" style="width: 980px;">
                        <div class="user-profile mr-3" style="min-width: 180px;">
                            <div class="n-chk align-self-center text-center">
                                <label class="new-control new-checkbox checkbox-primary">
                                    <input type="checkbox" class="new-control-input" id="contact-check-all">
                                    <span class="new-control-indicator"></span>
                                </label>
                            </div>
                            <h4>Name</h4>
                        </div>
                        <div class="user-email" style="min-width: 240px;">
                            <h4>Email</h4>
                        </div>
                        <div class="user-location" style="min-width: 150px;">
                            <h4 style="margin-left: 0;">Location</h4>
                        </div>
                        <div class="user-phone" style="min-width: 150px;">
                            <h4 style="margin-left: 3px;">Phone</h4>
                        </div>
                        <div class="action-btn" style="min-width: 150px;">
                            <h4>Action</h4>
                        </div>
                    </div>
                </div>
                <div id="items">
                    <div class="text-center mt-3">
                        <div class="spinner-border spinner-border-sm" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row detail-div" style="display: none;">
    <div class="col-12 col-md-6 layout-spacing">
        <div class="widget widget-table-two">
            <div class="widget-heading d-flex">
                <a href="javascript:void(0);" class="mr-3" onclick="onView();"><svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg></a>
                <h5 class="mb-0">User Storage</h5>
            </div>
            <div class="widget-content">
                <div class="table-responsive">
                    <table id="dataGridStorage" class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Warehouse</th>
                                <th>Capacity Used</th>
                                <th>End Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Table Body -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6 layout-spacing">
        <div class="widget widget-table-two">
            <div class="widget-heading">
                <h5 class="">Inventory</h5>
            </div>
			<div class="widget-content">
				<div id="storage-items">
					<div class="alert alert-primary mb-0" style="line-height: 18px; font-size: 13px;">
						Pilih storage untuk melihat detail lengkap.
					</div>
				</div>
			</div>
		</div>
    </div>
    <div class="col-12 col-md-8 layout-spacing">
        <div class="widget widget-table-two">
            <div class="widget-heading">
                <h5 class="">User Price</h5>
            </div>
			<div class="widget-content">
                <div class="table-responsive">
                    <table id="dataGridSpace" class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Warehouse</th>
                                <th>Space</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Table Body -->
                        </tbody>
                    </table>
                </div>
            </div>
		</div>
    </div>
    <div class="col-12 col-md-4 layout-spacing">
        <div class="widget widget-table-two">
            <div class="widget-heading">
                <h5 class="">Price</h5>
            </div>
			<div class="widget-content">
				<div id="price-items">
                    <form id="price-items-form">
                        <div class="alert alert-primary mb-0" style="line-height: 18px; font-size: 13px;">
                            Pilih space untuk menambahkan harga.
                        </div>
                    </form>
				</div>
			</div>
		</div>
    </div>
</div>

<div class="card form-div" style="display: none;">
    <div class="card-header bg-light">
        <div class="d-flex justify-content-between align-items-baseline p-0">
            <div class="card-title p-0 m-0">User Management</div>
        </div>
    </div>
    <div class="">
        <input type="hidden" id="id" name="id">
        <form id="form">
            <div class="card-body">
                <div id="error">
                    <!-- Error Placeholder -->
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="username">Email <span style="color: red;">*</span></label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Email">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                        <div id="passwordHelp" class="form-text text-secondary">Default password is <b>12345678</b></div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="fullname">Fullname <span style="color: red;">*</span></label>
                        <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Fullname">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="phone">Phone <span style="color: red;">*</span></label>
                        <input type="number" class="form-control" id="phone" name="phone" placeholder="Phone">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="provinsi_id">Provinsi <span style="color: red;">*</span></label>
                        <select class="select2-single form-control" id="provinsi_id">
                            <option value="" selected disabled>-- Please Select --</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="kabupaten_id">Kabupaten <span style="color: red;">*</span></label>
                        <select class="select2-single form-control" id="kabupaten_id" name="kabupaten_id">
                            <option value="" selected disabled>-- Please Select --</option>
                        </select>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="address">Address <span style="color: red;">*</span></label>
                        <textarea class="form-control" id="address" name="address" cols="30" rows="3" placeholder="Masukkan alamat anda"></textarea>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="role_id">Role <span style="color: red;">*</span></label>
                        <select class="select2-single form-control" id="role_id" name="role_id">
                            <option value="" selected disabled>-- Please Select --</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="status_id">Status <span style="color: red;">*</span></label>
                        <select class="select2-single form-control" id="status_id" name="status_id">
                            <option value="" selected disabled>-- Please Select --</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-footer text-right">
                <button type="button" class="btn btn-secondary btn-sm" onclick="$('.form-div').hide('slow'); $('.list-div').show('slow');">
                    Back
                </button>
                <button type="submit" class="btn btn-primary btn-sm" id="btn-submit">
                    Submit
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('script')

<script>

    $(function () {

        initializeForm();
        getUser();

        var validator = $('.form-div').find('#form').validate();

        $('.form-div').find('#form').on('submit', async function(e) {

            e.preventDefault();

            if ($(this).valid()) {

                blockUI();

                var form = $('.form-div').find('#form')[0];
                var data = new FormData(form);

                var id = $('.form-div').find('#id').val();

                var url = `/api/user`;
                if (id) url = `/api/user/${id}`;

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
                        $('.list-div').show('slow');
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

                // $('#dataGrid').DataTable().ajax.reload(null, false);
                getUser();

            }

        });

        var validatorPrice = $('#price-items-form').validate();

        $('#price-items-form').on('submit', async function(e) {

            e.preventDefault();

            if ($(this).valid()) {

                blockUI();

                var form = $('#price-items-form')[0];
                var data = new FormData(form);

                var id = $('#price-items-form').find('#id').val();

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
                        $('.detail-div').hide('slow');
                        $('.list-div').show('slow');
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
                        $('.detail-div').find('#error').html(`
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

                getUser();

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

        $('#input-search').on('keyup', function() {
            var rex = new RegExp($(this).val(), 'i');
            $('.searchable-items .items:not(.items-header-section)').hide();
            $('.searchable-items .items:not(.items-header-section)').filter(function() {
                return rex.test($(this).text());
            }).show();
        });

    });

    async function initializeForm() {

        var province = await sendRequest(`/api/province`);
        var provinceOption = `<option value="" selected disabled>-- Please Select --</option>`;
        province.map((e) => { provinceOption += `<option value="${e.id}">${e.name}</option>`; });
        $('.form-div').find('#provinsi_id').empty().html(provinceOption);

        var cityOption = `<option value="" selected disabled>-- Please Select --</option>`;
        $('.form-div').find('#kabupaten_id').empty().html(cityOption).attr('disabled', true);

    }

    async function getUser() {

        await axios.get(`/api/user`, {
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
                        <div class="items user-${e.id}">
                            <div class="item-content" style="justify-content: start !important; width: 980px;">
                                <div class="user-profile mr-3" style="min-width: 180px;">
                                    <div class="n-chk align-self-center text-center">
                                        <label class="new-control new-checkbox checkbox-primary">
                                            <input type="checkbox" class="new-control-input contact-chkbox">
                                            <span class="new-control-indicator"></span>
                                        </label>
                                    </div>
                                    <img src="{{ asset('/assets/apps/img/default_image.png') }}" alt="avatar">
                                    <div class="user-meta-info">
                                        <p class="user-name" data-name="${e.fullname}">${e.fullname}</p>
                                        <p class="user-work" data-occupation="${e.role_name}">${e.role_name}</p>
                                    </div>
                                </div>
                                <div class="user-email mr-3" style="min-width: 240px;">
                                    <p class="info-title">Email: </p>
                                    <p class="usr-email-addr" data-email="${e.email}" style="font-size: 12px;">${e.email}</p>
                                </div>
                                <div class="user-location mr-3" style="min-width: 150px;">
                                    <p class="info-title">Location: </p>
                                    <p class="usr-location" data-location="${e.address}" style="font-size: 12px;">${e.address ? e.address : '-'}</p>
                                </div>
                                <div class="user-phone mr-3" style="min-width: 150px;">
                                    <p class="info-title">Phone: </p>
                                    <p class="usr-ph-no" data-phone="${e.phone}" style="font-size: 12px;">${e.phone ? '+62 ' + e.phone : '-'}</p>
                                </div>
                                <div class="action-btn mr-3 text-center" style="min-width: 150px;">
                                    <a href="javascript:void(0);" onclick="onView(${e.id})"><svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="#3b3f5c" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-circle-2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg></a>
                                    <a href="javascript:void(0);" onclick="onUpdateOrCreate(${e.id})"><svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="#3b3f5c" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg></a>
                                    <a href="javascript:void(0);" onclick="onDelete(${e.id})"><svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="#3b3f5c" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></a>
                                </div>
                            </div>
                        </div>
                    `;
                });
                $('#items').html(html);
            } else {
                var html = `
                    <div class="items">
                        <div class="item-content">
                            <p>No data</p>
                        </div>
                    </div>
                `;
                $('#items').html(html);
            }
        })
        .catch(function (err) {
            console.log('error', err);
            if (err.response) {
                var html = `
                    <div class="items">
                        <div class="item-content">
                            <p>No data</p>
                        </div>
                    </div>
                `;
                $('#items').html(html);
            }
        });

    }

    async function onView(id = null) {

        if (id == null) {

            $('.detail-div').hide('slow');
            $('.list-div').show('slow');

            var html = `
                <div class="alert alert-primary mb-0" style="line-height: 18px; font-size: 13px;">
                    Pilih storage untuk melihat detail lengkap.
                </div>
            `;

            $('.detail-div').find('#dataGridStorage').find('tbody').html(``);

            $('.detail-div').find('#storage-items').html(html);

            return;

        }

        var data = await sendRequest(`/api/user/${id}`);
        console.log(data);

        var storage = await sendRequest(`/api/storage`, `GET`, { user_id: id });

        var html = ``;
        storage.map((e, i) => {

            html += `
                <tr onclick="onViewInventory(${e.warehouse_id}, ${id});" style="cursor: pointer;">
                    <td class="text-center">
                        ${i + 1}
                    </td>
                    <td>
                        ${e.warehouse_name}
                    </td>
                    <td class="text-center">
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" role="progressbar" style="width: ${e.capacity_used}%" aria-valuenow="${e.capacity_used}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </td>
                    <td>
                        ${moment(e.end_date).format('DD/MM/YYYY')}
                    </td>
                </tr>
            `;

        });

        $('.detail-div').find('#dataGridStorage').find('tbody').html(html);

        var space = await sendRequest(`/api/space`, `GET`);

        var html = ``;
        space.map((e, i) => {
            html += `
                <tr onclick="onEditPrice(${e.id}, ${id});" style="cursor: pointer;">
                    <td class="text-center">
                        ${i + 1}
                    </td>
                    <td>
                        ${e.warehouse_name}
                    </td>
                    <td>
                        ${e.size} 
                    </td>
                    <td>
                        ${ e.custom_price != null ? '<p style="text-decoration: line-through;">Rp. ' + parseInt(e.price).formatMoney(0, 3, '.') + '</p>' + parseInt(e.custom_price).formatMoney(0, 3, '.') : 'Rp. ' + parseInt(e.price).formatMoney(0, 3, '.') }
                    </td>
                </tr>
            `;
        });

        $('.detail-div').find('#dataGridSpace').find('tbody').html(html);

        $('.detail-div').show('slow');
        $('.list-div').hide('slow');

    }

    async function onEditPrice(spaceId, userId) {

        var html = `
            <input type="hidden" id="id" name="id" value="${spaceId}">
            <div class="form-row">
                <input type="hidden" id="items-0-user_id" name="items[0][user_id]" value="${userId}">
                <div class="form-group col-md-12">
                    <label for="items-0-price">Price <span style="color: red;">*</span></label>
                    <input type="number" class="form-control" id="items-0-price" name="items[0][price]" placeholder="Price">
                </div>
                <div class="form-group" col-md-12>
                    <button type="submit" class="btn btn-primary btn-sm">
                        Submit
                    </button>
                </div>
            </div>
        `;

        $('.detail-div').find('#price-items-form').html(html);

    }

    async function onViewInventory(warehouseId, userId) {

        var inventory = await sendRequest(`/api/inventory`, `GET`, { warehouse_id: warehouseId, user_id: userId });
        console.log(inventory);

        var html = `
            <table id="dataGridStorage" class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Stock</th>
                    </tr>
                </thead>
                <tbody>
                    ${
                        inventory.map((e, i) => {
                            return `
                                <tr>
                                    <td>${i + 1}</td>
                                    <td>${e.product_name}</td>
                                    <td>${e.total_stock}</td>
                                </tr>
                            `;
                        })
                    }
                </tbody>
            </table>
        `;

        $('.detail-div').find('#storage-items').html(html);

    }

    async function onUpdateOrCreate(id = null) {

        blockUI();

        var data = null;

        if (id) data = await sendRequest(`/api/user/${id}`);
        console.log(data);

        var userRole = await sendRequest(`/api/user-role`);
        var userRoleOption = `<option value="" selected disabled>-- Please Select --</option>`;
        userRole.map((e) => { userRoleOption += `<option value="${e.id}">${e.value}</option>`; });
        $('.form-div').find('#role_id').empty().html(userRoleOption);

        var userStatus = await sendRequest(`/api/user-status`);
        var userStatusOption = `<option value="" selected disabled>-- Please Select --</option>`;
        userStatus.map((e) => { userStatusOption += `<option value="${e.id}">${e.value}</option>`; });
        $('.form-div').find('#status_id').empty().html(userStatusOption);

        if (id) {

            var city = await sendRequest(`/api/city?provinsi_id=${data.provinsi_id}`);
            var cityOption = `<option value="" selected disabled>-- Please Select --</option>`;
            city.map((e) => { cityOption += `<option value="${e.id}">${e.name}</option>`; });
            $('.form-div').find('#kabupaten_id').empty().html(cityOption).attr('disabled', false);

        } else {

            var cityOption = `<option value="" selected disabled>-- Please Select --</option>`;
            $('.form-div').find('#kabupaten_id').empty().html(cityOption).attr('disabled', false);

        }

        $('.form-div').find('#error').html(``);

        $('.form-div').find('#id').val(id);

        $('.form-div').find('#username')
            .val(data ? data.username : null)
            .rules('add', { required: true });

        $('.form-div').find('#password')
            .val(null)
            .rules('add', { required: false });

        $('.form-div').find('#fullname')
            .val(data ? data.fullname : null)
            .rules('add', { required: true });

        $('.form-div').find('#phone')
            .val(data ? data.phone : null)
            .rules('add', { required: true });

        $('.form-div').find('#provinsi_id')
            .val(data ? data.provinsi_id : null)
            .trigger('change.select2')
            .rules('add', { required: true });

        $('.form-div').find('#kabupaten_id')
            .val(data ? data.kabupaten_id : null)
            .trigger('change.select2')
            .rules('add', { required: true });

        $('.form-div').find('#address')
            .val(data ? data.address : null)
            .rules('add', { required: true });

        $('.form-div').find('#role_id')
            .val(data ? data.role_id : null)
            .trigger('change.select2')
            .rules('add', { required: true });

        $('.form-div').find('#status_id')
            .val(data ? data.status_id : null)
            .trigger('change.select2')
            .rules('add', { required: true });

        $('.form-div').show('slow');
        $('.list-div').hide('slow');

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

                await axios.delete(`/api/user/${id}`, {
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

                // $('#dataGrid').DataTable().ajax.reload(null, false);
                getUser();

            }

        });

    }

</script>

@endsection
