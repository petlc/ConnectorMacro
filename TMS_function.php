<?php




function send_text($to,$body,$channel)
{
	return $link ="http://10.49.5.235:8014/TMS_SMS/index.php?slct_sms_mail=SMS&slct_charset=Plain+Text&txt_Channel=$channel&txt_to=$to&txt_Body=$body&btn_send_text=Send+message";
	
}
function export_textfile_toDB($connection,$file_name)
{
$myFile = "Temperature_files/".$file_name.".txt";
	
$lines = file($myFile);//file in to an array
echo count($lines);
	
	for($i=0;$i<=count($lines)-1;$i++)
	{
	   $export_count = 0;
	   $String_line = explode("^",preg_replace('/[?]/', '', preg_replace('/[\000-\031\200-\377]/', '', $lines[$i])));
		//	echo $String_line[2];
	   $dateTime_data = trim($String_line[2]," ");
		//echo "(".$dateTime_data.")";
	   $dateTime = explode(" ",trim($String_line[2]," "));
		//print_r($dateTime);
	   $date_now = $dateTime[0];
	   $time_now = $dateTime[1];
		//echo $date_now;
		//echo $time_now;
       $hum_temp = explode(",",trim(preg_replace("/[^0-9,.^a-z^A-Z]/", "", $String_line[3])));
	   $exist_count = count_data($connection,"tbl_temp_data","DateTime_data='$dateTime_data'");
		//echo "<BR>".$exist_count."<BR>";
		if($exist_count == 0)
		{
	 		$query = "SELECT MAX(Temp_id)
                        FROM tbl_temp_data";
            $result = mysqli_query($connection, $query) or die(mysqli_error($connection));    
            $row = mysqli_fetch_array($result);
            $temp_id = $row['MAX(Temp_id)']+1;
			$query_col = array("Temp_id","Humidity_data","Temperature_data","Water_data","Temp_date","Temp_time","DateTime_data");
			$query_val = array(
            "$temp_id",
            "$hum_temp[1]",
            "$hum_temp[0]",
            "$hum_temp[5]",
            "$date_now",
            "$time_now",
            "$dateTime_data"
            ); 
			
      	//print_r($query_val);
			query_add($connection,"tbl_temp_data",$query_col,$query_val);
			$export_count += 1;
			if($i == count($lines)-1 && $export_count > 0)
			{
				echo "$file_name already exported";
			}
			
			
		}
		else
		{
			//echo "$file_name already exported";
			if($i == count($lines)-1 && $export_count == 0)
			{
				echo "no data exported";
			}
			
		}
	
	}
	file_put_contents($myFile, "");
	
}

function get_time_array_tms($location,$filename)
{
	
}
function get_temp_array_tms($location,$filename)
{
	
}
function get_hum_array_tms($location,$filename)
{
	
}
function get_water_array_tms($location,$filename)
{
	
}



?>
