<?php

namespace App\Http\Controllers;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Team::all();
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
            'claim_id'=>'required',
            'leader'=>'required',
        ]);
        if($validator->fails()){
        return $this->sendError('Validation Error, make shure that all input required are not empty', $validator->errors());
        }
    $Team = Team::create($input);
    return response()->json([ 
        'success'=>true,
        'message'=> 'Team Record Created Successfully',
        'Team'=>$Team
    ]);
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Team::find($id);
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
        if(Team::where('id',$id)->exists()){
            $Team = Team::find($id);
            $Team->leader = $request->leader;
            $Team->save();
            return response()->json([
                'message'=>'Team Record Updated Successfully'
            ],);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(Team::where("id",$id)->exists()){
            $Team = Team::find($id);
            $Team->delete();
            return response()->json([
                'message' => 'Team Record Deleted Successfully'
            ], 200);
        }else{
            return response()->json([
                'message' => 'Team Record Not Found'
            ],404);
        }
    }
    
    public function getUsersByTeam($id){
        $team = Team::find($id);
        $users = $team->users;
        return response()->json($users);
    }

    public function addUsers(Team $team, User $user)
    {
        $team->users()->attach($user);
        return response()->json(['message' => 'User added to the team successfully']);
    }

}
