<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Lazada\LazopClient;
use Lazada\LazopRequest;
use Picqer\Barcode;

use App\Models\Integration;
use App\Models\User;
use App\Models\Product;

use App\Helper\Activity;
use App\Helper\CustomException;

use Carbon\Carbon;
use DB;
use Exception;
use Hash;
use Validator;

class ProductController extends Controller
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

            $data = Product::select(
                'products.id',
                'products.user_id',
                'users.fullname as user_name',
                'products.platform_id',
                'products.name',
                'products.sku',
                'products.outbound_price',
                'products.width',
                'products.height',
                'products.length',
                DB::raw('concat(products.length, " x ", products.width, " x ", products.height) as size'),
                'products.weight',
                'products.description',
                'products.created_at',
                'products.updated_at',
            )
            ->leftJoin('users', 'users.id', 'products.user_id')
            ->get();

            // foreach ($data as &$d) {

            //     $number = $d->sku;

            //     $generator = new Barcode\BarcodeGeneratorPNG();
            //     $barcode = '<img src="data:image/png;base64,' . base64_encode($generator->getBarcode($number, $generator::TYPE_CODE_128)) . '">';

            //     $d->barcode = $barcode;

            // }

            Activity::onAct($request, 'Get Product');

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
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|min:5|max:255',
            'sku' => 'nullable|string|min:5|max:255',
            'width' => 'required|integer',
            'height' => 'required|integer',
            'length' => 'required|integer',
            'weight' => 'required|integer',
            'description' => 'nullable|string|min:5|max:255',
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

            $now = Carbon::now();

            $data = $request->all();

            $product = Product::create($data);

            $user = User::find($request->user_id);
            $userName = strtoupper(str_split(explode(" ", $user->fullname)[0], 5)[0]);

            $incrementId = str_pad($product->id, 9, 0, STR_PAD_LEFT);

            $data = [ 
                'sku' => "{$userName}/{$incrementId}",
            ];

            if ($request->has('sku') && $request->sku) $data['sku'] = $request->sku;

            $product->update($data);

            DB::commit();

            Activity::onAct($request, 'Create Product');

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

            $data = Product::select(
                'products.id',
                'products.user_id',
                'users.fullname as user_name',
                'products.platform_id',
                'products.name',
                'products.sku',
                'products.outbound_price',
                'products.width',
                'products.height',
                'products.length',
                DB::raw('concat(products.length, " x ", products.width, " x ", products.height) as size'),
                'products.weight',
                'products.description',
                'products.created_at',
                'products.updated_at',
            )
            ->leftJoin('users', 'users.id', 'products.user_id')
            ->where('products.id', $id)
            ->first();

            if (is_null($data)) {

                return response()->json([
                    'status' => false,
                    'message' => 'Product tidak ditemukan...',
                ], 404);

            }

            Activity::onAct($request, 'Show Product');

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
            'user_id' => 'nullable|exists:users,id',
            'name' => 'nullable|string|min:5|max:255',
            'sku' => 'nullable|string|min:5|max:255',
            'width' => 'nullable|integer',
            'height' => 'nullable|integer',
            'length' => 'nullable|integer',
            'weight' => 'nullable|integer',
            'description' => 'nullable|string|min:5|max:255',
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

            $product = Product::where('id', $id)->first();

            if (is_null($product)) {

                return response()->json([
                    'status' => false,
                    'message' => 'Product tidak ditemukan...',
                ], 404);

            }

            $now = Carbon::now();

            $data = $request->all();

            $user = User::find($request->user_id);
            $userName = strtoupper(str_split(explode(" ", $user->fullname)[0], 5)[0]);

            $incrementId = str_pad($product->id, 9, 0, STR_PAD_LEFT);

            $data = [ 
                'sku' => "{$userName}/{$incrementId}",
            ];

            if ($request->has('sku') && $request->sku) $data['sku'] = $request->sku;

            $product->update($data);

            DB::commit();

            Activity::onAct($request, 'Update Product');

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

            $product = Product::where('id', $id)->first();

            if (is_null($product)) {

                return response()->json([
                    'status' => false,
                    'message' => 'Product tidak ditemukan...',
                ], 404);

            }

            $product->delete();

            DB::commit();

            Activity::onAct($request, 'Delete Product');

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

            $columns = ['id', 'id', 'user_name', 'name', 'sku', 'width', 'height', 'length', 'weight', 'description', 'created_at', 'updated_at'];

            $column = $columns[$request->input('order.0.column')];
            $dir   = $request->input('order.0.dir');

            $data = Product::select(
                'products.id',
                'products.user_id',
                'users.fullname as user_name',
                'products.platform_id',
                'products.name',
                'products.sku',
                'products.outbound_price',
                'products.width',
                'products.height',
                'products.length',
                DB::raw('concat(products.length, " x ", products.width, " x ", products.height) as size'),
                'products.weight',
                'products.description',
                'products.created_at',
                'products.updated_at',
            )
            ->leftJoin('users', 'users.id', 'products.user_id')
            ->when($user, function ($query) use ($user) {
                $admin = [1, 2];
                $isAdmin = in_array($user->role_id, $admin);
                if (!$isAdmin) {
                    $query->where('products.user_id', $user->id);
                }
            })
            ->when($request, function ($query) use ($request) {
                $search = $request->search['value'];
                if (isset($search)) {
                    // TODO
                }
                $filter = $request->filter;
                if (!is_null($filter)) {
                    if (array_key_exists('platform_id', $filter)) $query->where('products.platform_id', $filter['platform_id']);
                    if (array_key_exists('user_id', $filter)) $query->where('products.user_id', $filter['user_id']);
                    if (array_key_exists('start_date', $filter) && array_key_exists('end_date', $filter)) $query->whereBetween(DB::raw("date_format(products.created_at, '%Y-%m-%d')"), [$filter['start_date'], $filter['end_date']]);
                }
            })
            ->orderBy($column, $dir)
            ->skip($request->start)
            ->take($request->length)
            ->get();

            foreach ($data as &$d) {

                if ($d->sku) {

                    $generator = new \Picqer\Barcode\BarcodeGeneratorPNG();

                    $d->barcode = '<img src="data:image/png;base64,' . base64_encode($generator->getBarcode($d->sku, $generator::TYPE_CODE_128)) . '">';

                }

            }

            $recordsTotal = Product::count();
            $recordsFiltered = Product::select()
            ->leftJoin('users', 'users.id', 'products.user_id')
            ->when($user, function ($query) use ($user) {
                $admin = [1, 2];
                $isAdmin = in_array($user->role_id, $admin);
                if (!$isAdmin) {
                    $query->where('products.user_id', $user->id);
                }
            })
            ->when($request, function ($query) use ($request) {
                $search = $request->search['value'];
                if (isset($search)) {
                    // TODO
                }
                $filter = $request->filter;
                $filter = $request->filter;
                if (!is_null($filter)) {
                    if (array_key_exists('platform_id', $filter)) $query->where('products.platform_id', $filter['platform_id']);
                    if (array_key_exists('user_id', $filter)) $query->where('products.user_id', $filter['user_id']);
                    if (array_key_exists('start_date', $filter) && array_key_exists('end_date', $filter)) $query->whereBetween(DB::raw("date_format(products.created_at, '%Y-%m-%d')"), [$filter['start_date'], $filter['end_date']]);
                }
            })
            ->count();

            Activity::onAct($request, 'Get Product DataTable');

            return response()->json([
                'status' => true,
                'message' => 'OK',
                'data' => $data,
                'draw' => $request->draw,
                'recordsTotal' => $recordsTotal,
                'recordsFiltered' => $recordsFiltered,
                'request' => $request->all()
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

    public function sync(Request $request, $platformSlug)
    {

        $user = User::where('api_token', $request->bearerToken())->first();

        try {

            DB::beginTransaction();

            $platform = DB::table('master_platform')->where('slug', $platformSlug)->first();
            $integration = Integration::where('user_id', $user->id)->where('platform_id', $platform->id)->first();

            if ($platformSlug == 'tokopedia') {

                

            } else if ($platformSlug == 'lazada') {

                $integrationJson = json_decode($integration->json);

                $cli = new LazopClient('https://api.lazada.co.id/rest', env('LAZADA_CLIENT_ID'), env('LAZADA_CLIENT_SECRET'));
                $req = new LazopRequest('/products/get', 'GET');
                $req->addApiParam('access_token', $integration->key);
                $req->addApiParam('filter', 'all');
                $res = $cli->execute($req);

                $res = json_decode($res);

                if ($res->code == 0) {

                    if ($res->data && $res->data->total_products >= 1) {

                        foreach ($res->data->products as $p) {

                            $where = [
                                'user_id' => $user->id,
                                'platform_id' => $platform->id,
                            ];

                            foreach ($p->skus as $sku) {

                                $where['sku'] = $sku->ShopSku;

                                $data = [
                                    'name' => $p->attributes->name,
                                    'width' => $sku->package_width,
                                    'height' => $sku->package_height,
                                    'length' => $sku->package_length,
                                    'weight' => $sku->package_weight,
                                    'description' => $p->attributes->description,
                                ];
    
                                $product = Product::updateOrCreate($where, $data);
                                    
                            }

                        }

                    }

                } else if ($res->code == 'IllegalAccessToken') {

                    $cli = new LazopClient('https://auth.lazada.com/rest', env('LAZADA_CLIENT_ID'), env('LAZADA_CLIENT_SECRET'));
                    $req = new LazopRequest('/auth/token/refresh');
                    $req->addApiParam('refresh_token', $integrationJson->refresh_token);
                    $res = $cli->execute($req);

                    $res = json_decode($res);

                    $data = [
                        'key' => $res->access_token,
                        'json' => json_encode($res),
                    ];

                    $integration->update($data);

                    DB::commit();

                    return response()->json([
                        'status' => false,
                        'message' => 'Akses token expired! Silahkan coba lagi...',
                    ], 400);

                } else {

                    throw new Exception('Code Expired');

                }

            } else if ($platformSlug = 'shopee') {

                $path = '/api/v2/product/get_item_list';
                $timestamp = time();
                $baseString = env('SHOPEE_CLIENT_ID') . $path . $timestamp . $integration->key . $integration->extra_id;
                $sign = hash_hmac('sha256', $baseString, env('SHOPEE_CLIENT_SECRET'));

                $params = [
                    'partner_id' => env('SHOPEE_CLIENT_ID'),
                    'timestamp' => $timestamp,
                    'access_token' => $integration->key,
                    'shop_id' => $integration->extra_id,
                    'sign' => $sign,
                    'offset' => 0,
                    'page_size' => 10,
                    'item_status' => 'NORMAL',
                ];

                $params = http_build_query($params);

                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://partner.test-stable.shopeemobile.com/api/v2/product/get_item_list?{$params}",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_HTTPHEADER => [
                        'Content-Type' => 'application/json'
                    ],
                    CURLOPT_CUSTOMREQUEST => "GET",
                ));

                $response = curl_exec($curl);
                $responseError = curl_errno($curl);

                if ($responseError) {

                    throw new Exception($responseError);

                }

                curl_close($curl);

                $response = json_decode($response);

                if (property_exists($response, 'error')) {

                    throw new Exception($response->message);

                }

            }

            DB::commit();

            Activity::onAct($request, 'Sync Product');

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

}
