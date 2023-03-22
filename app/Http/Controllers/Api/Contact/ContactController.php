<?php


namespace App\Http\Controllers\Api\Contact;


use App\Http\Controllers\Controller;
//use App\Http\Resources\Api\Contacts\ContactsResource;
use App\Models\User;

use App\Http\Resources\Api\Contacts\ContactsResource;

class ContactController extends Controller
{

    public function index(User $user){
        //$contacts = $user->contacts();
        $contacts = User::all();

        return response()->json([
            'contacts' => ContactsResource::collection($contacts),
            //'contacts' => $contacts
        ]);
    }

}
