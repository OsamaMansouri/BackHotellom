<?php

namespace App\Http\Resources;

use App\Models\DemmandOption;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class DemmandUserResource extends JsonResource
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
            'message'      => $this->message,
            'status'  => $this->status,
            'demmand' => new DemmandResource($this->demmand),
            'option' => new DemmandOptionResource(DemmandOption::find($this->option_id)),
            'user' => new UserApiResource($this->user),
            'room' => new RoomResource($this->room),
            'done_by' => new UserApiResource(User::find($this->done_by))
        ];
    }
}
