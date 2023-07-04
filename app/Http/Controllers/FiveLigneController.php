<?php

namespace App\Http\Controllers;
use App\Models\FiveLigne;
use App\Models\Claim;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class FiveLigneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return FiveLigne::all();
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
            'why'=>'required', 
            'answer'=>'required'
        ]);
        if($validator->fails()){
        return $this->sendError('Validation Error, make shure that all input required are not empty', $validator->errors());
        }
    $FiveLigne = FiveLigne::create($input);
    return response()->json([ 
        'success'=>true,
        'message'=> 'FiveLigne Record Created Successfully',
        'FiveLigne'=>$FiveLigne
    ]);
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return FiveLigne::find($id);
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
        if(FiveLigne::where('id',$id)->exists()){
            $FiveLigne = FiveLigne::find($id);
            $FiveLigne->why = $request->why;
            $FiveLigne->answer = $request->answer;
            $FiveLigne->save();
            return response()->json([
                'message'=>'FiveLigne Record Updated Successfully'
            ],);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(FiveLigne::where("id",$id)->exists()){
            $FiveLigne = FiveLigne::find($id);
            $FiveLigne->delete();
            return response()->json([
                'message' => 'FiveLigne Record Deleted Successfully'
            ], 200);
        }else{
            return response()->json([
                'message' => 'FiveLigne Record Not Found'
            ],404);
        }
    }
    public function getFiveLignesByClaim($claim_id){
        $claim = Claim::find($claim_id);
        $five_lignes = $claim->five_why->five_lignes()->get();
        return $five_lignes;
    }
    public function getFiveLignesOccurence($claim_id){
        $claim = Claim::find($claim_id);
        $five_lignes = $claim->five_why->five_lignes()
        ->where('five_lignes.type','occurence')
        ->get();
        return $five_lignes;
    }
    public function getFiveLignesDetection($claim_id){
        $claim = Claim::find($claim_id);
        $five_lignes = $claim->five_why->five_lignes()
        ->where('five_lignes.type','detection')
        ->get();
        return $five_lignes;
    }
    public function getFiveLignesSystem($claim_id){
        $claim = Claim::find($claim_id);
        $five_lignes = $claim->five_why->five_lignes()
        ->where('five_lignes.type','system')
        ->get();
        return $five_lignes;
    }
}
