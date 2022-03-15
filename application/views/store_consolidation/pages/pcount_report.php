<?php
//require_once($_SERVER['DOCUMENT_ROOT']."/pcount/application/libraries/fpdf.php");
//require_once(FCPATH."application/libraries/Fpdf.php");
$this->load->library('fpdf.php');
$this->load->model('AdminModel');
date_default_timezone_set('Etc/GMT+8');

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

	function Details($user)
	{
		
		$this->SetTextColor(28, 28, 28);
		$this->SetFont("Arial", "B", 10);
		$this->Cell(0, 10, "CONSOLIDATED :", 0, 0, "L");
		//$this->Cell(0, 10, $vrs, 0, 0, "L");

		$this->SetFont("Arial", "", 8);
		$this->Cell(0, 10, "Prepared By :", 0, 0, "R");
		
		$this->Ln(5);
		$this->SetFont("Arial", "", 9);
		$this->Cell(0, 10, "VARIANCE.", 0, 0, "L");

		$this->Ln(4);
		$this->SetFont("Arial", "", 8);
		$this->Cell(0, 10, "REPORT", 0, 0, "L");
		$this->SetFont("Arial", "B", 8);
		$this->Cell(0, 10, $user, 0, 0, "R");
		$this->SetTextColor(28, 28, 28);
		
		$this->Ln();
	}

	function FancyTable($header, $item_code, $pm_itemcode, $alta_itemcode, $asc_itemcode, $talibon_itemcode,
			 			$description, $pm_description, $alta_description, $asc_description, $pm_description,
			 			$uom, $pm_uom, $alta_uom, $asc_uom, $talibon_uom,   
			 			$qty_db, $qty_pm, $qty_alta, $qty_asc,  $qty_talibon, 
			 			$icm_section, $pm_section, $alta_section, $asc_section, $talibon_section){
			 			
	
		$this->SetTextColor(28, 28, 28);
		$this->Cell(65, 10, "QTY FROM PHYSICAL COUNT.", 0, 0, "C");
		$this->Ln();

		// Colors, line width and bold font
		$this->SetFillColor(255,0,0);
		$this->SetTextColor(255);
		$this->SetDrawColor(128,0,0);
		$this->SetLineWidth(.3);
		$this->SetFont('Arial','B',6);
		// Header

		//$w = array(20, 35, 20, 15, 15, 15, 25, 28, 15 );

		$w = array(16, 65, 13, 17, 13, 13, 13, 13, 13, 13 );

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
 		
 		if($item_code != null ){

 			if($item_code == $pm_itemcode){
 				$pm_qty = $qty_pm;
 			}
 			if($item_code == $alta_itemcode){
 				$alta_qty = $qty_alta;
 			}
 			if($item_code == $asc_itemcode){
 				$asc_qty = $qty_asc;
 			}
 			if($item_code == $talibon_itemcode){
 				$talibon_qty = $qty_talibon;
 			}
 				
			foreach ($item_code as $key => $item_codes){

				$total_qty = @$qty_db[$key] + @$pm_qty[$key] + @$alta_qty[$key] + @$asc_qty[$key] + @$talibon_qty[$key];

				@$total_icm  	= $sum_icm 		 += @$qty_db[$key];
				@$total_pm 	 	= $sum_pm 		 += @$pm_qty[$key];
				@$total_alta 	= $sum_alta 	 += @$alta_qty[$key];
				@$total_asc 	= $sum_asc 		 += @$asc_qty[$key];
				@$total_talibon = $sum_talibon 	 += @$talibon_qty[$key]; 
			 
			 	@$all_total 	= $all_total_sum += $total_qty;

				$this->Cell($w[0],10,$item_codes,1,0,'C',true,$fill);
				$this->Cell($w[1],10,$description[$key],1,0,'C',true,$fill);
				$this->Cell($w[2],10,$uom[$key],1,0,'C',true,$fill);
				$this->Cell($w[3],10,$icm_section[$key],1,0,'C',true,$fill);

				$this->Cell($w[4],10,@$qty_db[$key],1,0,'C',true,$fill);
				$this->Cell($w[5],10,@$pm_qty[$key],1,0,'C',true,$fill);
				$this->Cell($w[6],10,@$alta_qty[$key],1,0,'C',true,$fill);
				$this->Cell($w[7],10,@$asc_qty[$key],1,0,'C',true,$fill);
				$this->Cell($w[8],10,@$talibon_qty[$key],1,0,'C',true,$fill);
				$this->Cell($w[9],10,@$total_qty,1,0,'C',true,$fill);
			
				//$this->Cell($w[4],10,$qty_excel[$key],1,0,'C',true,$fill);
				//$this->Cell($w[5],10,$business_unit[$key],1,0,'C',true,$fill);
				//$this->Cell($w[6],10,$department[$key],1,0,'C',true,$fill);
				//$this->Cell($w[7],10,$variance[$key],1,0,'C',true,$fill);
			
				$this->Ln();
			}
		}
		
		if($pm_itemcode !=null){
			if($pm_itemcode == $item_code){
 				$icm_qty = $qty_db;
 			}
 			if($pm_itemcode == $pm_itemcode){
 				$pm_qty = $qty_pm;
 			}
 			if($pm_itemcode == $alta_itemcode){
 				$alta_qty = $qty_alta;
 			}
 			if($pm_itemcode == $asc_itemcode){
 				$asc_qty = $qty_asc;
 			}
 			if($pm_itemcode == $talibon_itemcode){
 				$talibon_qty = $qty_talibon;
 			}

			foreach ($pm_itemcode as $key => $pm_codes){

				$total_qty = @$icm_qty[$key] + @$pm_qty[$key] + @$alta_qty[$key] + @$asc_qty[$key] + @$talibon_qty[$key];

				@$total_icm  	= $sum_icm 		 += @$icm_qty[$key];
				@$total_pm 	 	= $sum_pm 		 += @$pm_qty[$key];
				@$total_alta 	= $sum_alta 	 += @$alta_qty[$key];
				@$total_asc 	= $sum_asc 		 += @$asc_qty[$key];
				@$total_talibon = $sum_talibon 	 += @$talibon_qty[$key]; 
			 
			 	@$all_total 	= $all_total_sum += $total_qty;

				$this->Cell($w[0],10,$pm_codes,1,0,'C',true,$fill);
				$this->Cell($w[1],10,$pm_description[$key],1,0,'C',true,$fill);
				$this->Cell($w[2],10,$pm_uom[$key],1,0,'C',true,$fill);
				$this->Cell($w[3],10,$pm_section[$key],1,0,'C',true,$fill);
				
				$this->Cell($w[4],10,@$icm_qty[$key],1,0,'C',true,$fill);
				$this->Cell($w[5],10,@$pm_qty[$key],1,0,'C',true,$fill);
				$this->Cell($w[6],10,@$alta_qty[$key],1,0,'C',true,$fill);
				$this->Cell($w[7],10,@$asc_qty[$key],1,0,'C',true,$fill);
				$this->Cell($w[8],10,@$talibon_qty[$key],1,0,'C',true,$fill);
				$this->Cell($w[9],10,@$total_qty,1,0,'C',true,$fill);

				$this->Ln();
			}
		}
		if($alta_itemcode !=null){
			if($alta_itemcode == $item_code){
 				$icm_qty = $qty_db;
 			}
 			if($alta_itemcode == $pm_itemcode){
 				$pm_qty = $qty_pm;
 			}
 			if($alta_itemcode == $alta_itemcode){
 				$alta_qty = $qty_alta;
 			}
 			if($alta_itemcode == $asc_itemcode){
 				$asc_qty = $qty_asc;
 			}
 			if($alta_itemcode == $talibon_itemcode){
 				$talibon_qty = $qty_talibon;
 			}
			foreach ($alta_itemcode as $key => $alta_codes){

				$total_qty = @$icm_qty[$key] + @$pm_qty[$key] + @$alta_qty[$key] + @$asc_qty[$key] + @$talibon_qty[$key];

				@$total_icm  	= $sum_icm 		 += @$icm_qty[$key];
				@$total_pm 	 	= $sum_pm 		 += @$pm_qty[$key];
				@$total_alta 	= $sum_alta 	 += @$alta_qty[$key];
				@$total_asc 	= $sum_asc 		 += @$asc_qty[$key];
				@$total_talibon = $sum_talibon 	 += @$talibon_qty[$key]; 
			 
			 	@$all_total 	= $all_total_sum += $total_qty;

				$this->Cell($w[0],10,$alta_codes,1,0,'C',true,$fill);
				$this->Cell($w[1],10,$alta_description[$key],1,0,'C',true,$fill);
				$this->Cell($w[2],10,$alta_uom[$key],1,0,'C',true,$fill);
				$this->Cell($w[3],10,$alta_section[$key],1,0,'C',true,$fill);
				
				$this->Cell($w[4],10,@$icm_qty[$key],1,0,'C',true,$fill);
				$this->Cell($w[5],10,@$pm_qty[$key],1,0,'C',true,$fill);
				$this->Cell($w[6],10,@$alta_qty[$key],1,0,'C',true,$fill);
				$this->Cell($w[7],10,@$asc_qty[$key],1,0,'C',true,$fill);
				$this->Cell($w[8],10,@$talibon_qty[$key],1,0,'C',true,$fill);
				$this->Cell($w[9],10,@$total_qty,1,0,'C',true,$fill);

				$this->Ln();
			}
		}
		if($asc_itemcode !=null){
			if($asc_itemcode == $item_code){
 				$icm_qty = $qty_db;
 			}
 			if($asc_itemcode == $pm_itemcode){
 				$pm_qty = $qty_pm;
 			}
 			if($asc_itemcode == $alta_itemcode){
 				$alta_qty = $qty_alta;
 			}
 			if($asc_itemcode == $asc_itemcode){
 				$asc_qty = $qty_asc;
 			}
 			if($asc_itemcode == $talibon_itemcode){
 				$talibon_qty = $qty_talibon;
 			}
			foreach ($asc_itemcode as $key => $asc_codes){

				$total_qty = @$icm_qty[$key] + @$pm_qty[$key] + @$alta_qty[$key] + @$asc_qty[$key] + @$talibon_qty[$key];

				@$total_icm  	= $sum_icm 		 += @$icm_qty[$key];
				@$total_pm 	 	= $sum_pm 		 += @$pm_qty[$key];
				@$total_alta 	= $sum_alta 	 += @$alta_qty[$key];
				@$total_asc 	= $sum_asc 		 += @$asc_qty[$key];
				@$total_talibon = $sum_talibon 	 += @$talibon_qty[$key]; 
			 
			 	@$all_total 	= $all_total_sum += $total_qty;

				$this->Cell($w[0],10,$asc_codes,1,0,'C',true,$fill);
				$this->Cell($w[1],10,$asc_description[$key],1,0,'C',true,$fill);
				$this->Cell($w[2],10,$asc_uom[$key],1,0,'C',true,$fill);
				$this->Cell($w[3],10,$asc_section[$key],1,0,'C',true,$fill);
				
				$this->Cell($w[4],10,@$icm_qty[$key],1,0,'C',true,$fill);
				$this->Cell($w[5],10,@$pm_qty[$key],1,0,'C',true,$fill);
				$this->Cell($w[6],10,@$alta_qty[$key],1,0,'C',true,$fill);
				$this->Cell($w[7],10,@$asc_qty[$key],1,0,'C',true,$fill);
				$this->Cell($w[8],10,@$talibon_qty[$key],1,0,'C',true,$fill);
				$this->Cell($w[9],10,@$total_qty,1,0,'C',true,$fill);

				$this->Ln();
			}
		}
		if($talibon_itemcode !=null){
			if($talibon_itemcode == $item_code){
 				$icm_qty = $qty_db;
 			}
 			if($talibon_itemcode == $pm_itemcode){
 				$pm_qty = $qty_pm;
 			}
 			if($talibon_itemcode == $alta_itemcode){
 				$alta_qty = $qty_alta;
 			}
 			if($talibon_itemcode == $asc_itemcode){
 				$asc_qty = $qty_asc;
 			}
 			if($talibon_itemcode == $talibon_itemcode){
 				$talibon_qty = $qty_talibon;
 			}
			foreach ($talibon_itemcode as $key => $talibon_codes){

				$total_qty = @$icm_qty[$key] + @$pm_qty[$key] + @$alta_qty[$key] + @$asc_qty[$key] + @$talibon_qty[$key];

				@$total_icm  	= $sum_icm 		 += @$icm_qty[$key];
				@$total_pm 	 	= $sum_pm 		 += @$pm_qty[$key];
				@$total_alta 	= $sum_alta 	 += @$alta_qty[$key];
				@$total_asc 	= $sum_asc 		 += @$asc_qty[$key];
				@$total_talibon = $sum_talibon 	 += @$talibon_qty[$key]; 
			 
			 	@$all_total 	= $all_total_sum += $total_qty;

				$this->Cell($w[0],10,$talibon_codes,1,0,'C',true,$fill);
				$this->Cell($w[1],10,$talibon_description[$key],1,0,'C',true,$fill);
				$this->Cell($w[2],10,$talibon_uom[$key],1,0,'C',true,$fill);
				$this->Cell($w[3],10,$talibon_section[$key],1,0,'C',true,$fill);

				$this->Cell($w[4],10,@$icm_qty[$key],1,0,'C',true,$fill);
				$this->Cell($w[5],10,@$pm_qty[$key],1,0,'C',true,$fill);
				$this->Cell($w[6],10,@$alta_qty[$key],1,0,'C',true,$fill);
				$this->Cell($w[7],10,@$asc_qty[$key],1,0,'C',true,$fill);
				$this->Cell($w[8],10,@$talibon_qty[$key],1,0,'C',true,$fill);
				$this->Cell($w[9],10,@$total_qty,1,0,'C',true,$fill);

				$this->Ln();
			}
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
		$this->Cell($w[3],7,'',1,0,'C',true,$fill);
		$this->Cell($w[4],7,number_format(@$total_icm,2),1,0,'C',true,$fill);
		$this->Cell($w[5],7,number_format(@$total_pm,2),1,0,'C',true,$fill);
		$this->Cell($w[6],7,number_format(@$total_alta,2),1,0,'C',true,$fill);
		$this->Cell($w[7],7,number_format(@$total_asc,2),1,0,'C',true,$fill);
		$this->Cell($w[8],7,number_format(@$total_talibon,2),1,0,'C',true,$fill);
		$this->Cell($w[9],7,number_format(@$all_total,2),1,0,'C',true,$fill);

		$this->Ln();
		$this->Ln();
		
		$this->Cell(array_sum($w),0,'','T');
		$this->Ln(10);
	}
		

	function excel_qty_Table($header_2, $item_code, $pm_itemcode, $alta_itemcode, $asc_itemcode, $talibon_itemcode,
					  		 $description, $pm_description, $alta_description, $asc_description, $pm_description,
					  		 $uom, $pm_uom, $alta_uom, $asc_uom, $talibon_uom, 
					  		 $excel_icm, $excel_pm, $excel_alta, $excel_asc, $excel_talibon,
					  		 $icm_section, $pm_section, $alta_section, $asc_section, $talibon_section)
	{
		$this->AddPage();
		$this->SetTextColor(28, 28, 28);
		$this->Cell(55, 10, "QTY FROM NAVATION.", 0, 0, "C");
		$this->Ln();

		// Colors, line width and bold font
		$this->SetFillColor(255,0,0);
		$this->SetTextColor(255);
		$this->SetDrawColor(128,0,0);
		$this->SetLineWidth(.3);
		$this->SetFont('Arial','B',6);
		$w = array(16, 65, 13, 17, 13, 13, 13, 13, 13, 13 );
		// Header
		for($i=0;$i<count($header_2);$i++)
				
		$this->Cell($w[$i],10,$header_2[$i],1,0,'C',true);
		$this->Ln();
		//$this->Cell(18);
	
		// Color and font restoration
		$this->SetFillColor(224,235,255);
		$this->SetTextColor(0);
		$this->SetFont('Arial','',6);
		// Data
		$fill = false;
 		
		$total_excel = 0.00;
		$sum_excel_icm = 0.00;
		$sum_excel_pm = 0.00;
		$sum_excel_alta = 0.00;
		$sum_excel_asc = 0.00;
		$sum_excel_talibon = 0.00;
		$all_total_excel = 00;

		if($item_code !=null){

			if($item_code == $pm_itemcode){
 				$pm_xl_qty = $excel_pm;
 			}
 			if($item_code == $alta_itemcode){
 				$alta_xl_qty = $excel_alta;
 			}
 			if($item_code == $asc_itemcode){
 				$asc_xl_qty = $excel_asc;
 			}
 			if($item_code == $talibon_itemcode){
 				$talibon_xl_qty = $excel_talibon;
 			}

			foreach ($item_code as $key => $item_codes) {

				$total_excel = @$excel_icm[$key] + @$pm_xl_qty[$key] + @$alta_xl_qty + @$asc_xl_qty[$key] +@$talibon_xl_qty[$key];

				$total_excel_icm  		= $sum_excel_icm 		 += @$excel_icm[$key];
				$total_excel_pm  		= $sum_excel_pm 		 += @$pm_xl_qty[$key];
				$total_excel_alta  		= $sum_excel_alta 		 += @$alta_xl_qty[$key];
				$total_excel_asc  		= $sum_excel_asc 		 += @$asc_xl_qty[$key];
				$total_excel_talibon  	= $sum_excel_talibon 	 += @$talibon_xl_qty[$key];

				$total_sum 	= $all_total_excel += $total_excel;

				$this->Cell($w[0],10,$item_codes,1,0,'C',true,$fill);
				$this->Cell($w[1],10,$description[$key],1,0,'C',true,$fill);
				$this->Cell($w[2],10,$uom[$key],1,0,'C',true,$fill);
				$this->Cell($w[3],10,$icm_section[$key],1,0,'C',true,$fill);

				$this->Cell($w[4],10,@$excel_icm[$key],1,0,'C',true,$fill);
				$this->Cell($w[5],10,@$pm_xl_qty[$key],1,0,'C',true,$fill);
				$this->Cell($w[6],10,@$alta_xl_qty[$key],1,0,'C',true,$fill);
				$this->Cell($w[7],10,@$asc_xl_qty[$key],1,0,'C',true,$fill);
				$this->Cell($w[8],10,@$talibon_xl_qty[$key],1,0,'C',true,$fill);
				$this->Cell($w[9],10,@$total_excel,1,0,'C',true,$fill);
			
				$this->Ln();
			}
		}
		if($pm_itemcode != null){
			if($pm_itemcode == $item_code){
 				$icm_xl_qty = $excel_icm;
 			}
 			if($pm_itemcode == $pm_itemcode){
 				$pm_xl_qty = $excel_pm;
 			}
 			if($pm_itemcode == $alta_itemcode){
 				$alta_xl_qty = $excel_alta;
 			}
 			if($pm_itemcode == $asc_itemcode){
 				$asc_xl_qty = $excel_asc;
 			}
 			if($pm_itemcode == $talibon_itemcode){
 				$talibon_xl_qty = $excel_talibon;
 			}
 			foreach ($pm_itemcode as $key => $pm_codes) {

				$total_excel = @$icm_xl_qty[$key] + @$pm_xl_qty[$key] + @$alta_xl_qty + @$asc_xl_qty[$key] +@$talibon_xl_qty[$key];

				$total_excel_icm  		= $sum_excel_icm 		 += @$icm_xl_qty[$key];
				$total_excel_pm  		= $sum_excel_pm 		 += @$pm_xl_qty[$key];
				$total_excel_alta  		= $sum_excel_alta 		 += @$alta_xl_qty[$key];
				$total_excel_asc  		= $sum_excel_asc 		 += @$asc_xl_qty[$key];
				$total_excel_talibon  	= $sum_excel_talibon 	 += @$talibon_xl_qty[$key];

				$total_sum 	= $all_total_excel += $total_excel;

				$this->Cell($w[0],10,$pm_codes,1,0,'C',true,$fill);
				$this->Cell($w[1],10,$pm_description[$key],1,0,'C',true,$fill);
				$this->Cell($w[2],10,$pm_uom[$key],1,0,'C',true,$fill);
				$this->Cell($w[3],10,$pm_section[$key],1,0,'C',true,$fill);

				$this->Cell($w[4],10,@$icm_xl_qty[$key],1,0,'C',true,$fill);
				$this->Cell($w[5],10,@$pm_xl_qty[$key],1,0,'C',true,$fill);
				$this->Cell($w[6],10,@$alta_xl_qty[$key],1,0,'C',true,$fill);
				$this->Cell($w[7],10,@$asc_xl_qty[$key],1,0,'C',true,$fill);
				$this->Cell($w[8],10,@$talibon_xl_qty[$key],1,0,'C',true,$fill);
				$this->Cell($w[9],10,@$total_excel,1,0,'C',true,$fill);
			
				$this->Ln();
			}
		}
		if($alta_itemcode != null){
			if($alta_itemcode == $item_code){
 				$icm_xl_qty = $excel_icm;
 			}
 			if($alta_itemcode == $pm_itemcode){
 				$pm_xl_qty = $excel_pm;
 			}
 			if($alta_itemcode == $alta_itemcode){
 				$alta_xl_qty = $excel_alta;
 			}
 			if($alta_itemcode == $asc_itemcode){
 				$asc_xl_qty = $excel_asc;
 			}
 			if($alta_itemcode == $talibon_itemcode){
 				$talibon_xl_qty = $excel_talibon;
 			}
 			foreach ($alta_itemcode as $key => $alta_codes) {

				$total_excel = @$icm_xl_qty[$key] + @$pm_xl_qty[$key] + @$alta_xl_qty + @$asc_xl_qty[$key] +@$talibon_xl_qty[$key];

				$total_excel_icm  		= $sum_excel_icm 		 += @$icm_xl_qty[$key];
				$total_excel_pm  		= $sum_excel_pm 		 += @$pm_xl_qty[$key];
				$total_excel_alta  		= $sum_excel_alta 		 += @$alta_xl_qty[$key];
				$total_excel_asc  		= $sum_excel_asc 		 += @$asc_xl_qty[$key];
				$total_excel_talibon  	= $sum_excel_talibon 	 += @$talibon_xl_qty[$key];

				$total_sum 	= $all_total_excel += $total_excel;

				$this->Cell($w[0],10,$alta_codes,1,0,'C',true,$fill);
				$this->Cell($w[1],10,$alta_description[$key],1,0,'C',true,$fill);
				$this->Cell($w[2],10,$alta_uom[$key],1,0,'C',true,$fill);
				$this->Cell($w[3],10,$alta_section[$key],1,0,'C',true,$fill);

				$this->Cell($w[4],10,@$icm_xl_qty[$key],1,0,'C',true,$fill);
				$this->Cell($w[5],10,@$pm_xl_qty[$key],1,0,'C',true,$fill);
				$this->Cell($w[6],10,@$alta_xl_qty[$key],1,0,'C',true,$fill);
				$this->Cell($w[7],10,@$asc_xl_qty[$key],1,0,'C',true,$fill);
				$this->Cell($w[8],10,@$talibon_xl_qty[$key],1,0,'C',true,$fill);
				$this->Cell($w[9],10,@$total_excel,1,0,'C',true,$fill);
			
				$this->Ln();
			}
		}
		if($asc_itemcode != null){
			if($asc_itemcode == $item_code){
 				$icm_xl_qty = $excel_icm;
 			}
 			if($asc_itemcode == $pm_itemcode){
 				$pm_xl_qty = $excel_pm;
 			}
 			if($asc_itemcode == $alta_itemcode){
 				$alta_xl_qty = $excel_alta;
 			}
 			if($asc_itemcode == $asc_itemcode){
 				$asc_xl_qty = $excel_asc;
 			}
 			if($asc_itemcode == $talibon_itemcode){
 				$talibon_xl_qty = $excel_talibon;
 			}
 			foreach ($asc_itemcode as $key => $asc_codes) {

				$total_excel = @$icm_xl_qty[$key] + @$pm_xl_qty[$key] + @$alta_xl_qty + @$asc_xl_qty[$key] +@$talibon_xl_qty[$key];

				$total_excel_icm  		= $sum_excel_icm 		 += @$icm_xl_qty[$key];
				$total_excel_pm  		= $sum_excel_pm 		 += @$pm_xl_qty[$key];
				$total_excel_alta  		= $sum_excel_alta 		 += @$alta_xl_qty[$key];
				$total_excel_asc  		= $sum_excel_asc 		 += @$asc_xl_qty[$key];
				$total_excel_talibon  	= $sum_excel_talibon 	 += @$talibon_xl_qty[$key];

				$total_sum 	= $all_total_excel += $total_excel;

				$this->Cell($w[0],10,$asc_codes,1,0,'C',true,$fill);
				$this->Cell($w[1],10,$asc_description[$key],1,0,'C',true,$fill);
				$this->Cell($w[2],10,$asc_uom[$key],1,0,'C',true,$fill);
				$this->Cell($w[3],10,$asc_section[$key],1,0,'C',true,$fill);

				$this->Cell($w[4],10,@$icm_xl_qty[$key],1,0,'C',true,$fill);
				$this->Cell($w[5],10,@$pm_xl_qty[$key],1,0,'C',true,$fill);
				$this->Cell($w[6],10,@$alta_xl_qty[$key],1,0,'C',true,$fill);
				$this->Cell($w[7],10,@$asc_xl_qty[$key],1,0,'C',true,$fill);
				$this->Cell($w[8],10,@$talibon_xl_qty[$key],1,0,'C',true,$fill);
				$this->Cell($w[9],10,@$total_excel,1,0,'C',true,$fill);
			
				$this->Ln();
			}
		}

		if($talibon_itemcode != null){
			if($talibon_itemcode == $item_code){
 				$icm_xl_qty = $excel_icm;
 			}
 			if($talibon_itemcode == $pm_itemcode){
 				$pm_xl_qty = $excel_pm;
 			}
 			if($talibon_itemcode == $alta_itemcode){
 				$alta_xl_qty = $excel_alta;
 			}
 			if($talibon_itemcode == $asc_itemcode){
 				$asc_xl_qty = $excel_asc;
 			}
 			if($talibon_itemcode == $talibon_itemcode){
 				$talibon_xl_qty = $excel_talibon;
 			}
 			foreach ($talibon_itemcode as $key => $talibon_codes) {

				$total_excel = @$icm_xl_qty[$key] + @$pm_xl_qty[$key] + @$alta_xl_qty + @$asc_xl_qty[$key] +@$talibon_xl_qty[$key];

				$total_excel_icm  		= $sum_excel_icm 		 += @$icm_xl_qty[$key];
				$total_excel_pm  		= $sum_excel_pm 		 += @$pm_xl_qty[$key];
				$total_excel_alta  		= $sum_excel_alta 		 += @$alta_xl_qty[$key];
				$total_excel_asc  		= $sum_excel_asc 		 += @$asc_xl_qty[$key];
				$total_excel_talibon  	= $sum_excel_talibon 	 += @$talibon_xl_qty[$key];

				$total_sum 	= $all_total_excel += $total_excel;

				$this->Cell($w[0],10,$talibon_codes,1,0,'C',true,$fill);
				$this->Cell($w[1],10,$talibon_description[$key],1,0,'C',true,$fill);
				$this->Cell($w[2],10,$talibon_uom[$key],1,0,'C',true,$fill);
				$this->Cell($w[3],10,$talibon_section[$key],1,0,'C',true,$fill);

				$this->Cell($w[4],10,@$icm_xl_qty[$key],1,0,'C',true,$fill);
				$this->Cell($w[5],10,@$pm_xl_qty[$key],1,0,'C',true,$fill);
				$this->Cell($w[6],10,@$alta_xl_qty[$key],1,0,'C',true,$fill);
				$this->Cell($w[7],10,@$asc_xl_qty[$key],1,0,'C',true,$fill);
				$this->Cell($w[8],10,@$talibon_xl_qty[$key],1,0,'C',true,$fill);
				$this->Cell($w[9],10,@$total_excel,1,0,'C',true,$fill);
			
				$this->Ln();
			}
		}

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
		$this->Cell($w[3],7,'',1,0,'C',true,$fill);
		$this->Cell($w[4],7,number_format($total_excel_icm,2),1,0,'C',true,$fill);
		$this->Cell($w[5],7,number_format($total_excel_pm,2),1,0,'C',true,$fill);
		$this->Cell($w[6],7,number_format($total_excel_alta,2),1,0,'C',true,$fill);
		$this->Cell($w[7],7,number_format($total_excel_asc,2),1,0,'C',true,$fill);
		$this->Cell($w[8],7,number_format($total_excel_talibon,2),1,0,'C',true,$fill);
		$this->Cell($w[9],7,number_format($total_sum,2),1,0,'C',true,$fill);

		$this->Ln();
		$this->Ln();
		
		$this->Cell(array_sum($w),0,'','T');
		$this->Ln(10);
	}

	function Variance_Table($header_3, $item_code, $pm_itemcode, $alta_itemcode, $asc_itemcode, $talibon_itemcode, 
							$description, $pm_description, $alta_description, $asc_description, $pm_description,
							$uom, $pm_uom, $alta_uom, $asc_uom, $talibon_uom,
							$vr_icm, $vr_pm, $vr_alta, $vr_asc, $vr_talibon,
							$icm_section, $pm_section, $alta_section, $asc_section, $talibon_section)
	{

		$this->AddPage();
		
		$this->SetTextColor(28, 28, 28);
		$this->Cell(25, 10, "VARIANCE.", 0, 0, "C");
		$this->Ln();

		// Colors, line width and bold font
		$this->SetFillColor(255,0,0);
		$this->SetTextColor(255);
		$this->SetDrawColor(128,0,0);
		$this->SetLineWidth(.3);
		$this->SetFont('Arial','B',6);
		$w = array(16, 65, 13, 17, 13, 13, 13, 13, 13);
		// Header
		for($i=0;$i<count($header_3);$i++)
				
		$this->Cell($w[$i],10,$header_3[$i],1,0,'C',true);
		$this->Ln();
		//$this->Cell(18);
	
		// Color and font restoration
		$this->SetFillColor(224,235,255);
		$this->SetTextColor(0);
		$this->SetFont('Arial','',6);
		// Data
		$fill = false;
 		
 		if($item_code != null){
 			if($item_code == $pm_itemcode){
 				$pm_vr = $vr_pm;
 			}
 			if($item_code == $alta_itemcode){
 				$alta_vr = $vr_alta;
 			}
 			if($item_code == $asc_itemcode){
 				$asc_vr = $vr_asc;
 			}
 			if($item_code == $talibon_itemcode){
 				$talibon_vr = $vr_talibon;
 			}

 			foreach ($item_code as $key => $item_codes) {
	
				$this->Cell($w[0],10,$item_codes,1,0,'C',true,$fill);
				$this->Cell($w[1],10,$description[$key],1,0,'C',true,$fill);
				$this->Cell($w[2],10,$uom[$key],1,0,'C',true,$fill);
				$this->Cell($w[3],10,$icm_section[$key],1,0,'C',true,$fill);

				$this->Cell($w[4],10,@$vr_icm[$key],1,0,'C',true,$fill);
				$this->Cell($w[5],10,@$pm_vr[$key],1,0,'C',true,$fill);
				$this->Cell($w[6],10,@$alta_vr[$key],1,0,'C',true,$fill);
				$this->Cell($w[7],10,@$asc_vr[$key],1,0,'C',true,$fill);
				$this->Cell($w[8],10,@$talibon_vr[$key],1,0,'C',true,$fill);
				//$this->Cell($w[3],10,$total_qty,1,0,'C',true,$fill);
				
				$this->Ln();
			}
 		}
 		if($pm_itemcode != null){
 			if($pm_itemcode == $item_code){
 				$icm_vr = $vr_icm;
 			}
 			if($pm_itemcode == $pm_itemcode){
 				$pm_vr = $vr_pm;
 			}
 			if($pm_itemcode == $alta_itemcode){
 				$alta_vr = $vr_alta;
 			}
 			if($pm_itemcode == $asc_itemcode){
 				$asc_vr = $vr_asc;
 			}
 			if($pm_itemcode == $talibon_itemcode){
 				$talibon_vr = $vr_talibon;
 			}
 			foreach ($pm_itemcode as $key => $pm_codes) {
	
				$this->Cell($w[0],10,$pm_codes,1,0,'C',true,$fill);
				$this->Cell($w[1],10,$pm_description[$key],1,0,'C',true,$fill);
				$this->Cell($w[2],10,$pm_uom[$key],1,0,'C',true,$fill);
				$this->Cell($w[3],10,$pm_section[$key],1,0,'C',true,$fill);

				$this->Cell($w[4],10,@$icm_vr[$key],1,0,'C',true,$fill);
				$this->Cell($w[5],10,@$pm_vr[$key],1,0,'C',true,$fill);
				$this->Cell($w[6],10,@$alta_vr[$key],1,0,'C',true,$fill);
				$this->Cell($w[7],10,@$asc_vr[$key],1,0,'C',true,$fill);
				$this->Cell($w[8],10,@$talibon_vr[$key],1,0,'C',true,$fill);
				//$this->Cell($w[3],10,$total_qty,1,0,'C',true,$fill);
				
				$this->Ln();
			}
 		}
 		if($alta_itemcode != null){
 			if($alta_itemcode == $item_code){
 				$icm_vr = $vr_icm;
 			}
 			if($alta_itemcode == $pm_itemcode){
 				$alta_vr = $vr_pm;
 			}
 			if($alta_itemcode == $alta_itemcode){
 				$alta_vr = $vr_alta;
 			}
 			if($alta_itemcode == $asc_itemcode){
 				$asc_vr = $vr_asc;
 			}
 			if($alta_itemcode == $talibon_itemcode){
 				$talibon_vr = $vr_talibon;
 			}
 			foreach ($alta_itemcode as $key => $alta_codes) {
	
				$this->Cell($w[0],10,$alta_codes,1,0,'C',true,$fill);
				$this->Cell($w[1],10,$alta_description[$key],1,0,'C',true,$fill);
				$this->Cell($w[2],10,$alta_uom[$key],1,0,'C',true,$fill);
				$this->Cell($w[3],10,$alta_section[$key],1,0,'C',true,$fill);

				$this->Cell($w[4],10,@$vr_icm[$key],1,0,'C',true,$fill);
				$this->Cell($w[5],10,@$pm_vr[$key],1,0,'C',true,$fill);
				$this->Cell($w[6],10,@$alta_vr[$key],1,0,'C',true,$fill);
				$this->Cell($w[7],10,@$asc_vr[$key],1,0,'C',true,$fill);
				$this->Cell($w[8],10,@$talibon_vr[$key],1,0,'C',true,$fill);
				//$this->Cell($w[3],10,$total_qty,1,0,'C',true,$fill);
				
				$this->Ln();
			}
 		}	
 		if($asc_itemcode != null){
 			if($asc_itemcode == $item_code){
 				$icm_vr = $vr_icm;
 			}
 			if($asc_itemcode == $pm_itemcode){
 				$pm_vr = $vr_pm;
 			}
 			if($asc_itemcode == $alta_itemcode){
 				$alta_vr = $vr_alta;
 			}
 			if($asc_itemcode == $asc_itemcode){
 				$asc_vr = $vr_asc;
 			}
 			if($asc_itemcode == $talibon_itemcode){
 				$talibon_vr = $vr_talibon;
 			}
 			foreach ($asc_itemcode as $key => $asc_codes) {
	
				$this->Cell($w[0],10,$asc_codes,1,0,'C',true,$fill);
				$this->Cell($w[1],10,$asc_description[$key],1,0,'C',true,$fill);
				$this->Cell($w[2],10,$asc_uom[$key],1,0,'C',true,$fill);
				$this->Cell($w[3],10,$asc_section[$key],1,0,'C',true,$fill);

				$this->Cell($w[4],10,@$vr_icm[$key],1,0,'C',true,$fill);
				$this->Cell($w[5],10,@$pm_vr[$key],1,0,'C',true,$fill);
				$this->Cell($w[6],10,@$alta_vr[$key],1,0,'C',true,$fill);
				$this->Cell($w[7],10,@$asc_vr[$key],1,0,'C',true,$fill);
				$this->Cell($w[8],10,@$talibon_vr[$key],1,0,'C',true,$fill);
				//$this->Cell($w[3],10,$total_qty,1,0,'C',true,$fill);
				
				$this->Ln();
			}
 		}
 		if($talibon_itemcode != null){
 			if($talibon_itemcode == $item_code){
 				$icm_vr = $vr_icm;
 			}
 			if($talibon_itemcode == $pm_itemcode){
 				$pm_vr = $vr_pm;
 			}
 			if($talibon_itemcode == $alta_itemcode){
 				$alta_vr = $vr_alta;
 			}
 			if($talibon_itemcode == $asc_itemcode){
 				$asc_vr = $vr_asc;
 			}
 			if($talibon_itemcode == $talibon_itemcode){
 				$talibon_vr = $vr_talibon;
 			}
 			foreach ($talibon_itemcode as $key => $talibon_codes) {
	
				$this->Cell($w[0],10,$talibon_codes,1,0,'C',true,$fill);
				$this->Cell($w[1],10,$talibon_description[$key],1,0,'C',true,$fill);
				$this->Cell($w[2],10,$talibon_uom[$key],1,0,'C',true,$fill);
				$this->Cell($w[3],10,$talibon_section[$key],1,0,'C',true,$fill);

				$this->Cell($w[4],10,@$vr_icm[$key],1,0,'C',true,$fill);
				$this->Cell($w[5],10,@$pm_vr[$key],1,0,'C',true,$fill);
				$this->Cell($w[6],10,@$alta_vr[$key],1,0,'C',true,$fill);
				$this->Cell($w[7],10,@$asc_vr[$key],1,0,'C',true,$fill);
				$this->Cell($w[8],10,@$talibon_vr[$key],1,0,'C',true,$fill);
				//$this->Cell($w[3],10,$total_qty,1,0,'C',true,$fill);
				
				$this->Ln();
			}
 		}

		$this->Ln();
	
		$this->Cell(array_sum($w),0,'','T');
		$this->Ln(10);
	}	
}
$pdf = new PDF();
// Column headings

