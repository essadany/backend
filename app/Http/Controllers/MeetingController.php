<?php

namespace App\Http\Controllers;
use App\Models\Meeting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class MeetingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Meeting::all();
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
            'type'=>'required',
            'date'=>'required',
            'comment'=>''
        ]);
        if($validator->fails()){
        return $this->sendError('Validation Error, make shure that all input required are not empty', $validator->errors());
        }
    $meeting = Meeting::create($input);
    return response()->json([ 
        'success'=>true,
        'message'=> 'Meeting Record Created Successfully',
        'Meeting'=>$meeting
    ]);
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Meeting::find($id);
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
        if(Meeting::where('id',$id)->exists()){
            $meeting = Meeting::find($id);
            $meeting->type = $request->type;
            $meeting->date = $request->date;
            $meeting->comment = $request->comment;
            $meeting->save();
            return response()->json([
                'message'=>'Meeting Record Updated Successfully'
            ],);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(Meeting::where("id",$id)->exists()){
            $meeting = Meeting::find($id);
            $meeting->delete();
            return response()->json([
                'message' => 'Meeting Record Deleted Successfully'
            ], 200);
        }else{
            return response()->json([
                'message' => 'Meeting Record Not Found'
            ],404);
        }
    }
}
