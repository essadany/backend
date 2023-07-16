<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\PPM;
class PPMController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $validator = Validator::make($input, [
            'year' => '',
            'month' => '',
            'week' => '',
            'shipped_parts' => 'required',
            'objectif' => '',
        ]);
        
        if ($validator->fails()) {
            return $this->sendError('Validation Error, make sure that all required inputs are not empty', $validator->errors());
        }
    
        $existingRecord = PPM::where('year', $input['year'])
                            ->where('month', $input['month'])
                            ->where('week', $input['week'])
                            ->first();
    
        if ($existingRecord) {
            $existingRecord->shipped_parts = $input['shipped_parts'];
            $existingRecord->objectif = $input['objectif'];
            $existingRecord->save();
    
            return response()->json([
                'success' => true,
                'message' => 'PPM Record Updated Successfully',
                'PPM' => $existingRecord
            ]);
        }
    
        $ppm = PPM::create($input);
        
        return response()->json([
            'success' => true,
            'message' => 'PPM Record Created Successfully',
            'PPM' => $ppm
        ]);
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        if(PPM::where('id',$id)->exists()){
            $PPM = PPM::find($id);
            $PPM->year = $request->year;
            $PPM->month = $request->month;
            $PPM->week = $request->week;
            $PPM->shipped_parts = $request->shipped_parts;
            $PPM->objectif = $request->objectif;
            $PPM->save();
            return response()->json([
                'message'=>'PPM Record Updated Successfully'
            ],);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
