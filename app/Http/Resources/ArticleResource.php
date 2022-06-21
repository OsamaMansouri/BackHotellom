<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\CategoryResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return  [
        'id'            => $this->id,
        'category_id'   => $this->category_id,
        'name'          => $this->name,
        'image'      => Storage::url($this->image),
        //'image'         => asset('storage/'.$this->image),
        'description'   => $this->description,
        'price'         => $this->price,
        'cost'          => $this->cost,
        'profit'        => $this->profit,
        'max_options'   => $this->max_options,
        'rating'        => $this->rating,
        'options'       => OptionResource::collection($this->options),
        'category'      => new CategoryResource($this->category)
        ];
    }
}
