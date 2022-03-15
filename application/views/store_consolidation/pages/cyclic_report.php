<?php

$this->load->library('fpdf.php');
$this->load->model('AdminModel');
date_default_timezone_set('Asia/Manila');
class PDF extends FPDF
{
	function Header()
	{
		$this->cell(0, 10, "REPORT :", 0, 0, "L");
		//$this->Image('base_url("assets/images/pdf/alturas_logo.png/")'),175,8,30);
		$this->SetFont("Helvetica", "", 9);
		$this->SetTextColor(28, 28, 28);
		$this->Cell(0, 4, date("Y-m-d"), 0, 0, "R");
		$this->Ln(4);
		$this->Cell(179);
		$this->Cell(0, 4, date("g:i a"), 0, 0, "R");

		$this->SetDrawColor(74, 74, 74);
		$this->SetLineWidth(0.1);
		$this->Line(10, 19, 205, 19);

		$this->Ln(8);
	}

	function Footer()
	{
		// Position at 1.5 cm from bottom
		$this->SetY(-15);
		// Arial italic 8
		$this->SetFont('Arial','I',8);
		// Text color in gray
		$this->SetTextColor(128);
		// Page number
		$this->Cell(0,10,'Page '.$this->PageNo(),0,0,'C');
	}	

	function Details($bu_nit, $sec_tion)
	{
		
		$this->SetTextColor(28, 28, 28);
		$this->SetFont("Arial", "B", 10);
		$this->Cell(0, 10, $bu_nit, 0, 0, "L");
		//$this->Cell(0, 10, $vrs, 0, 0, "L");

		$this->SetFont("Arial", "", 8);
		$this->Cell(0, 10, "Prepared By :", 0, 0, "R");
		
		$this->Ln(5);
		$this->SetFont("Arial", "", 9);
		$this->Cell(0, 10, $sec_tion, 0, 0, "L");

		$this->Ln(4);
		$this->SetFont("Arial", "", 8);
		$this->Cell(0, 10, "VARIANCE REPORT", 0, 0, "L");
		$this->SetFont("Arial", "B", 8);
		$this->Cell(0, 10, 'samplename', 0, 0, "R");
		$this->SetTextColor(28, 28, 28);
		
		$this->Ln();
	}

	function FancyTable($header, $item_code, $description, $uom, $qty_db, $qty_excel,  $business_unit, $section, $variance)
	{
		// Colors, line width and bold font
		$this->SetFillColor(255,0,0);
		$this->SetTextColor(255);
		$this->SetDrawColor(128,0,0);
		$this->SetLineWidth(.3);
		$this->SetFont('Arial','B',6);
		// Header
		$w = array(15, 58, 15, 15, 15, 25, 25, 15 );

		for($i=0;$i<count($header);$i++)
			$this->Cell($w[$i],10,$header[$i],1,0,'C',true);
		$this->Ln();
		//$this->Cell(18);
	
		// Color and font restoration
		$this->SetFillColor(224,235,255);
		$this->SetTextColor(0);
		$this->SetFont('Arial','',6);
		// Data
		$fill = false;

 			
		foreach ($item_code as $key => $item_codes) {
			// $val = str_replace(",","",$qty[$key]);
			// $total_qty += $val;
			$this->Cell($w[0],10,$item_codes,1,0,'C',true,$fill);
			$this->Cell($w[1],10,$description[$key],1,0,'C',true,$fill);
			$this->Cell($w[2],10,$uom[$key],1,0,'C',true,$fill);
			$this->Cell($w[3],10,$qty_db[$key],1,0,'C',true,$fill);
			$this->Cell($w[4],10,$qty_excel[$key],1,0,'C',true,$fill);
			$this->Cell($w[5],10,$business_unit[$key],1,0,'C',true,$fill);
			$this->Cell($w[6],10,$section[$key],1,0,'C',true,$fill);
			$this->Cell($w[7],10,$variance[$key],1,0,'C',true,$fill);
			
			$this->Ln();

		}
			// $this->SetFillColor(255,0,0);
			// $this->SetTextColor(255);
			// $this->SetDrawColor(128,0,0);
			// $this->SetLineWidth(.3);
			// $this->SetFont('','B');

			// $this->Cell($w[0],7,'TOTAL',1,0,'C',true);
			// $this->Cell($w[1],7,'',1,0,'C',true);
			// $this->Cell($w[2],7,'',1,0,'C',true);
			// $this->Cell($w[3],7,'',1,0,'C',true);
			// $this->Cell($w[4],7,number_format($total_qty,2),1,0,'C',true);

		$this->Ln();
	
		$this->Cell(array_sum($w),0,'','T');
	}
}
$pdf = new PDF();
// Column headings

$pdf->SetFont('Arial','',12);
$pdf->SetLeftMargin(15);
$pdf->SetRightMargin(15);
$pdf->AddPage();

$bunit = array_unique($business_unit);
$sction = array_unique($section);

$bu_nit = implode(' ', $bunit );
$sec_tion = implode(' ', $sction );
$fname = $bu_nit.' '.$sec_tion;
$filename = str_replace(' ', '_', $fname);

$pdf->Details($bu_nit, $sec_tion);

$header = array('ITEM CODE', 'DESCRIPTION', 'UOM', 'Pcount QTY','NAV QTY', 'BUSINESS UNIT', 'SECTION', 'VARIANCE');
$pdf->SetFont('Arial','',12);
$pdf->FancyTable($header, $item_code, $description, $uom, $qty_db, $qty_excel,  $business_unit, $section, $variance);

$pdf->Output($_SERVER['DOCUMENT_ROOT']."/pcount/assets/images/pdf/".$filename.'_item_report.pdf', 'F');

//$pdf->Output(base_url("assets/images/pdf/").$exelfile.'_item_report.pdf', 'F');

//$path = $_SERVER['DOCUMENT_ROOT']."/store_conso/assets/images/pdf/".$exelfile.'_item_report.pdf';

$path = base_url("assets/images/pdf/").$filename.'_item_report.pdf';

$user_id = $this->session->userdata('user_id');

$id_paths = array( 'user_id' 		=> $user_id, 
				   'file_name' 		=> $fname, 
				   'report_path' 	=> $path, 
				   'date_uploaded' 	=> date("Y-m-d, g:i a"),
				   'time'			=> date("g:i a")
				);

$result = $this->AdminModel->dir_save_cyclic($id_paths);

?>