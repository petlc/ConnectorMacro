<?php

require_once("top_bar.php");


function getNameFromNumber($num) {
    $numeric = ($num - 1) % 26;
    $letter = chr(65 + $numeric);
    $num2 = intval(($num - 1) / 26);
    if ($num2 > 0) {
        return getNameFromNumber($num2) . $letter;
    } else {
        return $letter;
    }
}


// Set properties
$rowxls = 2; // 1-2-3
$colxls = 1; // A-B-C

$DEADLINE = "";
$VEHICLE_EVENT = "";
$CFRS_STAGE = "";
$DATA_RECIEVED_DATE = "";
$PET_ESTIMATE_HOURS = "";
$DATE = "";
$DATA_SEND = "";
$PPROVED = "";
$TOTAL = "";
$MH_SPENT = "";
$Q = "";
$C = "";
$D = "";
$CS = "";
$COMMENT = "";
    $objPHPExcel = new PHPExcel();
$objPHPExcel->getActiveSheet()->setTitle('report');\
//if($_SESSION['selected_server'] == "10.49.5.47")
    $header = array('No.','ORDER NO','TEAM','DATE','CATEGORY','YAZAKI PART NO.','VEHICLE CODE','THEME NO','ESTIMATED HOURS', 'DEADLINE','VEHICLE EVENT','CFRS STAGE','DATA RECIEVED DATE' , 'PET ESTIMATE HOURS' , 'DATE' , 'DATA SEND' ,'APPROVED' , 'TOTAL' , 'MH SPENT' ,'Q', 'C' ,'D' ,'CS' , 'COMMENT');



     $objPHPExcel->getActiveSheet()->freezePane("A3");
	$count = count($header);
	for($colxls = 0; $colxls <= $count-1; $colxls++ )
	{
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($colxls,$rowxls, $header[$colxls]);
         $objPHPExcel->getActiveSheet()
                ->getStyle("A2:I2")
                ->getBorders()
                ->getAllBorders()
                ->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK)
                ->getColor()
                ->setRGB('000000');
	}
$colxls =0;
$rowxls++;

$sql1 = "SELECT * 
		FROM returned_tbl ORDER BY return_returned DESC";
