<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FiveLigneRessource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'five_why_id'=>$this->five_why_id,
            'type'=>$this->type,
            'why'=>$this->why,
            'answer'=>$this->answer
        ];
    }
}
