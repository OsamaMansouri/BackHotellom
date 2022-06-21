<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommandOfferResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return  [
            'id'            => $this->id,
            'total'        => $this->total,
            'comment'   => $this->comment,
            'quantity'  => $this->quantity,
            'orderStatus' => $this->orderStatus,
            'created_at' => $this->created_at,
            'offer'      => new OfferApiResource($this->offer),
            'user'      => new UserApiResource($this->user),
            'room'      => new RoomResource($this->room)
            ];
    }
}
