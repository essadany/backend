<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PPMRessource extends JsonResource
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
            'year'=>$this->year,
            'month'=>$this->month,
            'week'=>$this->week,
            'shipped_parts'=>$this->shipped_parts,
            'objectif'=>$this->objectif
        ];
    }
}
