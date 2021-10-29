@extends('layouts.backend.default')

@section('title', 'Outbound')

@section('style')

<link href="{{ asset('assets/backend/assets/css/components/timeline/custom-timeline.css') }}" rel="stylesheet">

@endsection

@section('content')

<div class="card">
    <div class="card-header bg-light">
        <div class="d-flex justify-content-between align-items-baseline p-0">
            <div class="card-title p-0 m-0">Outbound</div>
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
                        <label for="user_id">User <span style="color: red;">*</span></label>
                        <select class="select2-single form-control" id="user_id" name="user_id">
                            <option value="" selected disabled>-- Please Select --</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="invoice_number">Invoice Number <span style="color: red;">*</span></label>
                        <input type="text" class="form-control" id="invoice_number" name="invoice_number" placeholder="Invoice Number">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="total_amount">Invoice Amount <span style="color: red;">*</span></label>
                        <input type="number" class="form-control" id="total_amount" name="total_amount" placeholder="Total Amount">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="name">Receiver Name <span style="color: red;">*</span></label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Name">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="phone">Receiver Phone <span style="color: red;">*</span></label>
                        <input type="number" class="form-control" id="phone" name="phone" placeholder="Receiver Phone">
                    </div>
                    <div class="form-group col-md-12">
                        <label for="address">Receiver Address <span style="color: red;">*</span></label>
                        <input type="text" class="form-control" id="address" name="address" placeholder="Receiver Address">
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
                    <div class="form-group col-md-6">
                        <label for="awb">Airway Bill</label>
                        <input type="text" class="form-control" id="awb" name="awb" placeholder="Airway Bill">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="note">Note</label>
                        <input type="text" class="form-control" id="note" name="note" placeholder="Note">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="warehouse_id">Origin <span style="color: red;">*</span></label>
                        <select class="select2-single form-control" id="warehouse_id" name="warehouse_id">
                            <option value="" selected disabled>-- Please Select --</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="status_id">Status <span style="color: red;">*</span></label>
                        <select class="select2-single form-control" id="status_id" name="status_id">
                            <option value="" selected disabled>-- Please Select --</option>
                        </select>
                    </div>
                    <div class="form-group col-md-12">
                        <div class="mb-3" id="items">
                            <!-- Placeholder -->
                        </div>
                        <button type="button" class="btn btn-danger btn-block" id="btn-add" onclick="onAddItem();">
                            Add Item
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
        <div class="card-body">
            <div class="d-flex flex-inline filter-div">
                <div class="form-group">
                    <select class="form-control form-control-sm select2-single" id="filter-platform_id" onchange="$('#dataGrid').DataTable().draw();">
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
                        <th>Status</th>
                        <th>User</th>
                        <th>Platform</th>
                        <th>Origin</th>
                        <th>Destination</th>
                        <th>Courier</th>
                        <th>Courier Price</th>
                        <th>Addon Price</th>
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

