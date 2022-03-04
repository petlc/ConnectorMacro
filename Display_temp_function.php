<?php
require_once("connect.php");

if(!empty($_GET['collect_temp']))
   {
    $temp_info = array();
     $query = "SELECT *
                 FROM tbl_temp_data
                        ";
            $result = mysqli_query($connection, $query) or die(mysqli_error($connection));    
            $rowcount=mysqli_num_rows($result);
            
            if($rowcount > 0)
            {
                
                while($row = $result->fetch_assoc()) {
                    array_push($temp_info,$row['Humidity_data'].",".$row['Temperature_data'].",".$row['Water_data']);
                }
            }
    
       echo json_encode($temp_info);
   }
?>