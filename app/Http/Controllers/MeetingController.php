<?php

namespace App\Http\Controllers;
use App\Models\Meeting;
use App\Models\Claim;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Mail\MeetingEmail;
use Illuminate\Support\Facades\Mail;
class MeetingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Meeting::all();
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
    public function store(Request $request, $claim_id)
    {
        $claim = Claim::find($claim_id);
        $team_id = $claim->team->id;
        $input = $request->all();
        $input['team_id'] = $team_id;
        $validator = Validator::make($input, [
            'type' => 'required',
            'date' => 'required',
            'hour' => 'required',
            'comment' => '',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error, make sure that all input required are not empty', $validator->errors());
        }
        $meeting = Meeting::create($input);
        $users = $meeting->team->users()->get();
         //Send Email ------------------
         foreach($users as $user){
            $email = $user->email;
            $mailSubject = "A New Meeting is scheduled on the ". $meeting->date;
            $mailData = [
            'title' => 'Meeting type :  '.$meeting->type,
            'body' => 'A New Meeting is scheduled on the  ' .  $meeting->date. ' at : ' . $meeting->hour .
            ' The meeting is about Claim with intern Reference : ' . $claim->internal_ID . 
            ' Comment : '.$meeting->comment ,

            ];
            Mail::to($email)->send(new MeetingEmail($mailData,$mailSubject));
         }
        
         
        return response()->json([
            'success' => true,
            'message' => 'Meeting Record Created Successfully',
            'meeting' => $meeting
        ]);
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Meeting::find($id);
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
    public function update(Request $request, $id)
    {
        if(Meeting::where('id',$id)->exists()){
            $meeting = Meeting::find($id);
            $meeting->type = $request->type;
            $meeting->date = $request->date;
            $meeting->hour = $request->hour;
            $meeting->comment = $request->comment;
            $meeting->save();
            return response()->json([
                'message'=>'Meeting Record Updated Successfully'
            ],);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(Meeting::where("id",$id)->exists()){
            $meeting = Meeting::find($id);
            $meeting->delete();
            return response()->json([
                'message' => 'Meeting Record Deleted Successfully'
            ], 200);
        }else{
            return response()->json([
                'message' => 'Meeting Record Not Found'
            ],404);
        }
    }
    //Disactivate Meeting
    public function disactivate(Request $request, $id)
    {
        if(Meeting::where('id',$id)->exists()){
            $Meeting = Meeting::find($id);
            $Meeting->deleted = true;
            
            $Meeting->save();
            return response()->json([
                'message'=>'Meeting Record Disactivated Successfully'
            ],);
        }
    }
    //Get Activated Meetings
    public function getActivatedMeetings(){
        $Meetings = DB::table('meetings')
            ->where('meetings.deleted',false)
            ->select( 'meetings.*')
            ->get();
        return $Meetings;
    }
}
