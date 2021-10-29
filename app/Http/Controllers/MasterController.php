<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Courier;
use App\Models\CourierService;

use App\Helper\Activity;
use App\Helper\CustomException;

use DB;

class MasterController extends Controller
{
    
    public function getCourier(Request $request)
    {

        try {

            $url = url('/assets/apps/img/courier/');

            $data = Courier::select(
                'couriers.id',
                'couriers.code',
                'couriers.name',
                DB::raw("concat('{$url}/', couriers.logo) as logo"),
            )
            ->get();

            foreach ($data as &$d) {

                $d->services = CourierService::select(
                    'courier_service.id',
                    'courier_service.service_code',
                    'courier_service.service_name',
                )
                ->where('courier_service.courier_id', $d->id)
                ->get();
                
            }

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

    public function getOutboundStatus(Request $request)
    {

        try {

            $data = DB::table('master_outbound_status')->get();

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

    public function getInboundStatus(Request $request)
    {

        try {

            $data = DB::table('master_inbound_status')->get();

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

    public function getOrderStatus(Request $request)
    {

        try {

            $data = DB::table('master_order_status')->get();

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

    public function getPlatform(Request $request)
    {

        try {

            $data = DB::table('master_platform')
            ->when($request, function ($query) use ($request) {
                if ($request->has('is_integration')) $query->where('is_integration', $request->is_integration);
                if ($request->has('is_available')) $query->where('is_available', $request->is_available);
            })
            ->get();

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

    public function getPlatformById(Request $request, $id)
    {

        try {

            $data = DB::table('master_platform')
            ->where('id', $id)
            ->first();

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

    public function getSpaceType(Request $request)
    {

        try {

            $data = DB::table('master_space_type')->get();

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

    public function getUserRole(Request $request)
    {

        try {

            $data = DB::table('master_user_role')->get();

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

    public function getUserStatus(Request $request)
    {

        try {

            $data = DB::table('master_user_status')->get();

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

    public function getProvince(Request $request)
    {

        try {

            $data = DB::table('master_wilayah_provinsi')->get();

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

    public function getCity(Request $request)
    {

        try {

            $data = DB::table('master_wilayah_kabupaten')
            ->when($request, function ($query, $request) {
                if ($request->has('provinsi_id')) $query->where('master_wilayah_kabupaten.provinsi_id', $request->provinsi_id);
            })
            ->get();

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

}
