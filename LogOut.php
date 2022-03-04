<?php
 
require_once('logs_function.php');             
require_once('database_connect.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
//session_start();
 // AddLogs('Logout',''.$_SESSION['sess_displayname'].' Logged out to the System ');
			$query = "SELECT * FROM emp_info where pet_id ='".$_SESSION['login_user']."'";
			$result = mysqli_query($connection_emp_info, $query) or die(mysqli_error($connection_emp_info));
			while($row = $result->fetch_assoc()) {
				$first_name = $row['first_name'];
				$middlename = $row['middle_initial'];
				$lastname = $row['last_name'];
				$displayname = $row['full_name'];
				$department = $row['department'];
				$query_mail = "Select * FROM emp_email WHERE email_pet_id = '".$_SESSION['login_user']."'";
				$result_mail = mysqli_query($connection_emp_info, $query_mail) or die(mysqli_error($connection_emp_info));
				$row_mail = $result_mail->fetch_assoc();
				$mail = $row_mail['email_account'];
			}
			/*
		$query = "SELECT * FROM tbl_sec_users where uname ='".$_SESSION['login_user_connmacro']."'";
					$result = mysqli_query($connection_ConnMacro, $query) or die(mysqli_error($connection_ConnMacro));
					while($row = $result->fetch_assoc()) {
							$query2 = "SELECT * FROM tbl_mtn_tech_profile where emp_id ='".$row['emp_id']."'";
							$result2 = mysqli_query($connection_ConnMacro, $query2) or die(mysqli_error($connection_ConnMacro));
							$row2 = $result2->fetch_assoc();
							
						if(mysqli_num_rows($result) > 0)
						{	
							$first_name = $row2['first_name'];
							$middlename = $row2['middle_name'];
							$lastname = $row2['last_name'];
							$displayname = $first_name." ".$lastname;
							$department = $row2['department_id'];
						//	$mail = $row2['email_account'];
					
						}
					}*/
	AddLogs($connection_ConnMacro,$displayname,"",$department,"Logout",$displayname." logout to the system");
	
//$_SESSION = array();
session_destroy();

header("Location: login.php");
?>