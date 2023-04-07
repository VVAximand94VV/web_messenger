<?php
namespace App\Http\Controllers\Api\Message;


use App\Events\NewMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Message\MessageRequest;
use App\Models\Chat;
use App\Models\User;
use App\Models\Message;

class MessageController extends Controller
{

    public function store(Chat $chat, MessageRequest $request){
        $data = $request->validated();

        $data['chatId'] = $chat->id;
        $users = [(int)$data['from'], (int)$data['to']];

        $result = $chat->whereHas('users', function($q) use($users){
            $q->where('userId', $users[0]);
        })->whereHas('users', function($q) use($users){
            $q->where('userId', $users[1]);
        })->first();

        if(empty($result)){
            return response()->json([
                'message' => 'Error! Unauthorize.'
            ], 401);
        }

        $message = Message::create($data);
        broadcast(new NewMessage($message))->toOthers();

        return response()->json([
            'message' => 'Message sended!',
        ]);
    }

    public function readMessages(Chat $chat, User $user){
        $unreadMessage = Message::where('isRead', '=', 0)->where('chatId', '=', $chat->id)->where('to', '=', $user->id)->get();

        if($unreadMessage->count() > 0){
            foreach($unreadMessage as $message){
                $message->isRead = 1;
                $message->save();
            }
        }

        return response()->json(['message' => 'All message read.']);

    }

}
