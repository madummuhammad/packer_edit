<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Outbound;
use App\Models\OutboundItem;
use App\Models\Product;

use App\Helper\Activity;
use App\Helper\CustomException;

use DB;
use Exception;
use Hash;
use Validator;

class RajaOngkirController extends Controller
{

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->api_key = env('RAJAONGKIR_API_KEY');
    }

    public function rates(Request $request, $outboundId)
    {

        try {

            $weight = 0;

            $outbound = Outbound::where('id', $outboundId)->first();
            $oubountItems = OutboundItem::where('outbound_id', $outboundId)->get();

            foreach ($oubountItems as $d) {

                $product = Product::where('id', $d->product_id)->first();

                $weight += $product->weight * $d->qty;

            }

            $curl = curl_init();

            // $postfields = [
            //     'origin' => $request->origin_id,
            //     'originType' => 'city',
            //     'destination' => $request->destination_id,
            //     'destinationType' => 'city',
            //     'weight' => $weight,
            //     'courier' => $request->courier_code,
            // ];

            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://pro.rajaongkir.com/api/cost",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => "origin={$request->origin_id}&originType=city&destination={$request->destination_id}&destinationType=city&weight={$weight}&courier={$request->courier_code}",
                CURLOPT_HTTPHEADER => array(
                    "content-type: application/x-www-form-urlencoded",
                    "key: {$this->api_key}"
                ),
            ));

            $response = curl_exec($curl);
            $responseError = curl_error($curl);

            curl_close($curl);

            if ($responseError) {

                throw new Exception($responseError);

            }

            $data = json_decode($response);

            if ($data->rajaongkir->status->code == 400) {

                throw new Exception($data->rajaongkir->status->description);

            }

            Activity::onAct($request, 'Shipment Rates');

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

    public function checkShipment(Request $request, $awb)
    {

        try {

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://pro.rajaongkir.com/api/waybill",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => "waybill={$awb}&courier=jne",
                CURLOPT_HTTPHEADER => array(
                    "content-type: application/x-www-form-urlencoded",
                    "key: {$this->api_key}"
                ),
            ));

            $response = curl_exec($curl);
            $responseError = curl_error($curl);

            curl_close($curl);

            if ($responseError) {

                throw new Exception($responseError);

            }

            $data = json_decode($response);

            if ($data->rajaongkir->status->code == 400) {

                throw new Exception($data->rajaongkir->status->description);

            }

            Activity::onAct($request, 'Check Waybill');

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
