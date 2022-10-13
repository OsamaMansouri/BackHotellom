<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RequestHotelResource extends JsonResource
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
            'hotel_id'      => $this->hotel_id,
            'demmand_id'  => $this->demmand_id,
            'hotel_id'         => $this->hotel_id,
            'demmand' => $this->demmand
        ];
    }
}
