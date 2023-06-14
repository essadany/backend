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
        'customer_id' => $this->customer_id,
        'customer_ref' => $this->customer_ref,
        'name' => $this->name,
        'zone' => $this->zone,
        'uap' => $this->uap,
        'deleted'=>$this->deleted];
    }
}
