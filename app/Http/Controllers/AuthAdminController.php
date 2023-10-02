<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Validator;
use Illuminate\Http\Request;
class AuthAdminController extends Controller
{

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('AuthAdmin', ['except' => ['login' , "register"]]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
            $request = $request->all();
            $validation = Validator::make($request,[
                "email" => "required|email",
                "password" => "required",

            ] , [
                "email.required" => "ادخل الايميل",
                "email.email" => "هذا الحقل يستقيل ايميل",
                "password.required" => "ادخل الرقم السري",
            ]);

            if($validation->fails()) {
                $errors = $validation->errors();
                return validationError($errors);
            }

            $credentials = request(['email' , "password"]);
            if (! $token = auth("Admin")->attempt($credentials)) {
                return response()->json(["status" => null , "error" => "Unauthorized"] );
            }
            $user = User::where("email" , $request["email"])->first();
            if (!$user->hasAnyRole("Admin" , "Super Admin")) {
                return response()->json(["status" => null , "error" => "you not admin and you not allowed to enter"] );
            }
   
        $permissions = Role::find($user->roles[0]->id)->permissions->pluck("name");
        return $this->respondWithToken($token , $user , $permissions);
    }
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
            $request = $request->all();
            $validation = Validator::make($request,[
                "name" => "required",
                "email" => "required|email",
                "password" => "required",

            ] , [
                "name.required" => "ادخل الاسم",
                "email.required" => "ادخل الايميل",
                "email.email" => "هذا الحقل يستقيل ايميل",
                "password.required" => "ادخل الرقم السري",
            ]);

            if($validation->fails()) {
                $errors = $validation->errors();
                return validationError($errors);
            }
        $data = $request->all();
        $data['password'] = Hash::make($data['password']);
        User::create($data);
        $token = auth()->attempt(request(['email',"password"]));
        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        $user = User::with(["roles"=>function($qr) {
            return $qr->select("name" , "id");
        }])->find(auth()->user()->id);
        $permissions = Role::find($user->roles[0]->id)->permissions->pluck("name");
        return success(["user" => $user , "permissions" => $permissions]);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        try {
            auth()->logout();
            return success(['message' => 'Successfully logged out']);
        } catch (\Throwable $th) {
            return errorMessage($th);
        }
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token,$user , $permissions)
    {
        return response()->json([
            "status" => true,
            "user" => $user,
            "permissions" => $permissions,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
