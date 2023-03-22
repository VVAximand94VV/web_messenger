<?php


namespace App\Http\Controllers\Api\Auth;


use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Http\Resources\Api\Profile\UserResource;
use App\Mail\Api\Auth\VerifyMail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;


class RegisterController extends Controller
{

    public function index(RegisterRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);
        $hash = Str::random(64);
        $data['verified_token'] = Hash::make($hash);

        $user = User::firstOrCreate(['login'=>$data['login']],$data);
        $token = $user->createToken('authToken')->plainTextToken;
        // email verification
        //$hash = $data['verified_token'];
//        $res = Hash::check($hash, $user->verified_token);
//        $res2 = $hash==$user->verified_token ? 'Yes': 'No';
//        dd($data, $user, $user->id, $hash, $user->verified_token,$res,$res2, $token);
        Mail::to($user->email)->send(new VerifyMail($user->login, $user->id, $hash));

        $response = [
            'message' => 'Registration successfully! Email verification link send on your email address.',
            'userInfo' => new UserResource($user),
            'token' => $token,
        ];

        return response()->json($response);
    }

}
