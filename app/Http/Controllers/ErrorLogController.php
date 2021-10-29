<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Error;

use App\Helper\Activity;
use App\Helper\CustomException;

use DB;
use Validator;

class ErrorLogController extends Controller
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
     * Truncate resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function truncate(Request $request)
    {

        try {

            Error::truncate();

            Activity::onAct($request, 'Truncate Error Log');

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
     * Display a listing of the resource for DataTable.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function dataTable(Request $request)
    {

        $user = User::where('api_token', $request->bearerToken())->first();

        try {

            $columns = ['id', 'path', 'line', 'error', 'created_at'];

            $column = $columns[$request->input('order.0.column')];
            $dir   = $request->input('order.0.dir');

            $data = Error::select(
                'errors.id',
                'errors.path',
                'errors.line',
                'errors.error',
                'errors.created_at',
            )
            ->when($request, function ($query) use ($request, $user) {
                $search = $request->search['value'];
                if (isset($search)) {
                    $query->where('errors.path', 'like', "%{$search}%")
                        ->orWhere('errors.line', 'like', "%{$search}%")
                        ->orWhere('errors.error', 'like', "%{$search}%");
                }
            })
            ->orderBy($column, $dir)
            ->skip($request->start)
            ->take($request->length)
            ->get();

            $recordsTotal = Error::count();
            $recordsFiltered = Error::select()
            ->when($request, function ($query) use ($request, $user) {
                $search = $request->search['value'];
                if (isset($search)) {
                    $query->where('errors.path', 'like', "%{$search}%")
                        ->orWhere('errors.line', 'like', "%{$search}%")
                        ->orWhere('errors.error', 'like', "%{$search}%");
                }
            })
            ->count();

            Activity::onAct($request, 'Get Error Log DataTable');

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
