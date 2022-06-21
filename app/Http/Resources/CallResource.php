<?php

namespace App\Http\Resources;

use App\Models\Conversation;
use Illuminate\Http\Resources\Json\JsonResource;

class CallResource extends JsonResource
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
            'room'  => new RoomResource($this->room),
            'user'      => new UserApiResource($this->user),
            'created_at' => $this->created_at,
            'status' => $this->status,
            'conversation' => Conversation::where('room_id', $this->room_id)->where('user_id', $this->user_id)->first()->value('id')
        ];
    }
}
