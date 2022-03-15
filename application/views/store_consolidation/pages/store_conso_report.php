<?php

$this->load->library('fpdf.php');
$this->load->model('AdminModel');

class PDF extends FPDF
{
	function Header()
	{
		$this->cell(0, 10, "REPORT :", 0, 0, "L");
		//$this->Image('base_url("assets/images/pdf/alturas_logo.png/")'),175,8,30);
		$this->SetFont("Helvetica", "", 9);
		$this->SetTextColor(28, 28, 28);
		$this->Cell(0, 4, date("F j, Y"), 0, 0, "R");
		$this->Ln(4);
		$this->Cell(179);
		$this->Cell(0, 4, date("h:i:s a"), 0, 0, "R");

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

	function Details()
	{
		
		$this->SetTextColor(28, 28, 28);
		$this->SetFont("Arial", "B", 10);
		$this->Cell(0, 10, "ISLAND CITY MALL :", 0, 0, "L");
		//$this->Cell(0, 10, $vrs, 0, 0, "L");

		$this->SetFont("Arial", "", 8);
		$this->Cell(0, 10, "Prepared By :", 0, 0, "R");
		
		$this->Ln(5);
		$this->SetFont("Arial", "", 9);
		$this->Cell(0, 10, "STORE DEPARTMENT.", 0, 0, "L");


		$this->Ln(4);
		$this->SetFont("Arial", "", 8);
		$this->Cell(0, 10, "CONSOLIDATION REPORT", 0, 0, "L");
		$this->SetFont("Arial", "B", 8);
		$this->Cell(0, 10, 'samplename', 0, 0, "R");
		$this->SetTextColor(28, 28, 28);
		
		$this->Ln();
	}

	function FancyTable($header, $item_code, $variant_code, $description, $uom, $qty, $cost_novat, $totalcost_novat, $cost_withvat, 
				 $totalcost_withvat, $divcode)
	{
		// Colors, line width and bold font
		$this->SetFillColor(255,0,0);
		$this->SetTextColor(255);
		$this->SetDrawColor(128,0,0);
		$this->SetLineWidth(.3);
		$this->SetFont('Arial','B',6);
		// Header
		$w = array(14, 17, 45, 14, 15, 18, 25, 18, 25, 15 );

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


 		$sum_total_novat = 0;
 		$sum_total_withvat = 0;
		foreach ($item_code as $key => $item_codes) {

			$val = str_replace(",","",$totalcost_novat[$key]);
			
			$sum_total_novat += $val;

			$val2 = str_replace(",","",$totalcost_novat[$key]);

			$sum_total_withvat += $val2;


			$this->Cell($w[0],10,$item_codes,1,0,'C',true,$fill);
			$this->Cell($w[1],10,$variant_code[$key],1,0,'C',true,$fill);
			$this->Cell($w[2],10,$description[$key],1,0,'C',true,$fill);
			$this->Cell($w[3],10,$uom[$key],1,0,'C',true,$fill);
			$this->Cell($w[4],10,$qty[$key],1,0,'C',true,$fill);
			$this->Cell($w[5],10,$cost_novat[$key],1,0,'C',true,$fill);
			$this->Cell($w[6],10,$totalcost_novat[$key],1,0,'C',true,$fill);
			$this->Cell($w[7],10,$cost_withvat[$key],1,0,'C',true,$fill);
			$this->Cell($w[8],10,$totalcost_withvat[$key],1,0,'C',true,$fill);
			$this->Cell($w[9],10,$divcode[$key],1,0,'C',true,$fill);
			
			$this->Ln();

		}

			//var_dump(number_format($sum_total_novat,2));
			//var_dump(number_format($sum_total_withvat, 2));

			$this->SetFillColor(255,0,0);
			$this->SetTextColor(255);
			$this->SetDrawColor(128,0,0);
			$this->SetLineWidth(.3);
			$this->SetFont('','B');

			$this->Cell($w[0],7,'TOTAL',1,0,'C',true);
			$this->Cell($w[1],7,'',1,0,'C',true);
			$this->Cell($w[2],7,'',1,0,'C',true);
			$this->Cell($w[3],7,'',1,0,'C',true);
			$this->Cell($w[4],7,'',1,0,'C',true);
			$this->Cell($w[5],7,'',1,0,'C',true);
			$this->Cell($w[6],7,number_format($sum_total_novat,2),1,0,'C',true);
			$this->Cell($w[7],7,'',1,0,'C',true);
			$this->Cell($w[8],7,number_format($sum_total_withvat, 2),1,0,'C',true);
			$this->Cell($w[9],7,'',1,0,'C',true);

		$this->Ln();
	
		$this->Cell(array_sum($w),0,'','T');
	}
}
$pdf = new PDF();
// Column headings

$pdf->SetFont('Arial','',8);
$pdf->SetLeftMargin(2);
$pdf->SetRightMargin(2);
$pdf->AddPage();
$pdf->Details();

$header = array('ITEM CODE', 'VARIANT CODE', 'DESCRIPTION', 'UOM', 'QTY', 'COST W/O VAT', 'TOTAL COST W/O VAT', 'COST W/ VAT', 'TOTAL COST W/ VAT', 'DIVCODE');
$pdf->SetFont('Arial','',8);
$pdf->FancyTable($header,  $item_code, $variant_code, $description, $uom, $qty, $cost_novat, $totalcost_novat, $cost_withvat, 
				 $totalcost_withvat, $divcode);

//$pdf->Output(); 
//FCPATH."assets/images/".$exelfile
$pdf->Output($_SERVER['DOCUMENT_ROOT']."/pcount/assets/images/pdf/".$exelfile.'_item_report.pdf', 'F');

//$pdf->Output(base_url("assets/images/pdf/").$exelfile.'_item_report.pdf', 'F');

//$path = $_SERVER['DOCUMENT_ROOT']."/store_conso/assets/images/pdf/".$exelfile.'_item_report.pdf';

$path = base_url("assets/images/pdf/").$exelfile.'_item_report.pdf';

$user_id = $this->session->userdata('user_id');

$id_paths = array( 'user_id' 		=> $user_id, 
				   'file_name' 		=> $exelfile, 
				   'report_path' 	=> $path, 
				   'date_uploaded' 	=> date("Y-m-d, g:i a"),
				   'time'			=> date("g:i a")
				);

$result = $this->AdminModel->dir_save($id_paths);

?>