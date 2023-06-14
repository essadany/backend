<?php

namespace App\Http\Controllers;
use App\Models\TeamUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class TeamUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return TeamUser::all();
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
        ]);
        if($validator->fails()){
        return $this->sendError('Validation Error, make shure that all input required are not empty', $validator->errors());
        }
    $TeamUser = TeamUser::create($input);
    return response()->json([ 
        'success'=>true,
        'message'=> 'TeamUser Record Created Successfully',
        'TeamUser'=>$TeamUser
    ]);
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return TeamUser::find($id);
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
        if(TeamUser::where('id',$id)->exists()){
            $TeamUser = TeamUser::find($id);
            $TeamUser->user_id = $request->user_id;
            $TeamUser->team_id = $request->team_id;
            $TeamUser->save();
            return response()->json([
                'message'=>'TeamUser Record Updated Successfully'
            ],);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(TeamUser::where("id",$id)->exists()){
            $TeamUser = TeamUser::find($id);
            $TeamUser->delete();
            return response()->json([
                'message' => 'TeamUser Record Deleted Successfully'
            ], 200);
        }else{
            return response()->json([
                'message' => 'TeamUser Record Not Found'
            ],404);
        }
    }
}