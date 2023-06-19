<?php

namespace App\Http\Controllers;
use App\Models\TeamUser;
use App\Models\Team;
use App\Models\User;
use App\Models\Claim;

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
    //Disactivate Team_user
    public function disactivate(Request $request,$team_id,$user_id)
    {
    
       // Get the team and user from the database.
       $team = Team::find($team_id);
       $user = User::find($user_id);

      // Check if the user exists in the team.
      if ($team->users()->where('user_id', $user_id)->exists()) {
        // Update the `deleted` column in the `team_user` table.
        $team->users()->updateExistingPivot($user, ['deleted' =>true]);

        // Return a success response.
        return response()->json([
            'success' => true,
        ]);
    } else {
        // Return an error response.
        return response()->json([
            'error' => 'User does not exist in team',
        ]);
    }
    }   
   
    
    public function addUserToTeam(Request $request)
    {
       // Get the team and the user from the database by their IDs.
       $team = Team::find($request->team_id);
       $user = User::find($request->user_id);

       // Check if the user is already in the team.
       if (!$team->users->contains($user)) {
        // Add the user to the team.
        $team->users()->attach($user);

        // Redirect the user back to the team page.
        return response()->json([
            'message'=>' User Added successfuly to the team',
            'success' => true,
        ]);
        } else {
        // Redirect the user back to the team page with a message that the user is already in the team.
        return response()->json([
            'success' => false,
            'message' => 'The user is already in the team.',
        ]);
        }
   }

   public function addLeader(Request $request)
    {
       // Get the team and the user from the database by their IDs.
       $team = Team::find($request->team_id);
       $user = User::find($request->user_id);

       // Check if the user is already in the team.
       if (!$team->users->contains($user)) {
        // Add the user to the team.
        $team->users()->attach($user);
        $user->role= "leader";
        $user->save();

        // Redirect the user back to the team page.
        return response()->json([
            'message'=>' User Added successfuly to the team',
            'success' => true,
        ]);
        } else {
        // Redirect the user back to the team page with a message that the user is already in the team.
        return response()->json([
            'success' => false,
            'message' => 'The user is already in the team.',
        ]);
        }
   }
  
    
}
