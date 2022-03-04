<?php
require_once("top_bar.php");


     require_once('PHPExcel.php');
   

        if(isset($_POST['btn_compare'])){

            if(isset($_FILES['file_cae']['name']) && $_FILES['file_cae']['name'] != "" &&  isset($_FILES['file_mtf']['name']) && $_FILES['file_cae']['name']  != "") 
            {
                $cae_file = $_FILES['file_cae']['name'];
                $mtf_file = $_FILES['file_mtf']['name'];
                $tmp_cae_file = $_FILES['file_cae']['tmp_name'];
                $tmp_mtf_file = $_FILES['file_mtf']['tmp_name'];
                
                $allowedExtensions = array("xls","xlsx","csv");
                $ext = pathinfo($cae_file, PATHINFO_EXTENSION);
                
                if(in_array($ext, $allowedExtensions)) {
                        // Uploaded file
                        if(is_dir("uploads"))
                        {
                            if(is_dir("uploads/".$_SESSION['login_user_connmacro']))
                            {
        
                            }
                            else
                            {
                                mkdir("uploads/".$_SESSION['login_user_connmacro']);
                            }
                        }
                        else
                        {
                            mkdir("uploads");
                            mkdir("uploads/".$_SESSION['login_user_connmacro']);
                        }
                       $part_no_count = 0;
                       $compare_id = "";
                       $file = "uploads/".$_SESSION['login_user_connmacro']."/".$cae_file;
                       $isUploaded = copy($tmp_cae_file, $file);
                       // check uploaded file
                       if($isUploaded) {
                          
                            try {
                                // load uploaded file
                                $objPHPExcel = PHPExcel_IOFactory::load($file);
                            } catch (Exception $e) {
                                 die('Error loading file "' . pathinfo($file, PATHINFO_BASENAME). '": ' . $e->getMessage());
                            }
                            
                            // Specify the excel sheet index
                            $sheet = $objPHPExcel->getSheet(0);
                            $total_rows = $sheet->getHighestRow();
                            $highestColumn      = $sheet->getHighestColumn();	
                            $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);		
                            
                            //	loop over the rows
                         //find Wire Name
                            $part_no                                 = "";
                            $Wire_Name                               = "";
                            $Start_Side_Circuit_Symbol               = "";         
                            $Start_Side_Terminal_Identification      = "";  
                            $Start_Side_Cavity_Number                = "";
                            $End_Side_Circuit_Symbol                 = "";
                            $End_Side_Terminal_Identification        = "";
                            $End_Side_Cavity_Number                  = "";
                            $Start_side_terminal_customer_part_No    = "";
                            $End_side_terminal_customer_part_No = "";
                            $comparison_id = "";

                            	//$sess_role = $_SESSION['bs_role'];
                      
                            $wire_name_column = "";
                            $query = "INSERT INTO compare_list(
                                mtfile, 
                                caefile,
                                emp_id,
                                emp_name,
                                emp_dept,
                                date_compared
                                )
                                VALUES 
                                (
                                '".$mtf_file."',
                                '".$cae_file."',
                                '".$_SESSION['login_user_connmacro']."',
                                '". $_SESSION['sess_displayname']."',
                                '". $_SESSION['sess_department']."',
                                  now()
                                )";
                                $result_compare_list = mysqli_query($connection_ConnMacro, $query) or die(mysqli_error($connection_ConnMacro));
                                $compare_id = mysqli_insert_id($connection_ConnMacro);
                            for ($row = 1; $row <= $total_rows; ++ $row) {
                                $ctr_wnc = 0;
                                $row_data =array();
                                $part_no = "";
                                for ($col = 0; $col < $highestColumnIndex; ++ $col) {
                                    $cell = $sheet->getCellByColumnAndRow($col, $row);
                                    $val = $cell->getValue();
                                    if($row == 1)
                                    {
                                        if($val == "Wire Name")
                                        {
                                            $wire_name_column = $col;
                                            $part_no_count = $wire_name_column+1;
                                        }
                                      
                                    }
                                    
                                    if($col >= $wire_name_column)
                                    {

                                        array_push($row_data,$val);
                                    }
                                    else
                                    {
                                        if(strlen($val) > 0)
                                        {
                                            $part_no .= 1;
                                        }
                                        else
                                        {
                                            $part_no .= 0;
                                        }
                                       
                                    }
                                 
                                    $records[$row][$col] = $val;
                                }
                                if($row > 1 )
                                {
                                    $query = "INSERT INTO caefile(
                                        part_no, 
                                        Wire_Name,
                                        Start_Side_Circuit_Symbol,
                                        Start_Side_Terminal_Identification,
                                        Start_Side_Cavity_Number,
                                        End_Side_Circuit_Symbol,                 
                                        End_Side_Terminal_Identification,        
                                        End_Side_Cavity_Number,         
                                        Multiple_WireNo,                 
                                        Kind_of_Multiple_Wire,                 
                                        Start_side_terminal_customer_part_No, 
                                        End_side_terminal_customer_part_No,
                                        comparison_id
                                        )
                                        VALUES 
                                        (
                                        '".trim($part_no)."',
                                        '".trim($row_data[0])."',
                                        '".trim($row_data[1])."',
                                        '".trim($row_data[2])."',
                                        '".trim($row_data[3])."',
                                        '".trim($row_data[4])."',
                                        '".trim($row_data[5])."',
                                        '".trim($row_data[6])."',
                                        '".trim($row_data[7])."',
                                        '".trim($row_data[8])."',
                                        '".trim($row_data[9])."',
                                        '".trim($row_data[10])."',
                                        '".trim($compare_id)."')";
                                        $result = mysqli_query($connection_ConnMacro, $query) or die(mysqli_error($connection_ConnMacro));
                                }
                                $part_no = "";
                                //insert row sql command
                            }
                        }
                        unlink($file);
                            $file = "uploads/".$_SESSION['login_user_connmacro']."/".$mtf_file;
                            $isUploaded = copy($tmp_mtf_file, $file);
                            // check uploaded file
                            if($isUploaded) {
                               
                                 try {
                                     // load uploaded file
                                     $objPHPExcel = PHPExcel_IOFactory::load($file);
                                 } catch (Exception $e) {
                                      die('Error loading file "' . pathinfo($file, PATHINFO_BASENAME). '": ' . $e->getMessage());
                                 }
                                 
                                 // Specify the excel sheet index
                                 //$sheet = $objPHPExcel->getSheet(0);
                                 $sheet = $objPHPExcel->getSheetByName("Cavity");
                                 $total_rows = $sheet->getHighestRow();
                                 $highestColumn      = $sheet->getHighestColumn();	
                                 $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);		
                                 
                                 //	loop over the rows
                              //find Wire Name
                                 $part_no                                 = "";
                                 $Con_No_connector                        = "";
                                 $Con_Part_Number                         = "";         
                                 $Col_connector                           = "";  
                                 $Cav_No                                  = "";
                                 $Term                                    = "";
                                 $comparison_id                           = "";
                                $val_arr = "";

                                     $Con_No_collumn = "";
                                     $Con_PN_collumn = "";
                                     $Col_collumn = "";
                                     $Cav_No_collumn = "";
                                     $Term_collumn = "";

                                 for ($row = 1; $row <= $total_rows; ++ $row) {
                                     $ctr_wnc = 0;
                                     $row_data =array();
                                     $part_no = "";
                                     $Con_No_connector                        = "";
                                     $Con_Part_Number                         = "";         
                                     $Col_connector                           = "";  
                                     $Cav_No                                  = "";
                                     $Term                                    = "";
                                     for ($col = 0; $col < $highestColumnIndex; ++ $col) {
                                         $cell = $sheet->getCellByColumnAndRow($col, $row);
                                         $val = $cell->getValue();
                                         if($row == 3)
                                         {
                                         
                                            if($val == "Cav.\nNo.")
                                            {
                                                $Cav_No_collumn = $col;
                                               // echo "found Cav_No_collumn $col";
                                            }
                                            if($val == "Term.")
                                            {
                                                $Term_collumn = $col;
                                                //echo "found Term_collumn $col";
                                            }
                                         }

                                         if($row == 4)
                                         {

                                             if($val == "Con.\nNo.")
                                             {
                                                 $Con_No_collumn = $col;
                                               //  echo "found Con_No_collumn $col";
                                             }
                                             if($val == "Con.\nPart Number")
                                             {
                                                 $Con_PN_collumn = $col;
                                                 //echo "found Con_PN_collumn $col";
                                             }
                                             if($val == "Col.")
                                             {
                                                
                                                 if($Col_collumn == "")
                                                 {
                                                    $Col_collumn = $col;
                                                 }
                                                 //echo "found Col_collumn $col";
                                             }
                                           
                                          
                                           
                                         }

                                        if($row > 4 )
                                        {
                                            if($col > 1 && $col < $Con_No_collumn)
                                            {
                                                if(strlen($val) > 0)
                                                {
                                                    if($val == "□" )
                                                    {
                                                        $part_no .= 0;
                                                    }
                                                    else
                                                    {
                                                        $val_arr .=  $val."</BR>";
                                                        $part_no .= 1;
                                                    }
                                                   
                                                }
                                                else
                                                {
                                                    $part_no .= 0;
                                                }
                                               
                                            }
                                
                                           
   
                                          
   
                                            if($col == $Con_No_collumn)
                                            {
                                               $Con_No_connector = $val;
                                              // echo "Con connector = $val";
                                            }
                                            if($col == $Con_PN_collumn)
                                            {
        
                                               $Con_Part_Number = $val;
                                              // echo "Col part number = $val";
                                            }
                                            if($col == $Col_collumn)
                                            {
                                               $Col_connector = $val;
                                             //  echo "Col collumn = $val";
                                            }
                                            if($col == $Cav_No_collumn)
                                            {
        
                                               $Cav_No = $val;
                                              // echo "Cav No = $val";
                                            }
                                            if($col == $Term_collumn)
                                            {
        
                                               $Term = $val;
                                             //  echo "term val = $val";
                                            }
                                            
                                         
                                            $records[$row][$col] = $val;
                                        }
                                   /*     echo "$Con_No_connector test con con ";
                                     echo "$Con_Part_Number test con part ";
                                     echo "$Col_connector test col con";
                                     echo "$Cav_No test cav no";
                                     echo "$Term test term</BR>";*/
                                     }
                                    
                                     if($row > 4 )
                                     {
                                        if($Term != "/" && $Term != "●")
                                        {
                                            $query = "INSERT INTO mtfile(
                                                part_no, 
                                                Con_No_connector,
                                                Con_Part_Number,
                                                Col_connector,
                                                Cav_No,
                                                Term,    
                                                comparison_id
                                                )
                                                VALUES 
                                                (
                                                '".trim($part_no)."',
                                                '".trim($Con_No_connector)."',
                                                '".trim($Con_Part_Number)."',
                                                '".trim($Col_connector)."',
                                                '".trim($Cav_No)."',
                                                '".trim($Term)."',
                                                '".trim($compare_id)."'
                                                )";
                                                $result = mysqli_query($connection_ConnMacro, $query) or die(mysqli_error($connection_ConnMacro));
                                        }
                                        
                                     }
                                     $part_no = "";
                                     //insert row sql command
                                 }
                                 unlink($file);
