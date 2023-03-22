<?php

namespace App\Http\Resources\Api\Contacts;

use Illuminate\Http\Resources\Json\JsonResource;

class ContactsResource extends JsonResource
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
            'login' => $this->login,
            // 'firstName' => $this->firstName,
            'name' => $this->firstName.' '.$this->lastName,
            // 'lastName' => $this->lastName,
            'email' => $this->email,
            'phone' => $this->phone,
            'status' => $this->status,
            'avatar' => $this->avatarUrl,
        ];
    }
}
