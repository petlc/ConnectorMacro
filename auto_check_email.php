<?php
require_once("logs_function.php");
require_once("locker.php");


require_once("created_functions_php.php");
require_once("TMS_function.php");
require_once("mailer.php");
$notif_time = "";
$col = "*";
$result = select_data($connection_TMS,"tbl_tms_settings",$col,"tms_setting_item = 'email_notification_time'");
  while($row = $result->fetch_assoc()) {
                   $notif_time = explode(",",$row['tms_settings_value']);
   }
  $datetime_now=date("Y-m-d H:i:s");
  $date_now=date("Y-m-d");
  $date_year=date("Y");
  $date_month=date("m");
  $time_now=date("H:i:s");
  $time_now_ampm=date("h:i:sa");
  $day_of_week = date("w");

  echo  
											  "<script>
													var url = 'test';
												//	alert(url);
												//	window.open(url_, 'ifrm_senttext');

												</script>"; 


 	
//echo $date_now;
//echo $time_now;
//print_r($notif_time);
$settings_TMS = array();
$result = select_data($connection_TMS,"tbl_tms_settings","*","1");
while($row = $result->fetch_assoc()) {
						 array_push($settings_TMS,$row['tms_settings_value']);
	}
$settings_auto_export_when_open_page = $settings_TMS[0];
$settings_alert_notification = $settings_TMS[1];
$settings_email_notification_time = $settings_TMS[2];
$settings_email_notification_to = $settings_TMS[3];
$settings_email_notification_last_sent = $settings_TMS[4];
$settings_water_leak_sensor_start = $settings_TMS[5];
$settings_hum_high_start = $settings_TMS[6];
$settings_temp_high_start = $settings_TMS[7];
$settings_sms_notification_to = $settings_TMS[8];
$settings_alert_level_temp_greater_than = $settings_TMS[9];
$settings_alert_level_water_not_equal_to = $settings_TMS[10];
$settings_alert_hum_level_greater_than = $settings_TMS[11];
$settings_alert_time_every_how_many_seconds = $settings_TMS[12];
$settings_sms_notification = $settings_TMS[13];
$settings_sms_notification_day = $settings_TMS[14];
$settings_arduino_name = $settings_TMS[15];


$settings_water_leak_sensor_start_arr = explode(",",$settings_water_leak_sensor_start);
$settings_hum_high_start_arr = explode(",",$settings_hum_high_start);
$settings_temp_high_start_arr = explode(",",$settings_temp_high_start);
						
$arduino_name_arr = explode(",",$settings_arduino_name);
//echo "<BR>".date("d");
if($settings_auto_export_when_open_page == "TRUE")
{
 export_textfile_toDB($connection_TMS,$date_now);
}


if(!empty($_GET['arduino_name']))
{
	
	
	$arduino_name = $_GET['arduino_name'];
	$index_arduino_name = array_search($arduino_name, $arduino_name_arr);
	if($arduino_name =="arduino1_A1")
	{
		$arduino_loc = "AseanaOne";
	}
	else if($arduino_name == "arduino1_A2")
	{
		$arduino_loc = "AseanaTwo";
	}
	else
	{
		 $arduino_loc = "AyalaTH";
	}
	
}
else
{
	$arduino_name = "arduino1_A1";
	$arduino_loc = "AseanaOne";
	$index_arduino_name = array_search($arduino_name, $arduino_name_arr);
}

 $file_name = $date_now;
 $file_time = $time_now;
 $location = "Temperature_backup/$arduino_loc";
 $myFile = "$location/$date_year/$date_month/".$file_name.".txt";


