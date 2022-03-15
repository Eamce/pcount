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

	function FancyTable($header, $item_code, $description, $uom, $pm_stockroom, $pm_sellingarea, $asc_stockroom, $asc_sellingarea, $alta_stockroom, $alta_sellingarea, $icm_stockroom, $icm_sellingarea, $tal_stockroom, $tal_sellingarea)
	{
		// Colors, line width and bold font
		$this->SetFillColor(224,235,255);
		$this->SetTextColor(0);
		$this->SetDrawColor(128,0,0);
		$this->SetLineWidth(.3);
		$this->SetFont('Arial','B',6);
		// Header
		$w = array(15, 30, 15, 15, 15, 15, 15, 15, 15, 15, 15, 15, 15, 15 );

			$this->Cell(15,7,'',0,0,'C',false);
			$this->Cell(30,7,'',0,0,'C',false);
			$this->Cell(15,7,'',0,0,'C',false);
			$this->Cell(30,7,'PLAZA MARCELA',1,0,'C',true,false);
			$this->Cell(30,7,'ASC',1,0,'C',true,false);
			$this->Cell(30,7,'ALTA',1,0,'C',true,false);
			$this->Cell(30,7,'ICM',1,0,'C',true,false);
			$this->Cell(30,7,'TALIBON',1,0,'C',true,false);
		
		$this->Ln();

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

 		$sum_pm_sr     	 = 0.00;
 		$sum_pm_sa       = 0.00;
 		$sum_asc_sr      = 0.00;
 		$sum_asc_sa      = 0.00;
 		$sum_alta_sr     = 0.00;
 		$sum_alta_sa     = 0.00;
 		$sum_icm_sr      = 0.00;
 		$sum_icm_sa      = 0.00;
 		$sum_tal_sr  = 0.00;
 		$sum_tal_sa  = 0.00;

 		$all_total_sum	 = 0.00;

		foreach ($item_code as $key => $item_codes) {

			 $total_qty = @$pm_stockroom[$key] + @$pm_sellingarea[$key] + @$asc_stockroom[$key] + @$asc_sellingarea[$key] + 
			 			  @$alta_stockroom[$key] + @$alta_sellingarea[$key] + @$icm_stockroom[$key] + @$icm_sellingarea[$key] + 
			 			  @$tal_stockroom[$key] + @$tal_sellingarea[$key];

			 $total_pm_sr  	 = $sum_pm_sr 	 += @$pm_stockroom[$key];
			 $total_pm_sa 	 = $sum_pm_sa 	 += @$pm_sellingarea[$key];
			 $total_asc_sr   = $sum_asc_sr 	 += @$asc_stockroom[$key];
			 $total_asc_sa 	 = $sum_asc_sa 	 += @$asc_sellingarea[$key];
			 $total_alta_sr  = $sum_alta_sr  += @$alta_stockroom[$key];
			 $total_alta_sa  = $sum_alta_sa  += @$alta_sellingarea[$key];

			 $total_icm_sr  = $sum_icm_sr  += @$icm_stockroom[$key];
			 $total_icm_sa  = $sum_icm_sa  += @$icm_sellingarea[$key];

			 $total_tal_sr   = $sum_tal_sr   += @$tal_stockroom[$key];
			 $total_tal_sa   = $sum_tal_sa   += @$tal_sellingarea[$key];

			$all_total 	= $all_total_sum += $total_qty;

			$this->Cell($w[0],10,$item_codes,1,0,'C',true,$fill);
			$this->Cell($w[1],10,$description[$key],1,0,'C',true,$fill);
			$this->Cell($w[2],10,$uom[$key],1,0,'C',true,$fill);

			$this->Cell($w[3],10,$pm_stockroom[$key],1,0,'C',true,$fill);
			$this->Cell($w[4],10,$pm_sellingarea[$key],1,0,'C',true,$fill);
			$this->Cell($w[5],10,$asc_stockroom[$key],1,0,'C',true,$fill);
			$this->Cell($w[6],10,$asc_sellingarea[$key],1,0,'C',true,$fill);
			$this->Cell($w[7],10,$alta_stockroom[$key],1,0,'C',true,$fill);
			$this->Cell($w[8],10,$alta_sellingarea[$key],1,0,'C',true,$fill);
			$this->Cell($w[9],10,$icm_stockroom[$key],1,0,'C',true,$fill);
			$this->Cell($w[10],10,$icm_sellingarea[$key],1,0,'C',true,$fill);
			$this->Cell($w[11],10,$tal_sellingarea[$key],1,0,'C',true,$fill);
			$this->Cell($w[12],10,$tal_stockroom[$key],1,0,'C',true,$fill);

			$this->Cell($w[13],10,$total_qty,1,0,'C',true,$fill);

			//$this->Cell($w[5],10,$business_unit[$key],1,0,'C',true,$fill);
			//$this->Cell($w[6],10,$department[$key],1,0,'C',true,$fill);
			//$this->Cell($w[7],10,$variance[$key],1,0,'C',true,$fill);
			
			$this->Ln();

		}
			//$sum_icm = 0;
		// Color and font restoration
		$this->SetFillColor(224,235,255);
		$this->SetTextColor(0);
		$this->SetFont('Arial','',6);
		// Data
		$fill = false;

		// var_dump($all_total);
		$this->SetFillColor(224,235,255);
		$this->SetTextColor(0);
		$this->SetDrawColor(128,0,0);
		$this->SetLineWidth(.3);
		$this->SetFont('','B');

		$this->Cell($w[0],7,'TOTAL',1,0,'C',true,$fill);
		$this->Cell($w[1],7,'',1,0,'C',true,$fill);
		$this->Cell($w[2],7,'',1,0,'C',true,$fill);
		$this->Cell($w[3],7,number_format($total_pm_sr,2),1,0,'C',true,$fill);
		$this->Cell($w[4],7,number_format($total_pm_sa,2),1,0,'C',true,$fill);
		$this->Cell($w[5],7,number_format($total_asc_sr,2),1,0,'C',true,$fill);
		$this->Cell($w[6],7,number_format($total_asc_sa,2),1,0,'C',true,$fill);
		$this->Cell($w[7],7,number_format($total_alta_sr,2),1,0,'C',true,$fill);
		$this->Cell($w[8],7,number_format($total_alta_sa,2),1,0,'C',true,$fill);

		$this->Cell($w[9],7,number_format($total_icm_sr,2),1,0,'C',true,$fill);
		$this->Cell($w[10],7,number_format($total_icm_sa,2),1,0,'C',true,$fill);

		$this->Cell($w[11],7,number_format($total_tal_sr,2),1,0,'C',true,$fill);
		$this->Cell($w[12],7,number_format($total_tal_sa,2),1,0,'C',true,$fill);

		$this->Cell($w[13],7,number_format($all_total,2),1,0,'C',true,$fill);

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
$pdf->AddPage('L');
$pdf->Details();

$header = array('ITEM CODE', 'DESCRIPTION', 'UOM', 'STOCKROOM', 'SELL AREA', 'STOCKROOM','SELL AREA', 'STOCKROOM','SELL AREA', 
				'STOCKROOM','SELL AREA', 'STOCKROOM','SELL AREA', 'QTY TOTAL' );

$pdf->SetFont('Arial','',12);
$pdf->FancyTable($header, $item_code, $description, $uom, $pm_stockroom, $pm_sellingarea, $asc_stockroom, $asc_sellingarea, $alta_stockroom, $alta_sellingarea, $icm_stockroom, $icm_sellingarea, $tal_stockroom, $tal_sellingarea);

 $file_name = $exelfile.'_item_report.pdf';

 $dir = 'assets/tempfile/'.$file_name;

 $pdf->Output($dir, 'F');

 echo json_encode(['type'=>'success', 'msg'=>'PDF file created', 'file'=>$file_name]);

// $user_id = $this->session->userdata('user_id');

// $id_paths = array( 'user_id' 		=> $user_id, 
// 				   'file_name' 		=> $exelfile, 
// 				   'report_path' 	=> $path, 
// 				   'date_uploaded' 	=> date("Y-m-d, g:i a"),
// 				   'time'			=> date("g:i a")
// 				);

//$result = $this->AdminModel->dir_save_nav($id_paths);

?>