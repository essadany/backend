<?php

namespace App\Observers;

use App\Models\Action;
use Carbon\Carbon;

class ActionObserver
{
    /**
     * Handle the Action "created" event.
     */
    public function created(Action $action): void
    {
        //
    }

    /**
     * Handle the Action "updated" event.
     */
    public function updating(Action $action)
    {
        $plannedDate = Carbon::parse($action->planned_date);
        $currentDate = Carbon::now();
        
        if ($plannedDate->isPast() && $action->status !== 'delayed') {
            $action->status = 'delayed';
        }
    }

    /**
     * Handle the Action "deleted" event.
     */
    public function deleted(Action $action): void
    {
        //
    }

    /**
     * Handle the Action "restored" event.
     */
    public function restored(Action $action): void
    {
        //
    }

    /**
     * Handle the Action "force deleted" event.
     */
    public function forceDeleted(Action $action): void
    {
        //
    }
}
