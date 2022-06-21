<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HotelResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $temp = explode(' ',$this->updated_at);
        return [
            'id'        => $this->id,
            'user_id' => $this->user_id,
            'name' => $this->name,
            'country'  => $this->country,
            'city'     => $this->city,
            'address'      => $this->address,
            'status'      => $this->status,
            //'rooms'      => $this->rooms,
            'ice'      => $this->ice,
            'rib'      => $this->rib,
            'idf'      => $this->idf,
            'reference'      => $this->reference,
            'rc'      => $this->rc,
            'code'      => $this->code,
            'reason' => $this->reason,
            'comment' => $this->comment,
            'mesibo_uid' => $this->mesibo_uid,
            'mesibo_token' => $this->mesibo_token,
            //'categories'      => $this->categories,
            'last_update'      => $temp[0] . ' at ' . $temp[1]
        ];
    }
}
