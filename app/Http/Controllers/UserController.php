<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\UserProfile;

use App\Helper\Activity;
use App\Helper\CustomException;
use App\Helper\Packer;

use Crypt;
use DB;
use Exception;
use Hash;
use Validator;

class UserController extends Controller
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

            $data = User::select(
                'users.id',
                'users.username',
                'users.fullname',
                'users.email',
                'users.role_id',
                'master_user_role.value as role_name',
                'users.status_id',
                'master_user_status.value as status_name',
                'users.api_token',
                'user_profile.phone',
                'user_profile.kabupaten_id',
                'master_wilayah_kabupaten.name as kabupaten_name',
                'master_wilayah_kabupaten.provinsi_id as provinsi_id',
                'master_wilayah_provinsi.name as provinsi_name',
                'user_profile.address',
                'user_profile.balance',
                'users.created_at',
                'users.updated_at',
            )
            ->leftJoin('user_profile', 'user_profile.user_id', 'users.id')
            ->leftJoin('master_user_role', 'master_user_role.id', 'users.role_id')
            ->leftJoin('master_user_status', 'master_user_status.id', 'users.status_id')
            ->leftJoin('master_wilayah_kabupaten', 'master_wilayah_kabupaten.id', 'user_profile.kabupaten_id')
            ->leftJoin('master_wilayah_provinsi', 'master_wilayah_provinsi.id', 'master_wilayah_kabupaten.provinsi_id')
            ->get();

            Activity::onAct($request, 'Get User');

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
            'username' => 'required|email|min:5|max:255|unique:users,username',
            'password' => 'nullable|string|min:5|max:255',
            'fullname' => 'required|string|min:5|max:255',
            'status_id' => 'required|exists:master_user_status,id',
            'role_id' => 'required|exists:master_user_role,id',
            'phone' => 'required|integer',
            'kabupaten_id' => 'required|exists:master_wilayah_kabupaten,id',
            'address' => 'required|string|min:5|max:255',
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

            $data = $request->all();

            $data['password'] = $request->has('password') && isset($request->password) ? Hash::make($request->password) : Hash::make('12345678');
            $data['email'] = $request->username;

            $user = User::create($data);

            $whereUserProfile = [
                'user_id' => $user->id,
            ];

            $dataUserProfile = [
                'phone' => $request->phone,
                'kabupaten_id' => $request->kabupaten_id,
                'address' => $request->address,
            ];

            $userProfile = UserProfile::updateOrCreate($whereUserProfile, $dataUserProfile);

            Packer::sendEmailVerification($user->email);

            DB::commit();

            Activity::onAct($request, 'Create User');

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

            $data = User::select(
                'users.id',
                'users.username',
                'users.fullname',
                'users.email',
                'users.role_id',
                'master_user_role.value as role_name',
                'users.status_id',
                'master_user_status.value as status_name',
                'users.api_token',
                'user_profile.phone',
                'user_profile.kabupaten_id',
                'master_wilayah_kabupaten.name as kabupaten_name',
                'master_wilayah_kabupaten.provinsi_id as provinsi_id',
                'master_wilayah_provinsi.name as provinsi_name',
                'user_profile.address',
                'user_profile.balance',
                'users.created_at',
                'users.updated_at',
            )
            ->leftJoin('user_profile', 'user_profile.user_id', 'users.id')
            ->leftJoin('master_user_role', 'master_user_role.id', 'users.role_id')
            ->leftJoin('master_user_status', 'master_user_status.id', 'users.status_id')
            ->leftJoin('master_wilayah_kabupaten', 'master_wilayah_kabupaten.id', 'user_profile.kabupaten_id')
            ->leftJoin('master_wilayah_provinsi', 'master_wilayah_provinsi.id', 'master_wilayah_kabupaten.provinsi_id')
            ->where('users.id', $id)
            ->first();

            if (is_null($data)) {

                return response()->json([
                    'status' => false,
                    'message' => 'User tidak ditemukan...',
                ], 404);

            }

            Activity::onAct($request, 'Show User');

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
            'username' => 'filled|email|min:5|max:255,unique:users,username,'.$id,
            'password' => 'nullable|string|min:5|max:255',
            'fullname' => 'filled|string|min:5|max:255',
            'status_id' => 'filled|exists:master_user_status,id',
            'role_id' => 'filled|exists:master_user_role,id',
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

            $user = User::where('id', $id)->first();

            if (is_null($user)) {

                return response()->json([
                    'status' => false,
                    'message' => 'User tidak ditemukan...',
                ], 404);

            }

            $data = $request->except('password');

            if ($request->has('password')) $data['password'] = Hash::make($request->password);

            if ($request->has('username') && $request->username != $user->username) {

                $data['email'] = $request->username;
                $data['api_token'] = null;

                Packer::sendEmailVerification($request->username);

            }

            $user->update($data);

            $whereUserProfile = [
                'user_id' => $user->id,
            ];

            $dataUserProfile = [
                'phone' => $request->phone,
                'kabupaten_id' => $request->kabupaten_id,
                'address' => $request->address,
            ];

            $userProfile = UserProfile::updateOrCreate($whereUserProfile, $dataUserProfile);

            DB::commit();

            Activity::onAct($request, 'Update User');

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

            $columns = ['id', 'id', 'username', 'fullname', 'email', 'role_name', 'status_name', 'created_at', 'updated_at'];

            $column = $columns[$request->input('order.0.column')];
            $dir   = $request->input('order.0.dir');

            $data = User::select(
                'users.id',
                'users.username',
                'users.fullname',
                'users.email',
                'users.role_id',
                'master_user_role.value as role_name',
                'users.status_id',
                'master_user_status.value as status_name',
                'users.created_at',
                'users.updated_at',
            )
            ->leftJoin('master_user_role', 'master_user_role.id', 'users.role_id')
            ->leftJoin('master_user_status', 'master_user_status.id', 'users.status_id')
            ->when($request, function ($query) use ($request) {
                $search = $request->search['value'];
                if (isset($search)) {
                    $query->where('users.fullname', 'like', "%{$search}%")
                        ->orWhere('users.email', 'like', "%{$search}%");
                }
            })
            ->orderBy($column, $dir)
            ->skip($request->start)
            ->take($request->length)
            ->get();

            $recordsTotal = User::count();
            $recordsFiltered = User::select()
            ->leftJoin('master_user_role', 'master_user_role.id', 'users.role_id')
            ->leftJoin('master_user_status', 'master_user_status.id', 'users.status_id')
            ->when($request, function ($query) use ($request) {
                $search = $request->search['value'];
                if (isset($search)) {
                    $query->where('users.fullname', 'like', "%{$search}%")
                        ->orWhere('users.email', 'like', "%{$search}%");
                }
            })
            ->count();

            Activity::onAct($request, 'Get User DataTable');

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
