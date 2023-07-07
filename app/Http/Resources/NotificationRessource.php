<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationRessource extends JsonResource
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
            'action_id'=>$this->action_id ,
            'user_id'=>$this->user_id ,
            'message'=>$this->message ,
            'notification_date'=>$this->notification_date ,
            'read_at'=>$this->read_at 
        ];
    }
}
