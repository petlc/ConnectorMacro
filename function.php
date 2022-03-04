<?php


require_once("database_connect.php");
require_once('logs_function.php');
require_once("created_functions_php.php");
require_once("mailer.php");
require_once('created_functions_js.php');


require_once("database_connect.php");
//require_once("locker.php");
require_once("created_functions_php.php");
require_once("logs_function.php");

if(isset($_POST['login'])){
	if(isset($_POST['username']) && isset($_POST['password'])){
		$username = filter_input(INPUT_POST, "username");
		$password = filter_input(INPUT_POST, "password");
        $domain = "petcad1100";
        $adserver = "petsvr1100";
        $accounts = new ldap_login();
        //echo $username;
	 $output =  $accounts->ldap_loginAccount($domain,$adserver,$username, $password);
		
		if($output != "false")
		{
			
				if (session_status() == PHP_SESSION_NONE) {
					session_start();
				}
					$_SESSION['login_user_connmacro'] =  $_POST['username'];
			
					$query = "SELECT * FROM emp_info where pet_id ='".$_SESSION['login_user_connmacro']."'";
					$result = mysqli_query($connection_emp_info, $query) or die(mysqli_error($connection_emp_info));
					while($row = $result->fetch_assoc()) {
						$first_name = $row['first_name'];
						$middlename = $row['middle_initial'];
						$lastname = $row['last_name'];
						$displayname = $row['full_name'];
						$department = $row['department'];
						$query_mail = "Select * FROM emp_email WHERE email_pet_id = '".$_SESSION['login_user_connmacro']."'";
						$result_mail = mysqli_query($connection_emp_info, $query_mail) or die(mysqli_error($connection_emp_info));
						$row_mail = $result_mail->fetch_assoc();
						$mail = $row_mail['email_account'];
					}
			AddLogs( $connection_ConnMacro,$displayname,"",$department,"Login",$displayname." login to the system");
			echo"<script>alert('Login Successful'); window.location.href = 'ConnectorMacro_Home.php';</script>";
		}
		else
		{
			AddLogs($connection_ConnMacro,$displayname,"",$department,"Login",$displayname." Wrong Credentials");
			echo "<script>alert('Invalid Username or Password'); window.location.href = 'index.php'; </script>";
		}
	}else{
		echo "please login";
	}
}


/*
if(isset($_POST['login']))
{

	$uname = $_POST['username'];
	$result = select_data($connection_OMS,"tbl_sec_users","*","uname = '$uname' ");
	$row_count = count_data($connection_OMS,"tbl_sec_users","uname ='$uname'");
	$row = mysqli_fetch_array($result);
         
	$db_sha1 = $row['pword'];
	//echo $db_sha1;
	if($row_count > 0 )
	{
		if (sha1($_POST['password']) == $db_sha1)
		  {
		//  echo "<br>Login in Successfull";
			  $_SESSION['login_user_oms'] = $uname;
			  	$query = "SELECT * FROM tbl_sec_users where uname ='".$uname."'";
					$result = mysqli_query($connection_OMS, $query) or die(mysqli_error($connection_OMS));
					while($row = $result->fetch_assoc()) {
							$query2 = "SELECT * FROM tbl_mtn_tech_profile where emp_id ='".$row['emp_id']."'";
							$result2 = mysqli_query($connection_OMS, $query2) or die(mysqli_error($connection_OMS));
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
					}
			  AddLogs($connection_OMS_TOOL,$displayname,"",$department,"Login",$displayname." login to the system");
			  echo "<script>alert('Log in Successful')</script>";
			  echo "<script>window.location.href = 'ConnectorMacro_Home.php'</script>";
			  
			  
		  exit;
		  }
		else
		{
			  echo "<script>alert('Log in failed')</script>";
			 echo "<br>Login in Failed";
			  echo "<script>window.location.href = 'login.php'</script>";
		}
		
	}
	else
	{
		  echo "<script>alert('Log in failed')</script>";
		 echo "<script>window.location.href = 'login.php'</script>";
		 echo "<br>user not found";
	}
	
	
}




*/







?>