$pdf->SetFont('Arial','',12);
$pdf->SetLeftMargin(9);
$pdf->SetRightMargin(9);
$pdf->AddPage();
$pdf->Details($user);

$header = array('ITEM CODE', 'DESCRIPTION', 'UOM', 'SECTION', 'QTY ICM', 'QTY PM', 'QTY ALTA','QTY ASC', 'QTY TAL', 'QTY TOTAL' );
$header_2 = array('ITEM CODE', 'DESCRIPTION', 'UOM', 'SECTION', 'QTY ICM', 'QTY PM', 'QTY ALTA','QTY ASC', 'QTY TAL', 'QTY TOTAL' );
$header_3 = array('ITEM CODE', 'DESCRIPTION', 'UOM', 'SECTION', 'QTY ICM', 'QTY PM', 'QTY ALTA','QTY ASC', 'QTY TAL' );

$pdf->SetFont('Arial','',12);
$pdf->FancyTable($header, $item_code, $pm_itemcode, $alta_itemcode, $asc_itemcode, $talibon_itemcode,
				 $description, $pm_description, $alta_description, $asc_description, $pm_description,
				 $uom, $pm_uom, $alta_uom, $asc_uom, $talibon_uom,   
				 $qty_db, $qty_pm, $qty_alta, $qty_asc,  $qty_talibon, 
				 $icm_section, $pm_section, $alta_section, $asc_section, $talibon_section);
				 
				
