@extends('layouts.backend.default')

@section('title', 'Invoice')

@section('content')

<div class="card">
    <div class="card-header bg-light">
        <div class="d-flex justify-content-between align-items-baseline p-0">
            <div class="card-title p-0 m-0">Invoice</div>
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
                    <select class="form-control form-control-sm select2-single" id="filter-status_id" onchange="$('#dataGrid').DataTable().draw();">
                        <option value="" selected disabled>-- Select Status --</option>
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
                        <th>Invoice</th>
                        <th>Type</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Reason for Cancel</th>
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

<div class="modal fade" id="cancel-modal" tabindex="-1" role="dialog" aria-labelledby="cancel-modal-label" aria-hidden="true">
    <input type="hidden" id="id">
    <form id="form">
        <input type="hidden" id="status_id" name="status_id" value="5">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cancel-modal-label">Reject Invoice</h5>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="reason_for_cancel">Reason <span style="color: red;">*</span></label>
                            <input type="text" class="form-control" id="reason_for_cancel" name="reason_for_cancel" placeholder="Reason">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Discard</button>
                    <button class="btn btn-primary" type="submit">Reject</button>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection

@section('script')

<script>

    var dataGrid

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
                url: `/api/datatable/order`,
                method: "GET",
                headers: {
                    "Authorization": "Bearer {{ Session::get('api_token') }}"
                },
                data: function(data) {

                    data.filter = {};

                    // data.filter.status_id = 3;

                    var statusId = $('#filter-status_id').val();
                    if (statusId) data.filter.status_id = statusId;

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
                        var html = `
                            <a href="/admin/main/invoice/${data}" target="_blank" class="p-0" type="button">
                                <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="#ffac0c" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                            </a>
                        `;
                        if (row.status_id == 1)
                            html += `
                                &nbsp;
                                <a href="javascript:void(0);" class="p-0" type="button" onclick="onPay(${data})">
                                    <svg viewBox="0 0 24 24" width="19" height="19" stroke="#4361ee" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect><line x1="1" y1="10" x2="23" y2="10"></line></svg>
                                </a>
                            `;
                        if (isAdmin && row.status_id == 2)
                            html += `
                                &nbsp;
                                <a href="javascript:void(0);" class="p-0" type="button" onclick="onConfirm(${data})">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="#4361ee" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                                </a>
                                &nbsp;
                                <a href="javascript:void(0);" class="p-0" type="button" onclick="onCancel(this)">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="#e7515a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
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
                    data: 'invoice',
                    width: '35px',
                },
                {
                    data: 'category_name',
                    width: '35px',
                    render: function (data, type, row) {
                        var color = 'badge-success';
                        if (row.category_id == 'warehouse') color = 'badge-danger';
                        return `<span class="badge outline-${color} p-1">${data}</span>`;
                    },
                },
                {
                    data: 'grandtotal',
                    width: '35px',
                    sClass: 'text-right',
                    render: function (data, type, row) {
                        return data ? "Rp. " + parseInt(data).formatMoney(0, 3, '.') : "Rp. 0";
                    },
                },
                {
                    data: 'status_name',
                    width: '35px',
                    sClass: 'text-center',
                    render: function (data, type, row) {
                        var color = 'badge-success';
                        if (row.status_id == 1) color = 'badge-danger';
                        if (row.status_id == 2) color = 'badge-info';
                        if (row.status_id == 3) color = 'badge-warning';
                        if (row.status_id == 5) color = 'badge-primary';
                        return `<span class="badge ${color} p-1">${data}</span>`;
                    },
                },
                {
                    data: 'reason_for_cancel',
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
                    render: function (data, type, row) {
                        return moment(data).format('DD/MM/YYYY HH:mm');
                    },
                },
            ]
        });

        $('#cancel-modal').find('#form').on('submit', async function(e) {

            e.preventDefault();

            if ($(this).valid()) {

                blockUI();

                var form = $('#cancel-modal').find('#form')[0];
                var data = new FormData(form);

                var id = $('#cancel-modal').find('#id').val();

                var url = `/api/order/${id}`;

                await axios.post(url, data, {
                    headers: {
                        "Authorization": "Bearer {{ Session::get('api_token') }}",
                        "content-type": "multipart/form-data"
                    },
                })
                .then(function (res) {
                    console.log('response', res.data);
                    if (res.data.status == true) {
                        $('#cancel-modal').modal('hide');
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
                        $('#cancel-modal').find('#error').html(`
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

        getFilter(`/api/user`, '#filter-user_id', 'Select User');
        getFilter(`/api/order-status`, '#filter-status_id', 'Select Status');

    });

    async function onPay(id) {

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

    async function onCancel(selector) {

        var rowData = dataGrid.row($(selector).parents('tr')).data();

        console.log(rowData);

        $('#cancel-modal').find('#id').val(rowData.id);
        
        $('#cancel-modal').find('#reason_for_cancel').val(rowData.reason_for_cancel);

        $('#cancel-modal').modal('show');

    }

</script>

@endsection
