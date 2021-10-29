@extends('layouts.backend.default')

@section('title', 'Store')

@section('content')

<div class="card">
    <div class="card-header bg-light">
        <div class="d-flex justify-content-between align-items-baseline p-0">
            <div class="card-title p-0 m-0">Store</div>
            <div>
                <button class="btn p-0" type="button" onclick="$('#dataGrid').DataTable().ajax.reload(null, false);">
                    <i class="icon-lg text-muted pb-3px" data-feather="refresh-cw"></i>
                </button>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table id="dataGrid" class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Action</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Description</th>
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

<div class="floating-button-wrapper">
    <button type="button" class="btn btn-primary" id="btnFloatCreate">
        <i class="mr-2 icon-small" data-feather="plus"></i>
        Create
    </button>
</div>

<div class="modal fade" id="modal_primary" tabindex="-1" role="dialog" aria-labelledby="title" aria-hidden="true">
    <input type="hidden" id="id" name="id">
    <form id="form">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-secondary" id="title">Create Warehouse</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
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
                        <label for="name">Name <span style="color: red;">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Name">
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <input type="text" class="form-control" id="description" name="description" placeholder="Description">
                    </div>
                    <div class="form-group">
                        <label for="is_online">Type <span style="color: red;">*</span></label>
                        <select class="select2-single form-control" id="is_online" name="is_online">
                            <option value="" selected disabled>-- Please Select --</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="btn_submit">
                        <span class="spinner-border spinner-border-sm mr-2" id="spinner" role="status" aria-hidden="true" style="display: none;"></span>
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
            processing: true,
            serverSide: true,
            order: [[0, 'ASC']],
            ajax: {
                url: `/api/datatable/store`,
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
                            <button class="btn p-0" type="button" onclick="onEdit(${data})">
                                <svg viewBox="0 0 24 24" width="19" height="19" stroke="#4361ee" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                </svg>
                            </button>
                            &nbsp;
                            <button class="btn p-0" type="button" onclick="onDelete(${data})">
                                <svg viewBox="0 0 24 24" width="19" height="19" stroke="#e7515a" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                                    <polyline points="3 6 5 6 21 6"></polyline>
                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                    <line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line>
                                </svg>
                            </button>
                        `;
                    },
                },
                {
                    data: 'name',
                    width: '35px',
                },
                {
                    data: 'is_online',
                    width: '35px',
                    render: function (data, type, row) {
                        var html = `<span class="badge badge-success">Online</span>`;
                        if (data == 0) {
                            html = `<span class="badge badge-danger">Offline</span>`;
                        }
                        return html
                    },
                },
                {
                    data: 'description',
                    width: '35px',
                },
                {
                    data: 'created_at',
                    width: '35px',
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

        var validator = $('#modal_primary').find('#form').validate();

        $('#btnFloatCreate').on('click', async function () {

            blockUI();

            var user = await sendRequest(`/api/user`);
            userOption = `<option value="" selected disabled>-- Please Select --</option>`;
            user.map((e) => { userOption += `<option value="${e.id}">${e.fullname}</option>`; });
            $('#modal_primary').find('#user_id').empty().html(userOption)
            $('#modal_primary').find('#user_id').parent().hide('fast');

            storeTypeOption = `<option value="" selected disabled>-- Please Select --</option>`;
            storeTypeOption += `<option value="1">Online</option>`;
            storeTypeOption += `<option value="0">Offline</option>`;
            $('#modal_primary').find('#is_online').empty().html(storeTypeOption);

            if (isAdmin) $('#modal_primary').find('#user_id').parent().show('fast');

            $('#modal_primary').find('#title').text('Create Store');

            $('#modal_primary').find('#error').html(``);

            $('#modal_primary').find('#id').val(null);

            $('#modal_primary').find('#user_id').val(isAdmin ? null : userId).trigger('change');
            $('#modal_primary').find('#name').val(null);
            $('#modal_primary').find('#description').val(null);
            $('#modal_primary').find('#is_online').val(null).trigger('change');

            $('#modal_primary').find('#name').rules('add', { required: true });
            $('#modal_primary').find('#description').rules('add', { required: false });
            $('#modal_primary').find('#is_online').rules('add', { required: true });

            $('#modal_primary').find('#spinner').hide('fast');
            $('#modal_primary').modal('show');

            unblockUI();

        });

        $('#modal_primary').find('#form').on('submit', async function(e) {

            e.preventDefault();

            if ($(this).valid()) {

                $('#modal_primary').find('#spinner').show('fast');

                var url = `/api/store`;

                var form = $('#modal_primary').find('#form')[0];
                var data = new FormData(form);

                var key = $('#modal_primary').find('#id').val();

                if (key) {
                    url = `/api/store/${key}`;
                }

                await axios.post(url, data, {
                    headers: {
                        "Authorization": "Bearer {{ Session::get('api_token') }}",
                        "content-type": "multipart/form-data"
                    },
                })
                .then(function (res) {
                    console.log('response', res.data);
                    if (res.data.status == true) {
                        $('#modal_primary').modal('hide');
                        $('#modal_primary').find('#spinner').hide('fast');
                        Swal.fire('Good job!', res.data.message, 'success');
                    } else {
                        $('#modal_primary').find('#spinner').hide('fast');
                        Swal.fire('Oops!', res.data.message, 'error');
                    }
                })
                .catch(function (err) {
                    console.log('error', err.response);
                    if (err.response) {
                        $('#modal_primary').find('#error').html(`
                            <div class="alert alert-danger" role="alert">
                                ${err.response.data.message}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        `).show('fast');
                    }
                    $('#modal_primary').find('#spinner').hide('fast');
                    Swal.fire('Oops!', 'Something went wrong...', 'error');
                });

                $('#dataGrid').DataTable().ajax.reload(null, false);

            }

        });

    });

    async function onEdit(id) {

        blockUI();

        var data = await sendRequest(`/api/store/${id}`);

        console.log(data);

        var user = await sendRequest(`/api/user`);
        userOption = `<option value="" selected disabled>-- Please Select --</option>`;
        user.map((e) => { userOption += `<option value="${e.id}">${e.fullname}</option>`; });
        $('#modal_primary').find('#user_id').empty().html(userOption);
        $('#modal_primary').find('#user_id').parent().hide('fast');

        storeTypeOption = `<option value="" selected disabled>-- Please Select --</option>`;
        storeTypeOption += `<option value="1">Online</option>`;
        storeTypeOption += `<option value="0">Offline</option>`;
        $('#modal_primary').find('#is_online').empty().html(storeTypeOption);

        if (isAdmin) $('#modal_primary').find('#user_id').parent().show('fast');

        $('#modal_primary').find('#title').text('Edit Store');

        $('#modal_primary').find('#error').html(``);

        $('#modal_primary').find('#id').val(data.id);

        $('#modal_primary').find('#user_id').val(data.user_id);
        $('#modal_primary').find('#name').val(data.name);
        $('#modal_primary').find('#description').val(data.description);
        $('#modal_primary').find('#is_online').val(data.is_online).trigger('change');

        $('#modal_primary').find('#user_id').rules('add', { required: true });
        $('#modal_primary').find('#name').rules('add', { required: true });
        $('#modal_primary').find('#description').rules('add', { required: false });
        $('#modal_primary').find('#is_online').rules('add', { required: true });

        $('#modal_primary').find('#spinner').hide('fast');
        $('#modal_primary').modal('show');

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

                await axios.delete(`/api/store/${id}`, {
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
