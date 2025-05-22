<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BorrowResource extends JsonResource
{
    /**
     * تحويل الموارد إلى مصفوفة من البيانات.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
   public function toArray($request)
{
  return [
        'id' => $this->id_pret, // استخدم id_pret بدلاً من id
        'id_pret' => $this->id_pret,
        'user_id' => $this->user_id,
        'copy_id' => $this->copy_id,
        'type' => $this->type,
        'borrowed_at' => $this->borrow_date ? $this->borrow_date->format('Y-m-d') : null,
        'due_date' => $this->due_date ? $this->due_date->format('Y-m-d') : null,
        'returned_at' => $this->return_date ? $this->return_date->format('Y-m-d') : null,
        'status' => $this->status,
        'user' => $this->user,
        'copy' => $this->copy,
        'book' => $this->copy && $this->copy->book
            ? $this->copy->book
            : $this->book,
        'duration' => $this->duration, // أضف هذا السطر
        'original_duration' => $this->original_duration, // أضف هذا السطر أيضاً إذا أردت
    ];
}
}
