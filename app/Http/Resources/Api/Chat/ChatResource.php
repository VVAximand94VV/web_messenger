<?php

namespace App\Http\Resources\Api\Chat;

use App\Http\Resources\Api\Message\MessageResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatResource extends JsonResource
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
            'type' => $this->type,
            'messages' => MessageResource::collection($this->messages),
            'users' => $this->users,
            //'contactInfo' => $this->contactInfo,
        ];
    }
}
