<?php

namespace App\Http\Controllers;
use App\Models\ProblemDescription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class ProblemDescriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ProblemDescription::all();
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
            'what'=>'required',
            'where'=>'required',
            'who'=>'required',
            'when'=>'required',
            'why'=>'required',
            'how'=>'required',
            'how_many_before'=>'required',
            'how_many_after'=>'required',
            'recurrence'=>'required',
            'received'=>'',
            'date_reception'=>'',
            'date_done'=>'required',
            'bontaz_fault'=>'',
            'description'=>'required'      
        ]);
        if($validator->fails()){
        return $this->sendError('Validation Error, make shure that all input required are not empty', $validator->errors());
        }
    $ProblemDescription = ProblemDescription::create($input);
    return response()->json([ 
        'success'=>true,
        'message'=> 'ProblemDescription Record Created Successfully',
        'ProblemDescription'=>$ProblemDescription
    ]);
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return ProblemDescription::find($id);
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
        if(ProblemDescription::where('id',$id)->exists()){
            $ProblemDescription = ProblemDescription::find($id);
            $ProblemDescription->what = $request->what;
            $ProblemDescription->where = $request->where;
            $ProblemDescription->who = $request->who;
            $ProblemDescription->when = $request->when;
            $ProblemDescription->why = $request->why;
            $ProblemDescription->how = $request->how;
            $ProblemDescription->how_many_before = $request->how_many_before;
            $ProblemDescription->how_many_after = $request->how_many_after;
            $ProblemDescription->recurrence = $request->recurrence;
            $ProblemDescription->received = $request->received;
            $ProblemDescription->date_reception = $request->date_reception;
            $ProblemDescription->date_done = $request->date_done;
            $ProblemDescription->bontaz_fault = $request->bontaz_fault;
            $ProblemDescription->description = $request->description;     
            $ProblemDescription->save();
            return response()->json([
                'message'=>'ProblemDescription Record Updated Successfully'
            ],);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(ProblemDescription::where("id",$id)->exists()){
            $ProblemDescription = ProblemDescription::find($id);
            $ProblemDescription->delete();
            return response()->json([
                'message' => 'ProblemDescription Record Deleted Successfully'
            ], 200);
        }else{
            return response()->json([
                'message' => 'ProblemDescription Record Not Found'
            ],404);
        }
    }
   
}
