<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Action;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ActionController extends Controller
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
        $input = $request->all();
        $validator = Validator::make($input,[
            'report_id'=>'required',
            'user_id'=>'required',
            'action'=>'required', 
            'type'=>'required', 
            'planned_date'=>'required', 
        ]);
        if($validator->fails()){
        return $this->sendError('Validation Error, make shure that all input required are not empty', $validator->errors());
        }
    $Action = Action::create($input);
    return response()->json([ 
        'success'=>true,
        'message'=> 'Action Record Created Successfully',
        'Action'=>$Action
    ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Action::find($id);
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
            $Action = Action::find($id);
            $Action->user_id = $request->user_id;
            $Action->action = $request->action;
            $Action->type = $request->type;
            $Action->planned_date = $request->planned_date;
            $Action->start_date = $request->start_date;
            $Action->status = $request->status?? 'not started';;
            $Action->done_date = $request->done_date;
            $Action->save();
            return response()->json([
                'message'=>'Action Record Updated Successfully'
            ],);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(Action::where("id",$id)->exists()){
            $Action = Action::find($id);
            $Action->delete();
            return response()->json([
                'message' => 'Action Record Deleted Successfully'
            ], 200);
        }else{
            return response()->json([
                'message' => 'Action Record Not Found'
            ],404);
        }
    }
    //Disactivate Action
    public function disactivate(Request $request, $id)
    {
        if(Action::where('id',$id)->exists()){
            $Action = Action::find($id);
            $Action->deleted = true;
            
            $Action->save();
            return response()->json([
                'message'=>'Action Record Disactivated Successfully'
            ],);
        }
    }
    //Get Activated Actions
    public function getActivatedActions($report_id){
        $Actions = DB::table('actions')
        ->join('reports', 'actions.report_id', '=', 'reports.id')
        ->join('users', 'actions.user_id', '=', 'users.id')
        ->where('actions.deleted',false)
        ->where('actions.report_id',$report_id)
            ->select( 'actions.*','users.name','users.fonction')
            ->get();
        return $Actions;
    }
    //Get Implemented Actions
    public function getImplementedActions($report_id){
        $Actions = DB::table('actions')
        ->join('reports', 'actions.report_id', '=', 'reports.id')
        ->join('users', 'actions.user_id', '=', 'users.id')
        ->where('actions.type','implemented')
        ->where('actions.deleted',false)
        ->where('actions.report_id',$report_id)
            ->select( 'actions.*','users.name','users.fonction')
            ->get();
        return $Actions;
    }
     //Get Preventive Actions
     public function getPreventiveActions($report_id){
        $Actions = DB::table('actions')
        ->join('reports', 'actions.report_id', '=', 'reports.id')
        ->join('users', 'actions.user_id', '=', 'users.id')
        ->where('actions.type','preventive')
        ->where('actions.report_id',$report_id)
        ->where('actions.deleted',false)
            ->select( 'actions.*','users.name','users.fonction')
            ->get();
        return $Actions;
    }
     //Get Implemented Actions
     public function getPotentialActions($report_id){
        $Actions = DB::table('actions')
        ->join('reports', 'actions.report_id', '=', 'reports.id')
        ->join('users', 'actions.user_id', '=', 'users.id')
        ->where('actions.type','potential')
        ->where('actions.report_id',$report_id)
        ->where('actions.deleted',false)
            ->select( 'actions.*','users.name','users.fonction')
            ->get();
        return $Actions;
    }
}
