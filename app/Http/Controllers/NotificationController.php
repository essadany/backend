<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Action;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;
class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Get actions with 'not started' or 'on going' status
        /*$actions = Action::whereIn('status', ['not started', 'on going'])->get();

        // Get the current date
        $currentDate = Carbon::now();

        foreach ($actions as $action) {
            // Calculate the difference between the current date and the planned date
            $plannedDate = Carbon::parse($action->planned_date);
            $differenceInDays = $currentDate->diffInDays($plannedDate);

            if ($action->status === 'on going' && $differenceInDays === 1) {
                // Create a notification
                $notification = new Notification();
                $notification->action_id = $action->id;
                $notification->message = 'Your action "' . $action->action . '" is due tomorrow.';
                $notification->save();
            }
            if ($action->status === 'not started') {
                // Create a notification
                $notification = new Notification();
                $notification->action_id = $action->id;
                $notification->message = ' "'.$action->created_at .'" : New action To Do before "' . $action->planned_date .'" ';
                $notification->save();
            }
        }*/

        // You can perform additional actions or return a response if needed
    
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if(Action::where('id',$id)->exists()){
            $action = Action::find($id);
            $Notification = $action->notification;
            $notification->message = $request->message;
            $notification->save();
            return response()->json([
                'message'=>'Notification Record Updated Successfully'
            ],);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(Action::where("id",$id)->exists()){
            $action = Action::find($id);
            $Notification = $action->notification;
            $Notification->delete();
            return response()->json([
                'message' => 'Notification Record Deleted Successfully'
            ], 200);
        }else{
            return response()->json([
                'message' => 'Notification Record Not Found'
            ],404);
        }
    }
    public function getNotificationsOfUser($user_id){
        $user = User :: find($user_id);
        $notifications = $user->notifications()->get();
        return response()->json($notifications);
    }
    public function getNumberOfNotifications($user_id){
        $numberOfNotifications = DB::table('notifications')
            ->where('notifications.user_id', $user_id)
            ->count();
    
        return $numberOfNotifications;
    }
    public function getNotificationOfAction($action_id){
        $action = Action :: find($action_id);
        $notification = $action->notification;
        return response()->json($notification);
    }
}
