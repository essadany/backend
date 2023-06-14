<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\SessionGuard;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class UserController extends Controller
{

   

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return User::all();
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
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'phone' => '',
            'fonction' => 'required',
            'role' => 'required'
        ]);
        if($validator->fails()){
        return $this->sendError('Validation Error, make shure that all input required are not empty', $validator->errors());
        }
    $User = User::create($input);
    return response()->json([ 
        'success'=>true,
        'message'=> 'User Record Created Successfully',
        'User'=>$User
    ]);
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return User::find($id);
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
        if(User::where('id',$id)->exists()){
            $User = User::find($id);
            $User->name = $request->name;
            $User->role = $request->role;
            $User->email = $request->email;
            $User->password = $request->password;
            $User->phone = $request->phone;
            $User->fonction = $request->fonction;
            $User->save();
            return response()->json([
                'message'=>'User Record Updated Successfully'
            ],);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(User::where("id",$id)->exists()){
            $User = User::find($id);
            $User->delete();
            return response()->json([
                'message' => 'User Record Deleted Successfully'
            ], 200);
        }else{
            return response()->json([
                'message' => 'User Record Not Found'
            ],404);
        }
    }

    //Disactivate User
    public function disactivate(Request $request, $id)
    {
        if(User::where('id',$id)->exists()){
            $User = User::find($id);
            $User->deleted = true;
            
            $User->save();
            return response()->json([
                'message'=>'User Record Disactivated Successfully'
            ],);
        }
    }
    //Get Activated Users
    public function getActivatedUsers(){
        $Users = DB::table('users')
            ->where('users.deleted',false)
            ->select( 'users.*')
            ->get();
        return $Users;
    }
}
