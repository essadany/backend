<?php

namespace App\Http\Controllers;
use App\Models\ActionComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class AnnexeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Annexe::all();
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
            'action_id'=>'required',
            'comment'=>'required', 
            'comment_date'=>'required'
        ]);
        if($validator->fails()){
        return $this->sendError('Validation Error, make shure that all input required are not empty', $validator->errors());
        }
    $Annexe = Annexe::create($input);
    return response()->json([ 
        'success'=>true,
        'message'=> 'Annexe Record Created Successfully',
        'Annexe'=>$Annexe
    ]);
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Annexe::find($id);
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
        if(Annexe::where('id',$id)->exists()){
            $Annexe = Annexe::find($id);
            $Annexe->action_id = $request->action_id;
            $Annexe->comment = $request->comment;
            $Annexe->comment_date = $request->comment_date;
            $Annexe->save();
            return response()->json([
                'message'=>'Annexe Record Updated Successfully'
            ],);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(Annexe::where("id",$id)->exists()){
            $Annexe = Annexe::find($id);
            $Annexe->delete();
            return response()->json([
                'message' => 'Annexe Record Deleted Successfully'
            ], 200);
        }else{
            return response()->json([
                'message' => 'Annexe Record Not Found'
            ],404);
        }
    }
    public function getComments($action_id)
    {
       $action = Action::find($action_id);
        $comments = $action->comments()->get();
        return response()->json($comments);
    }
}