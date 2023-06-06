<?php

namespace App\Http\Controllers;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Category::all();
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
            'ishikawa_id'=>'required',
            'type'=>'required',
            'input'=>'required',
            'isPrincipale'=>'required',
            'status'=>'required',
            'influence'=>'required',
            'comment'=>''
        ]);
        if($validator->fails()){
        return $this->sendError('Validation Error, make shure that all input required are not empty', $validator->errors());
        }
    $Category = Category::create($input);
    return response()->json([ 
        'success'=>true,
        'message'=> 'Category Record Created Successfully',
        'Category'=>$Category
    ]);
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Category::find($id);
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
        if(Category::where('id',$id)->exists()){
            $Category = Category::find($id);
            $Category->report_id = $request->report_id;
            $Category -> ishikawa_id = $request ->ishikawa_id;
            $Category -> type = $request ->type;
            $Category -> input = $request ->input;
            $Category -> isPrincipale = $request ->isPrincipale;
            $Category -> status = $request ->status;
            $Category -> influence = $request ->influence;
            $Category -> comment = $request ->commen;
            $Category->save();
            return response()->json([
                'message'=>'Category Record Updated Successfully'
            ],);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(Category::where("id",$id)->exists()){
            $Category = Category::find($id);
            $Category->delete();
            return response()->json([
                'message' => 'Category Record Deleted Successfully'
            ], 200);
        }else{
            return response()->json([
                'message' => 'Category Record Not Found'
            ],404);
        }
    }
}
