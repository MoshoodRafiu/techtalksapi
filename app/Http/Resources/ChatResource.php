<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ChatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'chatID' => $this->chatID,
            'sender' => $this->sender,
            'receiver' => $this->receiver,
            'message' => $this->message,
            'time' => date('h:i a', strtotime($this->time))
        ];
    }
}