/*
caefile table

part_no  1
Start_Side_Circuit_Symbol 2
Start_Side_Terminal_Identification 3
Start_Side_Cavity_Number 4
End_Side_Circuit_Symbol 5
End_Side_Terminal_Identification 6
End_Side_Cavity_Number 7
Start_side_terminal_customer_part_No 8
End_side_terminal_customer_part_No 9

mtfile table

part_no 1
Con_No_connector 3 6
Con_Part_Number 8 9
Col_connector 9
Cav_No 4 7
Term 2 5

*/ 
                                   $query_cae = "SELECT *
                                    FROM caefile 
                                    where comparison_id = $compare_id
                                    ";
                                    $result_cae = mysqli_query($connection_ConnMacro, $query_cae) or die(mysqli_error($connection_ConnMacro));
                                    $num_rows = mysqli_num_rows($result_cae);
                                 //   $total_count_rows = $num_rows;
                                    while($row_cae = $result_cae->fetch_assoc()) 
                                    {
                                       
                                        $query_mtf = "SELECT *
                                        FROM mtfile 
                                        where comparison_id = $compare_id AND Term = '".$row_cae['Start_Side_Circuit_Symbol']."' AND part_no = '".$row_cae['part_no']."'  ";
                                        $result_mtf = mysqli_query($connection_ConnMacro, $query_mtf) or die(mysqli_error($connection_ConnMacro));
                                        $row_mtf = $result_mtf->fetch_assoc();
                                        $num_rows_mtf = mysqli_num_rows($result_mtf);

                                        $changes_val = array();
                                        $changes_col = array();

                                        if($num_rows_mtf > 0)
                                        {
                                            if($row_mtf['Con_No_connector'] != $row_cae['Start_Side_Terminal_Identification'])
                                            {
                                                    array_push($changes_col,'Start_Side_Terminal_Identification');
                                                    array_push($changes_val,"Changes From ".$row_mtf['Con_No_connector']." to ".$row_cae['Start_Side_Terminal_Identification']);
                                            }
                                            if($row_mtf['Cav_No'] != $row_cae['Start_Side_Cavity_Number'])
                                            {
                                                array_push($changes_col,'Start_Side_Cavity_Number');
                                                array_push($changes_val,"Changes From ".$row_mtf['Cav_No']." to ".$row_cae['Start_Side_Cavity_Number']);
                                            }
                                            if($row_mtf['Col_connector'] != "" )
                                            {
                                                if($row_mtf['Con_Part_Number']."-".$row_mtf['Col_connector'] != $row_cae['Start_side_terminal_customer_part_No'])
                                                    {
                                                            array_push($changes_col,'Start_side_terminal_customer_part_No');
                                                            array_push($changes_val,"Changes From ".$row_mtf['Con_Part_Number']."-".$row_mtf['Col_connector']." to ".$row_cae['Start_side_terminal_customer_part_No']);
                                                    
                                                    }
                                            }
                                            else
                                            {
                                                if($row_mtf['Con_Part_Number'] != $row_cae['Start_side_terminal_customer_part_No'])
                                                {   
                                                        array_push($changes_col,'Start_side_terminal_customer_part_No');
                                                        array_push($changes_val,"Changes From ".$row_mtf['Con_Part_Number']." to ".$row_cae['Start_side_terminal_customer_part_No']);
                                                }
                                            }
                                       
                                           
                                            //cae end
                                            $query_mtf_end = "SELECT *
                                            FROM mtfile 
                                            where comparison_id = $compare_id AND Term = '".$row_cae['End_Side_Circuit_Symbol']."'";
                                            $result_mtf_end = mysqli_query($connection_ConnMacro, $query_mtf_end) or die(mysqli_error($connection_ConnMacro));
                                            $row_mtf_end = $result_mtf_end->fetch_assoc();
                                            $num_rows_mtf_end = mysqli_num_rows($result_mtf_end);
    
                                            if($num_rows_mtf_end > 0)
                                            {
                                                if($row_mtf_end['Con_No_connector'] != $row_cae['End_Side_Terminal_Identification'])
                                                {
                                                        
                                                        array_push($changes_col,'End_Side_Terminal_Identification');
                                                        array_push($changes_val,"Changes From ".$row_mtf_end['Con_No_connector']." to ".$row_cae['End_Side_Terminal_Identification']);
                                                }
                                                if($row_mtf_end['Cav_No'] != $row_cae['End_Side_Cavity_Number'])
                                                {
                                                    array_push($changes_col,'End_Side_Cavity_Number');
                                                    array_push($changes_val,"Changes From ".$row_mtf_end['Cav_No']." to ".$row_cae['End_Side_Cavity_Number']);
                                                }
                                                if($row_mtf_end['Con_Part_Number'] != $row_cae['End_side_terminal_customer_part_No'])
                                                {   
                                                    if($row_mtf_end['Col_connector'] != "" )
                                                    {   
                                                        if($row_mtf_end['Con_Part_Number']."-".$row_mtf_end['Col_connector'] != $row_cae['End_side_terminal_customer_part_No'])
                                                        {
                                                            array_push($changes_col,'End_side_terminal_customer_part_No');
                                                            array_push($changes_val,"Changes From ".$row_mtf_end['Con_Part_Number']."-".$row_mtf_end['Col_connector']." to ".$row_cae['End_side_terminal_customer_part_No']);
                                                    
                                                        }
    
                                                    }
                                                    else
                                                    {
                                                        array_push($changes_col,'End_side_terminal_customer_part_No');
                                                        array_push($changes_val,"Changes From ".$row_mtf_end['Con_Part_Number']." to ".$row_cae['End_side_terminal_customer_part_No']);
                                                    }
                                                    
                                                   
                                                }
                                            
                                          
                                            }
                                            if(count($changes_val) > 0)
                                            {

                                               // $comapre_Start_Side_Circuit_Symbol = $changes_val[array_search('Start_Side_Circuit_Symbol',$changes_col)];
                                               if (false !== $key = array_search('Start_Side_Terminal_Identification', $changes_col)) {
                                                //do something 
                                                $comapre_Start_Side_Terminal_Identification = $changes_val[array_search('Start_Side_Terminal_Identification',$changes_col)];
                                              
                                                } else {
                                                    // do something else
                                                $comapre_Start_Side_Terminal_Identification = $row_cae['Start_Side_Terminal_Identification'];
                                              
                                                }
                                                if (false !== $key = array_search('Start_Side_Cavity_Number', $changes_col)) {
                                                    //do something 
                                                  $comapre_Start_Side_Cavity_Number = $changes_val[array_search('Start_Side_Cavity_Number',$changes_col)];
                                                    } else {
                                                        // do something else
                                                  $comapre_Start_Side_Cavity_Number = $row_cae['Start_Side_Cavity_Number'];
                                                    }

                                                if (false !== $key = array_search('End_Side_Terminal_Identification', $changes_col)) {
                                                        //do something 
                                                        $comapre_End_Side_Terminal_Identification =  $changes_val[array_search('End_Side_Terminal_Identification',$changes_col)];
                                                      
                                                        } else {
                                                            // do something else
                                                        $comapre_End_Side_Terminal_Identification = $row_cae['End_Side_Terminal_Identification'];
                                                      
                                                        }   
                                                if (false !== $key = array_search('End_Side_Cavity_Number', $changes_col)) {
                                                            //do something 
                                                  $comapre_End_Side_Cavity_Number = $changes_val[array_search('End_Side_Cavity_Number',$changes_col)];
                                                          
                                                } else {
                                                                // do something else
                                                 $comapre_End_Side_Cavity_Number = $row_cae['End_Side_Cavity_Number'];
                                                          
                                                            }
                                                if (false !== $key = array_search('Start_side_terminal_customer_part_No', $changes_col)) {
                                                                //do something 
                                                $comapre_Start_side_terminal_customer_part_No =  $changes_val[array_search('Start_side_terminal_customer_part_No',$changes_col)];
                                                              
                                                } else {
                                                                    // do something else
                                                 $comapre_Start_side_terminal_customer_part_No = $row_cae['Start_side_terminal_customer_part_No'];
                                                              
                                                                }
                                                 if (false !== $key = array_search('End_side_terminal_customer_part_No', $changes_col)) {
                                                                    //do something 
                                                    $comapre_End_side_terminal_customer_part_No =  $changes_val[array_search('End_side_terminal_customer_part_No',$changes_col)];

                                                                  
                                                 } else {
                                                                        // do something else
                                                  $comapre_End_side_terminal_customer_part_No = $row_cae['End_side_terminal_customer_part_No'];
                                                                  
                                                 }
                                               /*

                                                if(array_key_exists("Start_Side_Terminal_Identification",$changes_col)) 
                                                {
                                                    $comapre_Start_Side_Terminal_Identification = $changes_val[array_search('Start_Side_Terminal_Identification',$changes_col)];
                                                } 
                                                else
                                                {
                                                    $comapre_Start_Side_Terminal_Identification = $row_cae['Start_Side_Terminal_Identification'];
                                                }

                                                if(array_key_exists("Start_Side_Cavity_Number",$changes_col))
                                                {
                                                    $comapre_Start_Side_Cavity_Number = $changes_val[array_search('Start_Side_Cavity_Number',$changes_col)];
                                                }
                                                else
                                                {
                                                    $comapre_Start_Side_Cavity_Number = $row_cae['Start_Side_Cavity_Number'];
                                                }
                                                if(array_key_exists("End_Side_Terminal_Identification",$changes_col))
                                                {
                                                    $comapre_End_Side_Terminal_Identification =  $changes_val[array_search('End_Side_Terminal_Identification',$changes_col)];
                                              
                                                }
                                                else
                                                {
                                                    $comapre_End_Side_Terminal_Identification = $row_cae['End_Side_Terminal_Identification'];
                                                }
                                                if(array_key_exists("End_Side_Cavity_Number",$changes_col))
                                                {
                                                   $comapre_End_Side_Cavity_Number = $changes_val[array_search('End_Side_Cavity_Number',$changes_col)];
                                                 
                                                }
                                                else
                                                {
                                                    $comapre_End_Side_Cavity_Number = $row_cae['End_Side_Cavity_Number'];
                                                }
                                                if(array_key_exists("Start_side_terminal_customer_part_No",$changes_col))
                                                {
                                                    $comapre_Start_side_terminal_customer_part_No =  $changes_val[array_search('Start_side_terminal_customer_part_No',$changes_col)];
                                              
                                                }
                                                else
                                                {
                                                    $comapre_Start_side_terminal_customer_part_No = $row_cae['Start_side_terminal_customer_part_No'];
                                                }
                                                if(array_key_exists("End_side_terminal_customer_part_No",$changes_col))
                                                {
                                                    $comapre_End_side_terminal_customer_part_No =  $changes_val[array_search('End_side_terminal_customer_part_No',$changes_col)];

                                                }
                                                else
                                                {
                                                    $comapre_End_side_terminal_customer_part_No = $row_cae['End_side_terminal_customer_part_No'];
                                                }*/

                                              //  $comapre_End_Side_Circuit_Symbol = $changes_val[array_search('End_Side_Circuit_Symbol',$changes_col)];             
                                             
                                                $query_compare = "INSERT INTO compare_result(
                                                    part_no, 
                                                    Wire_Name,
                                                    Start_Side_Circuit_Symbol,
                                                    Start_Side_Terminal_Identification,
                                                    Start_Side_Cavity_Number,
                                                    End_Side_Circuit_Symbol,                 
                                                    End_Side_Terminal_Identification,        
                                                    End_Side_Cavity_Number,                       
                                                    Start_side_terminal_customer_part_No, 
                                                    End_side_terminal_customer_part_No,
                                                    comparison_id,
                                                    compare_status
                                                    )
                                                    VALUES 
                                                    (
                                                    '".$row_cae['part_no']."',
                                                    '".$row_cae['Wire_Name']."',
                                                    '".$row_cae['Start_Side_Circuit_Symbol']."',
                                                    '".$comapre_Start_Side_Terminal_Identification."',
                                                    '".$comapre_Start_Side_Cavity_Number."',
                                                    '".$row_cae['End_Side_Circuit_Symbol']."',
                                                    '".$comapre_End_Side_Terminal_Identification."',
                                                    '".$comapre_End_Side_Cavity_Number."',
                                                    '".$comapre_Start_side_terminal_customer_part_No."',
                                                    '".$comapre_End_side_terminal_customer_part_No."',
                                                    '".$row_cae['comparison_id']."',
                                                    'Change'
                                                    )";
                                                    $result_compare = mysqli_query($connection_ConnMacro, $query_compare) or die(mysqli_error($connection_ConnMacro));
                                            }
                                         //   var_dump($changes_col);
                                          //  var_dump($changes_val);
                                        }
                                        else
                                        {
                                            //additional
                                          
                                            $query_add = "INSERT INTO compare_result(
                                                part_no, 
                                                Wire_Name,
                                                Start_Side_Circuit_Symbol,
                                                Start_Side_Terminal_Identification,
                                                Start_Side_Cavity_Number,
                                                End_Side_Circuit_Symbol,                 
                                                End_Side_Terminal_Identification,        
                                                End_Side_Cavity_Number,                       
                                                Start_side_terminal_customer_part_No, 
                                                End_side_terminal_customer_part_No,
                                                comparison_id,
                                                compare_status
                                                )
                                                VALUES 
                                                (
                                                '".$row_cae['part_no']."',
                                                '".$row_cae['Wire_Name']."',
                                                '".$row_cae['Start_Side_Circuit_Symbol']."',
                                                '".$row_cae['Start_Side_Terminal_Identification']."',
                                                '".$row_cae['Start_Side_Cavity_Number']."',
                                                '".$row_cae['End_Side_Circuit_Symbol']."',
                                                '".$row_cae['End_Side_Terminal_Identification']."',
                                                '".$row_cae['End_Side_Cavity_Number']."',
                                                '".$row_cae['Start_side_terminal_customer_part_No']."', 
                                                '".$row_cae['End_side_terminal_customer_part_No']."',
                                                '".$row_cae['comparison_id']."',
                                                'Additional'
                                                )";

                                                //echo $query_add;
                                                $result_add = mysqli_query($connection_ConnMacro, $query_add) or die(mysqli_error($connection_ConnMacro));
                                        }

                                      
                                    }
                                  


                            echo "<script>alert('files Compared');  window.location.href = 'ConnectorMacro_Home.php';</script>";
                        } else {
                            echo '<span class="msg">File not uploaded!</span>';
                        }
                } else {
                    echo '<span class="msg">Please upload excel sheet.</span>';
                }
            } else {
                echo '<span class="msg">Please upload excel file.</span>';
            }
        

    }
   
    
