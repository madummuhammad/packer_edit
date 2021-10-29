@extends('layouts.backend.default')

@section('title', 'Inventory')

@section('content')

<div class="card">
    <div class="card-header bg-light">
        <div class="d-flex justify-content-between align-items-baseline p-0">
            <div class="card-title p-0 m-0">Inventory</div>
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
                        <th>Name</th>
                        <th>SKU</th>
                        <th>Ready Stock</th>
                        <th>Incoming Stock</th>
                        <th>Pending Stock</th>
                        <th>Total Stock</th>
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
                url: `/api/datatable/inventory`,
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
                    visible: false,
                    render: function (data, type, row) {
                        return `
                            <a href="javascript:void(0);" class="btn p-0" type="button" onclick="onUpdateOrCreate(${data})">
                                <svg viewBox="0 0 24 24" width="19" height="19" stroke="#4361ee" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                            </a>
                            &nbsp;
                            <a href="javascript:void(0);" class="btn p-0" type="button" onclick="onDelete(${data})">
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
                    data: 'warehouse_name',
                    width: '35px',
                },
                {
                    data: 'product_name',
                    width: '35px',
                },
                {
                    data: 'sku',
                    width: '35px',
                },
                {
                    data: 'stock',
                    width: '35px',
                },
                {
                    data: 'incoming_stock',
                    width: '35px',
                },
                {
                    data: 'pending_stock',
                    width: '35px',
                },
                {
                    data: 'total_stock',
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

        if (isAdmin == false) $('#filter-user_id').parent().hide();

        getFilter(`/api/user`, '#filter-user_id', 'Select User');

    });

</script>

@endsection
