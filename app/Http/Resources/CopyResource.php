<?php

namespace App\Http\Resources; // Correct namespace for Resource

namespace App\Http\Resources;

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
            'id' => $this->id_exemplaire,
            'book_id' => $this->id_book,
            'status' => $this->etat_copy_liv,
            'book' => new BookResource($this->whenLoaded('book')),
        ];
    }
}
