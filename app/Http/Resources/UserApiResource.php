<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class UserApiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $image = $this->image == null ? null : Storage::url($this->image);
        return [
            'id'            => $this->id,
            'firstname'     => $this->firstname,
            'lastname'      => $this->lastname,
            'name'          => $this->name,
            'image'         => $image,
            'email'         => $this->email,
            'mesibo_uid'    => $this->mesibo_uid,
            'mesibo_token'  => $this->mesibo_token,
        ];
    }
}
