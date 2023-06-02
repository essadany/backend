<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ActionRessource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return ['id'=>$this->id,
            'user_id'=>$this->user_id,
            'action'=>$this->action,
            'type'=>$this->type,
            'pilot'=>$this->pilot,
            'planned_date'=>$this->planned_date,
            'start_date'=>$this->start_date, 
            'status'=>$this->status, 
            'done_date'=>$this->done_date
        ];
    }
}
