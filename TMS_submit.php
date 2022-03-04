<?php
require_once('logs_function.php');
require_once('locker.php');
require_once("database_connect.php");
require_once("created_functions_php.php");
require_once('TMS_modals.php');
require_once("mailer.php");
require_once('created_functions_js.php');

if(isset($_POST['btn_add_time'])){
$txt_time = $_POST['txt_time'];
$txt_date = $_POST['txt_date'];
//$txt_time_value = explode(",",$_POST['txt_time_value']);
//$txt_date_value = explode(",",$_POST['txt_date_value']);
$value = array();
$result = select_data($connection_TMS,"tbl_tms_settings","*","tms_settings_no = '3' OR tms_settings_no = '5'");
while($row = $result->fetch_assoc()) 
	   {
		array_push($value,$row['tms_settings_value']);
	   }
	$time_arr = explode(",",$value[0]);
	$last_sent_arr = explode(",",$value[1]);
	array_push($time_arr,$txt_time);
	array_push($last_sent_arr,$txt_date);
	
	$time_toinput = implode(",",$time_arr);
	$date_toinput = implode(",",$last_sent_arr);
	//array_push
	$columns = array("tms_settings_value");
	$column_values = array($time_toinput);
   query_update($connection_TMS,"tbl_tms_settings",$columns,$column_values,"tms_setting_item = 'email_notification_time'");
	$columns = array("tms_settings_value");
	$column_values = array($date_toinput);
   query_update($connection_TMS,"tbl_tms_settings",$columns,$column_values,"tms_setting_item = 'email_notification_last_sent'");
	AddLogs($connection_TMS,$sess_displayname,"",$sess_department,"Manage Notification Time","$txt_time added to the notification time");
	echo "<script>alert('$txt_time added to notification time'); window.location.href = 'TMS_Home.php'; </script>";
}
if(isset($_POST['btn_update_time'])){
	 $slct_notification_list = $_POST['slct_notification_list'];
	 $txt_time = $_POST['txt_time'];
	$txt_date = $_POST['txt_date'];

	$result = select_data($connection_TMS,"tbl_tms_settings","*","tms_settings_no = 3 OR tms_settings_no = 5");
		$value = array();
	while($row = $result->fetch_assoc()) 
		   {
			array_push($value,$row['tms_settings_value']);
		   }

		$time_arr = explode(",",$value[0]);
		$last_sent_arr = explode(",",$value[1]);
		$selected_time = array_search($slct_notification_list, $time_arr);
		if($selected_time !== false)
		{
			$selected_date = $last_sent_arr[$selected_time];

			$time_arr[$selected_time] = $txt_time;
			$last_sent_arr[$selected_time] = $txt_date;

			$time_toinput = implode(",",$time_arr);
			$date_toinput = implode(",",$last_sent_arr);
			//array_push
			$columns = array("tms_settings_value");
			$column_values = array($time_toinput);
		   query_update($connection_TMS,"tbl_tms_settings",$columns,$column_values,"tms_setting_item = 'email_notification_time'");
			$columns = array("tms_settings_value");
			$column_values = array($date_toinput);
		   query_update($connection_TMS,"tbl_tms_settings",$columns,$column_values,"tms_setting_item = 'email_notification_last_sent'");
		AddLogs($connection_TMS,$sess_displayname,"",$sess_department,"Manage Notification Time","update notification time $slct_notification_list to $txt_time and last sent date $selected_date to $txt_date");
		echo "<script>alert('update notification time $slct_notification_list to $txt_time and last sent date $selected_date to $txt_date '); window.location.href = 'TMS_Home.php'; </script>";
		}
		else
		{
				echo "<script>alert('$slct_notification_list Not found $time_arr[0]'); window.location.href = 'TMS_Home.php'; </script>";
		
		}
	
}
if(isset($_POST['btn_delete_time'])){
  	 $slct_notification_list = $_POST['slct_notification_list'];
	 $txt_time = $_POST['txt_time'];
	$txt_date = $_POST['txt_date'];

	$result = select_data($connection_TMS,"tbl_tms_settings","*","tms_settings_no = 3 OR tms_settings_no = 5");
		$value = array();
	while($row = $result->fetch_assoc()) 
		   {
			array_push($value,$row['tms_settings_value']);
		   }

		$time_arr = explode(",",$value[0]);
		$last_sent_arr = explode(",",$value[1]);
		$selected_time = array_search($slct_notification_list, $time_arr);
		if($selected_time !== false)
		{
			unset($time_arr[$selected_time]); 
			unset($last_sent_arr[$selected_time]); 
			$time_toinput = implode(",",$time_arr);
			$date_toinput = implode(",",$last_sent_arr);
			//array_push
			$columns = array("tms_settings_value");
			$column_values = array($time_toinput);
		   query_update($connection_TMS,"tbl_tms_settings",$columns,$column_values,"tms_setting_item = 'email_notification_time'");
			$columns = array("tms_settings_value");
			$column_values = array($date_toinput);
		   query_update($connection_TMS,"tbl_tms_settings",$columns,$column_values,"tms_setting_item = 'email_notification_last_sent'");

		AddLogs($connection_TMS,$sess_displayname,"",$sess_department,"Manage Notification Time","$txt_time Deleted to the notification time");
		echo "<script>alert('$txt_time Deleted to the notification time'); window.location.href = 'TMS_Home.php'; </script>";
		}
		else
		{
				echo "<script>alert('$txt_time Not Found'); window.location.href = 'TMS_Home.php'; </script>";
	
		}
	
	
}
if(isset($_POST['btn_save_alert'])){
  	 $txt_alert_temp = $_POST['txt_alert_temp'];
  	 $txt_alert_hum = $_POST['txt_alert_hum'];
  	 $txt_alert_repeat_seconds = $_POST['txt_alert_repeat_seconds'];
  	 $slct_alert_notification = $_POST['slct_alert_notification'];
	
	$result = select_data($connection_TMS,"tbl_tms_settings","*","tms_settings_no = 10 OR tms_settings_no = 12 OR tms_settings_no = 13 OR tms_settings_no = 2");
		$value = array();
	while($row = $result->fetch_assoc()) 
		   {
			array_push($value,$row['tms_settings_value']);
		   }

		$alert_level_temp_greater_than = $value[1];
		$alert_hum_level_greater_than = $value[2];
		$alert_time_every_how_many_seconds = $value[3];
		$alert_notification = $value[0];
	
		$columns = array("tms_settings_value");
		$column_values = array($txt_alert_temp);
	   query_update($connection_TMS,"tbl_tms_settings",$columns,$column_values,"tms_setting_item = 'alert_level_temp_greater_than'");
		$columns = array("tms_settings_value");
		$column_values = array($txt_alert_hum);
	   query_update($connection_TMS,"tbl_tms_settings",$columns,$column_values,"tms_setting_item = 'alert_hum_level_greater_than'");		
		$columns = array("tms_settings_value");
		$column_values = array($txt_alert_repeat_seconds);
	   query_update($connection_TMS,"tbl_tms_settings",$columns,$column_values,"tms_setting_item = 'alert_time_every_how_many_seconds'");
	
		$columns = array("tms_settings_value");
		$column_values = array($slct_alert_notification);
	   query_update($connection_TMS,"tbl_tms_settings",$columns,$column_values,"tms_setting_item = 'alert_notification'");
	
	
		AddLogs($connection_TMS,$sess_displayname,"",$sess_department,"Manage Alert Level of Sensors","update alert Settings, Temperature alert from $alert_level_temp_greater_than to $txt_alert_temp, Humidity alert from $alert_hum_level_greater_than to $txt_alert_hum, Repeart alert from $alert_time_every_how_many_seconds seconds to  $txt_alert_repeat_seconds seconds  ,alert Notification From $alert_notification to $slct_alert_notification");
	echo "<script>alert('update alert Settings, Temperature alert from $alert_level_temp_greater_than to $txt_alert_temp, Humidity alert from $alert_hum_level_greater_than to $txt_alert_hum, Repeart alert from $alert_time_every_how_many_seconds seconds to  $txt_alert_repeat_seconds seconds,  alert Notification From $alert_notification to $slct_alert_notification '); window.location.href = 'TMS_Home.php'; </script>";
}
if(isset($_POST['btn_update_sms_notification'])){
  	 $slct_sms_notification 	= $_POST['slct_sms_notification'];
  	 $slct_sms_notification_day = $_POST['slct_sms_notification_day'];

	$result = select_data($connection_TMS,"tbl_tms_settings","*","tms_settings_no = 14 OR tms_settings_no = 15");
		$value = array();
	while($row = $result->fetch_assoc()) 
		   {
			array_push($value,$row['tms_settings_value']);
		   }

		$sms_notification = $value[0];
		$sms_notification_day = $value[1];
	
		$columns = array("tms_settings_value");
		$column_values = array($slct_sms_notification);
	   query_update($connection_TMS,"tbl_tms_settings",$columns,$column_values,"tms_setting_item = 'sms_notification'");
		$columns = array("tms_settings_value");
		$column_values = array($slct_sms_notification_day);
	   query_update($connection_TMS,"tbl_tms_settings",$columns,$column_values,"tms_setting_item = 'sms_notification_day'");		
		
	
		AddLogs($connection_TMS,$sess_displayname,"",$sess_department,"Manage SMS Notification","update SMS Settings, SMS Notification from $sms_notification to $slct_sms_notification, SMS notification day from $sms_notification_day to $slct_sms_notification_day");
	echo "<script>alert('update SMS Settings, SMS Notification from $sms_notification to $slct_sms_notification, SMS notification day from $sms_notification_day to $slct_sms_notification_day'); window.location.href = 'TMS_Home.php'; </script>";
}
if(isset($_POST['btn_manage_email_add'])){
  	 $txt_email	= trim($_POST['txt_email']);
  
	$result = select_data($connection_TMS,"tbl_tms_settings","*","tms_settings_no = 4");
		$value = array();
	while($row = $result->fetch_assoc()) 
		   {
			array_push($value,$row['tms_settings_value']);
		   }

		$email_notification_to = explode(",",$value[0]);
		$selected_email = array_search($txt_email, $email_notification_to);
		if($selected_email !== false)
		{
			echo "<script>alert('Email Already Exist'); window.location.href = 'TMS_Home.php'; </script>";
		}
		else
		{
			//echo "<script>alert('Email Already Exist'); window.location.href = 'TMS_Home.php'; </script>";
			array_push($email_notification_to,$txt_email);
			$columns = array("tms_settings_value");
			$column_values = array(implode(",",$email_notification_to));
			query_update($connection_TMS,"tbl_tms_settings",$columns,$column_values,"tms_setting_item = 'email_notification_to'");
			
			AddLogs($connection_TMS,$sess_displayname,"",$sess_department,"Manage Email List","Added $txt_email to the Email List of Notification");
			echo "<script>alert('Added $txt_email to the Email List of Notification'); window.location.href = 'TMS_Home.php'; </script>";
		
		}
	
		
}
if(isset($_POST['btn_manage_email_delete'])){
  	 $txt_email	= trim($_POST['txt_email']);
  
	$result = select_data($connection_TMS,"tbl_tms_settings","*","tms_settings_no = 4");
		$value = array();
	while($row = $result->fetch_assoc()) 
		   {
			array_push($value,$row['tms_settings_value']);
		   }

		$email_notification_to = explode(",",$value[0]);
		$selected_email = array_search($txt_email, $email_notification_to);
		if($selected_email !== false)
		{
				unset($email_notification_to[$selected_email]); 
				$columns = array("tms_settings_value");
				$column_values = array(implode(",",$email_notification_to));
			   query_update($connection_TMS,"tbl_tms_settings",$columns,$column_values,"tms_setting_item = 'email_notification_to'");
			
			AddLogs($connection_TMS,$sess_displayname,"",$sess_department,"Manage Email List","Deleted $txt_email to the Email List of Notification");
			echo "<script>alert('Deleted $txt_email to the Email List of Notification'); window.location.href = 'TMS_Home.php'; </script>";
			
		}
		else
		{
			echo "<script>alert('Email Not Exist'); window.location.href = 'TMS_Home.php'; </script>";
		}
	
		
}
//btn sms manage contact list
if(isset($_POST['btn_manage_sms_add'])){
  	 $txt_sms_no	= trim($_POST['txt_sms_no']);
  
	$result = select_data($connection_TMS,"tbl_tms_settings","*","tms_settings_no = 9");
		$value = array();
	while($row = $result->fetch_assoc()) 
		   {
			array_push($value,$row['tms_settings_value']);
		   }

		$sms_notification_to = explode(",",$value[0]);
		$selected_sms_no = array_search($txt_sms_no, $sms_notification_to);
		if($selected_sms_no !== false)
		{
			echo "<script>alert('SMS No Already Exist'); window.location.href = 'TMS_Home.php'; </script>";
		}
		else
		{
			//echo "<script>alert('Email Already Exist'); window.location.href = 'TMS_Home.php'; </script>";
			array_push($sms_notification_to,$txt_sms_no);
			$columns = array("tms_settings_value");
			$column_values = array(implode(",",$sms_notification_to));
			query_update($connection_TMS,"tbl_tms_settings",$columns,$column_values,"tms_setting_item = 'sms_notification_to'");
			
			AddLogs($connection_TMS,$sess_displayname,"",$sess_department,"Manage SMS Contact List","Added $txt_sms_no to the SMS Contact List of Notification");
			echo "<script>alert('Added $txt_sms_no to the SMS Contact List of Notification'); window.location.href = 'TMS_Home.php'; </script>";
		
		}
	
		
}
if(isset($_POST['btn_manage_sms_delete'])){
  	 $txt_sms_no	= trim($_POST['txt_sms_no']);
  
	$result = select_data($connection_TMS,"tbl_tms_settings","*","tms_settings_no = 9");
		$value = array();
	while($row = $result->fetch_assoc()) 
		   {
			array_push($value,$row['tms_settings_value']);
		   }

		$sms_notification_to = explode(",",$value[0]);
		$selected_sms_no = array_search($txt_sms_no, $sms_notification_to);
		if($selected_sms_no !== false)
		{
				unset($sms_notification_to[$selected_sms_no]); 
				$columns = array("tms_settings_value");
				$column_values = array(implode(",",$sms_notification_to));
			   query_update($connection_TMS,"tbl_tms_settings",$columns,$column_values,"tms_setting_item = 'sms_notification_to'");
			
			AddLogs($connection_TMS,$sess_displayname,"",$sess_department,"Manage SMS Contact List","Deleted $txt_sms_no to the SMS Contact List of Notification");
			echo "<script>alert('Deleted $txt_sms_no to the SMS Contact List of Notification'); window.location.href = 'TMS_Home.php'; </script>";
			
		}
		else
		{
			echo "<script>alert('SMS No Not Exist'); window.location.href = 'TMS_Home.php'; </script>";
		}
	
		
}

?>