<?php

namespace App\Http\Controllers;
use App\Models\Result;
use App\Models\Claim;
use App\Models\FiveWhy;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class ResultController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Result::all();
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
            'five_why_id'=>'required',
            'type'=>'required',
            'input'=>'required'
        ]);
        if($validator->fails()){
        return $this->sendError('Validation Error, make shure that all input required are not empty', $validator->errors());
        }
    $Result = Result::create($input);
    return response()->json([ 
        'success'=>true,
        'message'=> 'Result Record Created Successfully',
        'Result'=>$Result
    ]);
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Result::find($id);
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
        if(Result::where('id',$id)->exists()){
            $Result = Result::find($id);
            $Result->input = $request->input;
            $Result->save();
            return response()->json([
                'message'=>'Result Record Updated Successfully'
            ],);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(Result::where("id",$id)->exists()){
            $Result = Result::find($id);
            $Result->delete();
            return response()->json([
                'message' => 'Result Record Deleted Successfully'
            ], 200);
        }else{
            return response()->json([
                'message' => 'Result Record Not Found'
            ],404);
        }
    }
    public function getResultsByClaim($claim_id){
        $claim = Claim::find($claim_id);
        $results = $claim->five_why->results()->get();
        return $results;
    }

    
    

}
