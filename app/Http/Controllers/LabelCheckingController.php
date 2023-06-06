<?php

namespace App\Http\Controllers;
use App\Models\LabelChecking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class LabelCheckingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return LabelChecking::all();
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
            'sorting_method'=>"required",
            'bontaz_plant'=>"required"
        ]);
        if($validator->fails()){
        return $this->sendError('Validation Error, make shure that all input required are not empty', $validator->errors());
        }
    $LabelChecking = LabelChecking::create($input);
    return response()->json([ 
        'success'=>true,
        'message'=> 'LabelChecking Record Created Successfully',
        'LabelChecking'=>$LabelChecking
    ]);
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return LabelChecking::find($id);
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
        if(LabelChecking::where('id',$id)->exists()){
            $LabelChecking = LabelChecking::find($id);
            $LabelChecking->sorting_method = $request->sorting_method;
            $LabelChecking->bontaz_plant = $request->bontaz_plant;
            $LabelChecking->save();
            return response()->json([
                'message'=>'LabelChecking Record Updated Successfully'
            ],);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(LabelChecking::where("id",$id)->exists()){
            $LabelChecking = LabelChecking::find($id);
            $LabelChecking->delete();
            return response()->json([
                'message' => 'LabelChecking Record Deleted Successfully'
            ], 200);
        }else{
            return response()->json([
                'message' => 'LabelChecking Record Not Found'
            ],404);
        }
    }
}
