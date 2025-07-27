<?php

namespace App\Http\Resources\Writing;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NoteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            
            "id" => $this->id,
            "related_book" => $this->writingBook->title ??null,
            "content" => $this->content,
            "created_at" => $this->created_at,
        ];
    }
}
