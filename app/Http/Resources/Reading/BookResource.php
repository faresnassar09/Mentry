<?php

namespace App\Http\Resources\Reading;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class BookResource extends JsonResource
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
            "category" => $this->category->name,
            "title" => $this->title,
            "author" => $this->author,
            "cover_path" => Storage::url($this->cover_path),
            "book_path" => Storage::url($this->book_path),
            "description" => $this->description,
            "pages" => $this->pages,  

        ];
    }
}
