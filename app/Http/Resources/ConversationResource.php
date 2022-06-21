<?php

namespace App\Http\Resources;

use App\Models\Message;
use Illuminate\Http\Resources\Json\JsonResource;

class ConversationResource extends JsonResource
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
            'id'        => $this->id,
            'room' => new RoomResource($this->room),
            'lastMsg' => new MessageApiResource(Message::find($this->lastMsg)),
            'user' => new UserApiResource($this->user),
            'status' => $this->status
        ];
    }
}
