<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use  App\Models\User;

class AuthController extends Controller
{


    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'refresh', 'logout']]);
    }
    /**
     * Get a JWT via given credentials.
     *
     * @param  Request  $request
     * @return Response
     */
    public function login(Request $request)
    {

        $this->validate($request, [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only(['email', 'password']);

        if (! $token = Auth::attempt($credentials)) {
//            return response()->json(['message' => 'You are Unauthorized'], 401);
            return  ['status' => '401', 'desc' =>'You are unauthorized'];

        }

        return $this->respondWithToken($token);
    }

    public function register(Request $request){

        if (strlen($request->email) < 8){
            return  ['status' => '406', 'desc' =>'Password Must be 8 characters or more'];
        }

//        if (User::where('email', '=', $request->email)->exists() OR User::where('phone', '=', $request->phone)->exists()){
        if (User::where('email', '=', $request->email)->exists()){
            return  ['status' => '406', 'desc' =>'User already exists'];
        }

        $this->validate($request, [
            'email' => 'required|string|email',
            'password' => 'required|string',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'state' => 'required|string',
            'city' => 'required|string',
            'address' => 'required|string',
            'phone' => 'required|Integer',
            'photo' => 'required|string',
            'country' => 'required|string',
            'role' => ['Integer','exists:user_roles,id'],
        ]);


        try {
            $us = new User();
            $us->first_name = $request->first_name;
            $us->last_name = $request->last_name;
            $us->email = $request->email;
            $us->password = app('hash')->make($request->password);
            $us->state = $request->state;
            $us->city = $request->city;
            $us->address = $request->address;
            $us->phone = $request->phone;
            $us->photo = $request->photo;
            $us->country = $request->country;

        } catch (\Exception $e){
            return ['status' => '500', 'desc' => $e->getMessage()];
        }

        if ($us->save()){
            $r = $this->login($request);
            return ['status' => 200, 'desc' => 'User Registered successfully', 'data'=> $r->original ];
        }

    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
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
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'user' => auth()->user(),
            'expires_in' => auth()->factory()->getTTL() * 600 * 24
        ]);
    }
}
