<?php
$this->load->model('AdminModel');
$this->load->library('PHPExcel');
date_default_timezone_set('Asia/Manila');
$objPHPExcel = new PHPExcel();
$count = 1;

//////////////////////size adjust per column///////////////////////////////////////

    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(60);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(30);
    $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
    $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(10);

////////////////////HEADER title///////////////////////////////////////////////////////

    $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0,1, 'ITEM CODE');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1,1, 'DESCRIPTION');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(2,1, 'UOM');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(3,1, 'QTY PHYSICAL COUNT');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(4,1, 'QTY NAV');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(5,1, 'BUSINESS UNIT');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(6,1, 'SECTION');
    $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(7,1, 'VARIANCE');

///////////////loop through array of data///////////////////////////////////////////////        

    foreach ($item_code as $key => $item_codes) {
        $count++;
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0,$count, $item_codes);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1,$count, $description[$key]);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(2,$count, $uom[$key]);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(3,$count, $qty_db[$key]);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(4,$count, $qty_excel[$key]);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(5,$count, $business_unit[$key]);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(6,$count, $section[$key]);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(7,$count, $variance[$key]);  
    }

// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment;filename=\"".$exelfile."\".xls");
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

$bunit = array_unique($business_unit);
$sction = array_unique($section);

$bu_nit = implode(' ', $bunit );
$sec_tion = implode(' ', $sction );
$fname = $bu_nit.' '.$sec_tion;
$filename = str_replace(' ', '_', $fname);

$objWriter->save($_SERVER['DOCUMENT_ROOT']."/pcount/assets/images/excel/".$filename.'_item_report.xls');

$path = base_url("assets/images/excel/").$filename.'_item_report.xls';
//var_dump($path);
$user_id = $this->session->userdata('user_id');

$excel_paths = array( 'excel_report' => $path );

$fname_user = array('user_id' => $user_id, 'file_name' => $fname );
                   
$result = $this->AdminModel->save_excel_path($excel_paths, $fname_user);

?>