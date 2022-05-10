<?php
declare(strict_types=1);
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
class AuthController extends Controller
{
    public function postRegister(Request $request): JsonResponse
    {
        $args = $request->validate([
            'name' => 'required|string|min:3',
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        $args['password'] = Hash::make($args['password']);
        try{
            $user = new User($args);
            $user->save();
        } catch (\Exception $e) {
            return Response::json([
                'message' => 'Problem creating user',
            ], 500);
        }
        return  Response::json([
            'message' => 'User registered successfully',
        ]);
    }
    public function postLogin(Request $request): JsonResponse {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if(!Auth::attempt($credentials)) {
            return Response::json([
                'message' => 'Credentials do not match any user',
            ], 401);
        }
        return Response::json([
            'message' => 'Login successful',
            'token' => Auth::user()->createToken('Api Token')->plainTextToken,
        ]);
    }

    public function postLogout(Request $request): JsonResponse
    {
        Auth::user()->tokens->delete();
        
        return Response::json([
            'message' => 'Logout succesful',
        ]);
    }
}