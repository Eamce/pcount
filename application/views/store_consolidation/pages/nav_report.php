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
		//$this->Cell(0, 4, date("h:i:s a"), 0, 0, "R");

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
		$this->Cell(0, 10, "NAVITION :", 0, 0, "L");
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

	function FancyTable($header, $item_code, $description, $uom, $qty_pm, $qty_alta, $qty_asc, $qty_talibon, $qty_icm, $business_unit, $department)
	{
		// Colors, line width and bold font
		$this->SetFillColor(255,0,0);
		$this->SetTextColor(255);
		$this->SetDrawColor(128,0,0);
		$this->SetLineWidth(.3);
		$this->SetFont('Arial','B',6);
		// Header
		$w = array(20, 35, 20, 15, 15, 15, 15, 15, 15 );

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

		$total_qty   	 = 0.00;
 		$sum_icm     	 = 0.00;
 		$sum_pm      	 = 0.00;
 		$sum_alta    	 = 0.00;
 		$sum_asc   	 	 = 0.00;
 		$sum_talibon 	 = 0.00;
 		$all_total_sum	 = 0.00;

		foreach ($item_code as $key => $item_codes) {

			 $total_qty = @$qty_pm[$key] + @$qty_alta[$key] + @$qty_asc[$key] + @$qty_talibon[$key] + @$qty_icm[$key];

			 $total_icm  	= $sum_icm 		 += @$qty_icm[$key];
			 $total_pm 	 	= $sum_pm 		 += @$qty_pm[$key];
			 $total_alta 	= $sum_alta 	 += @$qty_alta[$key];
			 $total_asc 	= $sum_asc 		 += @$qty_asc[$key];
			 $total_talibon = $sum_talibon 	 += @$qty_talibon[$key]; 
			 
			 $all_total 	= $all_total_sum += $total_qty;

			$this->Cell($w[0],10,$item_codes,1,0,'C',true,$fill);
			$this->Cell($w[1],10,$description[$key],1,0,'C',true,$fill);
			$this->Cell($w[2],10,$uom[$key],1,0,'C',true,$fill);

			$this->Cell($w[3],10,$qty_pm[$key],1,0,'C',true,$fill);
			$this->Cell($w[4],10,$qty_alta[$key],1,0,'C',true,$fill);
			$this->Cell($w[4],10,$qty_asc[$key],1,0,'C',true,$fill);
			$this->Cell($w[4],10,$qty_talibon[$key],1,0,'C',true,$fill);
			$this->Cell($w[4],10,$qty_icm[$key],1,0,'C',true,$fill);
			$this->Cell($w[3],10,$total_qty,1,0,'C',true,$fill);

			//$this->Cell($w[5],10,$business_unit[$key],1,0,'C',true,$fill);
			//$this->Cell($w[6],10,$department[$key],1,0,'C',true,$fill);
			//$this->Cell($w[7],10,$variance[$key],1,0,'C',true,$fill);
			
			$this->Ln();

		}
			$sum_icm = 0;
		// Color and font restoration
		$this->SetFillColor(224,235,255);
		$this->SetTextColor(0);
		$this->SetFont('Arial','',6);
		// Data
		$fill = false;

		// var_dump($all_total);
		$this->SetFillColor(255,0,0);
		$this->SetTextColor(255);
		$this->SetDrawColor(128,0,0);
		$this->SetLineWidth(.3);
		$this->SetFont('','B');

		$this->Cell($w[0],7,'TOTAL',1,0,'C',true,$fill);
		$this->Cell($w[1],7,'',1,0,'C',true,$fill);
		$this->Cell($w[2],7,'',1,0,'C',true,$fill);
		$this->Cell($w[3],7,number_format($total_pm,2),1,0,'C',true,$fill);
		$this->Cell($w[4],7,number_format($total_alta,2),1,0,'C',true,$fill);
		$this->Cell($w[5],7,number_format($total_asc,2),1,0,'C',true,$fill);
		$this->Cell($w[6],7,number_format($total_talibon,2),1,0,'C',true,$fill);
		$this->Cell($w[7],7,number_format($total_icm,2),1,0,'C',true,$fill);
		$this->Cell($w[8],7,number_format($all_total,2),1,0,'C',true,$fill);

		$this->Ln();
	
		$this->Cell(array_sum($w),0,'','T');
		$this->Ln(10);
	}
}
$pdf = new PDF();
// Column headings

$pdf->SetFont('Arial','',12);
$pdf->SetLeftMargin(20);
$pdf->SetRightMargin(10);
$pdf->AddPage();
$pdf->Details();

$header = array('ITEM CODE', 'DESCRIPTION', 'UOM', 'QTY PM', 'QTY ALTA', 'QTY ASC','QTY TAL', 'QTY ICM', 'QTY TOTAL' );
$pdf->SetFont('Arial','',12);
$pdf->FancyTable($header, $item_code, $description, $uom, $qty_pm, $qty_alta, $qty_asc, $qty_talibon, $qty_icm, $business_unit, $department);

$pdf->Output($exelfile.'_item_report.pdf', 'D');

//$pdf->Output($_SERVER['DOCUMENT_ROOT']."/store_conso/assets/images/pdf/".$exelfile.'_item_report.pdf', 'F');

$path = base_url("assets/images/pdf/").$exelfile.'_item_report.pdf';

$user_id = $this->session->userdata('user_id');

$id_paths = array( 'user_id' 		=> $user_id, 
				   'file_name' 		=> $exelfile, 
				   'report_path' 	=> $path, 
				   'date_uploaded' 	=> date("Y-m-d, g:i a"),
				   'time'			=> date("g:i a")
				);

//$result = $this->AdminModel->dir_save_nav($id_paths);

?>