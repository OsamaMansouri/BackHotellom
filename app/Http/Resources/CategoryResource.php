<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class CategoryResource extends JsonResource
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
            'hotel_id'  => $this->hotel_id,
            'name'      => $this->name,
            'icon'      => Storage::url($this->icon),
            //'icon'      => asset('storage/'.$this->icon),
            'startTime' => date('H:i', strtotime($this->startTime)),
            'endTime'   => date('H:i', strtotime($this->endTime)),
            'Sequence'  => $this->Sequence,
        ];
    }
}
