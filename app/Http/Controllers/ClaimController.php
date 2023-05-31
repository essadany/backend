<?php

namespace App\Http\Controllers;
use App\Models\Claim;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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
    return response()->json([ 
        'success'=>true,
        'message'=> 'Claim Record Created Successfully',
        'Claim'=>$Claim
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
            $Claim->save();
            return response()->json([
                'message'=>'Claim Record Updated Successfully'
            ],404);
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
}
