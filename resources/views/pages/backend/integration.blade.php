@extends('layouts.backend.default')

@section('title', 'Integration')

@section('content')

<div class="card">
    <div class="card-header bg-light">
        <div class="d-flex justify-content-between align-items-baseline p-0">
            <div class="card-title p-0 m-0">Integration</div>
            <div>
                <button type="button" class="btn btn-secondary btn-sm" id="btn-integrate-back" onclick="onIntegrateBack();" style="display: none;">
                    Back
                </button>
                <button type="button" class="btn btn-primary btn-sm" id="btn-integrate" onclick="onIntegrate();">
                    Integrate
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
                        <th>Platform</th>
                        <th>Identifier</th>
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
    <div class="card-body platform-div" style="display: none;">
        <h4 class="text-center mb-3 mt-4">Choose a plaform</h4>
        <p class="text-muted text-center mb-4 pb-2">Choose the e-commerce platform for integration.</p>
        <div class="container">
            <div class="row" id="platformContainer">
                <!-- Placehoder: Platform -->
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')

<script>

    $(function() {

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
                url: `/api/datatable/integration`,
                method: "GET",
                headers: {
                    "Authorization": "Bearer {{ Session::get('api_token') }}"
                },
                data: function(data) {

                    data.filter = {};

                    data.filter.status_id = 3;

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
                        return `
                            <a href="javascript:void(0);" class="p-0" type="button" onclick="onDelete(${data})">
                                <svg viewBox="0 0 24 24" width="19" height="19" stroke="#e7515a" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
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
                    data: 'platform_name',
                    width: '35px',
                },
                {
                    data: 'key',
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

        if (isAdmin == false) $('#filter-user_id').parent().hide();

        getFilter(`/api/user`, '#filter-user_id', 'Select User');

        getPlatform();

    });

    async function getPlatform() {

        await axios.get(`/api/platform`, {
            headers: {
                "Authorization": "Bearer {{ Session::get('api_token') }}",
            },
            params: {
                is_integration: 1,
            },
        })
        .then(function (res) {
            console.log('response', res.data);
            if (res.status == 200) {
                var data = res.data.data;
                var html = ``;
                data.map((e) => {
                    html += `
                        <div class="col-md-4 stretch-card grid-margin grid-margin-md-0 my-3">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="text-center text-uppercase mt-3 mb-4">${e.value}</h5>
                                    <img src="{{ asset('assets/apps/img/${e.logo}') }}" class="d-block mx-auto wd-60 my-3" alt="platform" width="120">
                                    <a href="/integration/${e.slug}" class="btn btn-primary d-block mx-auto mt-4 ${e.is_available == 0 ? 'disabled' : ''}">Integrate</a>
                                </div>
                            </div>
                        </div>
                    `;
                });
                $('#platformContainer').empty().html(html);
            } else {
                $('#platformContainer').empty();
            }
        })
        .catch(function (err) {
            console.log('error', err.response);
            if (err.response) {
                $('#platformContainer').empty();
            }
        });

    }

    async function onIntegrate() {

        $('.table-div').hide('fast');
        $('.platform-div').show('fast');
        $('#btn-integrate-back').show('fast');
        $('#btn-integrate').hide('fast');

    }

    async function onIntegrateBack() {

        $('.table-div').show('fast');
        $('.platform-div').hide('fast');
        $('#btn-integrate-back').hide('fast');
        $('#btn-integrate').show('fast');

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

                await axios.delete(`/api/integration/${id}`, {
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
