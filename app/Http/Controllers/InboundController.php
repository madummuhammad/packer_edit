<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Inbound;
use App\Models\InboundItem;
use App\Models\Inventory;

use App\Helper\Activity;
use App\Helper\CustomException;

use DB;
use Exception;
use Hash;
use Validator;

class InboundController extends Controller
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

            $data = Inbound::select(
                'inbounds.id',
                'inbounds.user_id',
                'users.fullname as user_name',
                'inbounds.warehouse_id',
                'warehouses.name as warehouse_name',
                'warehouses.kabupaten_id',
                'master_wilayah_kabupaten.name as kabupaten_name',
                'master_wilayah_kabupaten.provinsi_id',
                'master_wilayah_provinsi.name as provinsi_name',
                'inbounds.status_id',
                'master_inbound_status.value as status_name',
                'inbounds.created_at',
                'inbounds.updated_at',
            )
            ->leftJoin('users', 'users.id', 'inbounds.user_id')
            ->leftJoin('warehouses', 'warehouses.id', 'inbounds.warehouse_id')
            ->leftJoin('master_wilayah_kabupaten', 'master_wilayah_kabupaten.id', 'warehouses.kabupaten_id')
            ->leftJoin('master_wilayah_provinsi', 'master_wilayah_provinsi.id', 'master_wilayah_kabupaten.provinsi_id')
            ->leftJoin('master_inbound_status', 'master_inbound_status.id', 'inbounds.status_id')
            ->get();

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
            'warehouse_id' => 'required|exists:warehouses,id',
            'status_id' => 'filled|exists:master_inbound_status,id',
            'items' => 'required|array',
            'items.*.product_id' => 'filled|exists:products,id',
            'items.*.qty' => 'filled|integer',
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

            $inbound = Inbound::create($data);

            $items = $request->items;

            foreach ($items as $d) {

                $data = [
                    'inbound_id' => $inbound->id,
                    'product_id' => $d['product_id'],
                    'qty' => $d['qty'],
                ];

                $inboundItem = InboundItem::create($data);

            }

            DB::commit();

            Activity::onAct($request, 'Create Inbound');

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

            $data = Inbound::select(
                'inbounds.id',
                'inbounds.user_id',
                'users.fullname as user_name',
                'inbounds.warehouse_id',
                'warehouses.name as warehouse_name',
                'warehouses.kabupaten_id',
                'master_wilayah_kabupaten.name as kabupaten_name',
                'master_wilayah_kabupaten.provinsi_id',
                'master_wilayah_provinsi.name as provinsi_name',
                'inbounds.status_id',
                'master_inbound_status.value as status_name',
                'inbounds.created_at',
                'inbounds.updated_at',
            )
            ->leftJoin('users', 'users.id', 'inbounds.user_id')
            ->leftJoin('warehouses', 'warehouses.id', 'inbounds.warehouse_id')
            ->leftJoin('master_wilayah_kabupaten', 'master_wilayah_kabupaten.id', 'warehouses.kabupaten_id')
            ->leftJoin('master_wilayah_provinsi', 'master_wilayah_provinsi.id', 'master_wilayah_kabupaten.provinsi_id')
            ->leftJoin('master_inbound_status', 'master_inbound_status.id', 'inbounds.status_id')
            ->where('inbounds.id', $id)
            ->first();

            if (is_null($data)) {

                return response()->json([
                    'status' => false,
                    'message' => 'Inbound tidak ditemukan...',
                ], 404);

            }

            $data->items = InboundItem::leftJoin('products', 'products.id', 'inbound_item.product_id')->where('inbound_id', $data->id)->get();

            Activity::onAct($request, 'Show Inbound');

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
            'warehouse_id' => 'filled|exists:warehouses,id',
            'status_id' => 'filled|exists:master_inbound_status,id',
            'items' => 'filled|array',
            'items.*.product_id' => 'filled|exists:products,id',
            'items.*.qty' => 'filled|integer',
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

            $inbound = Inbound::where('id', $id)->first();

            if (is_null($inbound)) {

                return response()->json([
                    'status' => false,
                    'message' => 'Inbound tidak ditemukan...',
                ], 404);

            }

            $data = $request->except('items');

            $inbound->update($data);

            if ($request->status_id == 4) {

                $inboundItems = InboundItem::where('inbound_id', $inbound->id)->get();

                foreach ($inboundItems as $i) {

                    $where = [
                        'product_id' => $i->product_id,
                        'warehouse_id' => $inbound->warehouse_id,
                    ];

                    $inventory = Inventory::where($where)->first();

                    if (is_null($inventory)) {

                        $data = [
                            'product_id' => $i->product_id,
                            'warehouse_id' => $inbound->warehouse_id,
                            'stock' => $i->qty,
                        ];

                        $inventory = Inventory::create($data);

                    } else {

                        $data = [
                            'stock' => $inventory->stock + $i->qty,
                        ];
    
                        $inventory->update($data);

                    }

                }

            }

            DB::commit();

            Activity::onAct($request, 'Update Inbound');

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

            $inbound = Inbound::where('id', $id)->first();

            if (is_null($inbound)) {

                return response()->json([
                    'status' => false,
                    'message' => 'Inbound tidak ditemukan...',
                ], 404);

            }

            $inbound->delete();

            DB::commit();

            Activity::onAct($request, 'Delete Inbound');

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

        try {

            $columns = ['id', 'id', 'user_name', 'warehouse_name', 'provinsi_name', 'kabupaten_name', 'status_name', 'created_at', 'updated_at'];

            $column = $columns[$request->input('order.0.column')];
            $dir   = $request->input('order.0.dir');

            $data = Inbound::select(
                'inbounds.id',
                'inbounds.user_id',
                'users.fullname as user_name',
                'inbounds.warehouse_id',
                'warehouses.name as warehouse_name',
                'warehouses.kabupaten_id',
                'master_wilayah_kabupaten.name as kabupaten_name',
                'master_wilayah_kabupaten.provinsi_id',
                'master_wilayah_provinsi.name as provinsi_name',
                'inbounds.status_id',
                'master_inbound_status.value as status_name',
                'inbounds.created_at',
                'inbounds.updated_at',
            )
            ->leftJoin('users', 'users.id', 'inbounds.user_id')
            ->leftJoin('warehouses', 'warehouses.id', 'inbounds.warehouse_id')
            ->leftJoin('master_wilayah_kabupaten', 'master_wilayah_kabupaten.id', 'warehouses.kabupaten_id')
            ->leftJoin('master_wilayah_provinsi', 'master_wilayah_provinsi.id', 'master_wilayah_kabupaten.provinsi_id')
            ->leftJoin('master_inbound_status', 'master_inbound_status.id', 'inbounds.status_id')
            ->when($user, function ($query) use ($user) {
                $admin = [1, 2];
                $isAdmin = in_array($user->role_id, $admin);
                if (!$isAdmin) {
                    $query->where('inbounds.user_id', $user->id);
                }
            })
            ->when($request, function ($query) use ($request) {
                $search = $request->search['value'];
                if (isset($search)) {
                    // TODO
                }
                $filter = $request->filter;
                if (is_array($filter)) {
                    if (array_key_exists('user_id', $filter)) $query->where('inbounds.user_id', $filter['user_id']);
                    if (array_key_exists('start_date', $filter) && array_key_exists('end_date', $filter)) $query->whereBetween(DB::raw("date_format(inbounds.created_at, '%Y-%m-%d')"), [$filter['start_date'], $filter['end_date']]);
                }
            })
            ->orderBy($column, $dir)
            ->skip($request->start)
            ->take($request->length)
            ->get();

            $recordsTotal = Inbound::count();
            $recordsFiltered = Inbound::select()
            ->leftJoin('users', 'users.id', 'inbounds.user_id')
            ->leftJoin('warehouses', 'warehouses.id', 'inbounds.warehouse_id')
            ->leftJoin('master_wilayah_kabupaten', 'master_wilayah_kabupaten.id', 'warehouses.kabupaten_id')
            ->leftJoin('master_wilayah_provinsi', 'master_wilayah_provinsi.id', 'master_wilayah_kabupaten.provinsi_id')
            ->leftJoin('master_inbound_status', 'master_inbound_status.id', 'inbounds.status_id')
            ->when($user, function ($query) use ($user) {
                $admin = [1, 2];
                $isAdmin = in_array($user->role_id, $admin);
                if (!$isAdmin) {
                    $query->where('inbounds.user_id', $user->id);
                }
            })
            ->when($request, function ($query) use ($request) {
                $search = $request->search['value'];
                if (isset($search)) {
                    // TODO
                }
                $filter = $request->filter;
                if (is_array($filter)) {
                    if (array_key_exists('user_id', $filter)) $query->where('inbounds.user_id', $filter['user_id']);
                    if (array_key_exists('start_date', $filter) && array_key_exists('end_date', $filter)) $query->whereBetween(DB::raw("date_format(inbounds.created_at, '%Y-%m-%d')"), [$filter['start_date'], $filter['end_date']]);
                }
            })
            ->count();

            Activity::onAct($request, 'Get Inbound DataTable');

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

}
