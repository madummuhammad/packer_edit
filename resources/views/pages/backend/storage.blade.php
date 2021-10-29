@extends('layouts.backend.default')

@section('title', 'Storage')

@section('content')

<div class="card">
    <div class="card-header bg-light">
        <div class="d-flex justify-content-between align-items-baseline p-0">
            <div class="card-title p-0 m-0">Storage</div>
            <div>
                <button class="btn p-0" type="button" onclick="$('#dataGrid').DataTable().ajax.reload(null, false);">
                    <i class="icon-lg text-muted pb-3px" data-feather="refresh-cw"></i>
                </button>
            </div>
        </div>
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
                        <th>Size</th>
                        <th>Capacity Used</th>
                        <th>End Date</th>
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

<div class="modal fade" id="storage-modal" tabindex="-1" role="dialog" aria-labelledby="title" aria-hidden="true">
    <input type="hidden" id="id" name="id">
    <form id="form">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-secondary" id="title">Create Storage</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="error">
                        <!-- Error Placeholder -->
                    </div>
                    <div class="form-group">
                        <label for="capacity_used">Capacity Used <span style="color: red;">*</span></label>
                        <input type="number" class="form-control" id="capacity_used" name="capacity_used" min="0" max="100" placeholder="Capacity Used">
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
            order: [[0, 'DESC']],
            ajax: {
                url: `/api/datatable/storage`,
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
                    visible: isAdmin ? true : false,
                    render: function (data, type, row) {
                        return `
                            <a href="javascript:void(0);" class="p-0" type="button" onclick="onEdit(${data})">
                                <svg viewBox="0 0 24 24" width="19" height="19" stroke="#4361ee" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                </svg>
                            </a>
                        `;
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
                },
                {
                    data: 'kabupaten_name',
                    width: '35px',
                },
                {
                    data: 'size',
                    width: '35px',
                },
                {
                    data: 'capacity_used',
                    width: '35px',
                    render: function (data, type, row) {
                        return `
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" role="progressbar" style="width: ${data}%" aria-valuenow="${data}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        `;
                    }
                },
                {
                    data: 'end_date',
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

        var validator = $('#storage-modal').find('#form').validate();

        $('#storage-modal').find('#form').on('submit', async function(e) {

            e.preventDefault();

            if ($(this).valid()) {

                blockUI();

                var url = `/api/storage`;

                var form = $('#storage-modal').find('#form')[0];
                var data = new FormData(form);

                var key = $('#storage-modal').find('#id').val();

                if (key) {
                    url = `/api/storage/${key}`;
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
                        $('#storage-modal').modal('hide');
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
                        $('#storage-modal').find('#error').html(`
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

    async function onEdit(id) {

        blockUI();

        var data = await sendRequest(`/api/storage/${id}`);

        console.log(data);

        $('#storage-modal').find('#title').text('Edit Storage');

        $('#storage-modal').find('#error').html(``);

        $('#storage-modal').find('#id').val(data.id);

        $('#storage-modal').find('#capacity_used').val(data.capacity_used);

        $('#storage-modal').find('#capacity_used').rules('add', { required: true });

        $('#storage-modal').find('#spinner').hide('fast');
        $('#storage-modal').modal('show');

        unblockUI();

    }

</script>

@endsection
