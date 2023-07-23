<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ClaimRessource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return ['id'=>$this->id,
        'internal_ID' => $this->internal_ID,
        'refRecClient' => $this->refRecClient,
        'category' => $this->category,
        'customer' => $this->customer,
        'customer_part_number' => $this->customer_part_number,
        'product_ref' => $this->product_ref,
        'engraving' => $this->engraving,
        'prod_date' => $this->prod_date,
        'object' => $this->object,
        'opening_date' => $this->opening_date,
        'claim_details' => $this->claim_details,
        'def_mode' => $this->def_mode,
        'nbr_claimed_parts' => $this->nbr_claimed_parts,
        'status'=>$this->status,
        'deleted'=>$this->deleted
    ];
    }
}
