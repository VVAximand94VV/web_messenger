<?php


namespace App\Http\Controllers\Api\Profile;


use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Requests\Api\Profile\AvatarRequest;
use App\Http\Requests\Api\Profile\ProfileRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\Api\Profile\UserResource;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{

    public function update(User $user, ProfileRequest $request)
    {
        $data = $request->validated();

        $key = key($data);

//        foreach($data as $key=>$value){
//            $user->$key = $value;
//        }

        $user->$key = $data[$key];
        if($user->update()){
            return response()->json([
                'message' => 'Profile updated!',
                'userInfo' => new UserResource($user),
            ]);
        }else{
            return response()->json(['message' => 'Error.'], 500);
        }
    }

    public function userInfo(User $user){
        return response()->json([
            'userInfo' => new UserResource($user)
        ]);
    }


    public function editAvatar(User $user, AvatarRequest $request){
        $data = $request->validated();

        // if avatar isset
        if($user->avatarPath !== null && $user->avatarUrl !== null){
            if(Storage::disk('public')->exists($user->avatarPath)){
                Storage::disk('public')->delete($user->avatarPath);
            }
        }

        $imageName = md5(Carbon::now() . '_' . $data['avatar']->getClientOriginalName()) . '.' . $data['avatar']->getClientOriginalExtension();
        $imagePath = Storage::disk('public')->putFileAs('/users/images/avatars', $data['avatar'], $imageName);

        $user->avatarPath = $imagePath;
        $user->avatarUrl = url('/storage/' . $imagePath);
        $user->update();

        return response()->json([
            'userInfo' => new UserResource($user),
            'message' => 'Avatar uploaded.'
        ]);
    }

}
