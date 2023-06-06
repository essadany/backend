<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\SessionGuard;
class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','store']]);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        //$guard = Auth::guard();
       // $expiresIn = $guard->factory()->getTTL() * 60;
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
           // 'expires_in' => $expiresIn,
            'user' => auth()->user()
        ]);
    }
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = request(['email', 'password']);
        $token = auth()->attempt($credentials);

        if (!$token) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    



    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    




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
            $User->email = $request->email;
            $User->password = $request->password;
            $User->phone = $request->phone;
            $User->fonction = $request->fonction;
            $User->role = $request->role;
            $User->email = $request->email;
            $User->email = $request->email;
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
}
