<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RoomResource extends JsonResource
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
            'hotel_id' => $this->hotel_id,
            'room_number' => $this->room_number,
            'qrcode'     => $this->qrcode,
            //'hotel' => HotelResource::make($this->hotel)
        ];
    }
}
