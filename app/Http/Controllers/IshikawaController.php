<?php

namespace App\Http\Controllers;
use App\Models\Ishikawa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class IshikawaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Ishikawa::all();
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
    $Ishikawa = Ishikawa::create($input);
    return response()->json([ 
        'success'=>true,
        'message'=> 'Ishikawa Record Created Successfully',
        'Ishikawa'=>$Ishikawa
    ]);
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Ishikawa::find($id);
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
        if(Ishikawa::where('id',$id)->exists()){
            $Ishikawa = Ishikawa::find($id);
            $Ishikawa->claim_id = $request->claim_id;
            
            $Ishikawa->save();
            return response()->json([
                'message'=>'Ishikawa Record Updated Successfully'
            ],);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(Ishikawa::where("id",$id)->exists()){
            $Ishikawa = Ishikawa::find($id);
            $Ishikawa->delete();
            return response()->json([
                'message' => 'Ishikawa Record Deleted Successfully'
            ], 200);
        }else{
            return response()->json([
                'message' => 'Ishikawa Record Not Found'
            ],404);
        }
    }
}
