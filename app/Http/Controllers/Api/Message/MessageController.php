<?php
namespace App\Http\Controllers\Api\Message;


use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Message\MessageRequest;
use App\Models\Chat;
use App\Models\User;
use App\Models\Message;
use App\Events\SendMessage;

class MessageController extends Controller
{

    public function store(Chat $chat, MessageRequest $request){
        $data = $request->validated();
        //dd($data, $chat);   
        $data['chatId'] = $chat->id;

        //dd($data);
        $users = [(int)$data['from'], (int)$data['to']];

        //dd($chat->users);
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

        //dd($result);

        $message = Message::create($data);

        return response()->json([
            'message' => 'Message sended!',
        ]);
    }

}
