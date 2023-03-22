<?php


namespace App\Http\Controllers\Api\Auth;


use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\ForgotPasswordRequest;
use App\Mail\Api\Auth\PasswordResetMail;
use App\Models\PasswordReset;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{

    public function index(ForgotPasswordRequest $request){
        $data = $request->validated();
        $user = User::where('email', $data['email'])->first();
        if(!$user){
            return response()->json(['message'=>'User not found or invalid email.'], 422);
        }

        // create resetToken and add in password_resets table
        $resetToken = str_pad(random_int(1, 9), 6, '0', STR_PAD_LEFT);
        $userPasswordReset = PasswordReset::where('email', $user->email)->first();
        if(!$userPasswordReset){
            PasswordReset::create([
                'email' => $user->email,
                'token' => $resetToken,
            ]);
        }else{
            PasswordReset::update([
                'email' => $user->email,
                'token' => $resetToken,
            ]);
        }

        // send email message
        $userName = "{$user->firstName} {$user->lastName}";
        Mail::to($user->email)->send(new PasswordResetMail($resetToken, $userName));

        $response = [
            'message' => 'The code has been sent to the specified email.'
        ];
        return response()->json($response);
    }

}
