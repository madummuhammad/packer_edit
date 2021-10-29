<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Integration;

use App\Helper\Activity;
use App\Helper\CustomException;

use DB;
use Exception;
use Hash;
use Validator;

class IntegrationController extends Controller
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

            $data = Integration::select(
                'integrations.id',
                'integrations.user_id',
                'users.fullname as user_name',
                'integrations.platform_id',
                'master_platform.value as platform_name',
                'integrations.identifier',
                'integrations.created_at',
                'integrations.updated_at',
            )
            ->leftJoin('users', 'users.id', 'integrations.user_id')
            ->leftJoin('master_platform', 'master_platform.id', 'integrations.platform_id')
            ->get();

            Activity::onAct($request, 'Get Integration');

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

            $data = Integration::select(
                'integrations.id',
                'integrations.user_id',
                'users.fullname as user_name',
                'integrations.platform_id',
                'master_platform.value as platform_name',
                'integrations.identifier',
                'integrations.created_at',
                'integrations.updated_at',
            )
            ->leftJoin('users', 'users.id', 'integrations.user_id')
            ->leftJoin('master_platform', 'master_platform.id', 'integrations.platform_id')
            ->where('integrations.id', $id)
            ->first();

            if (is_null($data)) {

                return response()->json([
                    'status' => false,
                    'message' => 'Integration tidak ditemukan...',
                ], 404);

            }

            Activity::onAct($request, 'Show Integration');

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
        // 
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

            $integration = Integration::where('id', $id)->first();

            if (is_null($integration)) {

                return response()->json([
                    'status' => false,
                    'message' => 'Integration tidak ditemukan...',
                ], 404);

            }

            $integration->delete();

            DB::commit();

            Activity::onAct($request, 'Delete Integration');

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

            $columns = ['id', 'id', 'user_name', 'platform_name', 'key', 'created_at', 'updated_at'];

            $column = $columns[$request->input('order.0.column')];
            $dir   = $request->input('order.0.dir');

            $data = Integration::select(
                'integrations.id',
                'integrations.user_id',
                'users.fullname as user_name',
                'integrations.platform_id',
                'master_platform.value as platform_name',
                'integrations.key',
                'integrations.created_at',
                'integrations.updated_at',
            )
            ->leftJoin('users', 'users.id', 'integrations.user_id')
            ->leftJoin('master_platform', 'master_platform.id', 'integrations.platform_id')
            ->when($user, function ($query) use ($user) {
                $admin = [1, 2];
                $isAdmin = in_array($user->role_id, $admin);
                if (!$isAdmin) {
                    $query->where('integrations.user_id', $user->id);
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

            $recordsTotal = Integration::count();
            $recordsFiltered = Integration::select()
            ->leftJoin('users', 'users.id', 'integrations.user_id')
            ->leftJoin('master_platform', 'master_platform.id', 'integrations.platform_id')
            ->when($user, function ($query) use ($user) {
                $admin = [1, 2];
                $isAdmin = in_array($user->role_id, $admin);
                if (!$isAdmin) {
                    $query->where('integrations.user_id', $user->id);
                }
            })
            ->when($request, function ($query) use ($request) {
                $search = $request->search['value'];
                if (isset($search)) {
                    // TODO
                }
            })
            ->count();

            Activity::onAct($request, 'Get Integrations DataTable');

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
