<?php

namespace App\Http\Controllers;
use App\Models\Customer;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class customerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Customer::all();
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
            'customer_ref'=>'required',
            'name'=> 'required',
            'category' => 'required',
            'info' => 'required'
        ]);
        if($validator->fails()){
        return $this->sendError('Validation Error, make shure that all input required are not empty', $validator->errors());
        }
        $customer = Customer::create($input);
        return response()->json([ 
            'success'=>true,
            'message'=> 'customer Record Created Successfully',
            'customer'=>$customer
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Customer::find($id);
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
    public function update(Request $request, string $id)
    {
        if(Customer::where('id',$id)->exists()){
            $customer = Customer::find($id);
            $customer->customer_ref = $request->customer_ref;
            $customer->name = $request->name;
            $customer->category = $request->category;
            $customer->info = $request->info;
            $customer->save();
            return response()->json([
                'message'=>'customer Record Updated Successfully'
            ],);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(Customer::where("id",$id)->exists()){
            $customer = Customer::find($id);
            $customer->delete();
            return response()->json([
                'message' => 'customer Record Deleted Successfully'
            ], 200);
        }else{
            return response()->json([
                'message' => 'customer Record Not Found'
            ],404);
        }
    }

 
}
