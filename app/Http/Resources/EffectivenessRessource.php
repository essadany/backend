<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EffectivenessRessource extends JsonResource
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
            'report_id'=>$this->report_id,
            'title'=>$this->title,
            'file'=>$this->file,
            'description'=>$this->descritption
        ];
    }
}
