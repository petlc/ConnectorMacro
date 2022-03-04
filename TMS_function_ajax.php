<?php

require_once("database_connect.php");
require_once("created_functions_php.php"); 
/*

if(!empty($_GET['GetText_file_name']))
{
	
}*/
if(!empty($_GET['GetText_file_name']))
   { 
	  // $temp_info = array("test");
 $file_name = $_GET['GetText_file_name'];
 $file_time = $_GET['search_time'];
	 $location = $_GET['GetText_file_loc'];
	 $arduino_loc = $_GET['arduino_loc'];
	 $date_year=date("Y");
	 $date_month=date("m");
  	 $time_now=date("H:i:s");
  	 $time_now_ampm=date("h:i:sa");
	 $day_of_week = date("w");  
	 $datetime_now=date("Y-m-d H:i:s");
 $myFile = "$location/$arduino_loc/$date_year/$date_month/".$file_name.".txt";
	
	  
if (file_exists($myFile)) {
  //  echo "The file $file_name exists";
	
	
	
	 $sms_send = "False";
	 $col = "*";
 	 $lines = file($myFile);//file in to an array
	 $index = "";
	 $arr_index = "";
	 $last_index = count($lines)-1;
	 $String_line  = explode("^",preg_replace('/[?]/', '', preg_replace('/[\000-\031\200-\377]/', '', $lines[$last_index])));
     $hum_temp = explode(",",trim(preg_replace("/[^0-9,.^a-z^A-Z]/", "", $String_line[3])));
     $temp_info = array($hum_temp[0],$hum_temp[1],$hum_temp[5]);
	   
	
	 $result = select_data($connection_TMS,"tbl_tms_settings","*","tms_setting_item = 'alert_level_temp_greater_than'");	
	 $row = $result->fetch_assoc();
	 $alert_level_temp_greater_than = $row['tms_settings_value'];   
	   
	 $result = select_data($connection_TMS,"tbl_tms_settings","*","tms_setting_item = 'alert_level_water_not_equal_to'");	
	 $row = $result->fetch_assoc();
	 $alert_level_water_not_equal_to = $row['tms_settings_value'];  
	   
	 $result = select_data($connection_TMS,"tbl_tms_settings","*","tms_setting_item = 'alert_hum_level_greater_than'");	
	 $row = $result->fetch_assoc();
	 $alert_hum_level_greater_than = $row['tms_settings_value'];  
	  
	 $result = select_data($connection_TMS,"tbl_tms_settings","*","tms_setting_item = 'sms_notification_to'");	
	 $row = $result->fetch_assoc();
	 $sms_notification_to = explode(",",$row['tms_settings_value']);  

	 $temp_settings_info = array($alert_level_temp_greater_than,$alert_level_water_not_equal_to,$alert_hum_level_greater_than,$sms_notification_to); 
	   
	 $result = select_data($connection_TMS,"tbl_tms_settings",$col,"tms_setting_item = 'temp_high_start'");
	 $row = $result->fetch_assoc();
	 $temp_high_start = $row['tms_settings_value'];
						   
	 $result = select_data($connection_TMS,"tbl_tms_settings",$col,"tms_setting_item = 'hum_high_start'");
	 $row = $result->fetch_assoc();
	 $hum_high_start = $row['tms_settings_value'];
						   
	 $result = select_data($connection_TMS,"tbl_tms_settings",$col,"tms_setting_item = 'water_leak_sensor_start'");
	 $row = $result->fetch_assoc();
	 $water_leak_start = $row['tms_settings_value'];
	 
	  $temp_alert_start_arr = array($temp_high_start,$hum_high_start,$water_leak_start);
	   
	 $result = select_data($connection_TMS,"tbl_tms_settings",$col,"tms_setting_item = 'alert_time_every_how_many_seconds'");
	 $row = $result->fetch_assoc();
	 $settings_alert_time_every_how_many_seconds = $row['tms_settings_value']; 
	   
	 $result = select_data($connection_TMS,"tbl_tms_settings",$col,"tms_setting_item = 'sms_notification'");
	 $row = $result->fetch_assoc();
	 $settings_sms_notification = $row['tms_settings_value'];	 
	   
	 $result = select_data($connection_TMS,"tbl_tms_settings",$col,"tms_setting_item = 'sms_notification_day'");
	 $row = $result->fetch_assoc();
	 $sms_notification_day = $row['tms_settings_value']; 
	   
	 $result = select_data($connection_TMS,"tbl_tms_settings",$col,"tms_setting_item = 'arduino_name'");
	 $row = $result->fetch_assoc();
	 $arduino_name = $row['tms_settings_value'];
	
	$temp_date_diff_now = strtotime($datetime_now)-strtotime($temp_high_start);
$hum_date_diff_now = strtotime($datetime_now)-strtotime($hum_high_start);
$water_date_diff_now = strtotime($datetime_now)-strtotime($water_leak_start);
$alert_water = "False";
$alert_hum = "False";
$alert_temp = "False";

	  	if($sms_notification_day =="weekends" && $settings_sms_notification == "TRUE")
				{
					if($day_of_week > 5 )
					{
							if($temp_high_start == "")
							{  
								$alert_temp = "True";
							}
							else if($temp_date_diff_now >= $settings_alert_time_every_how_many_seconds)
							{
								$alert_temp = "True";
							}
							else
							{
								$alert_temp = "False";

							}

							if($hum_high_start == "")
							{  
								$alert_hum = "True";
							}
							else if($hum_date_diff_now >= $settings_alert_time_every_how_many_seconds)
							{
								$alert_hum = "True";
							}
							else
							{
								$alert_hum = "False";

							}

							if($water_leak_start == "")
							{  
								$alert_water = "True";
							}
							else if($water_date_diff_now >= $settings_alert_time_every_how_many_seconds)
							{
								$alert_water = "True";
							}
							else
							{
								$alert_water = "False";

							}
					}
				
					
   				}
	   		else if($sms_notification_day =="weekdays" && $settings_sms_notification == "TRUE")
			{
				if($day_of_week <= 5)
				{
					if($temp_high_start == "")
					{  
						$alert_temp = "True";
					}
					else if($temp_date_diff_now >= $settings_alert_time_every_how_many_seconds)
					{
						$alert_temp = "True";
					}
					else
					{
						$alert_temp = "False";
						
					}
					
					if($hum_high_start == "")
					{  
						$alert_hum = "True";
					}
					else if($hum_date_diff_now >= $settings_alert_time_every_how_many_seconds)
					{
						$alert_hum = "True";
					}
					else
					{
						$alert_hum = "False";
						
					}
					
					if($water_leak_start == "")
					{  
						$alert_water = "True";
					}
					else if($water_date_diff_now >= $settings_alert_time_every_how_many_seconds)
					{
						$alert_water = "True";
					}
					else
					{
						$alert_water = "False";
						
					}
				}
			
				
				
			}
	   		else if($sms_notification_day =="everyday" && $settings_sms_notification == "TRUE")
			{
					if($temp_high_start == "")
					{  
						$alert_temp = "True";
					}
					else if($temp_date_diff_now >= $settings_alert_time_every_how_many_seconds)
					{
						$alert_temp = "True";
					}
					else
					{
						$alert_temp = "False";
						
					}
					
					if($hum_high_start == "")
					{  
						$alert_hum = "True";
					}
					else if($hum_date_diff_now >= $settings_alert_time_every_how_many_seconds)
					{
						$alert_hum = "True";
					}
					else
					{
						$alert_hum = "False";
						
					}
					
					if($water_leak_start == "")
					{  
						$alert_water = "True";
					}
					else if($water_date_diff_now >= $settings_alert_time_every_how_many_seconds)
					{
						$alert_water = "True";
					}
					else
					{
						$alert_water = "False";
						
					}
				
			}
	   
	   
	     $alert_sms_notif_arr = array($alert_water,$alert_hum,$alert_temp);
	   if(in_array("True",$alert_sms_notif_arr)) 
	   {
		   $sms_send = "True";
	   }
	
	    $temp_info = array($temp_info,$temp_settings_info,$temp_alert_start_arr,$sms_send,$alert_sms_notif_arr);
	    echo json_encode($temp_info);
}
else
{
	//echo "The file $file_name does not exists";
	 //echo json_encode("$file_name");
	 echo json_encode("file not found");
}


   }
?>