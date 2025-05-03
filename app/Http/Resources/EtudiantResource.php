<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EtudiantResource extends JsonResource
{
    /**
     * تحويل النموذج إلى مصفوفة بيانات.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id, // أو `id_etudiant` حسب ما هو في قاعدة البيانات
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'level' => $this->level,
            'academic_year' => $this->academic_year,
            'speciality' => $this->speciality,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
