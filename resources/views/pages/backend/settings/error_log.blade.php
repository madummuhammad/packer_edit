@extends('layouts.backend.default')

@section('title', 'Error Log')

@section('content')

<div class="card">
    <div class="card-header bg-light">
        <div class="d-flex justify-content-between align-items-baseline p-0">
            <div class="card-title p-0 m-0">Error Log</div>
        </div>
    </div>
    <div class="table-div">
        <div class="table-responsive">
            <table id="dataGrid" class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Path</th>
                        <th>Line</th>
                        <th>Error Message</th>
                        <th>Created At</th>
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

        $('.custom-breadcrumb').toggleClass('bg-primary bg-danger');

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
                url: `/api/datatable/error-log`,
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
                    data: 'path',
                    width: '35px',
                    sClass: 'text-wrap width-200',
                },
                {
                    data: 'line',
                    width: '35px',
                },
                {
                    data: 'error',
                    width: '35px',
                    sClass: 'text-wrap width-200',
                },
                {
                    data: 'created_at',
                    width: '35px',
                    render: function (data, type, row) {
                        return moment(data).format('DD/MM/YYYY HH:mm');
                    },
                },
            ]
        });

        $('#btnFloatTruncate').on('click', function () {

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

                    await axios.delete(`/api/error-log`, {
                        headers: {
                            "Authorization": "Bearer {{ Session::get('api_token') }}",
                        },
                    })
                    .then(function (res) {
                        console.log('res', res);
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

        });

    });

</script>

@endsection
