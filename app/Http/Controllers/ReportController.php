<?php

namespace App\Http\Controllers;
use App\Models\Report;
use App\Models\Claim;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Report::all();
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
            'report_ref'=>'required',
            'due_date'=>'required',
            'sub_date'=>'',
            'containement_actions'=>'required',
            'first_batch3'=>'required',
            'first_batch6'=>'required',
            'date_cause_definition'=>'required',
            'reported_by'=>'required',
            'pilot'=>'',
            'ddm'=>'required',
            'approved'=>'required',
            'others'=>'required',
            'ctrl_plan'=>'required',
            'pfmea'=>'required',
            'dfmea'=>'required',
            'progress_rate'=>''
        ]);
        if($validator->fails()){
        return $this->sendError('Validation Error, make shure that all input required are not empty', $validator->errors());
        }
    $report = Report::create($input);
    return response()->json([ 
        'success'=>true,
        'message'=> 'Report Record Created Successfully',
        'report'=>$report
    ]);
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Report::find($id);
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
        if(Report::where('id',$id)->exists()){
            $report = Report::find($id);
            $report->sub_date = $request->sub_date;
            $report->due_date = $request->due_date;
            $report->containement_actions = $request->containement_actions;
            $report->first_batch3 = $request->first_batch3;
            $report->first_batch6 = $request->first_batch6;
            $report->date_cause_definition = $request->date_cause_definition;
            $report->reported_by = $request->reported_by;
            $report->pilot = $request->pilot;
            $report->ddm = $request->ddm;
            $report->approved = $request->approved;
            $report->others= $request->others;
            $report->ctrl_plan = $request->ctrl_plan;
            $report->pfmea = $request->pfmea;
            $report->dfmea = $request->dfmea;
            $report->status = $request->status;
            $report->progress_rate = $request->progress_rate;
            $report->save();
            return response()->json([
                'message'=>'Report Record Updated Successfully'
            ],);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(Report::where("id",$id)->exists()){
            $Report = Report::find($id);
            $Report->delete();
            return response()->json([
                'message' => 'Report Record Deleted Successfully'
            ], 200);
        }else{
            return response()->json([
                'message' => 'Report Record Not Found'
            ],404);
        }
    }
    
}
