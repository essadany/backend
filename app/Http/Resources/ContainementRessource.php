<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContainementRessource extends JsonResource
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
            'method_description'=>$this->method_description,
            'method_validation'=>$this->method_validation,
            'risk_assesment'=>$this->risk_assesment,
        ];
    }
}
