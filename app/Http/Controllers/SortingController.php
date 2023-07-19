<?php

namespace App\Http\Controllers;
use App\Models\Sorting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class SortingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Sorting::all();
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
            'containement_id'=>'required',
            'location_company'=>'required',
            'qty_to_sort'=>'required',
            'qty_sorted'=>'required',
            'qty_NOK'=>'required',
        ]);
        if($validator->fails()){
        return $this->sendError('Validation Error, make shure that all input required are not empty', $validator->errors());
        }
         // Calculate the scrap value (qty_NOK / qty_sorted)
    $scrap = $input['qty_sorted'] !== 0 ? (100*$input['qty_NOK'] / $input['qty_sorted']).'%' : '0%';
    
    // Add the calculated scrap value to the input array
    $input['scrap'] = $scrap;
    $Sorting = Sorting::create($input);
    return response()->json([ 
        'success'=>true,
        'message'=> 'Sorting Record Created Successfully',
        'Sorting'=>$Sorting
    ]);
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Sorting::find($id);
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
        if(Sorting::where('id',$id)->exists()){
            $Sorting = Sorting::find($id);
            $Sorting->containement_id = $request->containement_id;
            $Sorting->location_company = $request->location_company;
            $Sorting->qty_to_sort = $request->qty_to_sort;
            $Sorting->qty_sorted = $request->qty_sorted;
            $Sorting->qty_NOK = $request->qty_NOK;
            $Sorting->scrap = $Sorting->qty_sorted !== 0 ? (($Sorting->qty_NOK / $Sorting->qty_sorted) * 100).'%' : '0%';
            $Sorting->save();
            return response()->json([
                'message'=>'Sorting Record Updated Successfully'
            ],);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(Sorting::where("id",$id)->exists()){
            $Sorting = Sorting::find($id);
            $Sorting->delete();
            return response()->json([
                'message' => 'Sorting Record Deleted Successfully'
            ], 200);
        }else{
            return response()->json([
                'message' => 'Sorting Record Not Found'
            ],404);
        }
    }
}
