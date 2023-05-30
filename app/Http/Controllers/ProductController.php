<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Product::all();
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
            'product_ref'=>'required',
            'customer_ref'=>'required',
            'name',
            'zone' => 'required',
            'uap'
        ]);
        if($validator->fails()){
        return $this->sendError('Validation Error, make shure that all input required are not empty', $validator->errors());
        }
    $product = Product::create($input);
    return response()->json([ 
        'success'=>true,
        'message'=> 'Product Record Created Successfully',
        'product'=>$product
    ]);
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Product::find($id);
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
        if(Product::where('id',$id)->exists()){
            $product = Product::find($id);
            $product->product_ref = $request->product_ref;
            $product->customer_ref = $request->customer_ref;
            $product->name = $request->name;
            $product->zone = $request->zone;
            $product->uap = $request->uap;
            $product->save();
            return response()->json([
                'message'=>'Product Record Updated Successfully'
            ],404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(Product::where("id",$id)->exists()){
            $product = Product::find($id);
            $product->delete();
            return response()->json([
                'message' => 'Product Record Deleted Successfully'
            ], 200);
        }else{
            return response()->json([
                'message' => 'Product Record Not Found'
            ],404);
        }
    }
}
