<?php

namespace App\Http\Resources\Api\Message;

use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'chatId' => $this->chatId,
            'from' => $this->from,
            'to' => $this->to,
            'message' => $this->message,
            'isRead' => $this->isRead,
            'created' => $this->created_at,
            'updated' => $this->updated_at,
            'sender' => $this->sender,
            'files' => $this->files,
        ];
    }
}
