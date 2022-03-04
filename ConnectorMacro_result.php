<?php
require_once("top_bar.php");
require_once("PHPExcel.php");

/** PHPExcel_Writer_Excel2007 */
require_once("PHPExcel/Writer/Excel2007.php");


function getNameFromNumber($num)
{
    $numeric = $num % 26;
    $letter = chr(65 + $numeric);
    $num2 = intval($num / 26);
    if ($num2 > 0) {
        return getNameFromNumber($num2 - 1) . $letter;
    } else {
        return $letter;
    }
}
$tr_result_list = "";
if (isset($_GET['compare_id'])) {
    //echo $_GET['compare_id']."test";
    $comparison_id = $_GET['compare_id'];
    $query = "SELECT *
        FROM compare_list
        where id  = '" . $comparison_id . "'
       ";

    $result = mysqli_query($connection_ConnMacro, $query) or die(mysqli_error($connection_ConnMacro));
    while ($row = $result->fetch_assoc()) {
        $cae_file = $row['caefile'];
        $mtf_file = $row['mtfile'];
        $in_charge = $row['emp_name'];
        $date_compared = $row['date_compared'];
        $in_charge_id = $row['emp_id'];
    }


    $header = array(
        'STATUS', 'START SIDE CIRCUIT SYMBOL', 'SIDE TERMINAL IDENTIFICATION', 'START SIDE CAVITY NUMBER', 'END SIDE CICRCUIT SYMBOL',
        'END SIDE TERMINAL IDENTIFICATION', 'END SIDE CAVITY NUMBER', 'START SIDE TERMINAL CUSTOMER PART NO', 'END SIDE TERMINAL CUSTOMER PART NO'
    );

    $objPHPExcel = new PHPExcel();
    $objWorkSheet = $objPHPExcel->createSheet(0); //S
    $objWorkSheet->setTitle("Comparison Result");
    $objPHPExcel->setActiveSheetIndexByName("Comparison Result");

    $rowxls = 2; // 1-2-3
    $colxls = 1; // A-B-C
    //$objPHPExcel->getActiveSheet()->setTitle($month_arr[]);

    $count = count($header);
    for ($colxls = 0; $colxls <= $count - 1; $colxls++) {
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($colxls, $rowxls, $header[$colxls]);
        $objPHPExcel->getActiveSheet()->getColumnDimension(getNameFromNumber($colxls))->setAutoSize(true);
        $set_style_no = getNameFromNumber($colxls) . "" . $rowxls;

        // $set_style_no2 = getNameFromNumber($colxls+1)."".($rowxls-1);

        $objPHPExcel->getActiveSheet()
            ->getStyle($set_style_no)
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK)
            ->getColor()
            ->setRGB('000000');

        $styleArray = array(
            'font'  => array(
                'bold'  => true,
                //'color' => array('rgb' => 'Black'),
                'size'  => 10,
                'name'  => 'Verdana'
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'FFFF00')

            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )
        );
        $objPHPExcel->getActiveSheet()->getStyle($set_style_no)->applyFromArray($styleArray);
    }
    $colxls = 0;
    $rowxls++;

    $query = "SELECT *
                  FROM compare_result
                  where comparison_id = " . $comparison_id . "
                 ";

    $result = mysqli_query($connection_ConnMacro, $query) or die(mysqli_error($connection_ConnMacro));


    $num_rows = mysqli_num_rows($result);
    $total_count_rows = $num_rows;
    //	for($index_result = 0 ;$index_result <= $max_row_count_table -1 ; $index_result++  )
    $counter_table_row = 1;

    while ($row = $result->fetch_assoc()) {
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($colxls, $rowxls, $row['compare_status']);
        $objPHPExcel->getActiveSheet()->getColumnDimension(getNameFromNumber($colxls))->setAutoSize(true);
        $set_style_no = getNameFromNumber($colxls) . "" . $rowxls;

        // $set_style_no2 = getNameFromNumber($colxls+1)."".($rowxls-1);

        $objPHPExcel->getActiveSheet()
            ->getStyle($set_style_no)
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK)
            ->getColor()
            ->setRGB('000000');

        $styleArray = array(
            'font'  => array(
                'bold'  => false,
                //'color' => array('rgb' => 'Black'),
                'size'  => 10,
                'name'  => 'Verdana'
            ),

            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )
        );
        $objPHPExcel->getActiveSheet()->getStyle($set_style_no)->applyFromArray($styleArray);

        $colxls++;
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($colxls, $rowxls, $row['Start_Side_Circuit_Symbol']);
        $objPHPExcel->getActiveSheet()->getColumnDimension(getNameFromNumber($colxls))->setAutoSize(true);
        $set_style_no = getNameFromNumber($colxls) . "" . $rowxls;

        // $set_style_no2 = getNameFromNumber($colxls+1)."".($rowxls-1);

        $objPHPExcel->getActiveSheet()
            ->getStyle($set_style_no)
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK)
            ->getColor()
            ->setRGB('000000');

        $styleArray = array(
            'font'  => array(
                'bold'  => false,
                //'color' => array('rgb' => 'Black'),
                'size'  => 10,
                'name'  => 'Verdana'
            ),

            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )
        );
        $colxls++;
        $objPHPExcel->getActiveSheet()->getStyle($set_style_no)->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($colxls, $rowxls, $row['Start_Side_Terminal_Identification']);
        $objPHPExcel->getActiveSheet()->getColumnDimension(getNameFromNumber($colxls))->setAutoSize(true);
        $set_style_no = getNameFromNumber($colxls) . "" . $rowxls;

        // $set_style_no2 = getNameFromNumber($colxls+1)."".($rowxls-1);

        $objPHPExcel->getActiveSheet()
            ->getStyle($set_style_no)
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK)
            ->getColor()
            ->setRGB('000000');

        $styleArray = array(
            'font'  => array(
                'bold'  => false,
                //'color' => array('rgb' => 'Black'),
                'size'  => 10,
                'name'  => 'Verdana'
            ),

            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )
        );

        $colxls++;
        $objPHPExcel->getActiveSheet()->getStyle($set_style_no)->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($colxls, $rowxls, $row['Start_Side_Cavity_Number']);
        $objPHPExcel->getActiveSheet()->getColumnDimension(getNameFromNumber($colxls))->setAutoSize(true);
        $set_style_no = getNameFromNumber($colxls) . "" . $rowxls;

        // $set_style_no2 = getNameFromNumber($colxls+1)."".($rowxls-1);

        $objPHPExcel->getActiveSheet()
            ->getStyle($set_style_no)
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK)
            ->getColor()
            ->setRGB('000000');

        $styleArray = array(
            'font'  => array(
                'bold'  => false,
                //'color' => array('rgb' => 'Black'),
                'size'  => 10,
                'name'  => 'Verdana'
            ),

            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )
        );
        $colxls++;
        $objPHPExcel->getActiveSheet()->getStyle($set_style_no)->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($colxls, $rowxls, $row['End_Side_Circuit_Symbol']);
        $objPHPExcel->getActiveSheet()->getColumnDimension(getNameFromNumber($colxls))->setAutoSize(true);
        $set_style_no = getNameFromNumber($colxls) . "" . $rowxls;

        // $set_style_no2 = getNameFromNumber($colxls+1)."".($rowxls-1);

        $objPHPExcel->getActiveSheet()
            ->getStyle($set_style_no)
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK)
            ->getColor()
            ->setRGB('000000');

        $styleArray = array(
            'font'  => array(
                'bold'  => false,
                //'color' => array('rgb' => 'Black'),
                'size'  => 10,
                'name'  => 'Verdana'
            ),

            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )
        );
        $colxls++;
        $objPHPExcel->getActiveSheet()->getStyle($set_style_no)->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($colxls, $rowxls, $row['End_Side_Terminal_Identification']);
        $objPHPExcel->getActiveSheet()->getColumnDimension(getNameFromNumber($colxls))->setAutoSize(true);
        $set_style_no = getNameFromNumber($colxls) . "" . $rowxls;

        // $set_style_no2 = getNameFromNumber($colxls+1)."".($rowxls-1);

        $objPHPExcel->getActiveSheet()
            ->getStyle($set_style_no)
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK)
            ->getColor()
            ->setRGB('000000');

        $styleArray = array(
            'font'  => array(
                'bold'  => false,
                //'color' => array('rgb' => 'Black'),
                'size'  => 10,
                'name'  => 'Verdana'
            ),

            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )
        );
        $colxls++;
        $objPHPExcel->getActiveSheet()->getStyle($set_style_no)->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($colxls, $rowxls, $row['End_Side_Cavity_Number']);
        $objPHPExcel->getActiveSheet()->getColumnDimension(getNameFromNumber($colxls))->setAutoSize(true);
        $set_style_no = getNameFromNumber($colxls) . "" . $rowxls;

        // $set_style_no2 = getNameFromNumber($colxls+1)."".($rowxls-1);

        $objPHPExcel->getActiveSheet()
            ->getStyle($set_style_no)
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK)
            ->getColor()
            ->setRGB('000000');

        $styleArray = array(
            'font'  => array(
                'bold'  => false,
                //'color' => array('rgb' => 'Black'),
                'size'  => 10,
                'name'  => 'Verdana'
            ),

            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )
        );
        $colxls++;
        $objPHPExcel->getActiveSheet()->getStyle($set_style_no)->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($colxls, $rowxls, $row['Start_side_terminal_customer_part_No']);
        $objPHPExcel->getActiveSheet()->getColumnDimension(getNameFromNumber($colxls))->setAutoSize(true);
        $set_style_no = getNameFromNumber($colxls) . "" . $rowxls;

        // $set_style_no2 = getNameFromNumber($colxls+1)."".($rowxls-1);

        $objPHPExcel->getActiveSheet()
            ->getStyle($set_style_no)
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK)
            ->getColor()
            ->setRGB('000000');

        $styleArray = array(
            'font'  => array(
                'bold'  => false,
                //'color' => array('rgb' => 'Black'),
                'size'  => 10,
                'name'  => 'Verdana'
            ),

            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )
        );
        $colxls++;
        $objPHPExcel->getActiveSheet()->getStyle($set_style_no)->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($colxls, $rowxls, $row['End_side_terminal_customer_part_No']);
        $objPHPExcel->getActiveSheet()->getColumnDimension(getNameFromNumber($colxls))->setAutoSize(true);
        $set_style_no = getNameFromNumber($colxls) . "" . $rowxls;

        // $set_style_no2 = getNameFromNumber($colxls+1)."".($rowxls-1);

        $objPHPExcel->getActiveSheet()
            ->getStyle($set_style_no)
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK)
            ->getColor()
            ->setRGB('000000');

        $styleArray = array(
            'font'  => array(
                'bold'  => false,
                //'color' => array('rgb' => 'Black'),
                'size'  => 10,
                'name'  => 'Verdana'
            ),

            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            )
        );
        $objPHPExcel->getActiveSheet()->getStyle($set_style_no)->applyFromArray($styleArray);

        $tr_result_list .= "<tr>
                                  <td>" . $row['compare_status'] . "</td>
                                  <td>" . $row['Start_Side_Circuit_Symbol'] . "</td>
                                  <td>" . $row['Start_Side_Terminal_Identification'] . "</td>
                                  <td>" . $row['Start_Side_Cavity_Number'] . "</td>
                                  <td>" . $row['End_Side_Circuit_Symbol'] . "</td>
                                  <td>" . $row['End_Side_Terminal_Identification'] . "</td>
                                  <td>" . $row['End_Side_Cavity_Number'] . "</td>
                                  <td>" . $row['Start_side_terminal_customer_part_No'] . "</td>
                                  <td>" . $row['End_side_terminal_customer_part_No'] . "</td>
                              </tr>";
        $colxls = 0;
        $rowxls++;
    }
    if ($tr_result_list == "") {
        $tr_result_list = "<tr>
                                  <td>No Result yet</td>
                               </tr>";
    }

    $today = date("m-d-y");
    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
    $date = date('m-d-Y');

    if (is_dir("uploads/" . $in_charge_id . "/")) {
        if (is_dir("uploads/" . $in_charge_id . "/$comparison_id")) {
            if (is_dir("uploads/" . $in_charge_id . "/$comparison_id/result/")) {
            } else {
                mkdir("uploads/" . $in_charge_id . "/$comparison_id/result/");
            }
        } else {
            mkdir("uploads/" . $in_charge_id . "/$comparison_id/");
            mkdir("uploads/$in_charge_id/$comparison_id/result");
        }
    } else {
        mkdir("uploads/$in_charge_id/");
        mkdir("uploads/$in_charge_id/$comparison_id/");
        mkdir("uploads/$in_charge_id/$comparison_id/result");
    }

    $file = "uploads/" . $in_charge_id . "/$comparison_id/result/" . $cae_file . "_result.php";
    $file_to_ex = "uploads/" . $in_charge_id . "/$comparison_id/result/" . $cae_file . "_result.xlsx";
    //echo $file;
    foreach (range('A', 'Q') as $columnID) {
        $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
            ->setAutoSize(true);
    }
    $objWriter->save(str_replace('.php', '.xlsx', $file));
    $filename = str_replace('.php', '.xlsx', $file);

    $export_to_excel = "<a href='$file_to_ex' target='_blank'><img src='logo/excel-icon.png' dwonload>".$cae_file."_result.xlsx</a>";
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
    <form method="GET" action="ConnectorMacro_Home.php">
        <!--<button type="submit" value="export_data" name="btn_export_data" onclick="">Export file</button> -->
        <center>
            <div class="col-md-4 col-xl-7 mb-5">
                <div class="card">
                    <div class="card-header">
                        <h4 class="blink_me"><i class="fas fa-info-circle"></i> Compared list</h4>
                    </div>





                    <div class="card-block">
                        <B>Cae File :</B> <?php if (!empty($cae_file)) echo $cae_file; ?><BR>
                        <B>MTF File :</B> <?php if (!empty($mtf_file)) echo $mtf_file; ?><BR>
                        <B>In Charge :</B> <?php if (!empty($in_charge)) echo $in_charge; ?><BR>
                        <B>Date Compared :</B> <?php if (!empty($date_compared)) echo $date_compared; ?><BR>
                        <B>Excel File Result :</B> <?php if (!empty($export_to_excel)) echo $export_to_excel; ?><BR>
  
        
                        <div class="col-md-4 col-xl-7 mb-5">
                        </div>
                        <table border='1' style='' class='table table-hover'>
                            <thead>
                                <th>Status</th>
                                <th>Start Side Circuit Symbol</th>
                                <th>Start Side Terminal Identification</th>
                                <th>Start Side Cavity Number</th>
                                <th>End Side Circuit Symbol</th>
                                <th>End Side Terminal Identification</th>
                                <th>End Side Cavity Number</th>
                                <th>Start side terminal customer part No</th>
                                <th>End side terminal customer part No</th>
                            </thead>
                            <tbody>
                                <?php
                                echo $tr_result_list;
                                ?>

                            </tbody>
                        </table>







                        <div class="row">


                            <a id="btn_compare" href="ConnectorMacro_Home.php" class="btn btn-danger" name="btn_compare" onclick="" style="margin: 5px;">Back</a>


                        </div>

                    </div>


                </div>
    </form>

    </div>






    <div class="row navbar navbar-light red content footer">
        <div class="text-center">© PET BIT 2020</div>
    </div>
</body>

</html>