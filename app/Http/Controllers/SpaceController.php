<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Space;
use App\Models\SpacePrice;

use App\Helper\Activity;
use App\Helper\CustomException;

use DB;
use Exception;
use Hash;
use Validator;

class SpaceController extends Controller
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

            $data = Space::select(
                'spaces.id',
                'spaces.partner_id',
                DB::raw('if(spaces.partner_id = 0, "Packer", (select fullname from users where id = spaces.partner_id)) as partner_name'),
                'spaces.warehouse_id',
                'warehouses.name as warehouse_name',
                'warehouses.description as warehouse_description',
                'warehouses.kabupaten_id',
                'master_wilayah_kabupaten.name as kabupaten_name',
                'master_wilayah_kabupaten.provinsi_id',
                'master_wilayah_provinsi.name as provinsi_name',
                'spaces.space_type_id',
                'master_space_type.value as space_type_name',
                'spaces.size',
                'spaces.stock',
                'spaces.price',
                DB::raw("(select price from space_price where space_id = spaces.id and user_id = '{$user->id}' limit 1) as custom_price"),
                'spaces.created_at',
                'spaces.updated_at',
            )
            ->leftJoin('warehouses', 'warehouses.id', 'spaces.warehouse_id')
            ->leftJoin('master_wilayah_kabupaten', 'master_wilayah_kabupaten.id', 'warehouses.kabupaten_id')
            ->leftJoin('master_wilayah_provinsi', 'master_wilayah_provinsi.id', 'master_wilayah_kabupaten.provinsi_id')
            ->leftJoin('master_space_type', 'master_space_type.id', 'spaces.space_type_id')
            ->get();

            Activity::onAct($request, 'Get Space');

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
            'warehouse_id' => 'required|exists:warehouses,id',
            'space_type_id' => 'required|exists:master_space_type,id',
            'size' => 'required|string|min:5|max:255',
            'stock' => 'required|integer',
            'price' => 'required|integer',
            'items' => 'array',
            'items.*.user_id' => 'required|exists:users,id',
            'items.*.price' => 'required|integer',
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

            $data = $request->except('items');

            if ($user->role_id == 4) $data['partner_id'] = $user->id;

            $space = Space::create($data);

            $items = $request->items;

            foreach ($items as $d) {

                $where = [
                    'space_id' => $space->id,
                    'user_id' => $d['user_id'],
                ];

                $data = [
                    'price' => $d['price'],
                ];

                $spacePrice = SpacePrice::updateOrCreate($where, $data);

            }

            DB::commit();

            Activity::onAct($request, 'Create Space');

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

        $user = User::where('api_token', $request->bearerToken())->first();
        
        try {

            $data = Space::select(
                'spaces.id',
                'spaces.partner_id',
                DB::raw('if(spaces.partner_id = 0, "Packer", (select fullname from users where id = spaces.partner_id)) as partner_name'),
                'spaces.warehouse_id',
                'warehouses.name as warehouse_name',
                'warehouses.description as warehouse_description',
                'warehouses.kabupaten_id',
                'master_wilayah_kabupaten.name as kabupaten_name',
                'master_wilayah_kabupaten.provinsi_id',
                'master_wilayah_provinsi.name as provinsi_name',
                'spaces.space_type_id',
                'master_space_type.value as space_type_name',
                'spaces.size',
                'spaces.stock',
                'spaces.price',
                DB::raw("(select price from space_price where space_id = spaces.id and user_id = '{$user->id}' limit 1) as custom_price"),
                'spaces.created_at',
                'spaces.updated_at',
            )
            ->leftJoin('warehouses', 'warehouses.id', 'spaces.warehouse_id')
            ->leftJoin('master_wilayah_kabupaten', 'master_wilayah_kabupaten.id', 'warehouses.kabupaten_id')
            ->leftJoin('master_wilayah_provinsi', 'master_wilayah_provinsi.id', 'master_wilayah_kabupaten.provinsi_id')
            ->leftJoin('master_space_type', 'master_space_type.id', 'spaces.space_type_id')
            ->where('spaces.id', $id)
            ->first();

            if (is_null($data)) {

                return response()->json([
                    'status' => false,
                    'message' => 'Space tidak ditemukan...',
                ], 404);

            }

            $data->items = SpacePrice::where('space_id', $data->id)->get();

            Activity::onAct($request, 'Show Space');

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
            'warehouse_id' => 'nullable|exists:warehouses,id',
            'space_type_id' => 'nullable|exists:master_space_type,id',
            'size' => 'nullable|string|min:5|max:255',
            'stock' => 'nullable|integer',
            'price' => 'nullable|integer',
            'items' => 'array',
            'items.*.user_id' => 'nullable|exists:users,id',
            'items.*.price' => 'nullable|integer',
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

            $space = Space::where('id', $id)->first();

            if (is_null($space)) {

                return response()->json([
                    'status' => false,
                    'message' => 'Space tidak ditemukan...',
                ], 404);

            }

            $data = $request->except('items');

            if ($user->role_id == 4) $data['partner_id'] = $user->id;

            $space->update($data);

            $items = $request->items;

            foreach ($items as $d) {

                $where = [
                    'space_id' => $space->id,
                    'user_id' => $d['user_id'],
                ];

                $data = [
                    'price' => $d['price'],
                ];

                $spacePrice = SpacePrice::updateOrCreate($where, $data);

            }

            DB::commit();

            Activity::onAct($request, 'Update Space');

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

            $space = Space::where('id', $id)->first();

            if (is_null($space)) {

                return response()->json([
                    'status' => false,
                    'message' => 'Space tidak ditemukan...',
                ], 404);

            }

            $space->delete();

            DB::commit();

            Activity::onAct($request, 'Delete Space');

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

            $columns = ['id', 'id', 'warehouse_name', 'provinsi_name', 'kabupaten_name', 'space_type_name', 'size', 'stock', 'price', 'created_at', 'updated_at'];

            $column = $columns[$request->input('order.0.column')];
            $dir   = $request->input('order.0.dir');

            $data = Space::select(
                'spaces.id',
                'spaces.partner_id',
                DB::raw('if(spaces.partner_id = 0, "Packer", (select fullname from users where id = spaces.partner_id)) as partner_name'),
                'spaces.warehouse_id',
                'warehouses.name as warehouse_name',
                'warehouses.description as warehouse_description',
                'warehouses.kabupaten_id',
                'master_wilayah_kabupaten.name as kabupaten_name',
                'master_wilayah_kabupaten.provinsi_id',
                'master_wilayah_provinsi.name as provinsi_name',
                'spaces.space_type_id',
                'master_space_type.value as space_type_name',
                'spaces.size',
                'spaces.stock',
                'spaces.price',
                DB::raw("(select price from space_price where space_id = spaces.id and user_id = '{$user->id}' limit 1) as custom_price"),
                'spaces.created_at',
                'spaces.updated_at',
            )
            ->leftJoin('warehouses', 'warehouses.id', 'spaces.warehouse_id')
            ->leftJoin('master_wilayah_kabupaten', 'master_wilayah_kabupaten.id', 'warehouses.kabupaten_id')
            ->leftJoin('master_wilayah_provinsi', 'master_wilayah_provinsi.id', 'master_wilayah_kabupaten.provinsi_id')
            ->leftJoin('master_space_type', 'master_space_type.id', 'spaces.space_type_id')
            ->when($user, function ($query) use ($user) {
                if ($user->role_id == 4) $query->where('spaces.partner_id', $user->id);
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

            $recordsTotal = Space::count();
            $recordsFiltered = Space::select()
            ->leftJoin('warehouses', 'warehouses.id', 'spaces.warehouse_id')
            ->leftJoin('master_wilayah_kabupaten', 'master_wilayah_kabupaten.id', 'warehouses.kabupaten_id')
            ->leftJoin('master_wilayah_provinsi', 'master_wilayah_provinsi.id', 'master_wilayah_kabupaten.provinsi_id')
            ->leftJoin('master_space_type', 'master_space_type.id', 'spaces.space_type_id')
            ->when($user, function ($query) use ($user) {
                if ($user->role_id == 4) $query->where('spaces.partner_id', $user->id);
            })
            ->when($request, function ($query) use ($request) {
                $search = $request->search['value'];
                if (isset($search)) {
                    // TODO
                }
            })
            ->count();

            Activity::onAct($request, 'Get Space DataTable');

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
