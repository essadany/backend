<?php

namespace App\Http\Controllers;
use App\Models\Claim;
use App\Models\Team;
use App\Models\User;
use App\Models\Containement;

use App\Models\ProblemDescription;
use App\Models\Report;
use App\Models\Ishikawa;
use App\Models\FiveWhy;
use App\Models\LabelChecking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ClaimController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Claim::all();
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
            'internal_ID'=>'required',
            'refRecClient'=> 'required',
            'product_ref' => 'required',
            'engraving' => 'required',
            'prod_date' => 'required',
            'object' => 'required',
            'opening_date'=> 'required',
            'final_cusomer' => '',
            'claim_details'=>'required',
            'def_mode'=> '',
            'nbr_claimed_parts' => 'required',
            'returned_parts' => ''
        ]);
        if($validator->fails()){
        return $this->sendError('Validation Error, make shure that all input required are not empty', $validator->errors());
        }
    $Claim = Claim::create($input);
    //Create associated team
    $team = new Team();
    $Claim->team()->save($team);
    //--------------------
    //Create associated report
    $report = new Report();
    $Claim->report()->save($report);
    //--------------------
    //Create associated containement
    $containement = new Containement();
    $Claim->containement()->save($containement);
    //--------------------
    //Create associated problem description
    $prob = new ProblemDescription();
    $Claim->prob_desc()->save($prob);
    //--------------------
    //Create associated ishikawa
    $ishikawa = new Ishikawa();
    $Claim->ishikawa()->save($ishikawa);
    //--------------------
    //Create associated FiveWhy
    $five_why = new FiveWhy();
    $Claim->five_why()->save($five_why);
    //--------------------
    //Create associated LabelChecking
    $label = new LabelChecking();
    $Claim->label_checking()->save($label);
    //--------------------
    return response()->json([ 
        'success'=>true,
        'message'=> 'Claim Record Created Successfully',
        'Claim'=>$Claim,
    ]);
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Claim::find($id);
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
        if(Claim::where('id',$id)->exists()){
            $Claim = Claim::find($id);
            $Claim->internal_ID = $request->internal_ID;
            $Claim->refRecClient = $request->refRecClient;
            $Claim->product_ref = $request->product_ref;
            $Claim->engraving = $request->engraving;
            $Claim->prod_date = $request->prod_date;
            $Claim->object = $request->object;
            $Claim->opening_date = $request->opening_date;
            $Claim->final_cusomer = $request->final_cusomer;
            $Claim->claim_details = $request->claim_details;
            $Claim->def_mode = $request->def_mode;
            $Claim->nbr_claimed_parts = $request->nbr_claimed_parts;
            $Claim->returned_parts = $request->returned_parts;
            $Claim->status = $request->status?? 'not started';
            $Claim->save();
            return response()->json([
                'message'=>'Claim Record Updated Successfully'
            ],);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(Claim::where("id",$id)->exists()){
            $Claim = Claim::find($id);
            $Claim->delete();
            return response()->json([
                'message' => 'Claim Record Deleted Successfully'
            ], 200);
        }else{
            return response()->json([
                'message' => 'Claim Record Not Found'
            ],404);
        }
    }

    //Disactivate Claim
    public function disactivate(Request $request, $id)
    {
        if(Claim::where('id',$id)->exists()){
            $Claim = Claim::find($id);
            $Claim->deleted = true;
            
            $Claim->save();
            return response()->json([
                'message'=>'Claim Record Disactivated Successfully'
            ],);
        }
    }
    //Get Activated Claims
    public function getActivatedClaims(){
        $Claims = DB::table('claims')
            ->where('claims.deleted',false)
            ->select( 'claims.*')
            ->get();
        return $Claims;
    }

    //Claims join Customers and Products
    public function getClaimsJoin(){
        $claims = DB::table('claims')
            ->join('products', 'claims.product_ref', '=', 'products.product_ref')
            ->join('customers','customers.id', '=', 'products.customer_id' )
            ->where('claims.deleted',false)
            ->select( 'customers.id as customer_id','customers.name as customer_name','claims.*','products.name as product_name','customers.category')
            ->get();
        return $claims;
    }
    public function getTeamByClaim($id){
        $Claim = Claim::find($id);
        $team = $Claim->team ;
        return response()->json($team);

    }
    public function getMeetingsByClaim($claim_id){
        $Claim = Claim::find($claim_id);
        $team = $Claim->team ;
        $meetings = $team -> meetings()->where('meetings.deleted',false)->get();
        return response()->json($meetings);
    }
    public function getUsersOfTeam($claim_id)
    {
        $claim = Claim::find($claim_id);
        $team = $claim->team;
       $users = $team->users()->where('team_users.deleted', false)->get();
        return response()->json($users);
    }
    public function getContainementByClaim($id){
        $Claim = Claim::find($id);
        $containement = $Claim->containement ;
        return response()->json($containement);
    }
    public function getReportByClaim($id){
        $Claim = Claim::find($id);
        $report = $Claim->report ;
        return response()->json($report);
    }
    public function getProbDescByClaim($id){
        $Claim = Claim::find($id);
        $prob_desc = $Claim->prob_desc ;
        return response()->json($prob_desc);
    }
    public function getFiveWhyByClaim($id){
        $Claim = Claim::find($id);
        $five_why = $Claim->five_why ;
        return response()->json($five_why);
    }
    public function getLabelCheckByClaim($id){
        $Claim = Claim::find($id);
        $label_checking = $Claim->label_checking ;
        return response()->json($label_checking);
    }
    public function getActionsByClaim($id){
        $Claim = Claim::find($id);
        $report = $Claim->report;
        $actions = $report->actions()->get() ;
        return response()->json($actions);
    }
    
    
}