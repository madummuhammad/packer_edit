<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Addon;
use App\Models\AddonPrice;
use App\Models\User;

use App\Helper\Activity;
use App\Helper\CustomException;

use DB;
use Exception;
use Hash;
use Validator;

class AddonController extends Controller
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

            $data = Addon::select(
                'addons.id',
                'addons.name',
                'addons.price',
                DB::raw("(select price from addon_price where addon_id = addons.id and user_id = '{$user->id}' limit 1) as custom_price"),
                'addons.created_at',
                'addons.updated_at',
            )
            ->get();

            Activity::onAct($request, 'Get Addon');

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
            'price' => 'required|integer',
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

            $addon = Addon::create($data);

            $items = $request->items;

            foreach ($items as $d) {

                $where = [
                    'addon_id' => $addon->id,
                    'user_id' => $d['user_id'],
                ];

                $data = [
                    'price' => $d['price'],
                ];

                $addonPrice = AddonPrice::updateOrCreate($where, $data);

            }

            DB::commit();

            Activity::onAct($request, 'Create Addon');

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

            $data = Addon::select(
                'addons.id',
                'addons.name',
                'addons.price',
                DB::raw("(select price from addon_price where addon_id = addons.id and user_id = '{$user->id}' limit 1) as custom_price"),
                'addons.created_at',
                'addons.updated_at',
            )
            ->where('addons.id', $id)
            ->first();

            if (is_null($data)) {

                return response()->json([
                    'status' => false,
                    'message' => 'Addon tidak ditemukan...',
                ], 404);

            }

            $data->items = AddonPrice::where('addon_id', $data->id)->get();

            Activity::onAct($request, 'Show Addon');

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
            'name' => 'filled|string|min:5|max:255',
            'price' => 'filled|integer',
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

            $addon = Addon::where('id', $id)->first();

            if (is_null($addon)) {

                return response()->json([
                    'status' => false,
                    'message' => 'Addon tidak ditemukan...',
                ], 404);

            }

            $data = $request->except('items');

            if ($user->role_id == 4) $data['partner_id'] = $user->id;

            $addon->update($data);

            $items = $request->items;

            foreach ($items as $d) {

                $where = [
                    'addon_id' => $addon->id,
                    'user_id' => $d['user_id'],
                ];

                $data = [
                    'price' => $d['price'],
                ];

                $addonPrice = AddonPrice::updateOrCreate($where, $data);

            }

            DB::commit();

            Activity::onAct($request, 'Update Addon');

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

            $addon = Addon::where('id', $id)->first();

            if (is_null($addon)) {

                return response()->json([
                    'status' => false,
                    'message' => 'Addon tidak ditemukan...',
                ], 404);

            }

            $addon->delete();

            DB::commit();

            Activity::onAct($request, 'Delete Addon');

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

            $columns = ['id', 'id', 'name', 'price', 'created_at', 'updated_at'];

            $column = $columns[$request->input('order.0.column')];
            $dir   = $request->input('order.0.dir');

            $data = Addon::select(
                'addons.id',
                'addons.name',
                'addons.price',
                DB::raw("(select price from addon_price where addon_id = addons.id and user_id = '{$user->id}' limit 1) as custom_price"),
                'addons.created_at',
                'addons.updated_at',
            )
            ->when($user, function ($query) use ($user) {
                if ($user->role_id == 4) $query->where('addons.partner_id', $user->id);
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

            $recordsTotal = Addon::count();
            $recordsFiltered = Addon::select()
            ->when($user, function ($query) use ($user) {
                if ($user->role_id == 4) $query->where('addons.partner_id', $user->id);
            })
            ->when($request, function ($query) use ($request) {
                $search = $request->search['value'];
                if (isset($search)) {
                    // TODO
                }
            })
            ->count();

            Activity::onAct($request, 'Get Addon DataTable');

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
