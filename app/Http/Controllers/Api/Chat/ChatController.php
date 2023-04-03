<?php
namespace App\Http\Controllers\Api\Chat;


use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Chat\CreateChatRequest;
use App\Http\Resources\Api\Chat\ChatResource;
use App\Models\Chat;
use App\Models\User;
use App\Http\Resources\Api\Message\MessageResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class ChatController extends Controller
{

    public function index(User $user){

        $chats = Chat::whereHas('users', function($b) use($user){
            $b->where('userId',$user->id);
        })->get();

        foreach ($chats as $elem){
            $elem->contacts = $elem->users->where('id', '!=', $user->id);
            $elem->unreadMessages = $elem->messages->where('isRead', '=', 0)->where('to', '=', $user->id)->count();
        }

        //dd($chats[0]);
        return response()->json([
            'chats' => ChatResource::collection($chats),
        ]);
    }

    public function store(User $user, CreateChatRequest $request){
        $recipient = User::where('id', $request['recipientId'])->first();
        $users = [$user->id, $recipient->id];

        $chat = Chat::where('type', 0)->whereHas('users', function($q) use($users){
            $q->where('userId', $users[0]);
        })->whereHas('users', function($q) use($users){
            $q->where('userId', $users[1]);
        })->first();

        if(!empty($chat)){
            return response()->json([
                'message' => 'Chat is exists!',
                'chat' => $chat,
            ]);
        }

        $chat = Chat::create([
            'type' => 0,
        ]);
        $chat->users()->toggle($users);

        return response()->json([
            'message' => 'Chat created!',
            'chat'    => $chat
        ]);
    }

    public function show(User $user, Chat $chat){
        $result = $chat->users->whereIn('id', $user->id)->first();
        if(empty($result)){
            return response()->json([
                'message' => 'Chat not found.',
            ]);
        }

        foreach($chat->users as $chatUser){
            if($chatUser->id != $user->id) $contacts = $chatUser;
        }

        return response()->json([
            'chat' => new ChatResource($chat),
            'messages' => MessageResource::collection($chat->messages),
            'contacts' => $contacts,
        ]);
    }

    public function remove(){
        return response()->json(['message' => 'Chat removed.']);
    }

}
