<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckCodeRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ConfirmResetRequest;
use App\Http\Requests\ResetRequest;
use App\Mail\SendCodeResetPassword;
use App\Models\User;
use App\Traits\ApiResponser;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    use ApiResponser;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    public function login(LoginRequest $request)
    {

        $user = User::where('email', $request->user_name)->where('type', 'admin')->where('active', 1)->first();

        if($user) {
            if (!Auth::attempt(["email" => $request->user_name, "password" => $request->password])) {
                return apiResponse(false, null, __('api.check_user_name_passowrd'), null, Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        } else {

            $user = User::where('phone', $request->user_name)->where('type', 'admin')->where('active', 1)->first();
            if(!$user) {
                return apiResponse(false, null, __('api.check_user_name_passowrd'), null, Response::HTTP_UNPROCESSABLE_ENTITY);
            }
            if (!Auth::attempt(["phone" => $request->user_name, "password" => $request->password])) {
                return apiResponse(false, null, __('api.check_user_name_passowrd'), null, Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        }

        $access_token = auth()->user()->createToken('authToken')->accessToken;
        $dataR['user'] = auth()->user();
        // $dataR['user_permissions'] = auth()->user()->getAllPermissions();
        $dataR['access_token'] = $access_token;
        return $this->successResponse($dataR, Response::HTTP_CREATED);
    }

    public function resetPassword(ResetRequest $request)
    {
        try{

            $user = User::where('email', $request->user_name)->orWhere('phone',$request->user_name)->where('type','admin')->first();
            if (!$user) {
                return apiResponse(false, null, __('api.not_found'), null, 404);
            }

            $MsgID = rand(100000, 999999);
            $user->update(['reset_code' => $MsgID]);
            Mail::to($user->email)->send(new SendCodeResetPassword($user->email, $MsgID));
            return apiResponse(true, [$MsgID], __('api.reset_password_code_send'), null, 200);
        } catch (Exception $e) {
            return apiResponse(false, null, $e->getMessage(), null, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

    }
    public function checkCode(CheckCodeRequest $request)
    {
        try{
        $user = User::where('email', $request->user_name)->orWhere('phone',$request->user_name)->where('type','admin')->first();
        if (!$user) {
            return apiResponse(false, null, __('api.not_found'), null, 404);
        }
        if($user->reset_code == $request->code) {
            return apiResponse(true, null, __('api.code_success'), null, 200);
        }
        return apiResponse(false, null, __('api.code_error'), null, 201);
        } catch (Exception $e) {
            return apiResponse(false, null, $e->getMessage(), null, Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }
    public function confirmReset(ConfirmResetRequest $request)
    {
        try{
            $user = User::where('email', $request->user_name)->orWhere('phone',$request->user_name)->where('type','admin')->first();
            if (!$user) {
                return apiResponse(false, null, __('api.not_found'), null, 404);
            }
            $user->update(['password' => Hash::make($request->password),'reset_code' => null]);
            return apiResponse(true, null, __('api.update_success'), null, 200);
        } catch (Exception $e) {
            return apiResponse(false, null, $e->getMessage(), null, Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    }

    public function logout(Request $request)
    {
        $accessToken = Auth::user()->token();
        DB::table('oauth_refresh_tokens')
            ->where('access_token_id', $accessToken->id)
            ->update([
                'revoked' => true
            ]);

        $accessToken->revoke();
        $data['message'] = 'Logout successfully';
        return $this->successResponse($data, Response::HTTP_CREATED);
    }
}
