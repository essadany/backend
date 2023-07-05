<?php

namespace App\Http\Controllers;
use App\Models\Image;
use App\Models\LabelChecking;
use App\Models\ProblemDescription;
use App\Models\Report;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;

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
            'path'=>'required',
            'isGood'=>'', 
            'description'=>'',
            'report_id'=>'',
            'problem_id'=>'',
            'annexe_id'=>'',
            'label_checking_id'=>''
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
    $image = Image::find($id);
    if ($image) {
        $image->isGood = $request->input('isGood');
        $image->description = $request->input('description');

        // Check if the user has uploaded a new image file
        if ($request->hasFile('path')) {
            // Delete the old image file
            Storage::delete($image->path);

            // Store the new image file
            $newPath = $request->file('path')->store('images');
            $image->update([
                'path' => $newPath,
            ]);
        }
        $image->save();

        return response()->json([
            'message' => 'Image Record Updated Successfully'
        ]);
    } else {
        return response()->json([
            'message' => 'Image Record Not Found'
        ], 404);
    }
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(Image::where("id",$id)->exists()){
            $Image = Image::find($id);
            Storage::delete($image->path);
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
    public function getImageOfLabelChecking($label_id){
        $label = LabelChecking :: find($label_id);
        if ($label !== null && $label->image !== null) {
            $image = $label->image;
            $image->path = asset('/' . $image->path);
            return response()->json($image);
        } else {
            // Handle the case when $label or $label->image is null
            // You can return an appropriate response or perform error handling
        }
    }
    public function getImgagesOfProblemDescription($id){
        $problem = ProblemDescription :: find($id);
        $images = $problem->images()->get();
        foreach($images as $image){
            $image->path = asset('/' . $image->path);

        }

        return response()->json($images);
    }
    public function getImgagesOfReport($id){
        $report = Report :: find($id);
        $images = $report->images()->get();
        foreach($images as $image){
            $image->path = asset('/' . $image->path);

        }

        return response()->json($images);
    }

    public function addImage(Request $request){
        $image = new Image();
        $image->isGood=$request->input('isGood');
        $image->report_id=$request->input('report_id');
        $image->problem_id=$request->input('problem_id');
        $image->description=$request->input('description');
        $image->annexe_id=$request->input('annexe_id');
        $image->description=$request->input('description');
        $image->label_checking_id=$request->input('label_checking_id');
        $image->path=$request->file('path')->store('images');
        $image->save();
        return $image;

    
    }


}
