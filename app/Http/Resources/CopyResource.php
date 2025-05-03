<?php

namespace App\Http\Resources; // Correct namespace for Resource

use Illuminate\Http\Resources\Json\JsonResource;

class CopyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id_exemplaire, // Use correct primary key
            'purchase_date' => $this->date_achat, // Use correct attribute name
            'status' => $this->etat_copy_liv, // Use correct attribute name
            'book_id' => $this->id_book,
            // Optionally load book information
            // 'book' => new BookResource($this->whenLoaded('book')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
