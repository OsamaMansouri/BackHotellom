<?php

namespace App\Http\Resources;

use App\Models\Hotel;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class OffersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $status = 'active';
        $statusClass = 'success';
        if($this->startDate > date('Y-m-d H:i:s') || $this->endDate < date('Y-m-d H:i:s')){
            $status = 'inactive';
            $statusClass = 'warning';
        }
        $date = Carbon::now();
        return [
            'id' => $this->id,
            'titre' => $this->titre,
            'description' => $this->description,
            'type_id' => $this->type_id,
            'prix' => $this->prix,
            //'Frequency' => $this->Frequency,
            'startDate' => Carbon::parse($this->startDate)->format('Y-m-d'),
            'startTime' => $this->startTime,
            'endDate' => Carbon::parse($this->endDate)->format('Y-m-d'),
            //'image' => asset('storage/'.$this->image),
            'image' => Storage::url($this->image),
            'profit' => $this->profit,
            'discount' => $this->discount,
            'prixFinal' => $this->prixFinal,
            'status' => $status,
            'statusClass' => $statusClass,
            'orders' => $this->orders,
            //'hotel' => HotelResource::make($this->hotel),
            'type' => TypeResource::make($this->type),
            'hotel' => $this->hotel,
            'user' => $this->user
        ];
    }
}