$query1 = mysqli_query($conn, $sql1);

	while ($row=mysqli_fetch_array($query1))
    {
        $ret_name   =   $row['return_name'];
        $ret_dept   =   $row['return_dept'];
        $ret_need  =   $row['return_need'];
        $ret_return  =   $row['return_return'];
        $ret_purpose  =   $row['return_purpose'];
        $ret_lent  =   $row['return_lent'];
        $ret_returned  =   $row['return_returned'];
        $ret_pull  =   $row['return_pull'];
        $ret_con  =   $row['return_con'];
        
        $set_style_no  =getNameFromNumber($colxls+1)."".$rowxls;
                                                    
  
        $objPHPExcel->getActiveSheet()                                
        ->getStyle($set_style_no)                                               
            ->getBorders()
            ->getLeft()
            ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)                                      
            ->getColor()
            ->setRGB('000000');                                                
              //border right
                                                      
        $objPHPExcel->getActiveSheet()
         ->getStyle($set_style_no)
         ->getBorders()
         ->getRight()
         ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
         ->getColor()
         ->setRGB('000000');
   
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($colxls,$rowxls,$ret_name );
        $objPHPExcel->getActiveSheet()->getColumnDimension(getNameFromNumber($colxls+1))->setAutoSize(true);
        $colxls++;
        
        
             $set_style_no  =getNameFromNumber($colxls+1)."".$rowxls;
                                                    
  
        $objPHPExcel->getActiveSheet()                                
        ->getStyle($set_style_no)                                               
            ->getBorders()
            ->getLeft()
            ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)                                      
            ->getColor()
            ->setRGB('000000');                                                
              //border right
                                                      
        $objPHPExcel->getActiveSheet()
         ->getStyle($set_style_no)
         ->getBorders()
         ->getRight()
         ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
         ->getColor()
         ->setRGB('000000');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($colxls,$rowxls,$ret_dept );
        $objPHPExcel->getActiveSheet()->getColumnDimension(getNameFromNumber($colxls+1))->setAutoSize(true);
        $colxls++;
             $set_style_no  =getNameFromNumber($colxls+1)."".$rowxls;
                                                    
  
        $objPHPExcel->getActiveSheet()                                
        ->getStyle($set_style_no)                                               
            ->getBorders()
            ->getLeft()
            ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)                                      
            ->getColor()
            ->setRGB('000000');                                                
              //border right
                                                      
        $objPHPExcel->getActiveSheet()
         ->getStyle($set_style_no)
         ->getBorders()
         ->getRight()
         ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
         ->getColor()
         ->setRGB('000000');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($colxls,$rowxls,$ret_need );
        $objPHPExcel->getActiveSheet()->getColumnDimension(getNameFromNumber($colxls+1))->setAutoSize(true);
        $colxls++;
             $set_style_no  =getNameFromNumber($colxls+1)."".$rowxls;
                                                    
  
        $objPHPExcel->getActiveSheet()                                
        ->getStyle($set_style_no)                                               
            ->getBorders()
            ->getLeft()
            ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)                                      
            ->getColor()
            ->setRGB('000000');                                                
              //border right
                                                      
        $objPHPExcel->getActiveSheet()
         ->getStyle($set_style_no)
         ->getBorders()
         ->getRight()
         ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
         ->getColor()
         ->setRGB('000000');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($colxls,$rowxls,$ret_return );
        $objPHPExcel->getActiveSheet()->getColumnDimension(getNameFromNumber($colxls+1))->setAutoSize(true);
        $colxls++;
        
             $set_style_no  =getNameFromNumber($colxls+1)."".$rowxls;
                                                    
  
        $objPHPExcel->getActiveSheet()                                
        ->getStyle($set_style_no)                                               
            ->getBorders()
            ->getLeft()
            ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)                                      
            ->getColor()
            ->setRGB('000000');                                                
              //border right
                                                      
        $objPHPExcel->getActiveSheet()
         ->getStyle($set_style_no)
         ->getBorders()
         ->getRight()
         ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
         ->getColor()
         ->setRGB('000000');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($colxls,$rowxls,$ret_purpose );
        $objPHPExcel->getActiveSheet()->getColumnDimension(getNameFromNumber($colxls+1))->setAutoSize(true);
        $colxls++;
             $set_style_no  =getNameFromNumber($colxls+1)."".$rowxls;
                                                    
  
        $objPHPExcel->getActiveSheet()                                
        ->getStyle($set_style_no)                                               
            ->getBorders()
            ->getLeft()
            ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)                                      
            ->getColor()
            ->setRGB('000000');                                                
              //border right
                                                      
        $objPHPExcel->getActiveSheet()
         ->getStyle($set_style_no)
         ->getBorders()
         ->getRight()
         ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
         ->getColor()
         ->setRGB('000000');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($colxls,$rowxls, $ret_lent);
        $objPHPExcel->getActiveSheet()->getColumnDimension(getNameFromNumber($colxls+1))->setAutoSize(true);
        $colxls++;
        
             $set_style_no  =getNameFromNumber($colxls+1)."".$rowxls;
                                                    
  
        $objPHPExcel->getActiveSheet()                                
        ->getStyle($set_style_no)                                               
            ->getBorders()
            ->getLeft()
            ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)                                      
            ->getColor()
            ->setRGB('000000');                                                
              //border right
                                                      
        $objPHPExcel->getActiveSheet()
         ->getStyle($set_style_no)
         ->getBorders()
         ->getRight()
         ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
         ->getColor()
         ->setRGB('000000');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($colxls,$rowxls,$ret_returned );
        $objPHPExcel->getActiveSheet()->getColumnDimension(getNameFromNumber($colxls+1))->setAutoSize(true);
        $colxls++;
        
             $set_style_no  =getNameFromNumber($colxls+1)."".$rowxls;
                                                    
  
        $objPHPExcel->getActiveSheet()                                
        ->getStyle($set_style_no)                                               
            ->getBorders()
            ->getLeft()
            ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)                                      
            ->getColor()
            ->setRGB('000000');                                                
              //border right
                                                      
        $objPHPExcel->getActiveSheet()
         ->getStyle($set_style_no)
         ->getBorders()
         ->getRight()
         ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
         ->getColor()
         ->setRGB('000000');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($colxls,$rowxls,$ret_pull );
        $objPHPExcel->getActiveSheet()->getColumnDimension(getNameFromNumber($colxls+1))->setAutoSize(true);
        $colxls++;
        
             $set_style_no  =getNameFromNumber($colxls+1)."".$rowxls;
                                                    
  
        $objPHPExcel->getActiveSheet()                                
        ->getStyle($set_style_no)                                               
            ->getBorders()
            ->getLeft()
            ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)                                      
            ->getColor()
            ->setRGB('000000');                                                
              //border right
                                                      
        $objPHPExcel->getActiveSheet()
         ->getStyle($set_style_no)
         ->getBorders()
         ->getRight()
         ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN)
         ->getColor()
         ->setRGB('000000');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($colxls,$rowxls,$ret_con );
        $objPHPExcel->getActiveSheet()->getColumnDimension(getNameFromNumber($colxls+1))->setAutoSize(true);
        $colxls++;
        
        
        
        $rowxls++;
        $colxls = 0;
    }



 
$today = date("m-d-y");

 $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);

            $date = date('m-d-Y');
    $file = "export/History ".$today.".php";
    //echo $file;
    $objWriter->save(str_replace('.php', '.xlsx', $file));
    $filename = str_replace('.php', '.xlsx', $file);
    //$filerename = str_replace('..', 'http://10.49.1.242:8012/SRS', $filename);
     //$filerename = str_replace('..', 'http://10.49.1.242:8012/SRS', $filename);
if (session_status() == PHP_SESSION_NONE) {
    session_start();
	
	

	
	
    
    
	//print_r($server_arr);
}
    echo"<script>
		alert('Generating excel');
		window.location.href = 'http://localhost/OMS_TOOL/export/History ".$today.".xlsx';
		</script><script>window.close()</script>";

$objWriter->save('php://output');
?>