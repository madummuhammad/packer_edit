<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Addon;
use App\Models\User;
use App\Models\Inventory;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Outbound;
use App\Models\OutboundItem;
use App\Models\OutboundChatItem;
use App\Models\OutboundShipment;
use App\Models\Product;

use App\Helper\Activity;
use App\Helper\CustomException;

use DB;
use Carbon\Carbon;
use Exception;
use Hash;
use Validator;

class OutboundController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        try {

            $url = url('/assets/apps/img/courier/');

            $data = Outbound::select(
                'outbounds.id',
                'outbounds.user_id',
                'users.fullname as user_name',
                'outbounds.platform_id',
                'master_platform.value as platform_name',
                'warehouses.id as warehouse_id',
                'warehouses.name as warehouse_name',
                'origin_city.id as origin_kabupaten_id',
                'origin_city.name as origin_kabupaten_name',
                'origin_province.id as origin_provinsi_id',
                'origin_province.name as origin_provinsi_name',
                'outbounds.invoice_number',
                'outbounds.total_amount',
                'outbounds.name',
                'outbounds.phone',
                'outbounds.address',
                'destination_city.id as destination_kabupaten_id',
                'destination_city.name as destination_kabupaten_name',
                'destination_province.id as destination_provinsi_id',
                'destination_province.name as destination_provinsi_name',
                'outbounds.awb',
                'outbounds.note',
                'outbounds.courier',
                DB::raw('(select id from outbound_shipment where outbound_id = outbounds.id and deleted_at is null) as courier_id'),
                DB::raw('(select courier_code from outbound_shipment where outbound_id = outbounds.id and deleted_at is null) as courier_code'),
                DB::raw('(select courier_name from outbound_shipment where outbound_id = outbounds.id and deleted_at is null) as courier_name'),
                DB::raw('(select courier_service_code from outbound_shipment where outbound_id = outbounds.id and deleted_at is null) as courier_service_code'),
                DB::raw('(select courier_service_name from outbound_shipment where outbound_id = outbounds.id and deleted_at is null) as courier_service_name'),
                DB::raw('(select shipment_price from outbound_shipment where outbound_id = outbounds.id and deleted_at is null) as courier_price'),
                DB::raw("(select concat('{$url}/', logo) from couriers where id = substring_index(outbounds.courier, '-', 1)) as courier_logo"),
                'outbounds.dropshipper_name',
                'outbounds.dropshipper_phone',
                'outbounds.status_id',
                'master_outbound_status.value as status_name',
                'outbounds.created_at',
                'outbounds.updated_at',
            )
            ->leftJoin('users', 'users.id', 'outbounds.user_id')
            ->leftJoin('master_platform', 'master_platform.id', 'outbounds.platform_id')
            ->leftJoin('warehouses', 'warehouses.id', 'outbounds.warehouse_id')
            ->leftJoin('master_wilayah_kabupaten as origin_city', 'origin_city.id', 'warehouses.kabupaten_id')
            ->leftJoin('master_wilayah_provinsi as origin_province', 'origin_province.id', 'origin_city.provinsi_id')
            ->leftJoin('master_wilayah_kabupaten as destination_city', 'destination_city.id', 'outbounds.kabupaten_id')
            ->leftJoin('master_wilayah_provinsi as destination_province', 'destination_province.id', 'destination_city.provinsi_id')
            ->leftJoin('master_outbound_status', 'master_outbound_status.id', 'outbounds.status_id')
            ->get();

            foreach ($data as &$d) {

                $d->items = OutboundItem::where('outbound_id', $d->id)->get();
                $d->chat_items = OutboundChatItem::where('outbound_id', $d->id)->get();

            }

            Activity::onAct($request, 'Get Store');

