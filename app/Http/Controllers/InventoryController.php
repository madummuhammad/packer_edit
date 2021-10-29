<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Inventory;

use App\Helper\Activity;
use App\Helper\CustomException;

use DB;
use Exception;
use Hash;
use Validator;

class InventoryController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        try {

            $data = Inventory::select(
                'inventories.id',
                'products.user_id',
                'users.fullname as user_name',
                'inventories.warehouse_id',
                'warehouses.name as warehouse_name',
                'inventories.product_id',
                'products.name as product_name',
                'products.sku',
                'inventories.stock',
                DB::raw('coalesce((select sum(qty) from inbound_item left join inbounds on inbounds.id = inbound_item.inbound_id where product_id = inventories.product_id and inbounds.status_id = 2), 0) as incoming_stock'),
                DB::raw('coalesce((select sum(qty) from inbound_item left join inbounds on inbounds.id = inbound_item.inbound_id where product_id = inventories.product_id and inbounds.status_id = 3), 0) as pending_stock'),
                DB::raw('
                    (
                        coalesce((select sum(qty) from inbound_item left join inbounds on inbounds.id = inbound_item.inbound_id where product_id = inventories.product_id and inbounds.status_id = 2), 0) + 
                        coalesce((select sum(qty) from inbound_item left join inbounds on inbounds.id = inbound_item.inbound_id where product_id = inventories.product_id and inbounds.status_id = 3), 0) + 
                        inventories.stock
                    ) as total_stock
                '),
                'inventories.created_at',
                'inventories.updated_at',
            )
            ->leftJoin('products', 'products.id', 'inventories.product_id')
            ->leftJoin('users', 'users.id', 'products.user_id')
            ->leftJoin('warehouses', 'warehouses.id', 'inventories.warehouse_id')
            ->when($request, function ($query) use ($request) {
                if ($request->has('warehouse_id')) $query->where('inventories.warehouse_id', $request->warehouse_id);
                if ($request->has('user_id')) $query->where('products.user_id', $request->user_id);
            })
            ->get();

            Activity::onAct($request, 'Get Inventory');

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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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

            $columns = ['id', 'id', 'user_name', 'warehouse_name', 'product_name', 'sku', 'stock', 'incoming_stock', 'pending_stock', 'total_stock', 'created_at', 'updated_at'];

            $column = $columns[$request->input('order.0.column')];
            $dir   = $request->input('order.0.dir');

            $data = Inventory::select(
                'inventories.id',
                'products.user_id',
                'users.fullname as user_name',
                'inventories.warehouse_id',
                'warehouses.name as warehouse_name',
                'inventories.product_id',
                'products.name as product_name',
                'products.sku',
                'inventories.stock',
                DB::raw('coalesce((select sum(qty) from inbound_item left join inbounds on inbounds.id = inbound_item.inbound_id where product_id = inventories.product_id and inbounds.status_id = 2), 0) as incoming_stock'),
                DB::raw('coalesce((select sum(qty) from inbound_item left join inbounds on inbounds.id = inbound_item.inbound_id where product_id = inventories.product_id and inbounds.status_id = 3), 0) as pending_stock'),
                DB::raw('
                    (
                        coalesce((select sum(qty) from inbound_item left join inbounds on inbounds.id = inbound_item.inbound_id where product_id = inventories.product_id and inbounds.status_id = 2), 0) + 
                        coalesce((select sum(qty) from inbound_item left join inbounds on inbounds.id = inbound_item.inbound_id where product_id = inventories.product_id and inbounds.status_id = 3), 0) + 
                        inventories.stock
                    ) as total_stock
                '),
                'inventories.created_at',
                'inventories.updated_at',
            )
            ->leftJoin('products', 'products.id', 'inventories.product_id')
            ->leftJoin('users', 'users.id', 'products.user_id')
            ->leftJoin('warehouses', 'warehouses.id', 'inventories.warehouse_id')
            ->when($user, function ($query) use ($user) {
                $admin = [1, 2];
                $isAdmin = in_array($user->role_id, $admin);
                if (!$isAdmin) {
                    $query->where('users.id', $user->id);
                }
            })
            ->when($request, function ($query) use ($request) {
                $search = $request->search['value'];
                if (isset($search)) {
                    // TODO
                }
            })
            ->orderBy($column, $dir)
            ->skip($request->start)
            ->take($request->length)
            ->get();

            $recordsTotal = Inventory::count();
            $recordsFiltered = Inventory::select()
            ->leftJoin('products', 'products.id', 'inventories.product_id')
            ->leftJoin('users', 'users.id', 'products.user_id')
            ->leftJoin('warehouses', 'warehouses.id', 'inventories.warehouse_id')
            ->when($user, function ($query) use ($user) {
                $admin = [1, 2];
                $isAdmin = in_array($user->role_id, $admin);
                if (!$isAdmin) {
                    $query->where('users.id', $user->id);
                }
            })
            ->when($request, function ($query) use ($request) {
                $search = $request->search['value'];
                if (isset($search)) {
                    // TODO
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
