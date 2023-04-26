<?php


namespace App\Http\Controllers\Api\Contact;


use App\Http\Controllers\Controller;
//use App\Http\Resources\Api\Contacts\ContactsResource;
use App\Http\Requests\Api\Contact\SearchRequest;
use App\Http\Requests\Api\Contact\ToggleRequest;
use App\Http\Resources\Api\Profile\UserResource;
use App\Models\User;

use App\Http\Resources\Api\Contacts\ContactsResource;

class ContactController extends Controller
{

    public function index(User $user){
        //$contacts = User::all();
        $contacts = $user->contacts;
        //dd($contacts);
        return response()->json([
            'contacts' => ContactsResource::collection($contacts),
        ]);
    }

    public function search(User $user, SearchRequest $request){
        $data = $request->validated();
        $userName = $data['userName'];
        $users = User::where('login', 'like', "%$userName%")->orWhere('firstName', 'like', "%$userName%")->orWhere('lastName', 'like', "%$userName%")->get();
        return response()->json(['users' => ContactsResource::collection($users)]);
    }

    public function toggleContact(User $user, ToggleRequest $request){
        $data = $request->validated();
        $user->contacts()->toggle($data['contactId']);
        //dd($data);
        return response()->json([]);
    }

}
