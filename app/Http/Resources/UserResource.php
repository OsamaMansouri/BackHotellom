<?php

namespace App\Http\Resources;

use App\Models\User;
use App\Http\Resources\PermissionResource;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class UserResource extends JsonResource
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
        //$logo = 'https://api.hotellom.com/img/'.$this->hotel->general_setting->logo;
        return [
            'id'            => $this->id,
            'firstname'     => $this->firstname,
            'lastname'      => $this->lastname,
            'name'          => $this->name,
            'email'         => $this->email,
            'phone_number'  => $this->phone_number,
            'image'         => $image,
            'city'      => $this->city,
            'country'      => $this->country,
            'function'      => $this->function,
            'gender'      => $this->gender,
            'nationality'      => $this->nationality,
            'dateNaissance'      => $this->dateNaissance,
            //'logo'          => $logo,
            'hotel'         => $this->hotel,
            'hotel_id'         => $this->hotel_id,
            'social_id'     => $this->social_id,
            'roles'         => $this->roles,
            'mesibo_uid'    => $this->mesibo_uid,
            'mesibo_token'  => $this->mesibo_token,
            'experation_date' => $this->experation_date,
            'etat' => $this->etat,
            'del' => $this->del,
            'ability'       => PermissionResource::collection($this->whenLoaded('permissions', $this->getDirectPermissions())),
            'deviceToken' => $this->deviceToken,
            'is_manager'  => $this->is_manager,
        ];
    }
}
