<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class GeneralSettingsResource extends JsonResource
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
            'logo'      => Storage::url($this->logo),
            //'logo' => asset('storage/'.$this->logo),
            'licence_days'  => $this->licence_days,
            'tax' => $this->tax,
            'timer' =>  $this->timer

        ];
    }
}