$compare_list_table = 
$query = "SELECT *
					FROM compare_list 
          where emp_dept = '".$_SESSION['sess_department']."'
					ORDER BY date_compared DESC";

$result = mysqli_query($connection_ConnMacro, $query) or die(mysqli_error($connection_ConnMacro));
$num_rows = mysqli_num_rows($result);
$total_count_rows = $num_rows;
//	for($index_result = 0 ;$index_result <= $max_row_count_table -1 ; $index_result++  )
$counter_table_row =1;
$tr_compared_list = "";
while($row = $result->fetch_assoc()) 
{

 
}
if($tr_compared_list == "")
{
  $tr_compared_list = "<tr>
                          <td>No Comparison yet</td>
                       </tr>";
}
?>



<html>
	
	<head>
		<title>BITRR004</title>
		 <style>
         
       </style>
	
	</head>
	
	<body>
  <div class="col-md-4 col-xl-7 mb-5">
  </div>
		<form  method="POST" action="ConnectorMacro_compare.php"  enctype="multipart/form-data">
		<!--<button type="submit" value="export_data" name="btn_export_data" onclick="">Export file</button> -->
			<center>
	<div class="col-md-4 col-xl-7 mb-5">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="blink_me"><i class="fas fa-info-circle"></i> Compare</h4>
                        </div>
						
                        <div class="card-block">
                               
                               <label class="form-control">MTF File</label>
                               <input class="form-control" type="file" name="file_mtf" >
                               <br>
                               
                               <label class="form-control">CAE File</label>
                               <input class="form-control" type="file" name="file_cae" >
                            
								
								<div class="row">
											
												   <button id="btn_compare" type="submit" class="btn btn-success" name="btn_compare" onclick="" style="margin: 5px;">Start Compare</button>


								</div>	
							
							</div>
		
		
					  </div>
					  		
		</div>
	   
			
				

		   
		</form>
		  <div class="row navbar navbar-light red content footer">
            <div class="text-center">© PET BIT 2020</div>
        </div>
	</body>
</html>