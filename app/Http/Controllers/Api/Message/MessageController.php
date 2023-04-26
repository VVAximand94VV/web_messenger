<?php
namespace App\Http\Controllers\Api\Message;


use App\Events\NewMessage;
use App\Events\UserTypes;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Message\MessageRequest;
use App\Models\Chat;
use App\Models\MessageFile;
use App\Models\User;
use App\Models\Message;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class MessageController extends Controller
{

    public function store(Chat $chat, MessageRequest $request){
        $data = $request->validated();

        if(isset($data['files']) && count($data['files'])>6){
            return response()->json([
                'message' => 'You cannot upload more than 6 files in one message.'
            ]);
        }

        $data['chatId'] = $chat->id;
        $users = [(int)$data['from'], (int)$data['to']];

        $result = $chat->whereHas('users', function($q) use($users){
            $q->where('userId', $users[0]);
        })->whereHas('users', function($q) use($users){
            $q->where('userId', $users[1]);
        })->first();

        if(empty($result)){
            return response()->json([
                'message' => 'Error! Unauthorized.'
            ], 401);
        }

        $message = Message::create($data);
        broadcast(new NewMessage($message, $message->chatId));

        // images uploads
        if(isset($data['files']) && $data['files']>0){
            $files = $data['files']; unset($data['files']);
            if(count($files)!=0){
                foreach($files as $file){
                    $fileName = md5(Carbon::now().$file->getClientOriginalName()).'.'.$file->getClientOriginalExtension();
                    $filePath = Storage::disk('public')->putFileAs('/messages/images', $file, $fileName);
                    $fileUrl = url('storage/'.$filePath);
                    MessageFile::create([
                        'messageId' => $message->id,
                        'userId' => $message->from,
                        'fileUrl' => $fileUrl,
                        'filePath' => $filePath,
                        'fileType' => $file->getClientOriginalExtension()
                    ]);
                }
            }
        }


        return response()->json([
            'message' => 'Message sent!',
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

    public function userTypes(Chat $chat, User $user){
        broadcast(new UserTypes($user->id));
    }

}
