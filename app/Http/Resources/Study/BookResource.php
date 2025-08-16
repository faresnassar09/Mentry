<?php

namespace App\Http\Resources\Study;

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

            'status' => true,
            'id' => $this->id,
            'title' => $this->title,
            'path' => Storage::url($this->path),
            'last_read' => $this->last_read,



        ];
    }
}
