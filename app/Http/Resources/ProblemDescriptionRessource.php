<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProblemDescriptionRessource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'claim_id'=>$this->claim_id,
             'what'=>$this->what,
             'where'=>$this->where,
             'who'=>$this->who,
             'when'=>$this->when,
             'why'=>$this->why,
             'how'=>$this->how,
             'how_many_before'=>$this->how_many_before,
            'how_many_after'=>$this->how_many_after,
             'recurrence'=>$this->recurrence,
             'received'=>$this->received,
             'date_reception'=>$this->date_reception,
             'date_done'=>$this->date_done,
             'due_date'=>$this->due_date,
             'bontaz_fault'=>$this->bontaz_fault,
             'description'=>$this->description
        ];
    }
}
