<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\UserLog;

use App\Helper\Activity;
use App\Helper\CustomException;

use DB;
use Validator;

class UserLogController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            'activity' => 'required|string|min:5|max:255',
        ]);

        if ($validator->fails()) {

            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
                'error' => $validator->errors(),
            ], 400);

        }
        
        try {

            $data = $request->all();

            Activity::onAct($request, $request->activity);

            return response()->json([
                'status' => true,
                'message' => 'Berhasil melakukan perubahan!',
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
     * Truncate resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function truncate(Request $request)
    {

        try {

            DB::beginTransaction();

            UserLog::truncate();

            DB::commit();

            Activity::onAct($request, 'Truncate User Log');

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

            $columns = ['id', 'fullname', 'user_activity', 'user_ip', 'user_platform', 'user_browser', 'created_at'];

            $column = $columns[$request->input('order.0.column')];
            $dir   = $request->input('order.0.dir');

            $data = UserLog::select(
                'user_log.id',
                'users.fullname',
                'user_log.user_activity',
                'user_log.user_ip',
                'user_log.user_platform',
                'user_log.user_browser',
                'user_log.user_geolocation',
                'user_log.created_at',
            )
            ->leftJoin('users', 'users.id', 'user_log.user_id')
            ->when($request, function ($query) use ($request, $user) {
                if ($user->user_role != 1) {
                    $query->where('user_log.user_id', $user->id);
                }
                $search = $request->search['value'];
                if (isset($search)) {
                    $query->where('users.fullname', 'like', "%{$search}%")
                        ->orWhere('users_log.user_activity', 'like', "%{$search}%");
                }
            })
            ->orderBy($column, $dir)
            ->skip($request->start)
            ->take($request->length)
            ->get();

            $recordsTotal = UserLog::count();
            $recordsFiltered = UserLog::select('user_log.id')
            ->leftJoin('users', 'users.id', 'user_log.user_id')
            ->when($request, function ($query) use ($request, $user) {
                if ($user->user_role != 1) {
                    $query->where('user_log.user_id', $user->id);
                }
                $search = $request->search['value'];
                if (isset($search)) {
                    $query->where('users.fullname', 'like', "%{$search}%")
                        ->orWhere('users_log.user_activity', 'like', "%{$search}%");
                }
            })
            ->count();

            Activity::onAct($request, 'Get User Log DataTable');

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