$pdf->SetFont('Arial','',12);
$pdf->excel_qty_Table($header_2, $item_code, $pm_itemcode, $alta_itemcode, $asc_itemcode, $talibon_itemcode,
					  $description, $pm_description, $alta_description, $asc_description, $pm_description,
					  $uom, $pm_uom, $alta_uom, $asc_uom, $talibon_uom, 
					  $excel_icm, $excel_pm, $excel_alta, $excel_asc, $excel_talibon,
					  $icm_section, $pm_section, $alta_section, $asc_section, $talibon_section);


$pdf->SetFont('Arial','',12);
$pdf->Variance_Table($header_3, $item_code, $pm_itemcode, $alta_itemcode, $asc_itemcode, $talibon_itemcode, 
					 $description, $pm_description, $alta_description, $asc_description, $pm_description,
					 $uom, $pm_uom, $alta_uom, $asc_uom, $talibon_uom,
					 $vr_icm, $vr_pm, $vr_alta, $vr_asc, $vr_talibon,
					 $icm_section, $pm_section, $alta_section, $asc_section, $talibon_section);

//$pdf->Output(base_url("assets/images/pdf/").$exelfile.'_item_report.pdf', 'F');
//$path = $_SERVER['DOCUMENT_ROOT']."/store_conso/assets/images/pdf/".$exelfile.'_item_report.pdf'; 

foreach ($exelfile as $key => $filename) {
	$fname = $filename;

	$pdf->Output($_SERVER['DOCUMENT_ROOT']."/pcount/assets/images/pdf/".$fname.'_item_report.pdf', 'F');

	$path = base_url("assets/images/pdf/").$fname.'_item_report.pdf';

	$user_id = $this->session->userdata('user_id');

	$id_paths = array( 'user_id' 		=> $user_id, 
					   'file_name' 		=> $fname, 
					   'report_path' 	=> $path, 
					   'date_uploaded' 	=> date("Y-m-d, g:i a"),
					   'time'			=> date("g:i a")
					);
	
	 $result = $this->AdminModel->dir_save_cyclic($id_paths);
}
?>