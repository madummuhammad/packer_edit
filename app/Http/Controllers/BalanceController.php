<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\TopUpHistory;
use App\Models\User;
use App\Models\UserProfile;

use App\Helper\Activity;
use App\Helper\CustomException;

use DB;
use Exception;
use Storage;
use Str;
use Validator;

class BalanceController extends Controller
{
    
    public function topUp(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'amount' => 'required|integer',
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

            $data = [
                'user_id' => $user->id,
                'amount' => $request->amount,
                'status_id' => 'unpaid',
            ];

            TopUpHistory::create($data);

            Activity::onAct($request, 'Top Up Balance');

            return response()->json([
                'status' => true,
                'message' => 'OK',
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

    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'status_id' => 'nullable|in:paid',
            'attachment' => 'nullable|image',
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

            $topUpHistory = TopUpHistory::where('id', $id)->first();

            $data = $request->all();

            if ($request->has('attachment')) {

                $path = Storage::putFile('public/balance/', $request->file('attachment'));
                $data['attachment'] = str_replace('public/balance/', '', $path);

            }

            $topUpHistory->update($data);

            if ($request->status_id == 'paid') {

                $userProfile = UserProfile::where('user_id', $topUpHistory->user_id)->first();

                $balance = $topUpHistory->amount + $userProfile->balance;

                $data = [
                    'balance' => $balance,
                ];

                $userProfile->update($data);

            }

            Activity::onAct($request, 'Update Balance');

            return response()->json([
                'status' => true,
                'message' => 'OK',
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

    public function dataTable(Request $request)
    {

        $user = User::where('api_token', $request->bearerToken())->first();

        try {

            $columns = ['id', 'id', 'name', 'is_online', 'description', 'created_at', 'updated_at'];

            $column = $columns[$request->input('order.0.column')];
            $dir   = $request->input('order.0.dir');

            $data = TopUpHistory::select(
                'topup_history.id',
                'topup_history.user_id',
                'users.fullname as user_name',
                'topup_history.amount',
                'topup_history.status_id',
                'topup_history.status_id as status_name',
                DB::raw('concat("/storage/balance/", topup_history.attachment) as attachment'),
                'topup_history.created_at',
                'topup_history.updated_at',
            )
            ->leftJoin('users', 'users.id', 'topup_history.user_id')
            ->when($user, function ($query) use ($user) {
                $admin = [1, 2];
                $isAdmin = in_array($user->role_id, $admin);
                if (!$isAdmin) {
                    $query->where('topup_history.user_id', $user->id);
                }
            })
            ->when($request, function ($query) use ($request) {
                $search = $request->search['value'];
                if (isset($search)) {
                    // TODO
                }
                $filter = $request->filter;
                if (is_array($filter)) {
                    if (array_key_exists('user_id', $filter)) $query->where('topup_history.user_id', $filter['user_id']);
                    if (array_key_exists('start_date', $filter) && array_key_exists('end_date', $filter)) $query->whereBetween(DB::raw("date_format(topup_history.created_at, '%Y-%m-%d')"), [$filter['start_date'], $filter['end_date']]);
                }
            })
            ->orderBy($column, $dir)
            ->skip($request->start)
            ->take($request->length)
            ->get();

            $recordsTotal = TopUpHistory::count();
            $recordsFiltered = TopUpHistory::select()
            ->leftJoin('users', 'users.id', 'topup_history.user_id')
            ->when($user, function ($query) use ($user) {
                $admin = [1, 2];
                $isAdmin = in_array($user->role_id, $admin);
                if (!$isAdmin) {
                    $query->where('topup_history.user_id', $user->id);
                }
            })
            ->when($request, function ($query) use ($request) {
                $search = $request->search['value'];
                if (isset($search)) {
                    // TODO
                }
                $filter = $request->filter;
                if (is_array($filter)) {
                    if (array_key_exists('user_id', $filter)) $query->where('topup_history.user_id', $filter['user_id']);
                    if (array_key_exists('start_date', $filter) && array_key_exists('end_date', $filter)) $query->whereBetween(DB::raw("date_format(topup_history.created_at, '%Y-%m-%d')"), [$filter['start_date'], $filter['end_date']]);
                }
            })
            ->count();

            Activity::onAct($request, 'Get Top Up History DataTable');

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
