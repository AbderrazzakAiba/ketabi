<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EditorResource extends JsonResource
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
            'id' => $this->id_editor,
            'name' => $this->name_ed,
            'address' => $this->adress_ed,
            'city' => $this->city_ed,
            'email' => $this->email_ed,
            'phone' => $this->tel_ed,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