            return response()->json([
                'status' => true,
                'message' => 'OK',
                'data' => $data,
            ], 200);

        } catch (Exception $e) {

            CustomException::onError($e);

            return response()->json([
                'status' => false,
                'message' => 'Maaf! Terjadi kesalahan pada sistem...',
                'error' => $e->getMessage(),
            ], 500);

        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'invoice_number' => 'required|unique:outbounds,invoice_number',
            'total_amount' => 'required|integer',
            'name' => 'required|string|min:5|max:255',
            'phone' => 'required|string|min:5|max:255',
            'address' => 'required|string|min:5|max:255',
            'kabupaten_id' => 'required|exists:master_wilayah_kabupaten,id',
            'awb' => 'nullable|string|min:5|max:255',
            'note' => 'nullable|string|min:5|max:255',
            'status_id' => 'filled|exists:master_outbound_status,id',
            'dropshipper_name' => 'nullable|string|min:5|max:255',
            'dropshipper_phone' => 'nullable|string|min:5|max:255',
            'items' => 'required|array',
            'items.*.product_id' => 'filled|exists:products,id',
            'items.*.qty' => 'filled|integer',
            'items.*.addon_id' => 'filled|array',
            'items.*.addon_id.*' => 'filled|exists:addons,id',
        ]);

        if ($validator->fails()) {

            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
                'error' => $validator->errors(),
            ], 400);

        }
        
        try {

            DB::beginTransaction();

            $data = $request->except('items');

            $Outbound = Outbound::create($data);

            $items = $request->items;

            foreach ($items as $d) {

                $data = [
                    'outbound_id' => $Outbound->id,
                    'product_id' => $d['product_id'],
                    'qty' => $d['qty'],
                    'addon_id' => array_key_exists('addon_id', $d) ? json_encode($d['addon_id']) : json_encode([]),
                ];

                $OutboundItem = OutboundItem::create($data);

            }

            DB::commit();

            Activity::onAct($request, 'Create Outbound');

            return response()->json([
                'status' => true,
                'message' => 'Berhasil melakukan perubahan!',
            ], 200);

        } catch (Exception $e) {

            DB::rollBack();

            CustomException::onError($e);

            return response()->json([
                'status' => false,
                'message' => 'Maaf! Terjadi kesalahan pada sistem...',
                'error' => $e->getMessage(),
            ], 500);

        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        
        try {

            $url = url('/assets/apps/img/courier/');

            $data = Outbound::select(
                'outbounds.id',
                'outbounds.user_id',
                'users.fullname as user_name',
                'outbounds.platform_id',
                'master_platform.value as platform_name',
                'warehouses.id as warehouse_id',
                'warehouses.name as warehouse_name',
                'origin_city.id as origin_kabupaten_id',
                'origin_city.name as origin_kabupaten_name',
                'origin_province.id as origin_provinsi_id',
                'origin_province.name as origin_provinsi_name',
                'outbounds.invoice_number',
                'outbounds.total_amount',
                'outbounds.name',
                'outbounds.phone',
                'outbounds.address',
                'destination_city.id as destination_kabupaten_id',
                'destination_city.name as destination_kabupaten_name',
                'destination_province.id as destination_provinsi_id',
                'destination_province.name as destination_provinsi_name',
                'outbounds.awb',
                'outbounds.note',
                'outbounds.courier',
                DB::raw('(select id from outbound_shipment where outbound_id = outbounds.id and deleted_at is null) as courier_id'),
                DB::raw('(select courier_code from outbound_shipment where outbound_id = outbounds.id and deleted_at is null) as courier_code'),
                DB::raw('(select courier_name from outbound_shipment where outbound_id = outbounds.id and deleted_at is null) as courier_name'),
                DB::raw('(select courier_service_code from outbound_shipment where outbound_id = outbounds.id and deleted_at is null) as courier_service_code'),
                DB::raw('(select courier_service_name from outbound_shipment where outbound_id = outbounds.id and deleted_at is null) as courier_service_name'),
                DB::raw('(select shipment_price from outbound_shipment where outbound_id = outbounds.id and deleted_at is null) as courier_price'),
                DB::raw("(select concat('{$url}/', logo) from couriers where id = substring_index(outbounds.courier, '-', 1)) as courier_logo"),
                'outbounds.dropshipper_name',
                'outbounds.dropshipper_phone',
                'outbounds.status_id',
                'master_outbound_status.value as status_name',
                'outbounds.created_at',
                'outbounds.updated_at',
            )
            ->leftJoin('users', 'users.id', 'outbounds.user_id')
            ->leftJoin('master_platform', 'master_platform.id', 'outbounds.platform_id')
            ->leftJoin('warehouses', 'warehouses.id', 'outbounds.warehouse_id')
            ->leftJoin('master_wilayah_kabupaten as origin_city', 'origin_city.id', 'warehouses.kabupaten_id')
            ->leftJoin('master_wilayah_provinsi as origin_province', 'origin_province.id', 'origin_city.provinsi_id')
            ->leftJoin('master_wilayah_kabupaten as destination_city', 'destination_city.id', 'outbounds.kabupaten_id')
            ->leftJoin('master_wilayah_provinsi as destination_province', 'destination_province.id', 'destination_city.provinsi_id')
            ->leftJoin('master_outbound_status', 'master_outbound_status.id', 'outbounds.status_id')
            ->where('outbounds.id', $id)
            ->first();

            if (is_null($data)) {

                return response()->json([
                    'status' => false,
                    'message' => 'Outbound tidak ditemukan...',
                ], 404);

            }

            $data->items = OutboundItem::select(
                'outbound_item.*',
                'products.*'
            )
            ->leftJoin('products', 'products.id', 'outbound_item.product_id')
            ->where('outbound_id', $data->id)
            ->get();

            Activity::onAct($request, 'Show Outbound');

            return response()->json([
                'status' => true,
                'message' => 'OK',
                'data' => $data,
            ], 200);

        } catch (Exception $e) {

            CustomException::onError($e);

            return response()->json([
                'status' => false,
                'message' => 'Maaf! Terjadi kesalahan pada sistem...',
                'error' => $e->getMessage(),
            ], 500);

        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
        $validator = Validator::make($request->all(), [
            'user_id' => 'filled|exists:users,id',
            'invoice_number' => 'filled|exists:outbounds,invoice_number',
            'total_amount' => 'filled|integer',
            'name' => 'filled|string|min:5|max:255',
            'phone' => 'filled|string|min:5|max:255',
            'address' => 'filled|string|min:5|max:255',
            'kabupaten_id' => 'filled|exists:master_wilayah_kabupaten,id',
            'awb' => 'nullable|string|min:5|max:255',
            'note' => 'nullable|string|min:5|max:255',
            'status_id' => 'filled|exists:master_outbound_status,id',
            'dropshipper_name' => 'nullable|string|min:5|max:255',
            'dropshipper_phone' => 'nullable|string|min:5|max:255',
            'items' => 'filled|array',
            'items.*.product_id' => 'filled|exists:products,id',
            'items.*.qty' => 'filled|integer',
            'items.*.addon_id' => 'filled|array',
            'items.*.addon_id.*' => 'filled|exists:addons,id',
        ]);

        if ($validator->fails()) {

            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
                'error' => $validator->errors(),
            ], 400);

        }
        
        try {

            DB::beginTransaction();

            $outbound = Outbound::where('id', $id)->first();

            if (is_null($outbound)) {

                return response()->json([
                    'status' => false,
                    'message' => 'Outbound tidak ditemukan...',
                ], 404);

            }

            $data = $request->except('items');

            $outbound->update($data);

            $items = $request->items;

            OutboundItem::where('outbound_id', $outbound->id)->delete();

            foreach ($items as $d) {

                $data = [
                    'outbound_id' => $outbound->id,
                    'product_id' => $d['product_id'],
                    'qty' => $d['qty'],
                    'addon_id' => array_key_exists('addon_id', $d) ? json_encode($d['addon_id']) : json_encode([]),
                ];

                $outboundItem = OutboundItem::create($data);

            }

            if ($request->status_id == 2) {

                $now = Carbon::now();

                $subtotal = 0;
                $tax = 0;
                $grandtotal = 0;

                $dataOrder = [
                    'user_id' => $outbound->user_id,
                    'status_id' => 1,
                    'invoice' => null,
                    'category_id' => 'outbound',
                    'external_id' => $outbound->id,
                    'subtotal' => $subtotal,
                    'tax' => $tax,
                    'grandtotal' => $grandtotal,
                ];

                $order = Order::create($dataOrder);

                $outboundItems = OutboundItem::where('outbound_id', $outbound->id)->get();

                foreach ($outboundItems as $i) {

                    $product = Product::find($i->product_id);

                    $data = [
                        'order_id' => $order->id,
                        'description' => $product->name,
                        'qty' => $i->qty,
                        'duration' => 1,
                        'price' => $product->outbound_price,
                        'total_price' => $product->outbound_price * $i->qty,
                        'internal_id' => $i->product_id,
                    ];
    
                    $orderItem = OrderItem::create($data);

                    $subtotal += $product->outbound_price * $i->qty;

                }

                // $tax = $subtotal * 0.1;
                $grandtotal = $subtotal + $tax;

                $incrementId = str_pad($order->id, 9, 0, STR_PAD_LEFT);

                $dataOrder = [
                    'invoice' => "INV/{$now->format('Ymd')}/{$outbound->user_id}/{$incrementId}",
                    'subtotal' => $subtotal,
                    'tax' => $tax,
                    'grandtotal' => $grandtotal,
                ];
    
                $order->update($dataOrder);

            } else if ($request->status_id == 4) {

                $outboundItems = OutboundItem::where('outbound_id', $outbound->id)->get();

                $unavailableProducts = [];

                foreach ($outboundItems as $i) {

                    $product = Product::where('id', $i->product_id)->first();

                    $inventory = Inventory::where('product_id', $i->product_id)->first();

                    if (isset($inventory)) {

                        $data = [
                            'stock' => $inventory->stock - $i->qty,
                        ];
    
                        $inventory->update($data);

                    } else {

                        array_push($unavailableProducts, $product->name);

                    }

                }

                if (count($unavailableProducts) > 0) {

                    $productString = '';
                    
                    foreach ($unavailableProducts as $i => $d) {

                        if ($i == 0) $productString .= $d;
                        else $productString .= ', ' . $d;

                    }

                    DB::rollBack();

                    return response()->json([
                        'status' => false,
                        'message' => "Maaf! Stock untuk produk {$productString} tidak tersedia...",
                    ], 400);
                    
                }

            }

            DB::commit();

            Activity::onAct($request, 'Update Outbound');

            return response()->json([
                'status' => true,
                'message' => 'Berhasil melakukan perubahan!',
            ], 200);

        } catch (Exception $e) {

            DB::rollBack();

            CustomException::onError($e);

            return response()->json([
                'status' => false,
                'message' => 'Maaf! Terjadi kesalahan pada sistem...',
                'error' => $e->getMessage(),
            ], 500);

        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        
        try {

            DB::beginTransaction();

            $Outbound = Outbound::where('id', $id)->first();

            if (is_null($Outbound)) {

                return response()->json([
                    'status' => false,
                    'message' => 'Outbound tidak ditemukan...',
                ], 404);

            }

            $Outbound->delete();

            DB::commit();

            Activity::onAct($request, 'Delete Outbound');

            return response()->json([
                'status' => true,
                'message' => 'Berhasil melakukan perubahan!',
            ], 200);

        } catch (Exception $e) {

            DB::rollBack();

            CustomException::onError($e);

            return response()->json([
                'status' => false,
                'message' => 'Maaf! Terjadi kesalahan pada sistem...',
                'error' => $e->getMessage(),
            ], 500);

        }

    }

    /**
     * Display a listing of the resource for DataTable.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function dataTable(Request $request)
    {

        $user = User::where('api_token', $request->bearerToken())->first();

        $url = url('/assets/apps/img/courier/');

        try {

            $columns = ['id', 'id', 'status_name', 'user_name', 'warehouse_name', 'name', 'courier', 'created_at', 'updated_at'];

            $column = $columns[$request->input('order.0.column')];
            $dir   = $request->input('order.0.dir');

            $data = Outbound::select(
                'outbounds.id',
                'outbounds.user_id',
                'users.fullname as user_name',
                'outbounds.platform_id',
                'master_platform.value as platform_name',
                'warehouses.id as warehouse_id',
                'warehouses.name as warehouse_name',
                'origin_city.id as origin_kabupaten_id',
                'origin_city.name as origin_kabupaten_name',
                'origin_province.id as origin_provinsi_id',
                'origin_province.name as origin_provinsi_name',
                'outbounds.invoice_number',
                'outbounds.total_amount',
                'outbounds.name',
                'outbounds.phone',
                'outbounds.address',
                'destination_city.id as destination_kabupaten_id',
                'destination_city.name as destination_kabupaten_name',
                'destination_province.id as destination_provinsi_id',
                'destination_province.name as destination_provinsi_name',
                'outbounds.awb',
                'outbounds.note',
                'outbounds.courier',
                DB::raw('(select id from outbound_shipment where outbound_id = outbounds.id and deleted_at is null) as courier_id'),
                DB::raw('(select courier_code from outbound_shipment where outbound_id = outbounds.id and deleted_at is null) as courier_code'),
                DB::raw('(select courier_name from outbound_shipment where outbound_id = outbounds.id and deleted_at is null) as courier_name'),
                DB::raw('(select courier_service_code from outbound_shipment where outbound_id = outbounds.id and deleted_at is null) as courier_service_code'),
                DB::raw('(select courier_service_name from outbound_shipment where outbound_id = outbounds.id and deleted_at is null) as courier_service_name'),
                DB::raw('(select shipment_price from outbound_shipment where outbound_id = outbounds.id and deleted_at is null) as courier_price'),
                DB::raw("(select concat('{$url}/', logo) from couriers where id = substring_index(outbounds.courier, '-', 1)) as courier_logo"),
                'outbounds.dropshipper_name',
                'outbounds.dropshipper_phone',
                'outbounds.status_id',
                'master_outbound_status.value as status_name',
                'outbounds.created_at',
                'outbounds.updated_at',
            )
            ->leftJoin('users', 'users.id', 'outbounds.user_id')
            ->leftJoin('master_platform', 'master_platform.id', 'outbounds.platform_id')
            ->leftJoin('warehouses', 'warehouses.id', 'outbounds.warehouse_id')
            ->leftJoin('master_wilayah_kabupaten as origin_city', 'origin_city.id', 'warehouses.kabupaten_id')
            ->leftJoin('master_wilayah_provinsi as origin_province', 'origin_province.id', 'origin_city.provinsi_id')
            ->leftJoin('master_wilayah_kabupaten as destination_city', 'destination_city.id', 'outbounds.kabupaten_id')
            ->leftJoin('master_wilayah_provinsi as destination_province', 'destination_province.id', 'destination_city.provinsi_id')
            ->leftJoin('master_outbound_status', 'master_outbound_status.id', 'outbounds.status_id')
            ->when($user, function ($query) use ($user) {
                $admin = [1, 2];
                $isAdmin = in_array($user->role_id, $admin);
                if (!$isAdmin) {
                    $query->where('outbounds.user_id', $user->id);
                }
            })
            ->when($request, function ($query) use ($request) {
                $search = $request->search['value'];
                if (isset($search)) {
                    // TODO
                }
                $filter = $request->filter;
                if (is_array($filter)) {
                    if (array_key_exists('platform_id', $filter)) $query->where('outbounds.platform_id', $filter['platform_id']);
                    if (array_key_exists('user_id', $filter)) $query->where('outbounds.user_id', $filter['user_id']);
                    if (array_key_exists('start_date', $filter) && array_key_exists('end_date', $filter)) $query->whereBetween(DB::raw("date_format(outbounds.created_at, '%Y-%m-%d')"), [$filter['start_date'], $filter['end_date']]);
                }
            })
            ->orderBy($column, $dir)
            ->skip($request->start)
            ->take($request->length)
            ->get();

            foreach ($data as &$d) {

                $outboundItem = OutboundItem::where('outbound_id', $d->id)->get();

                $addon = [];
                
                foreach ($outboundItem as $i) {

                    foreach (json_decode($i->addon_id) as $e) {

                        array_push($addon, $e);

                    }

                }

                $d->addon_price = Addon::whereIn('id', $addon)->sum('price');

            }

            $recordsTotal = Outbound::count();
            $recordsFiltered = Outbound::select()
            ->leftJoin('users', 'users.id', 'outbounds.user_id')
            ->leftJoin('master_wilayah_kabupaten', 'master_wilayah_kabupaten.id', 'outbounds.kabupaten_id')
            ->leftJoin('master_wilayah_provinsi', 'master_wilayah_provinsi.id', 'master_wilayah_kabupaten.provinsi_id')
            ->leftJoin('master_outbound_status', 'master_outbound_status.id', 'outbounds.status_id')
            ->when($user, function ($query) use ($user) {
                $admin = [1, 2];
                $isAdmin = in_array($user->role_id, $admin);
                if (!$isAdmin) {
                    $query->where('outbounds.user_id', $user->id);
                }
            })
            ->when($request, function ($query) use ($request) {
                $search = $request->search['value'];
                if (isset($search)) {
                    // TODO
                }
                $filter = $request->filter;
                if (is_array($filter)) {
                    if (array_key_exists('platform_id', $filter)) $query->where('outbounds.platform_id', $filter['platform_id']);
                    if (array_key_exists('user_id', $filter)) $query->where('outbounds.user_id', $filter['user_id']);
                    if (array_key_exists('start_date', $filter) && array_key_exists('end_date', $filter)) $query->whereBetween(DB::raw("date_format(outbounds.created_at, '%Y-%m-%d')"), [$filter['start_date'], $filter['end_date']]);
                }
            })
            ->count();

            Activity::onAct($request, 'Get Outbound DataTable');

            return response()->json([
                'status' => true,
                'message' => 'OK',
                'data' => $data,
                'draw' => $request->draw,
                'recordsTotal' => $recordsTotal,
                'recordsFiltered' => $recordsFiltered,
            ], 200);

        } catch (\Exception $e) {

            CustomException::onError($e);

            return response()->json([
                'status' => false,
                'message' => 'Maaf! Terjadi kesalahan pada sistem...',
                'error' => $e->getMessage(),
            ], 500);

        }

    }

    public function updateShipment(Request $request, $outboundId)
    {

        try {

            DB::beginTransaction();

            $outbound = Outbound::where('id', $outboundId)->first();

            $courier = DB::table('couriers')->where('code', $request->courier_code)->first();
            $courierService = DB::table('courier_service')->where('service_code', $request->courier_service_code)->first();

            $dataOutbound = [
                'courier' => "{$courier->id}-{$courierService->id}"
            ];

            $outbound->update($dataOutbound);

            $whereOutboundShipment = [
                'outbound_id' => $outboundId,
            ];

            $dataOutboundShipment = [
                'courier_code' => $courier->code,
                'courier_name' => $courier->name,
                'courier_service_code' => $courierService->service_code,
                'courier_service_name' => $courierService->service_name,
                'shipment_price' => $request->shipment_price,
            ];

            $outboundShipment = OutboundShipment::updateOrCreate($whereOutboundShipment, $dataOutboundShipment);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'OK',
            ], 200);

        } catch (\Exception $e) {

            DB::rollBack();

            CustomException::onError($e);

            return response()->json([
                'status' => false,
                'message' => 'Maaf! Terjadi kesalahan pada sistem...',
                'error' => $e->getMessage(),
            ], 500);

        }

    }

}
