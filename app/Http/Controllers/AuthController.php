<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Lazada\LazopClient;
use Lazada\LazopRequest;

use App\Models\Integration;
use App\Models\User;
use App\Models\UserProfile;

use App\Helper\Activity;
use App\Helper\CustomException;
use App\Helper\Packer;

use Auth;
use Crypt;
use DB;
use Exception;
use Hash;
use Session;
use Str;
use Validator;

class AuthController extends Controller
{

    public function integrationAuth(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'platform_slug' => 'required|exists:master_platform,slug',
            'name' => 'required_if:platform_slug,blibli|string|min:5|max:255',
            'key' => 'required_if:platform_slug,blibli|string|min:5|max:255',
            'client_id' => 'required_if:platform_slug,tokopedia|string|min:5|max:255',
            'client_secret' => 'required_if:platform_slug,tokopedia|string|min:5|max:255',
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

            $platform = DB::table('master_platform')->where('slug', $request->platform_slug)->first();

            if ($request->platform_slug == 'tokopedia') {

                $authorizationToken = base64_encode("{$request->client_id}:{$request->client_secret}");

                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => "https://accounts.tokopedia.com/token?grant_type=client_credentials",
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_HTTPHEADER => array(
                        "Authorization: Basic $authorizationToken",
                        "Content-Length: 0",
                        "User-Agent: PostmanRuntime/7.17.1",
                    ),
                ));

                $response = curl_exec($curl);
                $responseError = curl_error($curl);

                curl_close($curl);

                if ($responseError) {

                    throw new Exception($responseError);
    
                }

                $data = json_decode($response);

                $where = [
                    'user_id' => $user->id,
                    'platform_id' => $platform->id,
                ];
    
                $data = [
                    'key' => $data->access_token,
                    'extra_id' => $request->client_id,
                    'extra_name' => $request->client_id,
                ];
    
