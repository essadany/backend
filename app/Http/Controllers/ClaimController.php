<?php

namespace App\Http\Controllers;
use App\Models\Claim;
use App\Models\Team;
use App\Models\User;
use App\Models\Containement;
use App\Models\Effectiveness;
use App\Models\Result;
use Carbon\Carbon;
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
            'category' => 'required',
            'product_ref' => 'required',
            'engraving' => 'required',
            'prod_date' => 'required',
            'object' => 'required',
            'opening_date'=> 'required',
            'final_cusomer' => '',
            'claim_details'=>'',
            'def_mode'=> '',
            'nbr_claimed_parts' => 'required',
            'returned_parts' => '',
            'deleted'=>''
        ]);
        if($validator->fails()){
        return $this->sendError('Validation Error, make shure that all input required are not empty', $validator->errors());
        }
    $Claim = Claim::create($input);
    //Create associated team
    $team = new Team();
    $Claim->team()->save($team);
    //--------------------------------------
    //Create associated report
    $report = new Report();
    $openingDate = Carbon::parse($Claim->opening_date);
    $due_date = $openingDate->addDays(10);
    $report->due_date = $due_date;
    $Claim->report()->save($report);
    //Create associated Effectiveness
    $eff = new Effectiveness();
    $report->effectiveness()->save($eff);
    //--------------------
    //Create associated containement
    $containement = new Containement();
    $Claim->containement()->save($containement);
    //--------------------
    //Create associated problem description
    $prob = new ProblemDescription();
    $openingDate = Carbon::parse($Claim->opening_date);
    $date = $openingDate->addDay();
    $prob->due_date = $date;
    $Claim->prob_desc()->save($prob);
    //--------------------
    //Create associated ishikawa
    $ishikawa = new Ishikawa();
    $Claim->ishikawa()->save($ishikawa);
    //--------------------
    //Create associated FiveWhy
    $five_why = new FiveWhy();
    $Claim->five_why()->save($five_why);
    //Create associated Results to FiveWhy
    $occurence_result = new Result();
    $detection_result = new Result();
    $system_result = new Result();
    $occurence_result->type = "occurence";
    $detection_result->type = "detection";
    $system_result->type = "system";
    // Save the results and associate them with the FiveWhy
    $five_why->results()->saveMany([$occurence_result, $detection_result, $system_result]);
    
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
            $Claim->category = $request->category;
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
            $Claim->save();
            $prob = $Claim->prob_desc;
            if ($Claim->opening_date !== null){
                $date = Carbon::parse($Claim->opening_date);
                $due_date = $date->addDay();
                $prob->due_date = $due_date;
            }
            $prob->save();
            return response()->json([
                'message'=>'Claim Record Updated Successfully'
            ],);
        }
    }
    // Update Claim Tracking
    public function updateClaimTracking(Request $request, $id){
        if(Claim::where('id',$id)->exists()){
            $claim = Claim::find($id);
            $report = $claim->report;
            $prob_desc = $claim->prob_desc;
            $claim->claim_details = $request->claim_details;
            $prob_desc->date_reception = $request->date_reception;
            $prob_desc->bontaz_fault = $request->bontaz_fault;
            $report->progress_rate = $request->progress_rate;
            $report->status = $request->status;
            $report->sub_date = $request->sub_date;
            if ($prob_desc->date_reception !== null){
                $date = Carbon::parse($prob_desc->date_reception);
                $due_date = $date->addDays(10);
                $report->due_date = $due_date;
            }
            $claim->save();
            $report->save();
            $prob_desc->save();
            return response()->json([
                'message'=>'Claim Tracking Record Updated Successfully'
            ],);
        }

    }
    /**
     * Update the specified resource in storage.
     */
    public function updateStatus(Request $request, $id)
    {
        if(Claim::where('id',$id)->exists()){
            $Claim = Claim::find($id);
            $Claim->status = $request->status?? 'on going';
            $Claim->done_date = $request->done_date;
            $Claim->save();
            return response()->json([
                'message'=>'Claim Record Updated Successfully'
            ],);
        }
        $claims = Claim::all();

        foreach ($claims as $claim) {
            if($claim->$done_date!==""){
                if ($claim->done_date > $claim->planned_date) {
                    $claim->status = 'delayed';
                    $claim->save();
                }
            }
        
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
            ->select( 'customers.id as customer_id','customers.name as customer_name','claims.*','products.name as product_name')
            ->get();
        return $claims;
    }
    //Claims Tracking
    public function getClaims_tracking(){
        $claims = DB::table('claims')
        ->join('products', 'claims.product_ref', '=', 'products.product_ref')
        ->join('customers', 'customers.id', '=', 'products.customer_id')
        ->leftJoin('reports', 'claims.id', '=', 'reports.claim_id')
        ->leftJoin('problem_descriptions', 'claims.id', '=', 'problem_descriptions.claim_id')
        ->leftJoin('ishikawas', 'claims.id', '=', 'ishikawas.claim_id')
        ->leftJoin('containements', 'claims.id', '=', 'containements.claim_id')
        ->leftJoin('categories', 'ishikawas.id', '=', 'categories.ishikawa_id')
       // ->leftJoin('sortings', 'containements.id', '=', 'sortings.containement_id')

            ->where('claims.deleted',false)
            ->select( 'customers.id as customer_id','customers.name as customer_name','claims.*','products.name as product_name','products.customer_ref','products.uap',
                        'reports.id as report_id','reports.progress_rate','reports.status as report_status',
                        'reports.due_date as report_due_date','reports.sub_date as report_sub_date',
                        'reports.sub_date as report_sub_date','reports.due_date as report_due_date',
                        'problem_descriptions.id as prob_desc_id','problem_descriptions.date_reception','categories.input as ishikawa_input','problem_descriptions.how_many_after',
                        'problem_descriptions.recurrence','problem_descriptions.bontaz_fault',
                        'categories.type as ishikawa_category','categories.input as ishikawa_principale')
            ->where(function ($query) {
                $query->where('categories.isPrincipale', true)
                    ->orWhereNull('categories.isPrincipale');
            })
            ->get();
        return $claims;
    }
    //////////////////////////////////////////
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
    public function getEffectivenessByClaim($id){
        $Claim = Claim::find($id);
        $eff = $Claim->report->effectiveness ;
        return response()->json($eff);
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
    public function getIshikawa($id){
        $Claim = Claim::find($id);
        $ishikawa = $Claim->ishikawa ;
        return response()->json($ishikawa);
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
    public function getLabelCheckJoin($claim_id){
        $label_check = DB::table('label_checkings')
        ->join('claims', 'claims.id', '=', 'label_checkings.claim_id')
        ->where('claims.id',$claim_id)
        ->join('products','products.product_ref','=','claims.product_ref')
        ->select('label_checkings.id', 'products.product_ref','internal_ID','customer_ref','sorting_method','bontaz_plant')
        ->get()->first();
        return $label_check;
    }
    public function getReportJoin($claim_id){
        $claim= Claim::find($claim_id);
        $report = DB::table('claims')
        ->where('claims.id', $claim_id)
        ->join('reports', 'claims.id', 'reports.claim_id')
        ->join('problem_descriptions', 'problem_descriptions.claim_id', '=', 'claims.id')
        ->join('five_whys', 'five_whys.claim_id', '=', 'claims.id')
        ->join('results as r1', function ($join) {
            $join->on('five_whys.id', '=', 'r1.five_why_id')
                ->where('r1.type', 'occurence');
        })
        ->join('results as r2', function ($join) {
            $join->on('five_whys.id', '=', 'r2.five_why_id')
                ->where('r2.type', 'detection');
        })
        ->join('results as r3', function ($join) {
            $join->on('five_whys.id', '=', 'r3.five_why_id')
                ->where('r3.type', 'system');
        })
        ->select('reports.*','opening_date','engraving','prod_date as production_date', 'what', 'recurrence', 'bontaz_fault', 'r1.input as occurrence_root_cause', 'r2.input as detection_root_cause',
                 'r3.input as system_root_cause')
        ->get()->first();
        return $report;
    }
    // Statistiques
    // Get the top five products that have the big number of claims
    public function MostProductsClaimed()
{
    $records = DB::table('products')
        ->join('claims','claims.product_ref','=','products.product_ref')
        ->select('products.product_ref as bontaz_part_number','products.customer_ref as customer_part_number',
        'products.name as product_designation','products.zone as zone','products.uap as uap_engineer', DB::raw('COUNT(*) as number_of_claims'))
        ->groupBy('products.product_ref','products.customer_ref',
        'products.name','products.zone','products.uap')
        ->orderBy('number_of_claims', 'desc')
        ->limit(5)
        ->get();
    return $records;

}
//Get Number of claims by status for month
public function ClaimsStatus(){
    $records = DB::table('claims')
    ->leftJoin('problem_descriptions','claims.id','=','problem_descriptions.claim_id')
    ->select('problem_descriptions.bontaz_fault as claim_confirmed', DB::raw('COUNT(*) as number_of_claims'),
    DB::raw('YEAR(claims.opening_date) as year'), DB::raw('MONTH(claims.opening_date) as month'))
    ->groupBy('year','month','problem_descriptions.bontaz_fault')
    ->get();
    return $records;

}
//Get Number of claims by status for month
public function ConfirmedClaimsStatus(){
    $records = DB::table('claims')
    ->leftJoin('problem_descriptions','claims.id','=','problem_descriptions.claim_id')
    ->where('bontaz_fault','YES')
    ->leftJoin('reports','claims.id','=','reports.claim_id')
    ->select('reports.status as 8d_status', DB::raw('COUNT(*) as number_of_8d'),
    DB::raw('YEAR(claims.opening_date) as year'), DB::raw('MONTH(claims.opening_date) as month'))
    ->groupBy('year','month','reports.status')
    ->get();
    return $records;

}
public function getWeekPPM(Request $request, $year)
{
    $records = DB::table('claims')
        ->join('ppm', function ($join) {
            $join->on(DB::raw('YEAR(claims.opening_date)'), '=', 'ppm.year')
                ->on(DB::raw('MONTH(claims.opening_date)'), '=', 'ppm.month')
                ->on(DB::raw('WEEK(claims.opening_date)'), '=', 'ppm.week');
        })
        ->select(
            DB::raw('YEAR(claims.opening_date) as year'),
            DB::raw('MONTH(claims.opening_date) as month'),
            DB::raw('WEEK(claims.opening_date) as week'),
            DB::raw('SUM(claims.nbr_claimed_parts) as claimed_parts'),
            'ppm.shipped_parts',
            DB::raw('(SUM(claims.nbr_claimed_parts) * 1000000 / ppm.shipped_parts) as week_ppm'),
            'ppm.objectif'
        )
        ->whereYear('claims.opening_date', $year)
        ->groupBy(
            DB::raw('YEAR(claims.opening_date)'),
            DB::raw('MONTH(claims.opening_date)'),
            DB::raw('WEEK(claims.opening_date)'),
            'ppm.shipped_parts',
            'ppm.objectif'
        )
        ->orderBy('year', 'desc')
        ->orderBy('month', 'desc')
        ->orderBy('week', 'desc')
        ->get();

    return $records;
}

public function getMonthPPM(Request $request, $year)
{
    $records = DB::table('claims')
    ->rightJoin(DB::raw('(SELECT year, month, SUM(shipped_parts) as total_shipped_parts, AVG(objectif) as objectif FROM ppm GROUP BY year, month) as ppm'), function ($join) {
        $join->on(DB::raw('YEAR(claims.opening_date)'), '=', 'ppm.year')
            ->on(DB::raw('MONTH(claims.opening_date)'), '=', 'ppm.month');
    })
    ->select(
        DB::raw('YEAR(claims.opening_date) as year'),
        DB::raw('MONTH(claims.opening_date) as month'),
        DB::raw('SUM(claims.nbr_claimed_parts) as claimed_parts'),
        'ppm.total_shipped_parts',
        DB::raw('(SUM(claims.nbr_claimed_parts) * 1000000 / ppm.total_shipped_parts) as month_ppm'),
        'ppm.objectif'
    )
    ->whereYear('claims.opening_date', $year)
    ->groupBy(
        DB::raw('YEAR(claims.opening_date)'),
        DB::raw('MONTH(claims.opening_date)'),
        'ppm.objectif',
        'ppm.total_shipped_parts'
    )
    ->orderBy('year', 'desc')
    ->orderBy('month', 'desc')
    ->get();

return $records;

}
    /*$records = DB::table('claims')
        ->select(DB::raw('YEAR(claims.opening_date) as year'),
                 DB::raw('MONTH(claims.opening_date) as month'),
                 DB::raw('WEEK(claims.opening_date) as week'),
                 DB::raw('SUM(nbr_claimed_parts) as claimed_parts'))
        ->whereYear('claims.opening_date', $year)
        ->groupBy('year', 'month', 'week')
        ->orderBy('year', 'desc')
        ->orderBy('month', 'desc')
        ->orderBy('week', 'desc')
        ->get();

    return $records;*/


    
}