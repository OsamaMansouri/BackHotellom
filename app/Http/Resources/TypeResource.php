<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class TypeResource extends JsonResource
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
            //'hotel_id'  => $this->hotel_id,
            'name'      => $this->name,
            'gold_img'      => Storage::url($this->gold_img),
            'purple_img'      => Storage::url($this->purple_img),
            //'gold_img'      => asset('storage/'.$this->gold_img),
            //'purple_img'      => asset('storage/'.$this->purple_img),
        ];
    }
}
