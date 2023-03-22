<?php


namespace App\Http\Controllers\Api\Auth;


use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\VerifyMailRequest;
use App\Mail\Api\Auth\VerifyMail;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class VerificationController extends Controller
{

    use VerifiesEmails;

//    public function sendVerificationEmail($email){
//        $user = User::where('email', $email)->first();
//        if(!$user){
//            return response()->json(['message'=>'User not found.'], 404);
//        }
//
//        if($user->hasVerifiedEmail()){
//            return response()->json(['message'=>'Email already verified.']);
//        }
//        $id = 1;
//
//        $hash = '11111111';
//        Mail::to($user->email)->send(new VerifyMail($user->login, $id, $hash));
//
//        return response()->json(['message'=>'Verification mail send.']);
//    }

    public function verify($id, $hash)
    {
        $user = User::where('id', $id)->first();
        if($user && $user->hasVerifiedEmail()){
            return redirect('/email/verified');
        }
        if(!Hash::check($hash, $user->verified_token)){
            return redirect('/email/error');
        }

        $user->markEmailAsVerified();
        return redirect('/email/verified');
    }

    public function resend(VerifyMailRequest $request)
    {
        $data = $request->validated();
        $user = User::where('email', $data['email'])->first();
        if($user && $user->hasVerifiedEmail()){
            return response()->json(['message'=>'Email already verified.']);
        }
        $hash = Str::random(64);
        $user->verified_token = Hash::make($hash);
        $user->updated();
        // send new mail
        Mail::to($user->email)->send(new VerifyMail($user->login, $user->id, $hash));

        return response()->json(['message' => 'New email verification link send on your email address.']);
    }

}
