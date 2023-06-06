<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryRessource extends JsonResource
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
            'ishikawa_id'=>$this->ishikawa_id,
            'type'=>$this->type,
            'input'=>$this->input,
            'isPrincipale'=>$this->isPrincipale,
            'status'=>$this->status,
            'influence'=>$this->influence,
            'comment'=>$this->comment
        ];
    }
}
