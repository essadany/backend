<?php

namespace App\Http\Controllers;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Image::all();
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
            'name'=>'required',
            'type'=>'required',
            'bloob'=>'required',  
            'isGood'=>'', 
            'description'=>'',
            'report_id'=>'',
            'annexe_id'=>'',
            'label_check_id'=>''
        ]);
        if($validator->fails()){
        return $this->sendError('Validation Error, make shure that all input required are not empty', $validator->errors());
        }
    $Image = Image::create($input);
    return response()->json([ 
        'success'=>true,
        'message'=> 'Image Record Created Successfully',
        'Image'=>$Image
    ]);
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Image::find($id);
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
        if(Image::where('id',$id)->exists()){
            $Image = Image::find($id);
            $Image->name = $request->name;
            $Image->report_id = $request->report_id;
            $Image->type = $request->type;
            $Image->bloob = $request->bloob;
            $Image->isGood = $request->isGood;
            $Image->description = $request->description;
            $Image->annexe_id = $request->annexe_id;
            $Image->label_check_id = $request->label_check_id;
            $Image->save();
            return response()->json([
                'message'=>'Image Record Updated Successfully'
            ],);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(Image::where("id",$id)->exists()){
            $Image = Image::find($id);
            $Image->delete();
            return response()->json([
                'message' => 'Image Record Deleted Successfully'
            ], 200);
        }else{
            return response()->json([
                'message' => 'Image Record Not Found'
            ],404);
        }
    }
}
