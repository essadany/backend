<?php

namespace App\Http\Controllers;
use App\Models\MeetingUser;
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
            'team_id'=>'required',
            'meet_id'=>'required',
            'present'=>'required',
            'comment'=>''
        ]);
        if($validator->fails()){
        return $this->sendError('Validation Error, make shure that all input required are not empty', $validator->errors());
        }
    $MeetingUser = MeetingUser::create($input);
    return response()->json([ 
        'success'=>true,
        'message'=> 'MeetingUser Record Created Successfully',
        'MeetingUser'=>$MeetingUser
    ]);
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
            $MeetingUser->team_id = $request->team_id;
            $MeetingUser->meet_id = $request->meet_id;
            $MeetingUser->present = $request->present;
            $MeetingUser->comment = $request->comment;
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
}
