<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductRessource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return ['id'=>$this->id,
        'product_ref' => $this->product_ref,
        'customer_code' => $this->customer_code,
        'name' => $this->name,
        'zone' => $this->zone,
        'deleted'=>$this->deleted];
    }
}
