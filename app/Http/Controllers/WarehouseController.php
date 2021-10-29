<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Warehouse;

use App\Helper\Activity;
use App\Helper\CustomException;

use DB;
use Exception;
use Hash;
use Validator;

class WarehouseController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $user = User::where('api_token', $request->bearerToken())->first();        
        
        try {

            $data = Warehouse::select(
                'warehouses.id',
                'warehouses.partner_id',
                DB::raw('if(warehouses.partner_id = 0, "Packer", (select fullname from users where id = warehouses.partner_id)) as partner_name'),
                'warehouses.name',
                'warehouses.description',
                'warehouses.kabupaten_id',
                'master_wilayah_kabupaten.name as kabupaten_name',
                'master_wilayah_kabupaten.provinsi_id',
                'master_wilayah_provinsi.name as provinsi_name',
                'warehouses.created_at',
                'warehouses.updated_at',
            )
            ->leftJoin('master_wilayah_kabupaten', 'master_wilayah_kabupaten.id', 'warehouses.kabupaten_id')
            ->leftJoin('master_wilayah_provinsi', 'master_wilayah_provinsi.id', 'master_wilayah_kabupaten.provinsi_id')
            ->when($user, function ($query) use ($user) {
                if ($user->role_id == 4) $query->where('warehouses.partner_id', $user->id);
            })
            ->get();

            Activity::onAct($request, 'Get Warehouse');

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
            'name' => 'required|string|min:5|max:255',
            'description' => 'nullable|string|min:5|max:255',
            'kabupaten_id' => 'required|exists:master_wilayah_kabupaten,id',
        ]);

        if ($validator->fails()) {

            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
                'error' => $validator->errors(),
            ], 400);

        }

        $user = User::where('api_token', $request->bearerToken())->first();
        
        try {

            DB::beginTransaction();

            $data = $request->all();

            if ($user->role_id == 4) $data['partner_id'] = $user->id;

            Warehouse::create($data);

            DB::commit();

            Activity::onAct($request, 'Create Warehouse');

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

            $data = Warehouse::select(
                'warehouses.id',
                'warehouses.partner_id',
                DB::raw('if(warehouses.partner_id = 0, "Packer", (select fullname from users where id = warehouses.partner_id)) as partner_name'),
                'warehouses.name',
                'warehouses.description',
                'warehouses.kabupaten_id',
                'master_wilayah_kabupaten.name as kabupaten_name',
                'master_wilayah_kabupaten.provinsi_id',
                'master_wilayah_provinsi.name as provinsi_name',
                'warehouses.created_at',
                'warehouses.updated_at',
            )
            ->leftJoin('master_wilayah_kabupaten', 'master_wilayah_kabupaten.id', 'warehouses.kabupaten_id')
            ->leftJoin('master_wilayah_provinsi', 'master_wilayah_provinsi.id', 'master_wilayah_kabupaten.provinsi_id')
            ->where('warehouses.id', $id)
            ->first();

            if (is_null($data)) {

                return response()->json([
                    'status' => false,
                    'message' => 'Warehouse tidak ditemukan...',
                ], 404);

            }

            Activity::onAct($request, 'Show Warehouse');

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
            'name' => 'nullable|string|min:5|max:255',
            'description' => 'nullable|string|min:5|max:255',
            'kabupaten_id' => 'nullable|exists:master_wilayah_kabupaten,id',
        ]);

        if ($validator->fails()) {

            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
                'error' => $validator->errors(),
            ], 400);

        }

        $user = User::where('api_token', $request->bearerToken())->first();
        
        try {

            DB::beginTransaction();

            $warehouse = Warehouse::where('id', $id)->first();

            if (is_null($warehouse)) {

                return response()->json([
                    'status' => false,
                    'message' => 'Warehouse tidak ditemukan...',
                ], 404);

            }

            $data = $request->all();

            if ($user->role_id == 4) $data['partner_id'] = $user->id;

            $warehouse->update($data);

            DB::commit();

            Activity::onAct($request, 'Update Warehouse');

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

            $user = User::where('id', $id)->first();

            if (is_null($user)) {

                return response()->json([
                    'status' => false,
                    'message' => 'User tidak ditemukan...',
                ], 404);

            }

            $user->delete();

            DB::commit();

            Activity::onAct($request, 'Delete User');

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

            $columns = ['id', 'id', 'partner_name', 'name', 'description', 'provinsi_name', 'kabupaten_name', 'created_at', 'updated_at'];

            $column = $columns[$request->input('order.0.column')];
            $dir   = $request->input('order.0.dir');

            $data = Warehouse::select(
                'warehouses.id',
                'warehouses.partner_id',
                DB::raw('if(warehouses.partner_id = 0, "Packer", (select fullname from users where id = warehouses.partner_id)) as partner_name'),
                'warehouses.name',
                'warehouses.description',
                'warehouses.kabupaten_id',
                'master_wilayah_kabupaten.name as kabupaten_name',
                'master_wilayah_kabupaten.provinsi_id',
                'master_wilayah_provinsi.name as provinsi_name',
                'warehouses.created_at',
                'warehouses.updated_at',
            )
            ->leftJoin('master_wilayah_kabupaten', 'master_wilayah_kabupaten.id', 'warehouses.kabupaten_id')
            ->leftJoin('master_wilayah_provinsi', 'master_wilayah_provinsi.id', 'master_wilayah_kabupaten.provinsi_id')
            ->when($user, function ($query) use ($user) {
                if ($user->role_id == 4) $query->where('warehouses.partner_id', $user->id);
            })
            ->when($request, function ($query) use ($request) {
                $search = $request->search['value'];
                if (isset($search)) {
                    $query->where('warehouses.name', 'like', "%{$search}%");
                }
            })
            ->orderBy($column, $dir)
            ->skip($request->start)
            ->take($request->length)
            ->get();

            $recordsTotal = Warehouse::count();
            $recordsFiltered = Warehouse::select()
            ->leftJoin('master_wilayah_kabupaten', 'master_wilayah_kabupaten.id', 'warehouses.kabupaten_id')
            ->leftJoin('master_wilayah_provinsi', 'master_wilayah_provinsi.id', 'master_wilayah_kabupaten.provinsi_id')
            ->when($user, function ($query) use ($user) {
                if ($user->role_id == 4) $query->where('warehouses.partner_id', $user->id);
            })
            ->when($request, function ($query) use ($request) {
                $search = $request->search['value'];
                if (isset($search)) {
                    $query->where('warehouses.name', 'like', "%{$search}%");
                }
            })
            ->count();

            Activity::onAct($request, 'Get Warehouse DataTable');

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
