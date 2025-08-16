<?php

namespace App\Http\Resources\Study;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ScheduleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        
        return [
            'id' => $this->id,
            'items' => $this->items->map(function ($item) {
                return [
                    'taskName' => $item->task,
                    'taskEndsAt' => $item->ends_at,
                    'taskCreatedAt' => $item->created_at,
                ];
            }),
        ];
    }
    }

