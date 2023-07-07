<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use App\Models\User;
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
    public function populateExcel()
    {
        // Path to the existing Excel file
        $filePath = 'H:/Bontaz.xlsx';

        // Load the existing Excel file
        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();

        // Retrieve data from the database
        $data = User::all(); // Replace with your actual model and data retrieval logic

        // Populate the Excel sheet with data
        $row = 45; // Starting row (e.g., 2 to skip header row)
        foreach ($data as $item) {
            // Set value in merged cells
            $sheet->mergeCells('AQ' . $row . ':CE' . $row); // Assuming cells A and B are merged
            $sheet->setCellValue('AQ' . $row, $item->column1); // Replace 'column1' with your actual column name

            // Add more cell population code for other columns as needed
            // For example, if cells C and D are merged:
            // $sheet->mergeCells('C' . $row . ':D' . $row);
            // $sheet->setCellValue('C' . $row, $item->column2);

           // $row++;
        }

        // Save the modified Excel file
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save($filePath);

        return response()->json(['file' => $filePath]);
    }
}




