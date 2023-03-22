<?php
namespace App\Http\Controllers\Api\Message;


use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Message\MessageRequest;
use App\Models\User;
use App\Models\Message;
use App\Events\SendMessage;

class MessageController extends Controller
{

    public function create(MessageRequest $request){
        $data = $request->validated();
        dd($data);    

        $message = Message::create($data);

        return response()->json([
            'message' => 'Message sended.',
        ]);
    }

}
