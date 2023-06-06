<?php

namespace App\Http\Controllers;
use App\Models\FiveWhy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class FiveWhyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return FiveWhy::all();
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
            'claim_id'=>'required'
        ]);
        if($validator->fails()){
        return $this->sendError('Validation Error, make shure that all input required are not empty', $validator->errors());
        }
    $FiveWhy = FiveWhy::create($input);
    return response()->json([ 
        'success'=>true,
        'message'=> 'FiveWhy Record Created Successfully',
        'FiveWhy'=>$FiveWhy
    ]);
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return FiveWhy::find($id);
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
        if(FiveWhy::where('id',$id)->exists()){
            $FiveWhy = FiveWhy::find($id);
            $FiveWhy->claim_id = $request->claim_id;
            
            $FiveWhy->save();
            return response()->json([
                'message'=>'FiveWhy Record Updated Successfully'
            ],);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(FiveWhy::where("id",$id)->exists()){
            $FiveWhy = FiveWhy::find($id);
            $FiveWhy->delete();
            return response()->json([
                'message' => 'FiveWhy Record Deleted Successfully'
            ], 200);
        }else{
            return response()->json([
                'message' => 'FiveWhy Record Not Found'
            ],404);
        }
    }
}
