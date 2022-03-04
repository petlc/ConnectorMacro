<?php

// php select option value from database
/*
$hostname = "localhost";
$username = "root";
$password = "";
$databaseName = "expense_ms";

// connect to mysql database

$connect = mysqli_connect($hostname, $username, $password, $databaseName);*/

if (session_status() == PHP_SESSION_NONE) {
    session_start();
	
	
	$server_arr = array('10.49.5.47','10.49.1.140');
	$user_arr = array('OMS_TOOL','OMS_TOOL');
	
	$_SESSION['selected_server'] = $server_arr[1];
	//print_r($server_arr);
}
function check_connection($connection,$db)
{
    if (!$connection){
    die("Database Connection Failed" . mysqli_error($connection));
    }
    $select_db = mysqli_select_db($connection, $db);
    if (!$select_db){
        die("Database Selection Failed" . mysqli_error($connection));
    }
    
}

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

  //  $connection_emp_info = mysqli_connect('10.49.5.235', 'root1', '');
    $connection_emp_info = mysqli_connect('localhost', 'root', '');
    check_connection($connection_emp_info,"pet_employees");
  


    $connection_ConnMacro = mysqli_connect('localhost','root','');
    check_connection($connection_ConnMacro,'connector_macro');


	//$connection_OMS = mysqli_connect($_SESSION['selected_server'],'OMS_TOOL','OMS_TOOL');
    //check_connection($connection_OMS,'oms_pet');	

   // $connection_OMS = mysqli_connect('10.49.5.47','OMS_TOOL','OMS_TOOL');
    //check_connection($connection_OMS,'oms_pet');

?>




      
      
      
      
      
      
      
      
      
