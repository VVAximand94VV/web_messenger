<?php


namespace App\Http\Controllers\Api\Contact;


use App\Http\Controllers\Controller;
//use App\Http\Resources\Api\Contacts\ContactsResource;
use App\Http\Requests\Api\Contact\SearchRequest;
use App\Http\Resources\Api\Profile\UserResource;
use App\Models\User;

use App\Http\Resources\Api\Contacts\ContactsResource;

class ContactController extends Controller
{

    public function index(User $user){
        $contacts = User::all();

        return response()->json([
            'contacts' => ContactsResource::collection($contacts),
        ]);
    }

    public function search(SearchRequest $request){
        $data = $request->validated();
        $userName = $data['userName'];
        $users = User::where('login', 'like', "%$userName%")->orWhere('firstName', 'like', "%$userName%")->orWhere('lastName', 'like', "%$userName%")->get();
        return response()->json(['users' => ContactsResource::collection($users)]);
    }

}
