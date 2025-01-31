<?php

namespace App\Http\Controllers;
use App\Models\Student;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Illuminate\Support\Facades\Storage;
use App\Imports\CommonImport;
use App\exports\CommonExport;
use App\Imports\StudentImport;

class ExcelController extends Controller
{
    //

    public function readFile(Request $request){
        if($request->form==1){
            $this->form1();
        }elseif($request->form==2){
            $this->form2();
        }
    }

    public function form1(){
        $file=storage_path('template//CK_B4_StudentRegistrationForm.xlsx');
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader("Xlsx");
        $spreadsheet = $reader->load($file);
        $data=[
            "B1"=>"2024",
            "B2"=>"初一",
            "B3"=>"A",
            "B4"=>"13",
            "B5"=>"陳輝民 陳輝民 陳輝民 陳輝民 陳輝民 陳輝民 陳輝民 陳輝民 陳輝民 陳輝民 陳輝民 陳輝民 陳輝民 陳輝民 陳輝民 陳輝民 陳輝民 陳輝民 陳輝民 陳輝民 陳輝民 陳輝民 陳輝民 陳輝民 陳輝民 陳輝民 陳輝民 陳輝民 陳輝民 陳輝民 陳輝民 陳輝民 陳輝民 陳輝民 陳輝民",
            "B6"=>"Jose Chan",
            "B7"=>"M",
            "B8"=>"1970",
            "C8"=>"07",
            "D8"=>"18",
            "B9"=>"中國",
            "B22"=>"陳大文",
            "C22"=>"父親",
            "D22"=>"54",
            "E22"=>"programmer",
            "F22"=>"my address ....",
            "G22"=>"63860836",
            "B23"=>"",
            "C23"=>"",
            "D23"=>"",
            "E23"=>"",
            "F23"=>"",
            "G23"=>"",
            "B28"=>"YES",
            "B32"=>"2024-03-20",
        ];
        $spreadsheet->getActiveSheet()->getPageMargins()->setTop(1);
        $spreadsheet->getActiveSheet()->getPageMargins()->setBottom(0.5);
        $spreadsheet->getActiveSheet()->getPageMargins()->setLeft(0.5);
        $spreadsheet->getActiveSheet()->getPageMargins()->setRight(0.4);

        $spreadsheet->getActiveSheet()->getPageSetup()->setPrintArea('A1:K27');
        $spreadsheet->getActiveSheet()->getPageSetup()->setFitToWidth(1);
        $spreadsheet->getActiveSheet()->getPageSetup()->setFitToHeight(1);
        
        

        //$spreadsheet->getActiveSheet()->getPageMargins()->setFooter(0.5);
        //$spreadsheet->getActiveSheet()->getHeaderFooter()->setFirstFooter('First footer');
        // $spreadsheet->getActiveSheet()->getHeaderFooter()->setEvenFooter('abc');
        // $spreadsheet->getActiveSheet()->getHeaderFooter()->setOddFooter('abc');
        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setName('Paid');
        $drawing->setDescription('Paid');
        $drawing->setPath(storage_path('template//P1A01.png')); /* put your path and image here */
        $drawing->setCoordinates('K4');
        $drawing->setWidth(150);
        $drawing->setHeight(150);
        //$drawing->setOffsetX(110);
        //$drawing->setRotation(25);
        //$drawing->getShadow()->setVisible(true);
        //$drawing->getShadow()->setDirection(45);
        $drawing->setWorksheet($spreadsheet->getActiveSheet());
        $spreadsheet->getActiveSheet()->getCell('k4')->setValue('');
    
        $sheet1=$spreadsheet->getSheet(1);
        foreach($data as $key=>$value){
            $sheet1->getCell($key)->setValue($value);
        }
        
       $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Mpdf');
       $writer->save(storage_path('template//form1.pdf'));

    }

    public function form2(){
        
        $file=storage_path('template//CK_2022F1A01_student_registration.xlsx');
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader("Xlsx");
        $spreadsheet = $reader->load($file);
        $data=[
            "B1"=>"陳輝民",
            "B2"=>"Jose Chan",
            "B3"=>"2016-04-04",
            "B4"=>"13",
            "B5"=>"F",
            "B6"=>"No",
            "B7"=>"M",
            "C7"=>"",
            "B8"=>"Primary",
            "B9"=>"M",
            "C9"=>"",
            "B10"=>"52031200",
            "B11"=>"M",
            "C11"=>"",
            "B12"=>"2016-12-12",
            "B13"=>"2036-12-12",
            "B14"=>"2025-12-12",
            "B15"=>"2026-12-12",
            "B16"=>"China",
            "B17"=>"GuangZhou",
            "B18"=>"12345678",
            "B19"=>"Macao address 1 ...",
            "B20"=>"28123456",
            "B21"=>"Macao address 2 ...",
            "B22"=>"Building...",
            "B23"=>"Father",
            "B24"=>"F. job",
            "B25"=>"F. mobile",
            "B26"=>"Mother",
            "B27"=>"M. Job",
            "B28"=>"M. mobile",
            "B29"=>"Relation",
            "B30"=>"G. Mobile",
            "B31"=>"Bros",
            "B32"=>"Parents",
            "B33"=>"G. name",
            "B34"=>"G. mobile",
            "B35"=>"G. job",
            "B36"=>"G. phone",
            "B37"=>"M",
            "C37"=>"M",
            "B38"=>"Y",
            "B39"=>"Macao Address 3 ...",
            "B40"=>"building",
            "B41"=>"M",
            "C41"=>"",
            "B42"=>"Remarks .... student description here ....",
            "B43"=>"note 1.....",
            "B44"=>"Note 2....",
            "B45"=>"Note 3......",
            "B46"=>"Note 4.....",
        ];
        $sheet1=$spreadsheet->getSheet(1);
        foreach($data as $key=>$value){
            $sheet1->getCell($key)->setValue($value);
        }
        
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Mpdf');
        $writer->save(storage_path('template//form2.pdf'),'I');
    }

    public function excelToStudents(Request $request){
      
        $tmpPath=$request->file('file')->getRealPath();
        $studentImport= new StudentImport();
        Excel::import($studentImport, $tmpPath);
        $failures=[];
        foreach( $studentImport->failures() as $failure ){
            $failures[]=[
                    'row'=> $failure->row(), // row that went wrong
                    'attribute'=>$failure->attribute(), // either heading key (if using heading row concern) or column index
                    'errors'=>$failure->errors(), // Actual error messages from Laravel validator
                    'values'=>$failure->values(), // Th
            ];
        }
        return redirect()->back()->with('data',['successes'=>$studentImport->getImportedRow(),'failures'=>$failures]);
    }
    public function downloadSheet(){
        $instance=new CommonExport();
        $excelKeys=Student::excelKeys();
        $instance->set_export_data([$excelKeys['keys'],$excelKeys['zh']]);
        return Excel::download($instance, 'example.xlsx');
    }
}
