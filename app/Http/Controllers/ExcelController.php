<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Models\User;
use App\Models\Claim;
use App\Models\Image;

use Illuminate\Http\Response;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class ExcelController extends Controller
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function populateExcel(Request $request , $claim_id)
    {
        // Path to the existing Excel file
        $filePath = storage_path("app/public/excel/Bontaz.xlsx");
        $claim = Claim::find($claim_id);

        // Load the existing Excel file
        $spreadsheet = IOFactory::load($filePath);
        $sheet1 = $spreadsheet->getSheetByName("20. 8D Report");
        $sheet2 = $spreadsheet->getSheetByName("21. 8D Annex");
        $sheet3 = $spreadsheet->getSheetByName("30. Team");
        $sheet4 = $spreadsheet->getSheetByName("31. Description");
        $sheet5 = $spreadsheet->getSheetByName("32. Label checking");
        $sheet6 = $spreadsheet->getSheetByName("33. Containment");
        $sheet7 = $spreadsheet->getSheetByName("35. Ishikawa");
        $sheet8 = $spreadsheet->getSheetByName("36. 5 Why");
        // Retrieve data from the database
        $report = $claim->report; 
        $potential_actions = $report->actions()->where('type','potential')->get();
        $implemented_actions = $report->actions()->where('type','implemented')->get();
        $preventive_actions = $report->actions()->where('type','preventive')->get();
        $product = $claim->product;
        $prob_desc = $claim->prob_desc;
       // $image = $prob_desc->images()->get()->first();
        $containement = $claim->containement;
        $five_why = $claim->five_why;
        $results_occurence = $five_why->results()->where('type','occurence')->first();
        $results_detection = $five_why->results()->where('type','detection')->first();

        $goodPart = $prob_desc->images()->where('isGood','1')->first();
        $badPart = $prob_desc->images()->where('isGood','0')->first();
        if ($badPart!==null){
            $drawing1 = new Drawing();
            $drawing1->setPath(storage_path('app/'.$badPart->path));
            $drawing1->setWidth(80);
            $drawing1->setHeight(90);
            $drawing1->setCoordinates('I12');
            $drawing1->setWorksheet($sheet1);
        }
        if ($goodPart!==null){
            $drawing2 = new Drawing();
            $drawing2->setPath(storage_path('app/'.$goodPart->path??''));
            $drawing2->setWidth(80);
            $drawing2->setHeight(90);
            $drawing2->setCoordinates('L12');
            $drawing2->setWorksheet($sheet1);
        }

        // Populate the Excel sheet with data
        $sheet1->setCellValue('B6', $claim->refRecClient);
        $sheet1->setCellValue('G6', $claim->internal_ID);
        $sheet1->setCellValue('L6', $claim->opening_date);
        $sheet1->setCellValue('B9', $product->name);
        $sheet1->setCellValue('L9', $report->updated_at);
        $sheet1->setCellValue('B12', $prob_desc->what);
        $sheet1->setCellValue('D16', "Engraving : $claim->engraving \n Production date : $claim->prod_date");
        $sheet1->setCellValue('N16', $prob_desc->recurrence);
        $sheet1->setCellValue('B19', $report->containement_actions);
        $sheet1->setCellValue('E23', $report->first_batch3);
        $sheet1->setCellValue('B27', $results_occurence->input??'');
        $sheet1->setCellValue('B32', $results_detection->input??'');
        $sheet1->setCellValue('G36', $report->bontaz_fault);
        $sheet1->setCellValue('L36', $report->date_cause_definition);


        $row = 39;
        foreach ($potential_actions as $item) {
            $user = $item->user;
            $pilot = $user->name;
            $sheet1->setCellValue('B' . $row, $item->action); 
            $sheet1->setCellValue('L' . $row, $pilot); 
            $sheet1->setCellValue('M' . $row, $item->planned_date); 
            $sheet1->setCellValue('N' . $row, $item->status); 
            $row++;
           
        }
        $sheet1->setCellValue('D44', $report->ddm);
        $sheet1->setCellValue('G44', $report->pilot);
        $sheet1->setCellValue('L44', $report->approved);


        $row = 47;
        foreach ($implemented_actions as $item) {
            $user = $item->user;
            $pilot = $user->name;
            $sheet1->setCellValue('B' . $row, $item->action); 
            $sheet1->setCellValue('L' . $row, $pilot); 
            $sheet1->setCellValue('M' . $row, $item->planned_date); 
            $sheet1->setCellValue('N' . $row, $item->status); 
            $row++;
           
        }
        $sheet1->setCellValue('D57', $report->dfmea);
        $sheet1->setCellValue('G57', $report->pfmea);
        $sheet1->setCellValue('J57', $report->ctrl_plan);
        $sheet1->setCellValue('M57', $report->others);
        $sheet1->setCellValue('K60', $report->sub_date);


        $row = 54;
        foreach ($preventive_actions as $item) {
            $user = $item->user;
            $pilot = $user->name;
            $sheet1->setCellValue('B' . $row, $item->action); 
            $sheet1->setCellValue('L' . $row, $pilot); 
            $sheet1->setCellValue('M' . $row, $item->planned_date); 
            $sheet1->setCellValue('N' . $row, $item->status); 
            $row++;
           
        }

        // ----------------------  Annexe  --------------------------------
        $sheet2->setCellValue('B6', $claim->refRecClient);
        $sheet2->setCellValue('H6', $claim->internal_ID);
        //------------------------- Team  ---------------------------------
        $team = $claim->team;
        $leader = $team->users()->where('role','leader')->first();
        $sheet3->setCellValue('B6', $claim->refRecClient);
        $sheet3->setCellValue('L6', $claim->opening_date);
        $sheet3->setCellValue('G6', $product->name);
        $sheet3->setCellValue('B9', $leader->name??'');
        $sheet3->setCellValue('G9', $leader->phone??'');
        $sheet3->setCellValue('J9', $leader->email??'');
        //------------------------ Meetings -----------------------------
        $cont = $team->meetings()->where('type','Containement')->first();
        $ana1 = $team->meetings()->where('type','Analyse1')->first();
        $ana2 = $team->meetings()->where('type','Analyse2')->first(); 
        $clos = $team->meetings()->where('type','Closure')->first(); 
        $sheet3->setCellValue('F13', $cont->date??''); 
        $sheet3->setCellValue('H13', $ana1->date??''); 
        $sheet3->setCellValue('J13', $ana2->date??'');
        $sheet3->setCellValue('L13', $clos->date??''); 
        $row = 15;
        $users = $team->users()->get();
        foreach ($users as $item) {
            $sheet3->setCellValue('B'.$row, $item->name??''); 
            $sheet3->setCellValue('D'.$row, $item->fonction??''); 
            $row++;
           
        }
        // ----------------------  Problem description  --------------------------------
        $sheet4->setCellValue('B6', $claim->internal_ID);
        $sheet4->setCellValue('G6', $product->name);
        $sheet4->setCellValue('L6', $claim->opening_date);
        $sheet4->setCellValue('F9', $prob_desc->what);
        $sheet4->setCellValue('E11', $prob_desc->recurrence);
        $sheet4->setCellValue('F12', $prob_desc->who);
        $sheet4->setCellValue('F15', $prob_desc->where);
        $sheet4->setCellValue('F18', $prob_desc->when);
        $sheet4->setCellValue('F21', $prob_desc->why);
        $sheet4->setCellValue('F24', $prob_desc->who);
        $sheet4->setCellValue('F28', $prob_desc->how_many_before);
        $sheet4->setCellValue('J28', $prob_desc->how_many_after);
        $sheet4->setCellValue('G31', $prob_desc->received);
        $sheet4->setCellValue('L31', $prob_desc->date_reception);
        $sheet4->setCellValue('B51', $prob_desc->bontaz_fault);
        $sheet4->setCellValue('G51', $prob_desc->date_done);
        $sheet4->setCellValue('B32', $prob_desc->description);
        
        $analyse_images = $prob_desc->images()->where('problem_id',$prob_desc->id)->where('isGood',null)->get();

        if ($badPart!==null){
            $drawing1 = new Drawing();
            $drawing1->setPath(storage_path('app/'.$badPart->path));
            $drawing1->setWidth(80);
            $drawing1->setHeight(90);
            $drawing1->setCoordinates('K11');
            $drawing1->setWorksheet($sheet4);
        }
        if ($goodPart!==null){
            $drawing2 = new Drawing();
            $drawing2->setPath(storage_path('app/'.$goodPart->path??''));
            $drawing2->setWidth(80);
            $drawing2->setHeight(90);
            $drawing2->setCoordinates('K20');
            $drawing2->setWorksheet($sheet4);
        }
        
        $cord = ['C40','F40','K40','B44','F44','K44'];
        $i =0;
        foreach ($analyse_images as $item) {
            $drawing1 = new Drawing();
            $drawing1->setPath(storage_path('app/'.$item->path??''));
            $drawing1->setWidth(50);
            $drawing1->setHeight(50);
            $drawing1->setCoordinates($cord[$i]);
            $drawing1->setWorksheet($sheet4);
            $i++;  
        }







        // Save the modified Excel file
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save($filePath);

        // Create a file response
        $headers = [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ];

        return response()->download($filePath, 'data.xlsx', $headers);

        $cellsToClear = ['B6',
        'G6','L6','B9','L9','B12','D16','N16', 'I13']; // Add more cell coordinates if needed
        foreach ($cellsToClear as $cell) {
            $sheet1->setCellValue($cell, '');
        }
        $cellCoordinate = 'I13'; // Cell coordinate with the image

        // Remove the drawing object from the cell
        $drawingObjects = $sheet->getDrawingCollection();
        foreach ($drawingObjects as $drawing) {
            if ($drawing->getCoordinates() === $cellCoordinate) {
                $sheet->getDrawingCollection()->remove($drawing);
            }
        }
        $sheet1->clearAllData();
    }

    
}




