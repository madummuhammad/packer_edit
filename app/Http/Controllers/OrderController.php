<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Outbound;
use App\Models\Storage as MyStorage;
use App\Models\User;
use App\Models\UserProfile;

use App\Helper\Activity;
use App\Helper\CustomException;

use DB;
use Carbon\Carbon;
use Exception;
use Hash;
use Validator;

class OrderController extends Controller
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

            $data = Order::select(
                'orders.id',
                'orders.user_id',
                'users.fullname as user_name',
                'orders.status_id',
                'master_order_status.value as status_name',
                'orders.invoice',
                'orders.category_id',
                'orders.category_id as category_name',
                'orders.subtotal',
                'orders.tax',
                'orders.grandtotal',
                'orders.reason_for_cancel',
                'orders.created_at',
                'orders.updated_at',
            )
            ->leftJoin('users', 'users.id', 'orders.user_id')
            ->leftJoin('master_order_status', 'master_order_status.id', 'orders.status_id')
            ->get();

            Activity::onAct($request, 'Get Order');

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

        $validator = Validator::make($request->all(), []);

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

            $now = Carbon::now();

            $cart = Cart::select(
                'carts.id',
                'carts.user_id',
                DB::raw('cast((select sum(total_price) from cart_item where cart_id = carts.id) as UNSIGNED) as subtotal'),
            )
            ->where('user_id', $user->id)->first();

            if (is_null($cart)) {

                return response()->json([
                    'status' => false,
                    'message' => 'Keranjang tidak ditemukan...',
                ], 404);
                
            }

            $cartItem = CartItem::where('cart_id', $cart->id);

            $subtotal = $cart->subtotal;
            $tax = 0;
            // $tax = $cart->subtotal * 0.1;
            $grandtotal = $subtotal + $tax;

            $data = [
                'user_id' => $user->id,
                'status_id' => 1,
                'invoice' => null,
                'category_id' => 'warehouse',
                'subtotal' => $subtotal,
                'tax' => $tax,
                'grandtotal' => $grandtotal,
            ];

            $order = Order::create($data);

            $incrementId = str_pad($order->id, 9, 0, STR_PAD_LEFT);

            $data = [
                'invoice' => "INV/{$now->format('Ymd')}/{$user->id}/{$incrementId}",
            ];

            $order->update($data);

            foreach ($cartItem->get() as $d) {

                $data = [
                    'order_id' => $order->id,
                    'description' => $d->description,
                    'qty' => $d->qty,
                    'duration' => $d->duration,
                    'price' => $d->price,
                    'total_price' => $d->total_price,
                    'internal_id' => $d->internal_id,
                ];

                $orderItem = OrderItem::create($data);

            }

            $cart->delete();
            $cartItem->delete();

            $userProfile = UserProfile::where('user_id', $order->user_id)->first();

            if ($userProfile->balance >= $order->grandtotal) {

                $balance = $userProfile->balance - $order->grandtotal;

                $dataUserProfile = [
                    'balance' => $balance,
                ];
                
                $userProfile->update($dataUserProfile);

                $order->status_id = 2;
                $order->save();

            }

            DB::commit();

            Activity::onAct($request, 'Create Order');

            return response()->json([
                'status' => true,
                'message' => 'Berhasil checkout!',
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

            $data = Order::select(
                'orders.id',
                'orders.user_id',
                'users.fullname as user_name',
                'users.email as user_email',
                'users.id as user_data',
                'orders.status_id',
                'master_order_status.value as status_name',
                'orders.invoice',
                'orders.category_id',
                'orders.category_id as category_name',
                'orders.subtotal',
                'orders.tax',
                'orders.grandtotal',
                'orders.reason_for_cancel',
                'orders.created_at',
                'orders.updated_at',
            )
            ->leftJoin('users', 'users.id', 'orders.user_id')
            ->leftJoin('master_order_status', 'master_order_status.id', 'orders.status_id')
            ->where('orders.id', $id)
            ->first();

            if (is_null($data)) {

                return response()->json([
                    'status' => false,
                    'message' => 'Order tidak ditemukan...',
                ], 404);

            }

            $data->user_data = UserProfile::select(
                'user_profile.id',
                'user_profile.phone',
                'user_profile.kabupaten_id',
                'master_wilayah_kabupaten.name as kabupaten_name',
                'master_wilayah_kabupaten.provinsi_id',
                'master_wilayah_provinsi.name as provinsi_name',
                'user_profile.address',
                'user_profile.postal_code',
            )
            ->leftJoin('master_wilayah_kabupaten', 'master_wilayah_kabupaten.id', 'user_profile.kabupaten_id')
            ->leftJoin('master_wilayah_provinsi', 'master_wilayah_provinsi.id', 'master_wilayah_kabupaten.provinsi_id')
            ->where('user_profile.id', $data->user_id)
            ->first();

            $data->items = OrderItem::select(
                'order_item.id',
                'order_item.order_id',
                'order_item.description',
                'order_item.qty',
                'order_item.price',
                'order_item.total_price',
            )
            ->where('order_item.id', $data->id)
            ->get();

            Activity::onAct($request, 'Show Order');

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
            'status_id' => 'nullable|exists:master_order_status,id',
            'reason_for_cancel' => 'required_if:status_id,5|string|max:255',
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

            $order = Order::where('id', $id)->first();

            if (is_null($order)) {

                return response()->json([
                    'status' => false,
                    'message' => 'Order tidak ditemukan...',
                ], 404);

            }

            $data = $request->all();

            $order->update($data);

            if ($request->status_id == 2) {

                $userProfile = UserProfile::where('user_id', $order->user_id)->first();

                if ($userProfile->balance <= $order->grandtotal) {

                    throw new Exception('Maaf! Dana anda kurang, silahkan top up terlebih dahulu...');

                }

                $balance = $userProfile->balance - $order->grandtotal;

                $dataUserProfile = [
                    'balance' => $balance,
                ];
                
                $userProfile->update($dataUserProfile);
                
            } else if ($request->status_id == 4) {

                if ($order->category_id == 'warehouse') {

                    $orderItem = OrderItem::where('order_id', $order->id)->get();

                    foreach($orderItem as $d) {
    
                        $data = [
                            'user_id' => $order->user_id,
                            'space_id' => $d->internal_id,
                            'start_date' => $now->format('Y-m-d'),
                            'end_date' => $now->addDays($d->duration)->format('Y-m-d'),
                        ];
        
                        $storage = MyStorage::create($data);
    
                    }

                } else if ($order->category_id == 'outbound') {

                    $outbound = Outbound::find($order->external_id);

                    $dataOutbound = [
                        'status_id' => 3,
                    ];

                    $outbound->update($dataOutbound);

                }

            } else if ($request->status_id == 5) {

                $userProfile = UserProfile::where('user_id', $order->user_id)->first();

                $balance = $userProfile->balance + $order->grandtotal;

                $dataUserProfile = [
                    'balance' => $balance,
                ];
                
                $userProfile->update($dataUserProfile);

            }

            DB::commit();

            Activity::onAct($request, 'Update Order');

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

            $order = Order::where('id', $id)->first();

            if (is_null($order)) {

                return response()->json([
                    'status' => false,
                    'message' => 'Order tidak ditemukan...',
                ], 404);

            }

            $order->delete();

            DB::commit();

            Activity::onAct($request, 'Delete Order');

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

            $columns = ['id', 'id', 'user_name', 'invoice', 'grandtotal', 'status_name', 'created_at', 'updated_at'];

            $column = $columns[$request->input('order.0.column')];
            $dir   = $request->input('order.0.dir');

            $data = Order::select(
                'orders.id',
                'orders.user_id',
                'users.fullname as user_name',
                'orders.status_id',
                'master_order_status.value as status_name',
                'orders.invoice',
                'orders.category_id',
                'orders.category_id as category_name',
                'orders.subtotal',
                'orders.tax',
                'orders.grandtotal',
                'orders.reason_for_cancel',
                'orders.created_at',
                'orders.updated_at',
            )
            ->leftJoin('users', 'users.id', 'orders.user_id')
            ->leftJoin('master_order_status', 'master_order_status.id', 'orders.status_id')
            ->when($user, function ($query) use ($user) {
                $admin = [1, 2];
                $isAdmin = in_array($user->role_id, $admin);
                if (!$isAdmin) {
                    $query->where('orders.user_id', $user->id);
                }
            })
            ->when($request, function ($query) use ($request) {
                $search = $request->search['value'];
                if (isset($search)) {
                    // TODO
                }
                $filter = $request->filter;
                if (is_array($filter)) {
                    if (array_key_exists('status_id', $filter)) $query->where('orders.status_id', $filter['status_id']);
                    if (array_key_exists('user_id', $filter)) $query->where('orders.user_id', $filter['user_id']);
                    if (array_key_exists('start_date', $filter) && array_key_exists('end_date', $filter)) $query->whereBetween(DB::raw("date_format(orders.created_at, '%Y-%m-%d')"), [$filter['start_date'], $filter['end_date']]);
                }
            })
            ->orderBy($column, $dir)
            ->skip($request->start)
            ->take($request->length)
            ->get();

            $recordsTotal = Order::count();
            $recordsFiltered = Order::select()
            ->leftJoin('users', 'users.id', 'orders.user_id')
            ->leftJoin('master_order_status', 'master_order_status.id', 'orders.status_id')
            ->when($user, function ($query) use ($user) {
                $admin = [1, 2];
                $isAdmin = in_array($user->role_id, $admin);
                if (!$isAdmin) {
                    $query->where('orders.user_id', $user->id);
                }
            })
            ->when($request, function ($query) use ($request) {
                $search = $request->search['value'];
                if (isset($search)) {
                    // TODO
                }
                $filter = $request->filter;
                if (is_array($filter)) {
                    if (array_key_exists('status_id', $filter)) $query->where('orders.status_id', $filter['status_id']);
                    if (array_key_exists('user_id', $filter)) $query->where('orders.user_id', $filter['user_id']);
                    if (array_key_exists('start_date', $filter) && array_key_exists('end_date', $filter)) $query->whereBetween(DB::raw("date_format(orders.created_at, '%Y-%m-%d')"), [$filter['start_date'], $filter['end_date']]);
                }
            })
            ->count();

            Activity::onAct($request, 'Get Order DataTable');

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
