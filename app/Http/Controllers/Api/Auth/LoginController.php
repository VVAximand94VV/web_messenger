<?php


namespace App\Http\Controllers\Api\Auth;


use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\Api\Profile\UserResource;

class LoginController extends Controller
{

    public function index(LoginRequest $request)
    {
        $data = $request->validated();
        $user = User::where('email', $data['email'])->first();

        if(!$user){
            return response()->json(['message' => 'User not found!'], 404);
        }
        if(!Hash::check($data['password'], $user->password)){
            return response()->json(['message' => 'Wrong password.'], 422);
        }

        $token = $user->createToken('authToken')->plainTextToken;

        $response = [
            'message' => 'Login in!',
            'userInfo' => new UserResource($user),
            'token' => $token,
        ];
        return response()->json($response);
    }

}
