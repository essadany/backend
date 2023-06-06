<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SortingRessource extends JsonResource
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
            'containement_id'=>$this->containement_id,
            'location_company'=>$this->location_company,
            'qty_to_sort'=>$this->qty_to_sort,
            'qty_sorted'=>$this->qty_sorted,
            'qty_NOK'=>$this->qty_NOK,
            'scrap'=>$this->scrap
        ];
    }
}
