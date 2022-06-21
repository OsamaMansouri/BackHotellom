<?php

namespace App\Http\Resources;

use App\Models\Article;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Resources\Json\JsonResource;

class CommandResource extends JsonResource
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
            'user_id'        => $this->user_id,
            'status'     => $this->status,
            'user' => $this->user,
            'articles'  => $this->articles,
            'created_at' => $this->created_at
        ];
    }
}
