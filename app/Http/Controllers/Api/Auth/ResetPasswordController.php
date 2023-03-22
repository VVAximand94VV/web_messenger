<?php


namespace App\Http\Controllers\Api\Auth;


use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\PasswordResetRequest;
use App\Models\PasswordReset;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{

    public function index(PasswordResetRequest $request){
        $data = $request->validated();
        $user = User::where('email', $data['email'])->first();

        if(!$user){
            return response()->json(['message' => 'User not found or invalid email.'], 401);
        }

        // if tokens !=
        $userPasswordReset = PasswordReset::where('email', $user->email)->first();
        if($userPasswordReset && ($userPasswordReset->token != $data['token'])){
            return response()->json(['message' => 'Error! Token mismatch.'], 401);
        }

        // new password
        $password = Hash::make($data['password']);
        $user->update([
            'password' => $password
        ]);
        // deletes all tokens
        $user->tokens()->delete();
        $userPasswordReset->delete();

        $response = [
            'message' => 'Password reset!',
        ];
        return response()->json($response);
    }

}
