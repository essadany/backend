<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
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
            'customer_id'=>'required',
            'name'=>'',
            'zone' => 'required',
            'uap'=>''
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
            $product->customer_id = $request->customer_id;
            $product->customer_ref = $request->customer_ref;
            $product->name = $request->name;
            $product->zone = $request->zone;
            $product->uap = $request->uap;
            $product->save();
            return response()->json([
                'message'=>'Product Record Updated Successfully'
            ],);
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
    //get Products By Customer Name
    public function getProductsByCustomerName($customerName)
    {
        // Make an HTTP request to fetch the customer record from the customers API
        $response = Http::get('/customers', [
            'name' => $customerName,
        ]);

        if ($response->successful()) {
            $customer = $response->json();

            // Extract the customer ID from the customer record
            $customerId = $customer['id'];

            // Fetch the products associated with the customer ID from your products database
            $products = Product::where('customer_id', $customerId)->get();

            // Return the list of products
            return $products;
        } else {
            // Handle the case where the request to the customers API failed
            return null;
        }
    }
}
