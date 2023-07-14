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
use Illuminate\Support\Facades\File;

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
        // Create a copy of the Excel file
        $copyPath = storage_path("Bontaz_copy.xlsx");
        File::copy($filePath, $copyPath);
        $claim = Claim::find($claim_id);

        // Load the existing Excel file
        $spreadsheet = IOFactory::load($copyPath);
        $sheet1 = $spreadsheet->getSheetByName("20. 8D Report");
        $sheet2 = $spreadsheet->getSheetByName("21. 8D Annex");
        $sheet3 = $spreadsheet->getSheetByName("30. Team");
        $sheet4 = $spreadsheet->getSheetByName("31. Description");
        $sheet5 = $spreadsheet->getSheetByName("32. Label checking");
        $sheet6 = $spreadsheet->getSheetByName("33. Containment");
        $sheet7 = $spreadsheet->getSheetByName("35. Ishikawa");
        $sheet8 = $spreadsheet->getSheetByName("36. 5 Why");
        $sheet9 = $spreadsheet->getSheetByName("37. Effectiveness");

        // Retrieve data from the database
        $report = $claim->report; 
        $potential_actions = $report->actions()->where('type','potential')->get();
        $implemented_actions = $report->actions()->where('type','implemented')->get();
        $preventive_actions = $report->actions()->where('type','preventive')->get();
        $product = $claim->product;
        $prob_desc = $claim->prob_desc;
        

        $report_images = $report->images()->get();
        foreach ($report_images as $image){
            $drawing1 = new Drawing();
            $drawing1->setPath(storage_path('app/'.$image->path));
            $drawing1->setWidth(80);
            $drawing1->setHeight(80);
            $drawing1->setCoordinates('M12');
            $drawing1->setWorksheet($sheet1);
        }
        $goodPart = $prob_desc->images()->where('isGood','1')->first();
        $badPart = $prob_desc->images()->where('isGood','0')->first();
        if ($badPart!==null){
            $drawing1 = new Drawing();
            $drawing1->setPath(storage_path('app/'.$badPart->path));
            $drawing1->setWidth(80);
            $drawing1->setHeight(80);
            $drawing1->setCoordinates('H12');
            $drawing1->setWorksheet($sheet1);
        }
        if ($goodPart!==null){
            $drawing2 = new Drawing();
            $drawing2->setPath(storage_path('app/'.$goodPart->path??''));
            $drawing2->setWidth(80);
            $drawing2->setHeight(80);
            $drawing2->setCoordinates('K12');
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
        
        $analyse_images = $prob_desc->images()->where('isGood',null)->get();

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
        // Label Checking --------------------------------------------
        $label_check = $claim->label_checking;
        $label_image = $label_check->image;
        
        $sheet5->setCellValue('D2', $product->customer_ref);
        $sheet5->setCellValue('D3', $claim->refRecClient);
        $sheet5->setCellValue('D4', $claim->opening_date);
        $sheet5->setCellValue('D6', $claim->product_ref);
        $sheet5->setCellValue('D7', $label_check->sorting_method);
        $sheet5->setCellValue('D8', $label_check->bontaz_plant);
        if ($label_image!==null){
            $drawing5 = new Drawing();
            $drawing5->setPath(storage_path('app/'.$label_image->path??''));
            $drawing5->setWidth(80);
            $drawing5->setHeight(90);
            $drawing5->setCoordinates('G3');
            $drawing5->setWorksheet($sheet5);
        }
        
        $sheet5->setCellValue('D11', $product->customer_ref);
        $sheet5->setCellValue('D12', $claim->refRecClient);
        $sheet5->setCellValue('D13', $claim->opening_date);
        $sheet5->setCellValue('D15', $claim->product_ref);
        $sheet5->setCellValue('D16', $label_check->sorting_method);
        $sheet5->setCellValue('D17', $label_check->bontaz_plant);
        if ($label_image!==null){
            $drawing5 = new Drawing();
            $drawing5->setPath(storage_path('app/'.$label_image->path??''));
            $drawing5->setWidth(80);
            $drawing5->setHeight(90);
            $drawing5->setCoordinates('G12');
            $drawing5->setWorksheet($sheet5);
        }
        $sheet5->setCellValue('D20', $product->customer_ref);
        $sheet5->setCellValue('D21', $claim->refRecClient);
        $sheet5->setCellValue('D22', $claim->opening_date);
        $sheet5->setCellValue('D24', $claim->product_ref);
        $sheet5->setCellValue('D25', $label_check->sorting_method);
        $sheet5->setCellValue('D26', $label_check->bontaz_plant);
        if ($label_image!==null){
            $drawing5 = new Drawing();
            $drawing5->setPath(storage_path('app/'.$label_image->path??''));
            $drawing5->setWidth(80);
            $drawing5->setHeight(90);
            $drawing5->setCoordinates('G21');
            $drawing5->setWorksheet($sheet5);
        }   
        $sheet5->setCellValue('D29', $product->customer_ref);
        $sheet5->setCellValue('D30', $claim->refRecClient);
        $sheet5->setCellValue('D31', $claim->opening_date);
        $sheet5->setCellValue('D33', $claim->product_ref);
        $sheet5->setCellValue('D34', $label_check->sorting_method);
        $sheet5->setCellValue('D35', $label_check->bontaz_plant);
        if ($label_image!==null){
            $drawing5 = new Drawing();
            $drawing5->setPath(storage_path('app/'.$label_image->path??''));
            $drawing5->setWidth(80);
            $drawing5->setHeight(90);
            $drawing5->setCoordinates('G30');
            $drawing5->setWorksheet($sheet5);
        }
        //Effectivness -------------------------------------------
        $eff = $report->effectiveness;
        $sheet9->setCellValue('B6', $claim->internal_ID);
        $sheet9->setCellValue('G6', $claim->product_ref);
        $sheet9->setCellValue('L6', $eff->updated_at);
        $sheet9->setCellValue('C10', $eff->description);
        // Five why-------------------------------------
        $five_why = $claim->five_why;
        $sheet8->setCellValue('B6', $claim->internal_ID);
        $sheet8->setCellValue('G6', $claim->product_ref);
        $sheet8->setCellValue('L6', $five_why->updated_at);
        $results_occurence = $five_why->results()->where('type','occurence')->first();
        $results_detection = $five_why->results()->where('type','detection')->first();
        $results_system = $five_why->results()->where('type','system')->first();
        $five_whys_occurence = $five_why->five_lignes()->where('type','occurence')->get();
        $five_whys_detection = $five_why->five_lignes()->where('type','detection')->get();
        $five_whys_system = $five_why->five_lignes()->where('type','system')->get();
        $row = 9;
        foreach($five_whys_occurence as $item){
            $row1 = $row+1;
            $sheet8->mergeCells('D'.$row.':M'.$row);
            $sheet8->mergeCells('E'.$row1.':M'.$row1);
            $sheet8->setCellValue('D'.$row, $item->why);
            $sheet8->setCellValue('E'.$row1, $item->answer);
            $row=$row+2;
        }
        $row = 25;
        foreach($five_whys_detection as $item){
            $row1 = $row+1;
            $sheet8->mergeCells('D'.$row.':M'.$row);
            $sheet8->mergeCells('E'.$row1.':M'.$row1);
            $sheet8->setCellValue('D'.$row, $item->why);
            $sheet8->setCellValue('E'.$row1, $item->answer);
            $row=$row+2;
                 }
        $row = 41;
        foreach($five_whys_system as $item){
            $row1 = $row+1;
            $sheet8->mergeCells('D'.$row.':M'.$row);
            $sheet8->mergeCells('E'.$row1.':M'.$row1);
            $sheet8->setCellValue('D'.$row, $item->why);
            $sheet8->setCellValue('E'.$row1, $item->answer);
            $row=$row+2;
        }
        $sheet8->mergeCells('E21:M22');
        $sheet8->mergeCells('E37:M38');
        $sheet8->mergeCells('E53:M54');
        $sheet8->setCellValue('F21', $results_occurence->input);
        $sheet8->setCellValue('F37', $results_detection->input);
        $sheet8->setCellValue('F53', $results_system->input);
        // Ishikawa-------------------------------------------------------
        $ishikawa = $claim->ishikawa;
        $categories = $ishikawa->categories()->get();
        $sheet7->setCellValue('B6', $claim->internal_ID);
        $sheet7->setCellValue('AG6', $claim->product_ref);
        $sheet7->setCellValue('BU6', $ishikawa->updated_at);
        $ishikawa_person = $categories->where('type','Person');
        $ishikawa_machine = $categories->where('type','Machine');
        $ishikawa_materials = $categories->where('type','Materials');
        $ishikawa_method = $categories->where('type','Method');
        $ishikawa_management = $categories->where('type','Management');
        $ishikawa_measurement = $categories->where('type','Measurement');
        $ishikawa_environment = $categories->where('type','Environment');
        $ishikawa_money = $categories->where('type','Money');
        $row = 45;
        foreach($ishikawa_person as $item){
            $sheet7->mergeCells('N'.$row.':AH'.$row);
            $sheet7->mergeCells('AI'.$row.':AP'.$row);
            $sheet7->mergeCells('AQ'.$row.':CE'.$row);
            $sheet7->setCellValue('N'.$row, $item->input);
            $sheet7->setCellValue('AI'.$row, $item->influence);
            $sheet7->setCellValue('AQ'.$row, $item->comment);
            $row++;
        }
        $row =51;
        foreach($ishikawa_machine as $item){
            $sheet7->mergeCells('N'.$row.':AH'.$row);
            $sheet7->mergeCells('AI'.$row.':AP'.$row);
            $sheet7->mergeCells('AQ'.$row.':CE'.$row);
            $sheet7->setCellValue('N'.$row, $item->input);
            $sheet7->setCellValue('AI'.$row, $item->influence);
            $sheet7->setCellValue('AQ'.$row, $item->comment);
            $row++;
        }
        $row=57;
        foreach($ishikawa_materials as $item){
            $sheet7->mergeCells('N'.$row.':AH'.$row);
            $sheet7->mergeCells('AI'.$row.':AP'.$row);
            $sheet7->mergeCells('AQ'.$row.':CE'.$row);
            $sheet7->setCellValue('N'.$row, $item->input);
            $sheet7->setCellValue('AI'.$row, $item->influence);
            $sheet7->setCellValue('AQ'.$row, $item->comment);
            $row++;
        }
        $row=63;
        foreach($ishikawa_method as $item){
            $sheet7->mergeCells('N'.$row.':AH'.$row);
            $sheet7->mergeCells('AI'.$row.':AP'.$row);
            $sheet7->mergeCells('AQ'.$row.':CE'.$row);
            $sheet7->setCellValue('N'.$row, $item->input);
            $sheet7->setCellValue('AI'.$row, $item->influence);
            $sheet7->setCellValue('AQ'.$row, $item->comment);
            $row++;
        }
        $row = 69;
        foreach($ishikawa_management as $item){
            $sheet7->mergeCells('N'.$row.':AH'.$row);
            $sheet7->mergeCells('AI'.$row.':AP'.$row);
            $sheet7->mergeCells('AQ'.$row.':CE'.$row);
            $sheet7->setCellValue('N'.$row, $item->input);
            $sheet7->setCellValue('AI'.$row, $item->influence);
            $sheet7->setCellValue('AQ'.$row, $item->comment);
            $row++;
        }
        $row = 75;
        foreach($ishikawa_measurement as $item){
            $sheet7->mergeCells('N'.$row.':AH'.$row);
            $sheet7->mergeCells('AI'.$row.':AP'.$row);
            $sheet7->mergeCells('AQ'.$row.':CE'.$row);
            $sheet7->setCellValue('N'.$row, $item->input);
            $sheet7->setCellValue('AI'.$row, $item->influence);
            $sheet7->setCellValue('AQ'.$row, $item->comment);
            $row++;
        }
        $row = 81;
        foreach($ishikawa_environment as $item){
            $sheet7->mergeCells('N'.$row.':AH'.$row);
            $sheet7->mergeCells('AI'.$row.':AP'.$row);
            $sheet7->mergeCells('AQ'.$row.':CE'.$row);
            $sheet7->setCellValue('N'.$row, $item->input);
            $sheet7->setCellValue('AI'.$row, $item->influence);
            $sheet7->setCellValue('AQ'.$row, $item->comment);
            $row++;
        }
        $row=87;
        foreach($ishikawa_money as $item){
            $sheet7->mergeCells('N'.$row.':AH'.$row);
            $sheet7->mergeCells('AI'.$row.':AP'.$row);
            $sheet7->mergeCells('AQ'.$row.':CE'.$row);
            $sheet7->setCellValue('N'.$row, $item->input);
            $sheet7->setCellValue('AI'.$row, $item->influence);
            $sheet7->setCellValue('AQ'.$row, $item->comment);
            $row++;
        }
        // Containement-------------------------------------------------------
        $containement = $claim->containement;
        $sortings = $containement->sortings()->get();
        $sheet6->mergeCells('C9:M17');
        $sheet6->mergeCells('C18:M21');
        $sheet6->mergeCells('B36:M55');
        $sheet6->setCellValue('B6', $claim->internal_ID);
        $sheet6->setCellValue('G6', $claim->product_ref);
        $sheet6->setCellValue('L6', $containement->updated_at);
        $sheet6->setCellValue('C9', $containement->method_description);
        $sheet6->setCellValue('C18', $containement->method_validation);
        $sheet6->setCellValue('B36', $containement->risk_assesment);

        $row = 25;
        foreach($sortings as $sorting){
            $sheet6->setCellValue('B'.$row, $sorting->location_company);
            $sheet6->setCellValue('F'.$row, $sorting->qty_to_sort);
            $sheet6->setCellValue('H'.$row, $sorting->qty_sorted);
            $sheet6->setCellValue('J'.$row, $sorting->qty_NOK);
            $sheet6->setCellValue('L'.$row, $sorting->scrap);
            $row++;
        }


        // Save the modified Excel file
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save($copyPath);

        // Create a file response
        $headers = [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ];

        $response = response()->download($copyPath, 'data.xlsx', $headers);
        // Delete the copied file
        return $response;




        
    }

    
}




