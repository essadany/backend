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
            'path'=>'required',
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
            $Image->report_id = $request->report_id;
            $Image->path = $request->path;
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
    public function uploadImage(Request $request)
    {
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = uniqid() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('images'), $imageName);

        // Save the image path in the database
        $imagePath = '/images/' . $imageName;
        DB::table('images')->insert([
        'image_path' => $imagePath,
        ]);

        return response()->json(['imagePath' => $imagePath]);
    }

    return response()->json(['message' => 'No image uploaded.'], 400);
    }


}
