<?php

namespace App\Http\Resources\User;

use App\Models\Reading\Book;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DashboardResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            
            'userName' => $this->name,
            'userEmail' => $this->email,
            'studyBooksCount' => $this->studyNotes->count(),
            'userBooksCount' => $this->userBooks->count(),
            'studySummersCount' => $this->studyMaterials->where('type',2)->count(),
            'studyMiniBooksCount' => $this->studyMaterials->where('type',1)->count(),
            'userNotesCount' => $this->userNotes->count(),
            'userSnippetsCount' => $this->userSnippets->count(),
            'readingBooksCount' => Book::count(),


        ];
    }
}
