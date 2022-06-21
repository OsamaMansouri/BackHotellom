<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class DemmandResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $isEmpthy = $this->isEmpthy === 1 ? true : false;
        return [
            'id'        => $this->id,
            'name'      => $this->name,
            'sequence'  => $this->sequence,
            'icon'  => Storage::url($this->icon),
            'options'  => $this->demmandOptions,
            'isEmpthy' => $isEmpthy
            //'hotel_id'  => $this->hotel_id,
        ];
    }
}
