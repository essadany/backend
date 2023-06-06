<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ImageRessource extends JsonResource
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
            'annexe_id'=>$this->annexe_id,
            'label_check_id'=>$this->label_check_id,
            'name'=>$this->name,
            'type'=>$this->type,
            'bloob'=>$this->bloob,
            'isGood'=>$this->isGood,
            'description'=>$this->description,
        ];
    }
}
