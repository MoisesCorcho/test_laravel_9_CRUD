<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Requests\Auth\LoginRequest;
use Tymon\JWTAuth\Token;

use App\Http\Controllers\BaseController;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class AuthController extends BaseController
{
    public function __construct()
    {
        $this->middleware('jwt.verify', ['except' => ['login', 'register']]);
    }


    public function register(Request $request)
    {

        $this->validate($request, [
            'name'      => 'required|max:255',
            'email'     => 'required|email|unique:users',
            'password'  => 'required|min:8'
        ]);

        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password)
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json([
            'message' => 'success',
            'token'   => $token,
            'data'    => $user
        ], 200);
    }


    public function login(LoginRequest $request)
    {
        $credentials = request(['email', 'password']);

        try {
            if (!$token = auth()->attempt($credentials)) {
                return $this->errorResponse(
                    401,
                    'Credenciales invalidas'
                );
            }
        } catch (TokenInvalidException $e) {
            return $this->errorResponse(
                404,
                'Error al crear el token de sesion'
            );
        }

        return $this->sendResponse(
            $this->respondWithToken($token),
            200,
            'Sesion iniciada correctamente'
        );

    }


    public function me()
    {
        try {
            if(!$user = JWTAuth::parseToken()->authenticate()){
                return $this->errorResponse(
                    404,
                    'Usuario no encontrado',
                    [
                        'error' => 'user_not_found'
                    ]
                );
            }
        } catch (TokenExpiredException $e) {
            return $this->errorResponse(
                404,
                'Token expirado',
                [
                    'error' => 'token_expired'
                ]
            );
        } catch (TokenInvalidException $e) {
            return dd($this->errorResponse(
                404,
                'Token innvalido',
                [
                    'error' => 'token_invalid'
                ]
            ));
        } catch (JWTException $e) {
            return $this->errorResponse(
                404,
                'Token ausente',
                [
                    'error' => 'token_absent'
                ]
            );
        }

        return $this->sendResponse(
            $this->respondWithToken((string) auth()->getToken()),
            200,
            'Usuario encontrado satisfactoriamente'
        );
    }


    public function logout()
    {
        auth()->logout();

        return $this->sendResponse(
            [],
            200,
            'Sesión cerrada con exito'
        );
    }


    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    protected function respondWithToken($token)
    {
        return [
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => auth()->factory()->getTTL(),
            'user'         => auth()->user(),
            'roles'        => auth()->user()->getRoleNames()
        ];
    }

}
