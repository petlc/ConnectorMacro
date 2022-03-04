
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if(empty($_SESSION["login_user_connmacro"]))
          {
              echo"<script>alert('Sorry you need to Log in ');
											  window.location.href = 'logout.php';
											  </script>";
		
              
 }
/*
$remote_add  = $_SERVER['REMOTE_ADDR'];

  $arr_info = shell_exec('wmic.exe/node:'.$remote_add.' computersystem get username');

  $arr_info =  explode("\\",$arr_info);
*/


if(getBrowser() != 'Chrome')
{
echo "<script>alert('Browser not supported. use Google Chrome');  window.close();window.location.href ='http://10.49.1.242:8012/srs/login.php'; </script>";
		
}
/*
if(count($arr_info) ==2)
{
	 $_SESSION['login_user'] =trim($arr_info[1]);
}*/


//echo $arr_info[1];
require_once("database_connect.php");
//var_dump($_SESSION);

 if(isset($_SESSION['login_user_connmacro'])){

	
	if(isset($_SESSION['sess_loaded']))
	{
	  $sess_department = $_SESSION['sess_department'];
	  $sess_firstname = $_SESSION['sess_firstname'];
      $sess_username = $_SESSION['login_user_connmacro'];
      $sess_email = $_SESSION['sess_email'];
	  $sess_displayname = $_SESSION['sess_displayname'];
		
	}
	 else
	 {
			 $sess_department = "";	
			 $sess_firstname = "";
			 $sess_username = "";
			 $sess_email = "";
			 $sess_displayname = "";
				if(strpos( $_SESSION['login_user_connmacro'], 'admin' ) !== false)
					{
						$exp = explode("-",$_SESSION['login_user_connmacro']);
						$_SESSION['login_user_connmacro'] = $exp[0];
					}
				   /// $_SESSION['login_pass'] = $password;
				$sess_arr_role = array();
				$sess_arr_dept_role =array();

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
					}/*
					$query = "SELECT * FROM emp_borrowing_role where bs_pet_id ='".$_SESSION['login_user_connmacro']."'";
					$result = mysqli_query($connection_emp_info, $query) or die(mysqli_error($connection_emp_info));
					while($row = $result->fetch_assoc()) {
						array_push($sess_arr_role,$row['bs_role']);
						array_push($sess_arr_dept_role,$row['bs_role_dept']);
					}*/


			//$sess_role = $_SESSION['bs_role'];
		 $_SESSION['sess_department'] = $department;
		 $_SESSION['sess_firstname'] = $first_name;
		 $_SESSION['sess_email'] = $mail;
		 $_SESSION['sess_displayname'] = $displayname;
		 $_SESSION['sess_loaded'] = "TRUE";
	  $sess_department = $_SESSION['sess_department'];
	  $sess_firstname = $_SESSION['sess_firstname'];
      $sess_username = $_SESSION['login_user_connmacro'];
      $sess_email = $_SESSION['sess_email'];
	  $sess_displayname = $_SESSION['sess_displayname'];
		
		 
	 }
		 
	

}
    


?>