<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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





    public function login(LoginRequest $request){

        $user=User::where('email',$request->user_name)->where('active',1)->first();

        if($user){
            if (!Auth::attempt(["email" => $request->user_name, "password" => $request->password])) {
                return response()->json([
                    'error' => 'رجاء التأكد من اسم المستخدم و كلمة المرور',
                    'code' => Response::HTTP_UNPROCESSABLE_ENTITY,
                    'message' => 'للاسف المعلومات التي ادخلتها لا تطابق البيانات المسجلة لدينا',
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        }else{
            $request->user_name = '966' . $request->user_name;
            if (!Auth::attempt(["phone" => $request->user_name, "password" => $request->password])) {
                return response()->json([
                    'error' => 'رجاء التأكد من اسم المستخدم و كلمة المرور',
                    'code' => Response::HTTP_UNPROCESSABLE_ENTITY,
                    'message' => 'للاسف المعلومات التي ادخلتها لا تطابق البيانات المسجلة لدينا',
                ], Response::HTTP_UNPROCESSABLE_ENTITY);
            }
        }

        $access_token = auth()->user()->createToken('authToken')->accessToken;
        $dataR['user'] = auth()->user();
        $dataR['user_permissions'] = auth()->user()->getAllPermissions();
        $dataR['access_token'] = $access_token;
        return $this->successResponse($dataR, Response::HTTP_CREATED);
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
