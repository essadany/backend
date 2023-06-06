<?php

namespace App\Http\Controllers;
use App\Models\Effectiveness;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class EffectivenessController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Effectiveness::all();
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
            'title'=>'required',
            'file'=>'required',
            'description'=>''
        ]);
        if($validator->fails()){
        return $this->sendError('Validation Error, make shure that all input required are not empty', $validator->errors());
        }
    $Effectiveness = Effectiveness::create($input);
    return response()->json([ 
        'success'=>true,
        'message'=> 'Effectiveness Record Created Successfully',
        'Effectiveness'=>$Effectiveness
    ]);
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Effectiveness::find($id);
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
        if(Effectiveness::where('id',$id)->exists()){
            $Effectiveness = Effectiveness::find($id);
            $Effectiveness->report_id = $request->report_id;
            $Effectiveness->title = $request->title;
            $Effectiveness->file = $request->file;
            $Effectiveness->description = $request->description;
            $Effectiveness->save();
            return response()->json([
                'message'=>'Effectiveness Record Updated Successfully'
            ],);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(Effectiveness::where("id",$id)->exists()){
            $Effectiveness = Effectiveness::find($id);
            $Effectiveness->delete();
            return response()->json([
                'message' => 'Effectiveness Record Deleted Successfully'
            ], 200);
        }else{
            return response()->json([
                'message' => 'Effectiveness Record Not Found'
            ],404);
        }
    }
}