                $integration = Integration::updateOrCreate($where, $data);

            } else if ($request->platfrorm_slug == 'blibli') {

                $where = [
                    'user_id' => $user->id,
                    'platform_id' => $platform->id,
                ];
    
                $data = [
                    'key' => $request->key,
                    'extra_id' => $request->name,
                    'extra_name' => $request->name,
                ];
    
                $integration = Integration::updateOrCreate($where, $data);

            }

            DB::commit();

            Activity::onAct($request, "Integration {$platform->value}");

            return response()->json([
                'status' => true,
                'message' => 'Berhasil! Silahkan cek integrasi anda...',
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

    public function integrationCallback(Request $request, $slug)
    {

        $validator = Validator::make($request->all(), []);

        if ($validator->fails()) {

            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
                'error' => $validator->errors(),
            ], 400);

        }

        $user = User::where('api_token', $request->token)->first();

        try {

            DB::beginTransaction();

            $platform = DB::table('master_platform')->where('slug', $slug)->first();

            $where = [
                'user_id' => $user->id,
                'platform_id' => $platform->id,
            ];

            $data = [
                'key' => $request->code,
            ];

            if ($slug == 'lazada') {

                $cli = new LazopClient('https://auth.lazada.com/rest', env('LAZADA_CLIENT_ID'), env('LAZADA_CLIENT_SECRET'));
                $req = new LazopRequest('/auth/token/create');
                $req->addApiParam('code', $request->code);
                $res = $cli->execute($req);

                $res = json_decode($res);

                if ($res->code == 0) {

                    $data['key'] = $res->access_token;
                    $data['extra_id'] = $res->account;
                    $data['extra_name'] = $res->account;
                    $data['json'] = json_encode($res);

                } else {

                    throw new Exception('Code Expired');

                }

            } else if ($slug == 'shopee') {

                if ($request->has('shop_id')) $data['extra_id'] = $request->shop_id;
                if ($request->has('shop_id')) $data['extra_name'] = $request->shop_id;

            }

            $itegration = Integration::updateOrCreate($where, $data);

            DB::commit();

            Activity::onAct($request, "Integration Callback");

            return redirect('/admin/main/integration');

        } catch (Exception $e) {

            DB::rollBack();

            CustomException::onError($e);

            return redirect("/admin/main/integration/{$slug}");

        }

    }

    public function signUp(Request $request)
    {

        try {

            DB::beginTransaction();

            $validator = Validator::make($request->all(), [
                'fullname' => 'required|string|min:5|max:255',
                'username' => 'required|string|min:5|max:255|unique:users,username',
                'password' => 'required|string|min:5|max:255',
                'phone' => 'required|integer',
                'kabupaten_id' => 'required|exists:master_wilayah_kabupaten,id',
                'address' => 'required|string|min:5|max:255',
            ]);
    
            if ($validator->fails()) {

                return redirect('register')->with('error', $validator->errors()->first());
    
            }

            $data = $request->only('fullname', 'username');

            $data['password'] = Hash::make($request->password);
            $data['email'] = $request->username;
            $data['role_id'] = 3;
            $data['status_id'] = 2;

            $user = User::create($data);

            $data = [
                'user_id' => $user->id,
                'phone' => $request->phone,
                'kabupaten_id' => $request->kabupaten_id,
                'address' => $request->address,
            ];

            $userProfile = UserProfile::create($data);

            DB::commit();

            Activity::onAct($request, 'Register');

            return redirect('login')->with('success', 'Berhasil! Silahkan login menggunakan akun anda...');

        } catch (Exception $e) {

            DB::rollBack();

            CustomException::onError($e);

            return redirect('register')->with('error', $e->getMessages());

        }

    }
    
    public function signIn(Request $request)
    {

        try {

            $validator = Validator::make($request->all(), [
                'username' => 'required|string|min:5|max:255|exists:users,username',
                'password' => 'required|string|min:5|max:255',
            ]);
    
            if ($validator->fails()) {

                return redirect("login?username={$request->username}")->with('error', $validator->errors()->first());
    
            }

            $user = User::where('username', $request->username)->first();

            if ($user->status_id != 2) {

                return redirect("login?username={$request->username}")->with('error', 'Akun anda belum aktif! Silahkan hubungi admin untuk informasi lebih lanjut...');
            
            }

            if ($user->is_verified == 0) {

                return redirect("login?username={$request->username}")->with('error', 'Maaf! Mohon melakukan verifikasi email terlebih dahulu...');

            }

            $credentials = $request->only('username', 'password');

            if (Auth::attempt($credentials)) {

                if (is_null($user->api_token)) {

                    $user->api_token = Str::random(60);
                    $user->update();
    
                }

                Session::put('id', $user->id);
                Session::put('username', $user->username);
                Session::put('fullname', $user->fullname);
                Session::put('email', $user->email);
                Session::put('status_id', $user->status_id);
                Session::put('role_id', $user->role_id);
                Session::put('api_token', $user->api_token);

            } else {

                return redirect("login?username={$request->username}")->with('error', 'Maaf! Periksa kembali username dan password anda.');

            }

            Activity::onAct($request, 'Login');

            return redirect('admin/main/dashboard');

        } catch (Exception $e) {

            CustomException::onError($e);

            return redirect("login?username={$request->username}")->with('error', 'Maaf! Terjadi kesalahan pada sistem...');

        }

    }

    public function signOut(Request $request)
    {

        try {

            Auth::logout();

            Activity::onAct($request, 'Logout');

            return redirect('login');

        } catch (Exception $e) {

            CustomException::onError($e);

            return redirect('admin/main/dashboard')->with('error', 'Maaf! Terjadi kesalahan pada sistem...');

        }

    }

    public function profile(Request $request)
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
            ->where('users.api_token', $request->bearerToken())
            ->first();

            if (is_null($data)) {

                return response()->json([
                    'status' => false,
                    'message' => 'Profile tidak ditemukan...'
                ], 404);

            }

            Activity::onAct($request, 'Get Profile');

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

    public function resendVerification(Request $request)
    {

        try {

            $user = User::where('email', $request->email)->first();

            if (is_null($user)) {

                return redirect('login')->with('error', 'Maaf! Email belum terdaftar...');

            }

            Packer::sendEmailVerification($user->email);

            Activity::onAct($request, "Resend email verification {$user->fullname}");

            return redirect('login')->with('success', 'Berhasil! Silahkan cek email anda...');

        } catch (Exception $e) {

            CustomException::onError($e);

            return redirect('login')->with('error', 'Maaf! Terjadi kesalahan pada sistem...');

        }

    }

    public function checkVerification(Request $request, $token)
    {

        try {

            $email = Crypt::decryptString($token);

            $user = User::where('email', $email)->first();

            $data = [
                'status_id' => 2,
                'is_verified' => 1,
            ];

            $user->update($data);

            Activity::onAct($request, "Check email verification {$user->fullname}");

            return redirect('login')->with('success', 'Berhasil! Silahkan login ke akun anda...');

        } catch (Exception $e) {

            CustomException::onError($e);

            return redirect('login')->with('error', 'Maaf! Terjadi kesalahan pada sistem...');

        }

    }

    public function forgotPassword(Request $request)
    {

        try {

            $user = User::where('email', $request->email)->first();

            if (is_null($user)) {

                return redirect('login')->with('error', 'Maaf! Email belum terdaftar...');

            }

            Packer::sendEmailForgotPassword($user->email, $user->fullname);

            Activity::onAct($request, "Send email verification {$user->fullname} for Forgot Password");

            return redirect('login')->with('success', 'Berhasil! Silahkan cek email anda...');

        } catch (Exception $e) {

            CustomException::onError($e);

            return redirect('login')->with('error', 'Maaf! Terjadi kesalahan pada sistem...');

        }

    }

    public function changePassword(Request $request)
    {

        try {

            $user = User::where('email', $request->email)->first();

            if (is_null($user)) {

                return redirect('login')->with('error', 'Maaf! Email belum terdaftar...');

            }

            $data = [
                'password' => Hash::make($request->password),
            ];

            $user->update($data);

            Activity::onAct($request, "Change Password");

            return redirect('login')->with('success', 'Berhasil! Silahkan login ke akun anda...');

        } catch (Exception $e) {

            CustomException::onError($e);

            return redirect('login')->with('error', 'Maaf! Terjadi kesalahan pada sistem...');

        }

    }

}
