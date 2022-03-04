<?php            
require_once 'database_connect.php';
require_once 'created_functions_php.php';
if (isset($_GET['term'])){
    
    $return_arr = array();
    $searchie = $_GET['term'];	
	$table_columns1 = array("pet_id","full_name","department");
	$table_columns2 = array("email_account");
	$result =	select_data_leftjoin($connection_TMS,"emp_info",$table_columns1,"emp_email",$table_columns2," emp_info.full_name like '%$searchie%' or emp_info.pet_id like '%$searchie%'","pet_id","email_pet_id")
while($row = $result->fetch_assoc()) 
	   {
		$return_arr[] = $row['full_name']." | ".$row['department']." | ".$row['pet_id']." | ".$row['email_account'];
	   }

    echo json_encode($return_arr);
}
?>