<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
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
            'customer_code'=>'required',
            'name'=>'',
            'zone' => 'required',
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
            $product->customer_code = $request->customer_code;
            $product->name = $request->name;
            $product->zone = $request->zone;
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
            $product->deleted = 1;
            return response()->json([
                'message' => 'Product Record Deleted Successfully'
            ], 200);
        }else{
            return response()->json([
                'message' => 'Product Record Not Found'
            ],404);
        }
    }
    //
    public function getCustomerNameByProductId($id)
    {
        $product = Product::find($id);
        $customer = $product->customer;
        return response()->json($customer);
        //$customerName = $product->customer->name;
        //return response()->json(['customer_name' => $customerName]);
    }

    public function getCustomerIdByName($name)
    {
        
        $customer_id = DB::table('products')
            ->join('customers', 'products.customer_code', '=', 'customers.code')
            ->where('customers.name', '=', $name)
            ->select( 'customers.code')
            ->get();
        return $customer_id;
    }
    
    //Disactivate Product
    public function disactivate(Request $request, $id)
    {
        if(Product::where('id',$id)->exists()){
            $product = Product::find($id);
            $product->deleted = true;
            
            $product->save();
            return response()->json([
                'message'=>'Product Record Disactivated Successfully'
            ],);
        }
    }
    //Get Activated Products
    public function getActivatedProducts(){
        $Products = DB::table('products')
            ->where('products.deleted',false)
            ->select( 'products.*')
            ->get();
        return $Products;
    }
    //Products join Customers
    public function getProductsJoinCustomers(){
        $products = DB::table('products')
            ->leftJoin('customers', 'products.customer_code', '=', 'customers.code')
            ->where('products.deleted',false)
            ->select( 'products.id as product_id','product_ref','products.name as product_name','products.customer_code','customers.name as customer_name','products.zone','products.deleted')
            ->get();
        return $products;
    }

}
