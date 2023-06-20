<?php

namespace App\Http\Controllers;
use App\Models\MeetingUser;
use App\Models\Meeting;
use App\Models\User;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class MeetingUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return MeetingUser::all();
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
        $input = $request->all();
        $validator = Validator::make($input,[
            'user_id'=>'required',
            'meeting_id'=>'required'
        ]);
        if($validator->fails()){
        return $this->sendError('Validation Error, make shure that all input required are not empty', $validator->errors());
        }
    // Check if the couple (user_id,meeting_id) exists in the table
    $meetingUser = MeetingUser::where('user_id', $input['user_id'])
                                 ->where('meeting_id', $input['meeting_id'])
                                 ->first();

    if ($meetingUser) {
        return response()->json([
            'success' => false,
            'message' => 'The user already exists in the table',
        ]);
    } else {
        // The couple (user_id,meeting_id) does not exist in the table, so we can add it
        $MeetingUser = MeetingUser::create($input);
        return response()->json([
            'success' => true,
            'message' => 'Absence Record Created Successfully',
            'MeetingUser' => $MeetingUser
        ]);
    }
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return MeetingUser::find($id);
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
        if(MeetingUser::where('id',$id)->exists()){
            $MeetingUser = MeetingUser::find($id);
            $MeetingUser->user_id = $request->user_id;
            $MeetingUser->meeting_id = $request->meeting_id;
            $MeetingUser->save();
            return response()->json([
                'message'=>'MeetingUser Record Updated Successfully'
            ],);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(MeetingUser::where("id",$id)->exists()){
            $MeetingUser = MeetingUser::find($id);
            $MeetingUser->delete();
            return response()->json([
                'message' => 'MeetingUser Record Deleted Successfully'
            ], 200);
        }else{
            return response()->json([
                'message' => 'MeetingUser Record Not Found'
            ],404);
        }
    }

   
    public function getAbsences()
    {
        $MeetingUser = DB::table('meeting_users')
        ->join('users', 'users.id', '=', 'meeting_users.user_id')
        ->select('meeting_users.id','meeting_users.user_id','users.name','meeting_users.meeting_id')
        ->get();
    return $MeetingUser;
        
        
    }
}