if (file_exists($myFile)) {
    echo "The file $myFile exists";
	
	 $lines = file($myFile);//file in to an array
 $index = "";
 $arr_index = "";
 $last_index = "";
 $last_index = count($lines)-1;
				
				for($j = 0 ;$j <= count($lines)-1; $j++)
				{
					$arr_index = $j;
						$index = strpos($lines[$j], "$file_name $file_time");

						if ($index === false) {
							//echo "The string '$file_name $file_time' was not found in the string '$lines[$i]'";
						} else {
						echo "The string '$file_name $file_time' was found in the string '$lines[$j]'";
						echo " and exists at position $index and array index $j";
							break;
						}
				}

				 $String_line  = explode("^",preg_replace('/[?]/', '', preg_replace('/[\000-\031\200-\377]/', '', $lines[$arr_index])));
				 //$String_line  = explode("^",preg_replace('/[?]/', '', preg_replace('/[\000-\031\200-\377]/', '', $lines[$last_index])));
				 $hum_temp = explode(",",trim(preg_replace("/[^0-9,.^a-z^A-Z]/", "", $String_line[3])));
				


					
					$temp_data = $hum_temp[0];
					$hum_data = $hum_temp[1];
					$wat_data = $hum_temp[5];
echo $temp_data;
					if($wat_data == "Empty")
					{
						$wat_data_to_mail = "No Water Detected";
					}
					else
					{
						$wat_data_to_mail = $wat_data;
					}
	
					if($temp_data != "nan" && $settings_alert_notification == "TRUE"){
						if($temp_data >= $settings_alert_level_temp_greater_than)
						{


							if((strtotime($datetime_now)-strtotime($settings_temp_high_start_arr[$index_arduino_name])) >= $settings_alert_time_every_how_many_seconds || $settings_temp_high_start_arr[$index_arduino_name] == "")
							{

								
									$settings_temp_high_start_arr[$index_arduino_name] ="$datetime_now";
									$new_settings_temp_high_start_arr = implode(",",$settings_temp_high_start_arr);
								$column = array("tms_settings_value");
								$column_values=	array("$new_settings_temp_high_start_arr");
								query_update($connection_TMS,"tbl_tms_settings",$column,$column_values,"tms_setting_item = 'temp_high_start'");
							
									$to = array();
									$to = explode(",",$settings_email_notification_to);
									$att = array("$myFile");


									$message = "Good day MIS,<BR>
												<BR>
												As of    <B>$time_now_ampm $date_now</B>
												<BR>
												<table border='1' bordercolor='black'>
												<thead>
													<tr>
														<th align='center'><B>Location</B></th>
														<th align='center'><B>Temperature</B></th>
														<th align='center'><B>Humidity</B></th>
														<th align='center'><B>Water Sensor</B></th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td align='center'>$arduino_loc</td>
														<td align='center'>$temp_data °C</td>
														<td align='center'>$hum_data %</td>
														<td align='center'>$wat_data_to_mail</td>
													</tr>
												</tbody>
												</table>



												<BR><font color='red'> Temperature Sensor Reached <B>$temp_data °C</B> please do some action.</font>
												 <BR>
												 Thanks, <BR><BR>
												 <a href='http://10.49.1.213/TMS/TMS_Home.php'>Temperature Monitoring System</a>
																					";
								
										$col = array("Humidity_data","Temperature_data","Water_data","Temp_date","Temp_time","DateTime_data","Warning_data","Location");
										$col_val = array("$hum_data","$temp_data","$wat_data_to_mail","$date_now","$time_now","$datetime_now","Temperature","$arduino_loc");
										query_add($connection_TMS,"tbl_temp_data",$col,$col_val);
								
										php_mail($message ,"Temperature Sensor Notification ",$att,$to,"Temperature Sensor Notification","1");
										AddLogs($connection_TMS,$sess_displayname,"",$sess_department,"Temperature Sensor","Mail Sent Temperature Sensor reach $temp_data °C ");

								
										if($sms_notification_day == "weekends" && $settings_sms_notification == "TRUE")
											{
												if($day_of_week > 5)
												{

													    AddLogs($connection_TMS,$sess_displayname,"",$sess_department,"Temperature Sensor","SMS Notification Sent Temperature Sensor reach $temp_data °C ");

												}

											}
											else if($sms_notification_day == "weekdays" && $settings_sms_notification == "TRUE")
											{
												if($day_of_week <= 5)
												{

													  AddLogs($connection_TMS,$sess_displayname,"",$sess_department,"Temperature Sensor","SMS Notification Sent Temperature Sensor reach $temp_data °C ");
												}

											}
											else if($sms_notification_day == "everyday" && $settings_sms_notification == "TRUE")
											{
												  AddLogs($connection_TMS,$sess_displayname,"",$sess_department,"Temperature Sensor","SMS Notification Sent Temperature Sensor reach $temp_data °C ");
											}
								}

							
						}
						else if($temp_data < $settings_alert_level_temp_greater_than)
						{
							
						
							$settings_temp_high_start_arr[$index_arduino_name] ="";
							$settings_temp_high_start_arr = implode(",",$settings_temp_high_start_arr);
							$column = array("tms_settings_value");

							$column_values = array("$settings_temp_high_start_arr");
							query_update($connection_TMS,"tbl_tms_settings",$column,$column_values,"tms_setting_item = 'temp_high_start'");
						}
					}
				
					

					if($hum_data != "nan" && $settings_alert_notification == "TRUE"){
						if($hum_data >= $settings_alert_hum_level_greater_than)
						{
							

							if((strtotime($datetime_now)-strtotime($settings_hum_high_start_arr[$index_arduino_name])) >= $settings_alert_time_every_how_many_seconds || $settings_hum_high_start_arr[$index_arduino_name] == "")
							{
								$settings_hum_high_start_arr[$index_arduino_name] ="$datetime_now";
								$settings_hum_high_start_arr = implode(",",$settings_hum_high_start_arr);
					
								$column = array("tms_settings_value");
								$column_values=	array("$settings_hum_high_start_arr");
								query_update($connection_TMS,"tbl_tms_settings",$column,$column_values,"tms_setting_item = 'hum_high_start'");
								
								$to = array();
									$result = select_data($connection_TMS,"tbl_tms_settings","*","tms_setting_item = 'email_notification_to'");
									$row = $result->fetch_assoc();
									echo $row['tms_settings_value'];
									$email_list = explode(",",$row['tms_settings_value']);
									for($j = 0; $j <= count($email_list)-1; $j++ )
									{
										array_push($to,$email_list[$j]);
									}
									print_r($to);
									$att = array("$myFile");


									$message = "Good day MIS,<BR>
												<BR>
												As of    <B>$time_now_ampm $date_now</B>
												<BR>
												<table border='1' bordercolor='black'>
												<thead>
													<tr>
														<th align='center'><B>Location</B></th>
														<th align='center'><B>Temperature</B></th>
														<th align='center'><B>Humidity</B></th>
														<th align='center'><B>Water Sensor</B></th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td align='center'>$arduino_loc</td>
														<td align='center'>$temp_data °C</td>
														<td align='center'>$hum_data %</td>
														<td align='center'>$wat_data_to_mail</td>
													</tr>
												</tbody>
												</table>



												<BR><font color='red'> Humidity Sensor Reached <B>$hum_data %</B> please do some action.</font>
												 <BR>
												 Thanks, <BR><BR>
												 <a href='http://10.49.1.213/TMS/TMS_Home.php'>Temperature Monitoring System</a>
																					";
									
										$col = array("Humidity_data","Temperature_data","Water_data","Temp_date","Temp_time","DateTime_data","Warning_data","Location");
										$col_val = array("$hum_data","$temp_data","$wat_data_to_mail","$date_now","$time_now","$datetime_now","Humidity","$arduino_loc");
										query_add($connection_TMS,"tbl_temp_data",$col,$col_val);
									
										php_mail($message ,"Humidity Sensor Notification ",$att,$to,"Humidity Sensor Notification","1");
										AddLogs($connection_TMS,$sess_displayname,"",$sess_department,"Humidity Sensor","Mail Sent Humidity Sensor reach $hum_data % ");
								if($sms_notification_day == "weekends" && $settings_sms_notification == "TRUE")
								{
									if($day_of_week > 5)
									{
										  AddLogs($connection_TMS,$sess_displayname,"",$sess_department,"Humidity Sensor","SMS Notification Sent Humidity Sensor reach $hum_data % ");
									}
									
								}
								else if($sms_notification_day == "weekdays" && $settings_sms_notification == "TRUE")
								{
									if($day_of_week <= 5)
									{
									
										  AddLogs($connection_TMS,$sess_displayname,"",$sess_department,"Humidity Sensor","SMS Notification Sent Humidity Sensor reach $hum_data % ");

									}
								
								}
								else if($sms_notification_day == "everyday" && $settings_sms_notification == "TRUE")
								{
									 AddLogs($connection_TMS,$sess_displayname,"",$sess_department,"Humidity Sensor","SMS Notification Sent Humidity Sensor reach $hum_data % ");
								}
								

							}
						}

						else if($hum_data < $settings_alert_hum_level_greater_than)
						{

								$settings_hum_high_start_arr[$index_arduino_name] ="";
								$settings_hum_high_start_arr = implode(",",$settings_hum_high_start_arr);
					
								$column = array("tms_settings_value");
								$column_values=	array("$settings_hum_high_start_arr");
								query_update($connection_TMS,"tbl_tms_settings",$column,$column_values,"tms_setting_item = 'hum_high_start'");
								
							
					

						}
					}


					
					

					
					
					if($wat_data != "nan" && $settings_alert_notification == "TRUE"){
						if($wat_data == "Empty")
						{

							$settings_water_leak_sensor_start_arr[$index_arduino_name] ="";
							$new_settings_water_leak_sensor_start_arr = implode(",",$settings_water_leak_sensor_start_arr);
							$column = array("tms_settings_value");
							$column_values=	array("$new_settings_water_leak_sensor_start_arr");
						
							query_update($connection_TMS,"tbl_tms_settings",$column,$column_values,"tms_setting_item = 'water_leak_sensor_start'");


								
						}
						else if($wat_data != "")
						{
							if((strtotime($datetime_now)-strtotime($settings_water_leak_sensor_start_arr[$index_arduino_name])) >= $settings_alert_time_every_how_many_seconds || $settings_water_leak_sensor_start_arr[$index_arduino_name] =="")
							{


								
											if($sms_notification_day == "weekends" && $settings_sms_notification == "TRUE")
											{
												if($day_of_week > 5)
												{

													  AddLogs($connection_TMS,$sess_displayname,"",$sess_department,"Water Sensor","SMS Notification Sent Water Sensor reach $wat_data level ");

												}

											}
											else if($sms_notification_day == "weekdays" && $settings_sms_notification == "TRUE")
											{
												if($day_of_week <= 5)
												{

													 AddLogs($connection_TMS,$sess_displayname,"",$sess_department,"Water Sensor","SMS Notification Sent Water Sensor reach $wat_data level ");

												}

											}
											else if($sms_notification_day == "everyday" && $settings_sms_notification == "TRUE")
											{
												 AddLogs($connection_TMS,$sess_displayname,"",$sess_department,"Water Sensor","SMS Notification Sent Water Sensor reach $wat_data level ");
											}

									$settings_water_leak_sensor_start_arr[$index_arduino_name] ="$datetime_now";
									$new_settings_water_leak_sensor_start_arr = implode(",",$settings_water_leak_sensor_start_arr);
									$column = array("tms_settings_value");
									$column_values = array("$new_settings_water_leak_sensor_start_arr");
									query_update($connection_TMS,"tbl_tms_settings",$column,$column_values,"tms_setting_item = 'water_leak_sensor_start'");
									
			
							
									$to = array();
									$result = select_data($connection_TMS,"tbl_tms_settings","*","tms_setting_item = 'email_notification_to'");
									$row = $result->fetch_assoc();
									echo $row['tms_settings_value'];
									$email_list = explode(",",$row['tms_settings_value']);
									for($j = 0; $j <= count($email_list)-1; $j++ )
									{
										array_push($to,$email_list[$j]);
									}
									print_r($to);
									$att = array("$myFile");


									$message = "Good day MIS,<BR>
												<BR>
												As of    <B>$time_now_ampm $date_now</B>
												<BR>
												<table border='1' bordercolor='black'>
												<thead>
													<tr>
														<th align='center'><B>Location</B></th>
														<th align='center'><B>Temperature</B></th>
														<th align='center'><B>Humidity</B></th>
														<th align='center'><B>Water Sensor</B></th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td align='center'>$arduino_loc</td>
														<td align='center'>$temp_data °C</td>
														<td align='center'>$hum_data %</td>
														<td align='center'>$wat_data_to_mail</td>
													</tr>
												</tbody>
												</table>



												<BR> <font color='red'> Water Sensor Reached <B>$wat_data</B> please do some action. </font>
												 <BR>
												 Thanks, <BR><BR>
												 <a href='http://10.49.1.213/TMS/TMS_Home.php'>Temperature Monitoring System</a>
																					";
										
										$col = array("Humidity_data","Temperature_data","Water_data","Temp_date","Temp_time","DateTime_data","Warning_data","Location");
										$col_val = array("$hum_data","$temp_data","$wat_data_to_mail","$date_now","$time_now","$datetime_now","Water","$arduino_loc");
										query_add($connection_TMS,"tbl_temp_data",$col,$col_val);
									
										php_mail($message ,"Water Sensor Notification ",$att,$to,"Water Sensor Notification","1");
										AddLogs($connection_TMS,$sess_displayname,"",$sess_department,"Water Sensor","Mail Sent Water Sensor reach $wat_data level ");


							}



						}
					}
} else {
    echo "The file $myFile does not exist";
}

	//PMC
