<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Space;
use App\Models\User;
use App\Models\Warehouse;

use App\Helper\Activity;
use App\Helper\CustomException;

use DB;
use Validator;

class CartController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $user = User::where('api_token', $request->bearerToken())->first();

        try {

            $data = Cart::select(
                'carts.id',
                'carts.user_id',
                'users.fullname as user_name',
                DB::raw('cast((select sum(total_price) from cart_item where cart_id = carts.id) as UNSIGNED) as subtotal'),
            )
            ->leftJoin('users', 'users.id', 'carts.user_id')
            ->where('user_id', $user->id)
            ->first();

            if (is_null($data)) {

                return response()->json([
                    'status' => false,
                    'message' => 'Cart tidak ditemukan...'
                ], 404);

            }

            $data->items = CartItem::select(
                'cart_item.id',
                'cart_item.cart_id',
                'cart_item.description',
                'cart_item.qty',
                'cart_item.price',
                'cart_item.total_price',
                'cart_item.internal_id',
            )
            ->where('cart_item.cart_id', $data->id)
            ->get();

            Activity::onAct($request, 'Get Cart');

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
            'space_id' => 'required|exists:spaces,id',
            'qty' => 'required|integer',
            'duration' => 'required|integer',
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

            $cart = Cart::where('user_id', $user->id)->first();

            if (is_null($cart)) {

                $data = [
                    'user_id' => $user->id,
                ];

                $cart = Cart::create($data);

            }

            $space = Space::where('id', $request->space_id)->first();

            if ($space->stock <= $request->qty) {

                $warehouse = Warehouse::where('id', $space->warehouse_id)->first();

                $total = $space->price * $request->qty;

                $param = [
                    'cart_id' => $cart->id,
                    'internal_id' => $request->space_id,
                ];

                $data = [
                    'description' => "{$request->duration} month(s) Stock Management Services (Location: {$warehouse->name}, {$space->size})",
                    'qty' => $request->qty,
                    'duration' => $request->duration,
                    'price' => $space->price,
                    'qty' => $request->qty,
                    'total_price' => $total,
                ];

                CartItem::updateOrCreate($param, $data);

            } else {

                DB::rollBack();

                return response()->json([
                    'status' => false,
                    'message' => 'Kuantitas yang dimasukkan melebihi barang yang tersedia...'
                ], 400);

            }

            DB::commit();

            Activity::onAct($request, 'Add Or Update Cart Item');

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
    public function destroy(Request $request, $id)
    {

        $user = User::where('api_token', $request->bearerToken())->first();
        
        try {

            DB::beginTransaction();
        
            $item = CartItem::where('id', $id)->first();

            if (is_null($item)) {

                return response()->json([
                    'status' => false,
                    'message' => 'Item tidak ditemukan...'
                ], 400);

            }

            $cart = Cart::where('id', $item->cart_id)->first();

            $item->delete();

            $cartItemCount = CartItem::where('cart_id', $cart->id)->count();

            if ($cartItemCount == 0) {

                $cart->delete();

            }

            DB::commit();

            Activity::onAct($request, 'Destroy Cart / Cart Item');

            return response()->json([
                'status' => true,
                'message' => 'Berhasil menghapus item dari keranjang.'
            ], 200);

        } catch (\Exception $e) {

            DB::rollBack();

            CustomException::onError($e);

            return response()->json([
                'status' => false,
                'message' => 'Maaf! Terjadi kesalahan pada sistem...',
                'error' => $e->getMessage()
            ], 500);

        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function truncate(Request $request)
    {

        $user = User::where('api_token', $request->bearerToken())->first();
        
        try {

            DB::beginTransaction();

            $cart = Cart::where('user_id', $user->id)->first();

            if (is_null($cart)) {

                return response()->json([
                    'status' => false,
                    'message' => 'Cart tidak ditemukan...'
                ], 404);

            }

            CartItem::where('cart_id', $cart->id)->delete();

            $cart->delete();

            DB::commit();

            Activity::onAct($request, 'Clear All Cart');

            return response()->json([
                'status' => true,
                'message' => 'Berhasil menghapus item dari keranjang.'
            ], 200);

        } catch (\Exception $e) {

            DB::rollBack();

            CustomException::onError($e);

            return response()->json([
                'status' => false,
                'message' => 'Maaf! Terjadi kesalahan pada sistem...',
                'error' => $e->getMessage()
            ], 500);

        }

    }

}
