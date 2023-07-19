<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MeetingRessource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'team_id'=>$this->team_id,
            'type'=>$this->type,
            'date'=>$this->date,
            'hour'=>$this->hour,
            'comment'=>$this->comment,
            'deleted'=>$this->deleted
        ];
    }
}