for($i = 0 ; $i <= count($notif_time)-1 ; $i++)
{
	echo "<BR>".$i."<BR>";
	echo "$date_now $time_now  $notif_time[$i] <BR>";
/*
	$column = array("tms_settings_value");
			$date_notif_arr[$i] = $date_now;
			$column_values=	array();

		
	query_update($connection_TMS,"tbl_tms_settings",$column,$column_values,"tms_setting_item = 'water_leak_sensor_start'");
	*/
	
	
	
	if(strtotime($time_now) == strtotime($notif_time[$i]) )
	{
		
			//	echo "same";
			$result = select_data($connection_TMS,"tbl_tms_settings","*","tms_setting_item = 'email_notification_last_sent'");
			$row = $result->fetch_assoc();
		//	echo "test".$row['tms_settings_value'];
			$date_notif_arr = explode(",",$row['tms_settings_value']);
			//$date_notif_arr[4] = $date_now;
		
			if($date_notif_arr[$i] != $date_now)
			{
					$to = array();
					$result = select_data($connection_TMS,"tbl_tms_settings","*","tms_setting_item = 'email_notification_to'");
					$row = $result->fetch_assoc();
					echo $row['tms_settings_value'];
					$email_list = explode(",",$row['tms_settings_value']);
					for($j = 0; $j <= count($email_list)-1; $j++ )
					{
						array_push($to,$email_list[$j]);
					}
					print_r($to);
					$att = array("$myFile");
					/*export_textfile_toDB($connection_TMS,$date_now);
					$result = select_data($connection_TMS,"tbl_temp_data","*","Temp_time = '$time_now' AND Temp_date = '$date_now'");
					$row = $result->fetch_assoc();
					echo "temp data:".$row['Temperature_data'];*/


				

				$message = "Good day MIS,<BR>
							<BR>
							As of    <B>$time_now_ampm $date_now</B>
							<BR>
							<table border='1' bordercolor='black'>
							<thead>
								<tr>
									<th align='center'><B>Location</B></th>
									<th align='center'><B>Temperature</B></th>
									<th align='center'><B>Humidity</B></th>
									<th align='center'><B>Water Sensor</B></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td align='center'>$arduino_loc</td>
									<td align='center'>$temp_data °C</td>
									<td align='center'>$hum_data %</td>
									<td align='center'>$wat_data_to_mail</td>
								</tr>
							</tbody>
							</table>



							<BR>  Dont forget to input in PMC.
							 <BR>
							 Thanks, <BR><BR>
							 <a href='http://10.49.1.213/TMS/TMS_Home.php'>Temperature Monitoring System</a>
																";
		if($settings_alert_notification == "TRUE")
			{
			 $column = array("tms_settings_value");
			 $date_notif_arr[$i] = $date_now;
			 $column_values=	array(implode(",",$date_notif_arr));
			 query_update($connection_TMS,"tbl_tms_settings",$column,$column_values,"tms_setting_item = 'email_notification_last_sent'");
			
			 php_mail($message ,"TMS Notification",$att,$to,"Temp Monitoring System","");
			 AddLogs($connection_TMS,$sess_displayname,"",$sess_department,"PMC mailer","Temperature: $temp_data,Humidity:$hum_data, Water Sensor: $wat_data_to_mail, Email Time $time_now_ampm, STATUS: SENT ");
			}
			
		
		}
	}
}

?>