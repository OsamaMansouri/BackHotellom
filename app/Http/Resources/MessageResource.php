<?php

namespace App\Http\Resources;

use App\Models\Demmand;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
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
            'content'      => $this->content,
            'type'  => $this->type,
            'fromManager' => $this->fromManager,
            'demmand' => new DemmandResource($this->demmand),
            'user' => new UserApiResource($this->user)
        ];
    }
}
