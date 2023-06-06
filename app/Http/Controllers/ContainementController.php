<?php

namespace App\Http\Controllers;
use App\Models\Containement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class ContainementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Containement::all();
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
            'method_description'=>'required',
            'method_validation'=>'required',
            'risk_assesment'=>'required',
        ]);
        if($validator->fails()){
        return $this->sendError('Validation Error, make shure that all input required are not empty', $validator->errors());
        }
    $Containement = Containement::create($input);
    return response()->json([ 
        'success'=>true,
        'message'=> 'Containement Record Created Successfully',
        'Containement'=>$Containement
    ]);
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Containement::find($id);
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
        if(Containement::where('id',$id)->exists()){
            $Containement = Containement::find($id);
            $Containement->report_id = $request->report_id;
            $Containement->method_description = $request->method_description;
            $Containement->method_validation = $request->method_validation;
            $Containement->risk_assesment = $request->risk_assesment;
            $Containement->save();
            return response()->json([
                'message'=>'Containement Record Updated Successfully'
            ],);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(Containement::where("id",$id)->exists()){
            $Containement = Containement::find($id);
            $Containement->delete();
            return response()->json([
                'message' => 'Containement Record Deleted Successfully'
            ], 200);
        }else{
            return response()->json([
                'message' => 'Containement Record Not Found'
            ],404);
        }
    }
}