<div class="modal fade" id="courier-modal" tabindex="-1" role="dialog" aria-labelledby="courier-modal-label" aria-hidden="true">
    <input type="hidden" id="id" name="id">
    <input type="hidden" id="origin_id" name="origin_id">
    <input type="hidden" id="destination_id" name="destination_id">
    <form id="form">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="courier-modal-label">Courier</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="error">
                        <!-- Error Placeholder -->
                    </div>
                    <div class="form-row">
                        <input type="hidden" id="shipment_price" name="shipment_price">
                        <div class="form-group col-md-12">
                            <label for="courier_code">Courier <span style="color: red;">*</span></label>
                            <select class="select2-single form-control" id="courier_code" name="courier_code">
                                <option value="" selected disabled>-- Please Select --</option>
                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="courier_service_code">Service <span style="color: red;">*</span></label>
                            <select class="select2-single form-control" id="courier_service_code" name="courier_service_code" disabled>
                                <option value="" selected disabled>-- Please Select --</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12 mr-1"></i>Discard</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="modal fade" id="sent-modal" tabindex="-1" role="dialog" aria-labelledby="sent-modal-label" aria-hidden="true">
    <input type="hidden" id="id" name="id">
    <form id="form">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="sent-modal-label">Send Package</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="error">
                        <!-- Error Placeholder -->
                    </div>
                    <input type="hidden" id="status_id" name="status_id" value="5">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="awb">Airway Bill <span style="color: red;">*</span></label>
                            <input type="text" class="form-control" id="awb" name="awb" placeholder="Airway Bill">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="note">Note</label>
                            <textarea class="form-control" id="note" name="note" cols="30" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12 mr-1"></i>Discard</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="modal fade" id="shipment-status-modal" tabindex="-1" role="dialog" aria-labelledby="shipment-status-modal-label" aria-hidden="true">
    <input type="hidden" id="id" name="id">
    <form id="form">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="shipment-status-modal-label">Shipment Status</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-4">
                            <div class="card mb-2">
                                <div class="card-header">
                                    <h6 class="my-1">Informasi Pengiriman</h6>
                                </div>
                                <div class="card-body">
                                    <p class="mb-0 text-primary" style="font-size: 13px; font-weight: 800;">Receiver</p>
                                    <p style="font-size: 14.5px;" id="receiver_name"></p>
                                    <p class="mb-0 text-primary" style="font-size: 13px; font-weight: 800;">Destination</p>
                                    <p style="font-size: 13px;" id="address"></p>
                                    <p class="mb-0 text-primary" style="font-size: 13px; font-weight: 800;">Courier</p>
                                    <p style="font-size: 14.5px;" id="courier_name"></p>
                                    <p class="mb-0 text-primary" style="font-size: 13px; font-weight: 800;">Status</p>
                                    <p style="font-size: 14.5px;" id="shipment_status"></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-8">
                            <div class="card mb-2">
                                <div class="card-header">
                                    <h6 class="my-1">Manifest</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mt-container mx-auto">
                                        <div class="timeline-line">
                                            <!-- Placeholder: Timeline -->
                                        </div>                                    
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12 mr-1"></i>Close</button>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="modal fade" id="detail-modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Outbound</h5>
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
                                            <p id="invoice_number-text">-</p>
                                        </div>
                                        <div>
                                            <p class="mb-0 text-primary">Pembeli</p>
                                            <p id="name-text">-</p>
                                        </div>
                                        <div>
                                            <p class="mb-0 text-primary">Status</p>
                                            <p id="status_name-text">-</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card mt-2">
                                <div class="card-header" style="cursor: pointer;">
                                    <section class="mb-0 mt-0">
                                        <div role="menu" class="" data-toggle="collapse" data-target="#accordion-shipment" aria-expanded="false" aria-controls="accordion-shipment">
                                            Pengiriman
                                        </div>
                                    </section>
                                </div>
                                <div id="accordion-shipment" class="collapse" aria-labelledby="headingOne4" data-parent="#accordion-parent">
                                    <div class="card-body">
                                        <div>
                                            <p class="mb-0 text-primary">Alamat Tujuan</p>
                                            <p id="address-text">-</p>
                                        </div>
                                        <div>
                                            <p class="mb-0 text-primary">Kurir</p>
                                            <p id="courier-text">-</p>
                                        </div>
                                        <div>
                                            <p class="mb-0 text-primary">Ongkos Kirim</p>
                                            <p id="courier_price-text">-</p>
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
                                                    <th>Harga</th>
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

    var dataGrid, productIndex = 0;

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
                url: `/api/datatable/outbound`,
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
                        var html = ``;
                        html += `
                            <div class="row mb-2">
                                <div class="col-md-12">
                                    <a href="javascript:void(0);" class="p-0" type="button" onclick="onView(${data})">
                                        <svg viewBox="0 0 24 24" width="19" height="19" stroke="#ffac0c" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
                                    </a>
                                    &nbsp;
                                    <a href="javascript:void(0);" class="p-0" type="button" onclick="onUpdateOrCreate(${data})">
                                        <svg viewBox="0 0 24 24" width="19" height="19" stroke="#4361ee" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                    </a>
                                    &nbsp;
                                    <a href="javascript:void(0);" class="p-0" type="button" onclick="onDelete(${data})">
                                        <svg viewBox="0 0 24 24" width="19" height="19" stroke="#e7515a" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                    </a>
                                </div>
                            </div>
                        `;
                        if (isAdmin && row.status_id == 1)
                            html += `
                                <div class="row">
                                    <div class="col-md-12">
                                        <a href="javascript:void(0);" class="p-0" type="button" onclick="onStatusChange(${data}, 2)">
                                            <svg viewBox="0 0 24 24" width="19" height="19" stroke="#1abc9c" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                                        </a>
                                        &nbsp;
                                        <a href="javascript:void(0);" class="p-0" type="button" onclick="onStatusChange(${data}, 6)">
                                            <svg viewBox="0 0 24 24" width="19" height="19" stroke="#e7515a" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                                        </a>
                                    </div>
                                </div>
                            `;
                        if (isAdmin && row.status_id == 3)
                            html += `
                                <div class="row">
                                    <div class="col-md-12">
                                        <a href="javascript:void(0);" class="p-0" type="button" onclick="onStatusChange(${data}, 4)">
                                            <svg viewBox="0 0 24 24" width="19" height="19" stroke="#1abc9c" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                                        </a>
                                        &nbsp;
                                        <a href="javascript:void(0);" class="p-0" type="button" onclick="onStatusChange(${data}, 6)">
                                            <svg viewBox="0 0 24 24" width="19" height="19" stroke="#e7515a" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                                        </a>
                                    </div>
                                </div>
                            `;
                        if (isAdmin && row.status_id == 4)
                            html += `
                                <div class="row">
                                    <div class="col-md-12">
                                        <a href="/admin/main/shipment-label/${data}" class="p-0" type="button">
                                            <svg viewBox="0 0 24 24" width="19" height="19" stroke="#1abc9c" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><polyline points="6 9 6 2 18 2 18 9"></polyline><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path><rect x="6" y="14" width="12" height="8"></rect></svg>
                                        </a>
                                        &nbsp;
                                        <a href="javascript:void(0);" class="p-0" type="button" onclick="onSent(${data})">
                                            <svg viewBox="0 0 24 24" width="19" height="19" stroke="#e7515a" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><rect x="1" y="3" width="15" height="13"></rect><polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon><circle cx="5.5" cy="18.5" r="2.5"></circle><circle cx="18.5" cy="18.5" r="2.5"></circle></svg>
                                        </a>
                                    </div>
                                </div>
                            `;
                        if (isAdmin && row.status_id == 5)
                            html += `
                                <div class="row">
                                    <div class="col-md-12">
                                        <a href="javascript:void(0);" class="p-0" type="button" onclick="onCheckShipmentStatus(${row.awb})">
                                            <svg viewBox="0 0 24 24" width="19" height="19" stroke="#1abc9c" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1"><circle cx="12" cy="12" r="10"></circle><polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"></polygon></svg>
                                        </a>
                                    </div>
                                </div>
                            `;
                        return html;
                    },
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
                    data: 'user_name',
                    width: '35px',
                    visible: isAdmin ? true : false,
                },
                {
                    data: 'platform_name',
                    width: '35px',
                },
                {
                    data: 'warehouse_name',
                    width: '35px',
                    render: function (data, type, row) {
                        var html = `-`;
                        if (data) {
                            html = `
                                <p>${data}</p>
                                <p>${row.origin_kabupaten_name}</p>
                                <p>${row.origin_provinsi_name}</p>
                            `;
                        }
                        return html;
                    },
                },
                {
                    data: 'name',
                    width: '35px',
                    render: function (data, type, row) {
                        var html = `-`;
                        if (data) {
                            html = `
                                <p>${data}</p>
                                <p>${row.destination_kabupaten_name}</p>
                                <p>${row.destination_provinsi_name}</p>
                            `;
                        }
                        return html;
                    },
                },
                {
                    data: 'courier',
                    width: '35px',
                    sClass: 'text-center',
                    render: function (data, type, row) {
                        var html = ``;
                        if (row.courier_logo) 
                            html += `
                                <img src="${row.courier_logo}" atl="Courier Logo" style="height: 60px;">
                                <p>${row.courier_service_name}</p>
                            `;
                        if (row.status_id == 1)
                            html += `<a href="javascript:void(0);" class="btn btn-primary btn-sm" type="button" onclick="onSelectCourier(this);">Pilih Kurir</a>`;
                        return html;
                    },
                },
                {
                    data: 'courier_price',
                    width: '35px',
                    sClass: 'text-right',
                    render: function (data, type, row) {
                        return data ? "Rp. " + parseInt(data).formatMoney(0, 3, '.') : "Rp. 0";
                    },
                },
                {
                    data: 'addon_price',
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

                var url = `/api/outbound`;

                var form = $('.form-div').find('#form')[0];
                var data = new FormData(form);

                var key = $('.form-div').find('#id').val();

                if (key) {
                    url = `/api/outbound/${key}`;
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

        $('#sent-modal').find('#form').on('submit', async function(e) {

            e.preventDefault();

            if ($(this).valid()) {

                blockUI();

                var form = $('#sent-modal').find('#form')[0];
                var data = new FormData(form);

                var key = $('#sent-modal').find('#id').val();

                var url = `/api/outbound/${key}`;

                await axios.post(url, data, {
                    headers: {
                        "Authorization": "Bearer {{ Session::get('api_token') }}",
                        "content-type": "multipart/form-data"
                    },
                })
                .then(function (res) {
                    console.log('response', res.data);
                    if (res.data.status == true) {
                        $('#sent-modal').modal('hide');
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
                        $('#sent-modal').find('#error').html(`
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

        $('#courier-modal').find('#form').on('submit', async function(e) {

            e.preventDefault();

            if ($(this).valid()) {

                blockUI();

                var form = $('#courier-modal').find('#form')[0];
                var data = new FormData(form);

                var key = $('#courier-modal').find('#id').val();

                var url = `/api/outbound/shipment/${key}`;

                await axios.post(url, data, {
                    headers: {
                        "Authorization": "Bearer {{ Session::get('api_token') }}",
                        "content-type": "multipart/form-data"
                    },
                })
                .then(function (res) {
                    console.log('response', res.data);
                    if (res.data.status == true) {
                        $('#courier-modal').modal('hide');
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
                        $('#courier-modal').find('#error').html(`
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

                var city = await sendRequest(`/api/city`, `GET`, { provinsi_id: provinsiId });
                cityOption = `<option value="" selected disabled>-- Please Select --</option>`;
                city.map((e) => { cityOption += `<option value="${e.id}">${e.name}</option>`; });
                $('.form-div').find('#kabupaten_id').empty().html(cityOption).attr('disabled', false);

            }

        });

        $('#courier-modal').find('#courier_code').on('change', async function() {

            var outboundId = $('#courier-modal').find('#id').val();
            var originId = $('#courier-modal').find('#origin_id').val();
            var destinationId = $('#courier-modal').find('#destination_id').val();

            var courierCode = $(this).val();

            if (courierCode) {

                var courierService = await sendRequest(`/api/rajaongkir/rates/${outboundId}`, `GET`, {
                    origin_id: originId,
                    destination_id: destinationId,
                    courier_code: courierCode,
                });

                console.log(courierService.rajaongkir.results);

                var courierServiceOption = `<option value="" selected disabled>-- Please Select --</option>`;
                courierService.rajaongkir.results[0].costs.map((e) => { courierServiceOption += `<option value="${e.service}" data-price="${e.cost[0].value}">${e.description} - Rp. ${e.cost[0].value}</option>`; });
                $('#courier-modal').find('#courier_service_code').empty().html(courierServiceOption).attr('disabled', false);

            }

        });

        $('#courier-modal').find('#courier_service_code').on('change', async function(e) {

            var courierServiceCode = $(this).val();
            var shipmentPrice = $(this).find(':selected').attr('data-price');

            $('#courier-modal').find('#shipment_price').val(shipmentPrice);

        });

        if (isAdmin == false) $('#filter-user_id').parent().hide();

        initializeForm();

        getFilter(`/api/user`, '#filter-user_id', 'Select User');
        getFilter(`/api/platform`, '#filter-platform_id', 'Select Platform');

    });

    async function initializeForm() {

        var user = await sendRequest(`/api/user`);
        var userOption = `<option value="" selected disabled>-- Please Select --</option>`;
        user.map((e) => { userOption += `<option value="${e.id}">${e.fullname}</option>`; });
        $('.form-div').find('#user_id').empty().html(userOption);

        var warehouse = await sendRequest(`/api/warehouse`);
        var warehouseOption = `<option value="" selected disabled>-- Please Select --</option>`;
        warehouse.map((e) => { warehouseOption += `<option value="${e.id}">${e.name}</option>`; });
        $('.form-div').find('#warehouse_id').empty().html(warehouseOption);

        var outboundStatus = await sendRequest(`/api/outbound-status`);
        var outboundStatusOption = `<option value="" selected disabled>-- Please Select --</option>`;
        outboundStatus.map((e) => { outboundStatusOption += `<option value="${e.id}">${e.value}</option>`; });
        $('.form-div').find('#status_id').empty().html(outboundStatusOption);

        var province = await sendRequest(`/api/province`);
        var provinceOption = `<option value="" selected disabled>-- Please Select --</option>`;
        province.map((e) => { provinceOption += `<option value="${e.id}">${e.name}</option>`; });
        $('.form-div').find('#provinsi_id').empty().html(provinceOption);

        var warehouse = await sendRequest(`/api/warehouse`);
        var warehouseOption = `<option value="" selected disabled>-- Please Select --</option>`;
        warehouse.map((e) => { warehouseOption += `<option value="${e.id}">${e.name}</option>`; });
        $('.form-div').find('#warehouse_id').empty().html(warehouseOption);

        var courier = await sendRequest(`/api/courier`);
        var courierOption = `<option value="" selected disabled>-- Please Select --</option>`;
        courier.map((e) => { 
            courierOption += `<option value="${e.code}">${e.name}</option>`;
        });
        $('#courier-modal').find('#courier_code').empty().html(courierOption);

    }

    async function onAddItem() {

        productIndex++;

        var itemsHtml = `
            <div class="card mt-3" id="items-${productIndex}">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-baseline p-0">
                        <button class="btn p-0" type="button" onclick="onDeleteItem(${productIndex})">
                            <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="#e7515a" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="items-${productIndex}-product_id">Product <span style="color: red;">*</span></label>
                            <select class="select2-single form-control" id="items-${productIndex}-product_id" name="items[${productIndex}][product_id]">
                                <option value="" selected disabled>-- Please Select --</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="items-${productIndex}-qty">Qty <span style="color: red;">*</span></label>
                            <input type="number" class="form-control" id="items-${productIndex}-qty" name="items[${productIndex}][qty]" placeholder="Qty">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="items-${productIndex}-addon_id">Addon <span style="color: red;">*</span></label>
                            <select class="select2-multiple form-control" id="items-${productIndex}-addon_id" name="items[${productIndex}][addon_id][]" multiple>
                                
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        `;
        $('.form-div').find('#items').append(itemsHtml);
        $('.select2-single').select2();
        $('.select2-multiple').select2();

        var product = await sendRequest(`/api/product`);
        productOption = `<option value="" selected disabled>-- Please Select --</option>`;
        product.map((e) => { productOption += `<option value="${e.id}">${e.name} - ${e.sku}</option>`; });
        $('.form-div').find(`#items-${productIndex}-product_id`).empty().html(productOption);

        var addon = await sendRequest(`/api/addon`);
        addonOption = ``;
        addon.map((e) => { addonOption += `<option value="${e.id}">${e.name} - Rp. ${parseInt(e.price).formatMoney(0, 3, '.')}</option>`; });
        $('.form-div').find(`#items-${productIndex}-addon_id`).empty().html(addonOption);

    }

    async function onView(id) {

        var data = await sendRequest(`/api/outbound/${id}`);
        console.log(data);

        $('#detail-modal').find('#invoice_number-text').text(data.invoice_number);
        $('#detail-modal').find('#name-text').text(data.name);
        $('#detail-modal').find('#status_name-text').text(data.status_name);

        $('#detail-modal').find('#address-text').text(`${data.address}, ${data.destination_kabupaten_name}, ${data.destination_provinsi_name}`);
        $('#detail-modal').find('#courier-text').text(`${data.courier_name} - ${data.courier_service_code}`);
        $('#detail-modal').find('#courier_price-text').text(`Rp. ${parseInt(data.courier_price).formatMoney(0, 3, '.')}`);

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
                    <td>
                        <p class="mb-0 text-right">Rp. ${parseInt(e.outbound_price).formatMoney(0, 2, '.')}</p>
                        <p class="mb-0 text-right text-muted">(Rp. ${parseInt(e.outbound_price * e.qty).formatMoney(0, 2, '.')})</p>
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

        if (id) data = await sendRequest(`/api/outbound/${id}`);
        console.log(data);

        if (data) {
            var city = await sendRequest(`/api/city`, `GET`, { provinsi_id: data.destination_provinsi_id });
            var cityOption = `<option value="" selected disabled>-- Please Select --</option>`;
            city.map((e) => { cityOption += `<option value="${e.id}">${e.name}</option>`; });
            $('.form-div').find('#kabupaten_id').empty().html(cityOption).attr('disabled', false);
        } else {
            $('.form-div').find('#kabupaten_id').attr('disabled', true);
        }

        if (isAdmin) $('.form-div').find('#user_id').parent().show('fast');
        else $('.form-div').find('#user_id').parent().hide('fast');
        
        if (isAdmin) $('.form-div').find('#status_id').parent().show('fast');
        else $('.form-div').find('#status_id').parent().hide('fast');

        $('.form-div').find('#error').html(``);

        $('.form-div').find('#id').val(id);

        $('.form-div').find('#user_id')
            .val(data ? data.user_id : null)
            .trigger('change.select2')
            .rules('add', { required: true });

        $('.form-div').find('#invoice_number')
            .val(data ? data.invoice_number : null)
            .rules('add', { required: true });

        $('.form-div').find('#total_amount')
            .val(data ? data.total_amount : null)
            .rules('add', { required: true });

        $('.form-div').find('#name')
            .val(data ? data.name : null)
            .rules('add', { required: true });

        $('.form-div').find('#phone')
            .val(data ? data.phone : null)
            .rules('add', { required: true });

        $('.form-div').find('#address')
            .val(data ? data.address : null)
            .rules('add', { required: true });

        $('.form-div').find('#provinsi_id')
            .val(data ? data.destination_provinsi_id : null)
            .trigger('change.select2')
            .rules('add', { required: true });

        $('.form-div').find('#kabupaten_id')
            .val(data ? data.destination_kabupaten_id : null)
            .trigger('change.select2')
            .rules('add', { required: true });

        $('.form-div').find('#awb')
            .val(data ? data.awb : null)
            .rules('add', { required: false });

        $('.form-div').find('#note')
            .val(data ? data.note : null)
            .rules('add', { required: false });

        $('.form-div').find('#status_id')
            .val(data ? data.status_id : null)
            .trigger('change.select2')
            .rules('add', { required: true });

        $('.form-div').find('#warehouse_id')
            .val(data ? data.warehouse_id : null)
            .trigger('change.select2')
            .rules('add', { required: true });

        $('.form-div').find('#courier')
            .val(data ? data.courier : null)
            .rules('add', { required: true });

        $('.form-div').find('#dropshipper_name')
            .val(data ? data.dropshipper_name : null)
            .rules('add', { required: false });

        $('.form-div').find('#dropshipper_phone')
            .val(data ? data.dropshipper_phone : null)
            .rules('add', { required: false });

        productIndex = 0;

        $('.form-div').find('#items').empty();

        if (data) {

            data.items.map(async (e) => {

                productIndex++;

                var itemsHtml = `
                    <div class="card">
                        <div class="card-body">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label for="items-${productIndex}-product_id">Product <span style="color: red;">*</span></label>
                                    <select class="select2-single form-control" id="items-${productIndex}-product_id" name="items[${productIndex}][product_id]">
                                        <option value="" selected disabled>-- Please Select --</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="items-${productIndex}-qty">Qty <span style="color: red;">*</span></label>
                                    <input type="number" class="form-control" id="items-${productIndex}-qty" name="items[${productIndex}][qty]" placeholder="Qty">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="items-${productIndex}-addon_id">Addon <span style="color: red;">*</span></label>
                                    <select class="select2-multiple form-control" id="items-${productIndex}-addon_id" name="items[${productIndex}][addon_id][]" multiple>
                                        
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                $('.form-div').find('#items').append(itemsHtml);
                $('.select2-single').select2();
                $('.select2-multiple').select2();

                var product = await sendRequest(`/api/product`);
                productOption = `<option value="" selected disabled>-- Please Select --</option>`;
                product.map((e) => { productOption += `<option value="${e.id}">${e.name} - ${e.sku}</option>`; });
                $('.form-div').find(`#items-${productIndex}-product_id`).empty().html(productOption);

                var addon = await sendRequest(`/api/addon`);
                addonOption = ``;
                addon.map((e) => { addonOption += `<option value="${e.id}">${e.name} - Rp. ${parseInt(e.price).formatMoney(0, 3, '.')}</option>`; });
                $('.form-div').find(`#items-${productIndex}-addon_id`).empty().html(addonOption);

                $('.form-div').find(`#items-${productIndex}-product_id`).val(e.product_id).trigger('change.select2');
                $('.form-div').find(`#items-${productIndex}-qty`).val(e.qty);
                $('.form-div').find(`#items-${productIndex}-addon_id`).val(JSON.parse(e.addon_id)).trigger('change.select2');

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
                        <div class="form-group">
                            <label for="items-${productIndex}-addon_id">Addon <span style="color: red;">*</span></label>
                            <select class="select2-multiple form-control" id="items-${productIndex}-addon_id" name="items[${productIndex}][addon_id][]" multiple>
                                
                            </select>
                        </div>
                    </div>
                </div>
            `;
            $('.form-div').find('#items').html(itemsHtml);
            $('.select2-single').select2();
            $('.select2-multiple').select2();

            var product = await sendRequest(`/api/product`);
            productOption = `<option value="" selected disabled>-- Please Select --</option>`;
            product.map((e) => { productOption += `<option value="${e.id}">${e.name} - ${e.sku}</option>`; });
            $('.form-div').find(`#items-${productIndex}-product_id`).empty().html(productOption);

            var addon = await sendRequest(`/api/addon`);
            addonOption = ``;
            addon.map((e) => { addonOption += `<option value="${e.id}">${e.name} - Rp. ${parseInt(e.price).formatMoney(0, 3, '.')}</option>`; });
            $('.form-div').find(`#items-${productIndex}-addon_id`).empty().html(addonOption);

        }

        $('.form-div').show('slow');
        $('.table-div').hide('slow');

        unblockUI();

    }

    async function onSelectCourier(selector) {

        var rowData = dataGrid.row($(selector).parents('tr')).data();

        console.log(rowData);

        $('#courier-modal').find('#id').val(rowData.id);
        $('#courier-modal').find('#origin_id').val(rowData.origin_kabupaten_id);
        $('#courier-modal').find('#destination_id').val(rowData.destination_kabupaten_id);

        $('#courier-modal').modal('show');

    }

    async function onPrintShippingLabel(id) {

        var data = await sendRequest(`/api/outbound/print-shipping-label/${id}`);
        console.log(data);

        window.open(data.url);

    }

    async function onCheckShipmentStatus(awb) {

        await axios.get(`/api/rajaongkir/waybill/${awb}`, {
            headers: {
                "Authorization": "Bearer {{ Session::get('api_token') }}",
            },
        })
        .then(function (res) {
            console.log('response', res.data);
            if (res.status == 200) {
                $('#shipment-status-modal').find('#receiver_name').text(res.data.rajaongkir.result.summary.receiver_name);
                $('#shipment-status-modal').find('#address').text(res.data.rajaongkir.result.detail.receiver_address1 + ' ' + res.data.rajaongkir.result.detail.receiver_address2 + ' ' + res.data.rajaongkir.result.detail.receiver_address3);
                $('#shipment-status-modal').find('#courier_name').text(res.data.rajaongkir.result.summary.courier_name);
                $('#shipment-status-modal').find('#shipment_status').text(res.data.rajaongkir.result.summary.status);
                res.data.rajaongkir.result.manifest.map((e) => {
                    $('#shipment-status-modal').find('.timeline-line').append(`
                        <div class="item-timeline">
                            <p class="t-time">${e.manifest_time}</p>
                            <div class="t-dot t-dot-primary">
                            </div>
                            <div class="t-text">
                                <p>${e.manifest_description} - ${e.city_name}</p>
                                <p class="t-meta-time">${e.manifest_date} ${e.manifest_time}</p>
                            </div>
                        </div>
                    `);
                });
                $('#shipment-status-modal').modal('show');
            } else {
                Swal.fire('Oops!', res.data.message, 'error');
            }
        })
        .catch(function (err) {
            console.log('error', err);
            if (err.response) {
                Swal.fire('Oops!', err.response.data.message, 'error');
            } else {
                Swal.fire('Oops!', 'Something went wrong...', 'error');
            }
        });

    }

    async function onStatusChange(id, statusId) {

        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "info",
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: statusId == 8 ? "Reject" : "Approve",
            denyButtonText: "Cancel",
        }).then(async (result) => {

            if (result.value) {

                blockUI();

                var data = {
                    status_id: statusId
                };

                await axios.post(`/api/outbound/${id}`, data, {
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
                    console.log('error', err);
                    if (err.response) {
                        Swal.fire('Oops!', err.response.data.message, 'error');
                    } else {
                        Swal.fire('Oops!', 'Something went wrong...', 'error');
                    }
                });

                unblockUI();

                $('#dataGrid').DataTable().ajax.reload(null, false);

            }

        });

    }

    async function onSent(id) {

        $('#sent-modal').find('#id').val(id);

        $('#sent-modal').modal('show');

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

                await axios.delete(`/api/outbound/${id}`, {
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
                    console.log('error', err);
                    if (err.response) {
                        Swal.fire('Oops!', err.response.data.message, 'error');
                    } else {
                        Swal.fire('Oops!', 'Something went wrong...', 'error');
                    }
                });

                unblockUI();

                $('#dataGrid').DataTable().ajax.reload(null, false);

            }

        });

    }

</script>

@endsection
