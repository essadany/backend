<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReportRessource extends JsonResource
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
            'report_ref'=>$this->report_ref,
            'due_date'=>$this->due_date,
            'sub_date'=>$this->sub_date,
            'containement_actions'=>$this->containement_actions,
            'first_batch3'=>$this->first_batch3,
            'first_batch6'=>$this->first_batch6,
            'date_cause_definition'=>$this->date_cause_definition,
            'reported_by'=>$this->reported_by,
            'pilot'=>$this->pilot,
            'ddm'=>$this->ddm,
            'approved'=>$this->approved,
            'others'=>$this->others,
            'ctrl_plan'=>$this->ctrl_plan,
            'pfmea'=>$this->pfmea,
            'dfmea'=>$this->dfmea,
            'progress_rate'=>$this->progress_rate
        ];
    }
}
