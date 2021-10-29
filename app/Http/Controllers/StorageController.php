<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Storage as MyStorage;

use App\Helper\Activity;
use App\Helper\CustomException;

use DB;
use Exception;
use Hash;
use Validator;

class StorageController extends Controller
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

            $data = MyStorage::select(
                'storages.id',
                'storages.user_id',
                'users.fullname as user_name',
                'spaces.warehouse_id',
                'warehouses.name as warehouse_name',
                'warehouses.kabupaten_id',
                'master_wilayah_kabupaten.name as kabupaten_name',
                'master_wilayah_kabupaten.provinsi_id',
                'master_wilayah_provinsi.name as provinsi_name',
                'spaces.size',
                'storages.capacity_used',
                'storages.start_date',
                'storages.end_date',
                'storages.created_at',
                'storages.updated_at',
            )
            ->leftJoin('users', 'users.id', 'storages.user_id')
            ->leftJoin('spaces', 'spaces.id', 'storages.space_id')
            ->leftJoin('warehouses', 'warehouses.id', 'spaces.warehouse_id')
            ->leftJoin('master_wilayah_kabupaten', 'master_wilayah_kabupaten.id', 'warehouses.kabupaten_id')
            ->leftJoin('master_wilayah_provinsi', 'master_wilayah_provinsi.id', 'master_wilayah_kabupaten.provinsi_id')
            ->when($request, function ($query) use ($request) {
                if ($request->has('user_id')) $query->where('storages.user_id', $request->user_id);
            })
            ->get();

            Activity::onAct($request, 'Get Storage');

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
    public function show(Request $request, $id)
    {
        
        try {

            $data = MyStorage::select(
                'storages.id',
                'storages.user_id',
                'users.fullname as user_name',
                'spaces.warehouse_id',
                'warehouses.name as warehouse_name',
                'warehouses.kabupaten_id',
                'master_wilayah_kabupaten.name as kabupaten_name',
                'master_wilayah_kabupaten.provinsi_id',
                'master_wilayah_provinsi.name as provinsi_name',
                'spaces.size',
                'storages.capacity_used',
                'storages.start_date',
                'storages.end_date',
                'storages.created_at',
                'storages.updated_at',
            )
            ->leftJoin('users', 'users.id', 'storages.user_id')
            ->leftJoin('spaces', 'spaces.id', 'storages.space_id')
            ->leftJoin('warehouses', 'warehouses.id', 'spaces.warehouse_id')
            ->leftJoin('master_wilayah_kabupaten', 'master_wilayah_kabupaten.id', 'warehouses.kabupaten_id')
            ->leftJoin('master_wilayah_provinsi', 'master_wilayah_provinsi.id', 'master_wilayah_kabupaten.provinsi_id')
            ->where('storages.id', $id)
            ->first();

            if (is_null($data)) {

                return response()->json([
                    'status' => false,
                    'message' => 'Storage tidak ditemukan...',
                ], 404);

            }

            Activity::onAct($request, 'Show Storage');

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
            'space_id' => 'filled|exists:spaces,id',
            'capacity_used' => 'filled|integer|between:1,100',
            'start_date' => 'filled|date_format:Y-m-d',
            'end_date' => 'filled|date_format:Y-m-d',
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

            $storage = MyStorage::where('id', $id)->first();

            if (is_null($storage)) {

                return response()->json([
                    'status' => false,
                    'message' => 'Storage tidak ditemukan...',
                ], 404);

            }

            $data = $request->all();

            $storage->update($data);

            DB::commit();

            Activity::onAct($request, 'Update Storage');

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

            $columns = ['id', 'id', 'user_name', 'warehouse_name', 'provinsi_name', 'kabupaten_name', 'size', 'capacity_used', 'end_date', 'created_at', 'updated_at'];

            $column = $columns[$request->input('order.0.column')];
            $dir   = $request->input('order.0.dir');

            $data = MyStorage::select(
                'storages.id',
                'storages.user_id',
                'users.fullname as user_name',
                'spaces.warehouse_id',
                'warehouses.name as warehouse_name',
                'warehouses.kabupaten_id',
                'master_wilayah_kabupaten.name as kabupaten_name',
                'master_wilayah_kabupaten.provinsi_id',
                'master_wilayah_provinsi.name as provinsi_name',
                'spaces.size',
                'storages.capacity_used',
                'storages.start_date',
                'storages.end_date',
                'storages.created_at',
                'storages.updated_at',
            )
            ->leftJoin('users', 'users.id', 'storages.user_id')
            ->leftJoin('spaces', 'spaces.id', 'storages.space_id')
            ->leftJoin('warehouses', 'warehouses.id', 'spaces.warehouse_id')
            ->leftJoin('master_wilayah_kabupaten', 'master_wilayah_kabupaten.id', 'warehouses.kabupaten_id')
            ->leftJoin('master_wilayah_provinsi', 'master_wilayah_provinsi.id', 'master_wilayah_kabupaten.provinsi_id')
            ->when($user, function ($query) use ($user) {
                $admin = [1, 2];
                $isAdmin = in_array($user->role_id, $admin);
                if (!$isAdmin) {
                    $query->where('storages.user_id', $user->id);
                }
            })
            ->when($request, function ($query) use ($request) {
                $search = $request->search['value'];
                if (isset($search)) {
                    // TODO
                }
                $filter = $request->filter;
                if (!is_null($filter)) {
                    if (array_key_exists('user_id', $filter)) $query->where('storages.user_id', $filter['user_id']);
                    if (array_key_exists('start_date', $filter) && array_key_exists('end_date', $filter)) $query->whereBetween(DB::raw("date_format(storages.created_at, '%Y-%m-%d')"), [$filter['start_date'], $filter['end_date']]);
                }
            })
            ->orderBy($column, $dir)
            ->skip($request->start)
            ->take($request->length)
            ->get();

            $recordsTotal = MyStorage::count();
            $recordsFiltered = MyStorage::select()
            ->leftJoin('users', 'users.id', 'storages.user_id')
            ->leftJoin('spaces', 'spaces.id', 'storages.space_id')
            ->leftJoin('warehouses', 'warehouses.id', 'spaces.warehouse_id')
            ->leftJoin('master_wilayah_kabupaten', 'master_wilayah_kabupaten.id', 'warehouses.kabupaten_id')
            ->leftJoin('master_wilayah_provinsi', 'master_wilayah_provinsi.id', 'master_wilayah_kabupaten.provinsi_id')
            ->when($user, function ($query) use ($user) {
                $admin = [1, 2];
                $isAdmin = in_array($user->role_id, $admin);
                if (!$isAdmin) {
                    $query->where('storages.user_id', $user->id);
                }
            })
            ->when($request, function ($query) use ($request) {
                $search = $request->search['value'];
                if (isset($search)) {
                    // TODO
                }
                $filter = $request->filter;
                if (!is_null($filter)) {
                    if (array_key_exists('user_id', $filter)) $query->where('storages.user_id', $filter['user_id']);
                    if (array_key_exists('start_date', $filter) && array_key_exists('end_date', $filter)) $query->whereBetween(DB::raw("date_format(storages.created_at, '%Y-%m-%d')"), [$filter['start_date'], $filter['end_date']]);
                }
            })
            ->count();

            Activity::onAct($request, 'Get Storage DataTable');

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
