<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LabelCheckingRessource extends JsonResource
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
            'claim_id'=>$this->claim_id,
            'sorting_method'=>$this->sorting_method, 
            'bontaz_plant'=>$this->bontaz_plant
        ];
    }
}
