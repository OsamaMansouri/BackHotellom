<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\TypeResource;

class ShopResource extends JsonResource
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
            'id'            => $this->id,
            'hotel_id'      => $this->hotel_id,
            'name'          => $this->name,
            'type_id'       => $this->type_id,
            'color'         => $this->color,
            'pdf_file'      => Storage::url($this->pdf_file),
            'menu'          => $this->menu,
            'startTime'     => $this->startTime,
            'endTime'       => $this->endTime,
            'description'   => $this->description,
            'sequence'      => $this->sequence,
            'type'          => new TypeResource($this->type),
            'size'      => $this->size,
            //'isRoomService'      => $this->isRoomService
        ];
    }
}
