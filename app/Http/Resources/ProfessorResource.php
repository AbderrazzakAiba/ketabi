<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfessorResource extends JsonResource
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
            'id' => $this->id_professor,
            'user' => new UserResource($this->user), // استخدم Resource للمستخدم المرتبط
            'affiliation' => $this->affiliation,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
