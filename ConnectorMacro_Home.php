<?php
require_once("top_bar.php");


        require_once 'PHPExcel.php';

        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "office";

        if(isset($_POST['upload'])){
            $inputfilename = $_FILES['file']['tmp_name'];
            $exceldata = array();

            $conn = mysqli_connect($servername, $username, $password, $dbname);

            if(!$conn){
                die("Connection Failed: " . mysqli_connect_error());
            }

            try {
                $inputfiletype = PHPExcel_IOFactory::identify($inputfilename);
                $objReader = PHPExcel_IOFactory::createReader($inputfiletype);
                $objPHPExcel = $objReader->load($inputfilename);
            } catch(Exception $e){
                die('Error loading file "'.pathinfo($inputfilename,PATHINFO_BASENAME).'": '.$e->getMessage());
            }

        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();

        for($row = 2; $row <= $highestRow; $row++) {
            $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);

            $sql = "INSERT INTO allsec (emp_code, emp_full_name, request_type, leave_status, leave_from, leave_to, days, year, month, pl, pm, lpm, status, emp_name, wg, leave_type)
        VALUES ('".$rowData[0][0]."', '".$rowData[0][1]."', '".$rowData[0][2]."', '".$rowData[0][3]."', '".$rowData[0][4]."', '".$rowData[0][5]."', '".$rowData[0][6]."', '".$rowData[0][7]."', '".$rowData[0][8]."', '".$rowData[0][9]."', '".$rowData[0][10]."', '".$rowData[0][11]."', '".$rowData[0][12]."', '".$rowData[0][13]."', '".$rowData[0][14]."', '".$rowData[0][15]."')";

            if(mysqli_query($conn, $sql)){
                $exceldata[] = $rowData[0];
            } else{
                echo "Error: " .$sql . "<br>" . mysqli_error($conn);
            }

        }


        echo "<table border='1'>";
        foreach($exceldata as $index => $excelraw){
            echo "<tr>";
            foreach($excelraw as $excelcolumn){
                echo "<td>".$excelcolumn."</td>";
            }
            echo "</tr>";
        }
        echo "</table>";

        mysqli_close($conn);

    }
    

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

 $tr_compared_list .= "<tr class='tr_link' href='ConnectorMacro_result.php?compare_id=".$row['id']."'>
                          <td>".$row['emp_name']."</td>
                          <td>".$row['mtfile']."</td>
                          <td>".$row['caefile']."</td>
                          <td>".$row['date_compared']."</td>
                      </tr>";
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
		<form  method="GET" action="ConnectorMacro_Home.php">
		<!--<button type="submit" value="export_data" name="btn_export_data" onclick="">Export file</button> -->
			<center>
	<div class="col-md-4 col-xl-7 mb-5">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="blink_me"><i class="fas fa-info-circle"></i> Compared list</h4>
                        </div>
						
                        <div class="card-block">
                             
                              <a id="btn_compare" href="ConnectorMacro_compare.php" class="btn btn-success" name="btn_compare" onclick="" style="margin: 5px;">Compare</a>


                     
                        <table border='1' style='' class='table table-hover'>
                          <thead>
                            <th>In Charge</th>
                            <th>MT File name</th>
                            <th>Cae File Name</th>
                            <th>Date compared</th>
                          </thead>
                            <tbody>
                                  <?php
                                    echo $tr_compared_list;
                                  ?>

                          </tbody>
                        </table>
							
       
								
										
								

					
							
							
							</div>
		
		
					  </div>
            </form>		
									
		</div>
	   
			
				

		   

		  <div class="row navbar navbar-light red content footer">
            <div class="text-center">© PET BIT 2020</div>
        </div>
	</body>
</html>