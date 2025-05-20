<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderLivResource extends JsonResource
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
            'id' => $this->id_demande,
            'user' => $this->user ? [
                'id' => $this->user->id_User,
                'name' => $this->user->name,
            ] : null,
            'title' => $this->title,
            'auteur' => $this->auteur,
            'category' => $this->category,
            'order_date' => $this->order_date,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
