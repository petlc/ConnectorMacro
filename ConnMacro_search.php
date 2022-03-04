
<?php


require_once('top_bar.php');

$slct_search_sys_logs = "";
$slct_search_temp_logs ="";

$table_header = "Logs";
$th_search = "";
$tr_search = "";
$logs_display = "";

$slct_syslog_categ = "";
$div_display_syslog = "display:none";
$div_display_templog = "display:none";
 
//echo shell_exec("cd Temperature_backup\\AseanaOne\\2020\\02 && DIR ");



$location_list = get_filename_list("Temperature_backup/","");
//print_r($location_list);
$slct_senlog_year = "";
$slct_senlog_month = "";
$slct_senlog_file = "";
$slct_senlog_loc = "";
$txt_time_start = "";
$txt_time_end = "";




$arduino_location = array();
 $selected_categ_sys = "";
$result = select_distinct($connection_ConnMacro,"tbl_logs","Category","1");
  while($row = $result->fetch_assoc()) {
	 
      $categ_syslog = $row['Category'];
	  if(isset($_GET['slct_search_categ_syslog']))
	  {
		$selected_categ_sys = $_GET['slct_search_categ_syslog'];
	  }
      if($selected_categ_sys == $categ_syslog)
	  {
		$set_selected  = "Selected";
	  }
	  else
	  {
		  $set_selected = "";
	  }
	  $slct_syslog_categ .= "<option value = '$categ_syslog' $set_selected>$categ_syslog</option>";
	  
  }
$slct_senlog_loc =	get_file_name_list_populate_to_opt("Temperature_backup/","","");
	
$total_count_rows = 0;
$page_count = 0;
$max_row_count_table = 10;
$pager_bottom_no = "";
$page_no = "";
$class_disabled_pager = "";
$link_pager = "";



$url_search = "";

if(isset($_GET['btn_search']))
{
	
$page_no = 1;
	if(isset($_GET['custom_pagination_php']))
	{
		if(isset($_GET['pageno']))
		{
			$page_no = $_GET['pageno'];
		}
			
	}


	

	
$url_search = "slct_search=".$_GET['slct_search']."&txt_search_syslogs=".$_GET['txt_search_syslogs']."&slct_search_categ_syslog=".$_GET['slct_search_categ_syslog']."&slct_search_location=".$_GET['slct_search_location']."&slct_search_yaer=".$_GET['slct_search_yaer']."&slct_search_month=".$_GET['slct_search_month']."&slct_search_file=".$_GET['slct_search_file']."&txt_time_start=".$_GET['txt_time_start']."&txt_time_end=".$_GET['txt_time_end']."&btn_search=".$_GET['slct_search'];
	if($_GET['slct_search']=="syslogs")
	{
		
		$div_display_syslog = "";
		
		$slct_search_sys_logs = "Selected";
		$table_header =  "SYSTEM LOGS ";
		
			if(!empty($_GET['txt_search_syslogs']) )
			{
				echo "<script> $( document ).ready(function() {


						   $('#txt_search_syslogs').val('".$_GET['txt_search_syslogs']."');
						});


				</script>";
			}


			 if( isset($_SESSION["User_Type"])){
			 	if( $_SESSION["User_Type"] =="Admin"){
				 
					if(!empty($_GET['txt_search_syslogs']) )
					{
						$search = $_GET['txt_search_syslogs'];
						$slct_search_categ_syslog = $_GET['slct_search_categ_syslog'];
						$query = "SELECT *
										FROM tbl_logs 
									  WHERE (Emp_id LIKE '%$search%' OR Department LIKE '%$search%'  OR	Activity LIKE '%$search%' OR log_date LIKE '%$search%'	OR user_name LIKE '%$search%' OR User_Type LIKE '%$search%' OR user_IP LIKE '%$search%' OR Log_os LIKE '%$search%' OR Log_browser LIKE '%$search%')	 AND Category LIKE '%$slct_search_categ_syslog%'
										ORDER BY log_date DESC ";

					}
					else
					{
						$slct_search_categ_syslog = $_GET['slct_search_categ_syslog'];
						
						if(empty($_GET['slct_search_categ_syslog']))
						{
							 $query = "SELECT *
										FROM tbl_logs
										ORDER BY log_date DESC ";
						}
						else
						{
							 $query = "SELECT *
										FROM tbl_logs
										WHERE Category ='$slct_search_categ_syslog'
										ORDER BY log_date DESC ";
						}
						 
					}
				}
			 }
			else
			{
				 if(!empty($_GET['txt_search_syslogs']) )
					{
						$search = $_GET['txt_search_syslogs'];
						$slct_search_categ_syslog = $_GET['slct_search_categ_syslog'];
						$query = "SELECT *
										FROM tbl_logs 
									  WHERE (Emp_id LIKE '%$search%'  OR	Activity LIKE '%$search%' OR log_date LIKE '%$search%'	OR user_name LIKE '%$search%' OR user_IP LIKE '%$search%' OR Log_os LIKE '%$search%' OR Log_browser LIKE '%$search%') AND Category LIKE '%$slct_search_categ_syslog%' 
										ORDER BY log_date DESC "; //AND Department = '".$sess_department."'

					}
					else
					{
						$slct_search_categ_syslog = $_GET['slct_search_categ_syslog'];
						if(empty($_GET['slct_search_categ_syslog']))
						{
								  $query = "SELECT *
										FROM tbl_logs
										ORDER BY log_date DESC "; //Department = '".$sess_department."' AND
						}
						else
						{
								  $query = "SELECT *
										FROM tbl_logs
										WHERE Category ='$slct_search_categ_syslog' 
										ORDER BY log_date DESC "; //Department = '".$sess_department."' AND
						}
				
						
					
					} 
			}

					$logs_display = "";
			if(isset($_SESSION['User_Type'])){
				if($_SESSION['User_Type']=="Admin")
				{
				$logs_display .= "
									<table border='1' style='' class='table table-hover'>
								  <thead>
									  <th>User Account</th>
									  <th>User Name</th>
									  <th>Department</th>
									  <th>Category</th>
									  <th>Activity</th>
									  <th>Date</th>
									  <th>Operating System</th>
									  <th>Browser</th>
									  <th>User Type</th>
									  <th>User IP</th>


								  </thead>";
				}
			}
			else
			{

						$logs_display .= "
									<table border='1' style='' class='table table-hover cf'>
								  <thead>

									  <th>User Name</th>
									  <th>Category</th>
									  <th>Activity</th>
									  <th>Date</th>
									<!--  <th>User Type</th> -->



								  </thead>";

			}


							 $result = mysqli_query($connection_ConnMacro, $query) or die(mysqli_error($connection_ConnMacro));
							$num_rows = mysqli_num_rows($result);
							$total_count_rows = $num_rows;
							$result =	pagination_sql_query($connection_ConnMacro,$query,$page_no,$max_row_count_table);
						//	for($index_result = 0 ;$index_result <= $max_row_count_table -1 ; $index_result++  )
							$counter_table_row =1;
							while($row = $result->fetch_assoc()) 
							{
						
									
										 $Log_ID = $row['Log_ID'];
										 $Emp_id = $row['Emp_id'];
										 $dept = $row['Department'];
										 $Category = $row['Category'];
										 $Activity = $row['Activity'];
										 $log_date = $row['log_date'];
										 $user_name = $row['user_name'];
										 $User_Type = $row['User_Type'];
										 $user_IP = $row['user_IP'];
										 $Log_os = $row['Log_os'];
										 $Log_browser= $row['Log_browser'];



															  if(isset($_SESSION['User_Type'])){
																  if($_SESSION['User_Type']=="Admin")
																	{
																			   $logs_display.=  "<tr>
																											   <td><a id='$Emp_id' name=$Emp_id href='#' data-toggle='modal' data-target='#emp_id_info' onClick ='user_info(this)' >$Emp_id</a></td>
																											   <td>$user_name</td>
																											   <td>$dept</td>
																											   <td>$Category</td>
																											   <td>$Activity</td>
																											   <td>$log_date</td>
																											   <td>$Log_os</td>
																											   <td>$Log_browser</td>
																											   <td>$User_Type</td>
																											   <td>$user_IP</td>

																												</tr>";
																	}
																  else
																	  {
																		     $logs_display.=  "<tr>
																											   <td>$user_name</td>
																											   <td>$Category</td>
																											   <td>$Activity</td>
																											   <td>$log_date</td>
																											<!--	<td>$User_Type</td> -->

																												</tr>";
																	  }
																}
																else
																	{
																			   $logs_display.=  "<tr>
																											   <td>$user_name</td>
																											   <td>$Category</td>
																											   <td>$Activity</td>
																											   <td>$log_date</td>
																											<!--	<td>$User_Type</td> -->

																												</tr>";

																	}
										
									
							
							}
							// while($row = $result->fetch_assoc()) {}

						
									 




			$logs_display .= "</table>"; 
	}
	else if($_GET['slct_search'] == "templogs")
	{
		$div_display_templog = "";
		$slct_search_temp_logs = "Selected";
		$table_header =  "SENSOR LOGS";
		$tr_search_templogs = "";
				
		if(empty($_GET['slct_search_location']))
		{
			echo "<script>alert('location need to be selected');</script>";
			$slct_senlog_loc =	get_file_name_list_populate_to_opt("Temperature_backup/","","");
	
		}else if(empty($_GET['slct_search_yaer']))
		{
				echo "<script>alert('Year need to be selected');</script>";
			 $slct_senlog_loc 	=	get_file_name_list_populate_to_opt("Temperature_backup/","",$_GET['slct_search_location']);
			 $slct_senlog_year  =	get_file_name_list_populate_to_opt("Temperature_backup/".$_GET['slct_search_location']."/","","");
		
				}
		else if(empty($_GET['slct_search_month']))
		{
			echo "<script>alert('Month need to be selected');</script>";
			 $slct_senlog_loc 	=	get_file_name_list_populate_to_opt("Temperature_backup/","",$_GET['slct_search_location']);
			 $slct_senlog_year  =	get_file_name_list_populate_to_opt("Temperature_backup/".$_GET['slct_search_location']."/","",$_GET['slct_search_yaer']);
			 $slct_senlog_month =	get_file_name_list_populate_to_opt("Temperature_backup/".$_GET['slct_search_location']."/".$_GET['slct_search_yaer']."/","","");
			
		}
		else if(empty($_GET['slct_search_file']))
		{
			echo "<script>alert('Log File need to be selected');</script>";
			 $slct_senlog_loc 	=	get_file_name_list_populate_to_opt("Temperature_backup/","",$_GET['slct_search_location']);
			 $slct_senlog_year  =	get_file_name_list_populate_to_opt("Temperature_backup/".$_GET['slct_search_location']."/","",$_GET['slct_search_yaer']);
			 $slct_senlog_month =	get_file_name_list_populate_to_opt("Temperature_backup/".$_GET['slct_search_location']."/".$_GET['slct_search_yaer']."/","",$_GET['slct_search_month']);
			 $slct_senlog_file  =	get_file_name_list_populate_to_opt("Temperature_backup/".$_GET['slct_search_location']."/".$_GET['slct_search_yaer']."/".$_GET['slct_search_month']."/","","");
		}
		else
		{
			 $slct_senlog_loc 	=	get_file_name_list_populate_to_opt("Temperature_backup/","",$_GET['slct_search_location']);
			 $slct_senlog_year  =	get_file_name_list_populate_to_opt("Temperature_backup/".$_GET['slct_search_location']."/","",$_GET['slct_search_yaer']);
			 $slct_senlog_month =	get_file_name_list_populate_to_opt("Temperature_backup/".$_GET['slct_search_location']."/".$_GET['slct_search_yaer']."/","",$_GET['slct_search_month']);
			 $slct_senlog_file  =	get_file_name_list_populate_to_opt("Temperature_backup/".$_GET['slct_search_location']."/".$_GET['slct_search_yaer']."/".$_GET['slct_search_month']."/","",$_GET['slct_search_file']);
			
			 $txt_time_start   = $_GET['txt_time_start'];
			if(count(explode(":",$txt_time_start)) == 2)
			{
				$txt_time_start .= ":00";
				//echo "<BR>time start ".$txt_time_start;
			}
			
			 $txt_time_end     = $_GET['txt_time_end'];
			if(count(explode(":",$txt_time_end)) == 2)
			{
				$txt_time_end .= ":00";
				//echo "<BR>time end ".$txt_time_end;
			}
			
			 $myFile = "Temperature_backup/".$_GET['slct_search_location']."/".$_GET['slct_search_yaer']."/".$_GET['slct_search_month']."/".$_GET['slct_search_file'].".txt";
			 $lines = file($myFile);//file in to an array
			 $index = "";
			 $arr_index = "";
			 $last_index = "";
			 $last_index = count($lines)-1;

			
					
			$line_count = count($lines);
			$result_arr_count = "";
			$line_start_count = ($page_no) * $max_row_count_table -1;
			$index_start = "";
			$index_end = "";
			if($_GET['txt_time_start'] =="" && $_GET['txt_time_end'] == "")
			{
				$result_arr = $lines;
				$result_arr_count = $line_count;
			}
			else
			{
				
				for($j = 0 ;$j <= count($lines)-1; $j++)
				{
						$index_start = $j;
						$index_string = strpos($lines[$j], $txt_time_start);

						if ($index_string === false) {
							//echo "The string '$file_name $file_time' was not found in the string '$lines[$i]'";
								$index_start = "";
						} else {
					//	echo "The string '". $_GET['txt_time_start']."' was found in the string '$lines[$j]'";
					//	echo " and exists at position $index_string and array index $index_start";
					//		$index_start = "";
							break;
						}
				}
				for($j = 0 ;$j <= count($lines)-1; $j++)
				{
						$index_end = $j;
						$index_string = strpos($lines[$j],$txt_time_end );

						if ($index_string === false) {
							//echo "The string '$file_name $file_time' was not found in the string '$lines[$i]'";
							$index_end = "";
							//echo "done";
						} else {
					//	echo "The string '". $_GET['txt_time_end']."' was found in the string '$lines[$j]'";
				//		echo " and exists at position $index_string and array index $index_end";
						//$index_end = "";
							break;
						}
				}
				
				
				if($index_start == 0 || $index_start != "" || $index_end == 0 || $index_end != "")
				{
					$diff_array_index = ($index_end  + 1) - ($index_start  );
					if($index_start - 1 <0)
					{
						$index_start_to_slice =0 ;
						//$diff_array_index -=1;
					}
					else
					{
						$index_start_to_slice = $index_start ;
						
					}
					$result_arr = array_slice($lines,$index_start_to_slice,$diff_array_index);
					$result_arr_count = count($result_arr);
			
				}
				else
				{
					$result_arr = $lines;
					$result_arr_count = $line_count;
				}
			
			}
		//	print_r($result_arr);
		
			$max_row_count_table_loop = $max_row_count_table;
			for($i = 0 ; $i <= $max_row_count_table_loop-1;$i++ )
			{
				
			  if($i > (count($result_arr) - 1))
			  {
				 // echo "test2 $i";
				 // break;
			  }  
			 $line_start = $line_start_count;
			
				  	$total_pages = intdiv(count($result_arr), $max_row_count_table);
					if(count($result_arr) % $max_row_count_table != 0)
					{
						$total_pages += 1;
					}
				
					//echo $line_start." - $i <BR>";
				//	echo "linestart[".($line_start - $i)."]<BR>";
					//echo $i."<BR>";
				if(array_key_exists( ($line_start - $max_row_count_table  + $i + 1),$result_arr))
				{
				
					
							$String_line  = explode("^",preg_replace('/[?]/', '', preg_replace('/[\000-\031\200-\377]/', '', $result_arr[ ($line_start - $max_row_count_table  + $i + 1 ) ])));
							$hum_temp = explode(",",trim(preg_replace("/[^0-9,.^a-z^A-Z]/", "", $String_line[3])));
							$temp_data = $hum_temp[0];
							$hum_data = $hum_temp[1];
							$wat_data = $hum_temp[5];
							$datetime_display = trim($String_line[2]);
							if($wat_data == "Empty")
							{
								$water_to_display = "No water detected";
							}
							else
							{
								$water_to_display = $wat_data;
							}
					$tr_search_templogs .= " <tr>
												<td>".$_GET['slct_search_location']."</td>
												<td>".$temp_data." °C</td>
												<td>".$hum_data." %</td>
												<td>".$water_to_display."</td>
												<td>".$datetime_display." </td>
											</tr>
											"; 
					
					
				}
				else
				{
					
					if($page_no != $total_pages)
					{
							if($line_count-1 > $max_row_count_table)
							{
								$max_row_count_table_loop = $max_row_count_table_loop +1;
							}
					}
					else
					{
					//	  echo ($line_start - 0)."<BR>";
					//	  echo ($line_start - $i)."<BR>";
					//	  echo $result_arr[0]."<BR>";
					//	  echo $result_arr[count($result_arr)-1]."<BR>";
				
					}
				
					
					
						
				}
				
			}
			
			$total_count_rows = $result_arr_count;


			
		}
			$logs_display .= "
									<table border='1' style='' class='table table-hover'>
								  <thead>
									  <th>Location</th>
									  <th>Temperature</th>
									  <th>Humidity</th>
									  <th>Water Sensor</th>
									  <th>Date / Time</th>

								  </thead>
								  <tbody>
								   $tr_search_templogs
								  
								  </tbody>
								  ";


		

			$logs_display .= "</table>"; 
		
	}
	
//echo $query;

	$pager_bottom_no = custom_pagination_php($total_count_rows,$max_row_count_table,$page_no,5,$url_search);
   


    //echo "<script>alert('sort');</script>";
	$logs_display .= $pager_bottom_no;
}


?>

<html>
	<head>
		
	</head>
	<script>
		    $(document).ready(function(){
				$("#slct_search_location").change(function(){
					 // alert("The text has been changed.");
						//alert(this.value);
						get_file_name_list_populate_to('Temperature_backup/'+this.value+'/','','slct_search_yaer','');
						//callback_jquery(get_file_name_list,method1_param,alert,window.get_file_name_list_file_list);
						$('#slct_search_yaer').empty().append('<option selected="selected" value="">--</option>');
						$('#slct_search_month').empty().append('<option selected="selected" value="">--</option>');
						$('#slct_search_file').empty().append('<option selected="selected" value="">--</option>');
											 
					});
				$("#slct_search_yaer").change(function(){
					 // alert("The text has been changed.");
						//alert(this.value);
					var location = $('#slct_search_location').val();
					var url = 'Temperature_backup/'+location+'/'+this.value+'/';
					//alert(url);
						get_file_name_list_populate_to(url,'','slct_search_month','');
						//callback_jquery(get_file_name_list,method1_param,alert,window.get_file_name_list_file_list);
						$('#slct_search_month').empty().append('<option selected="selected" value="">--</option>');
						$('#slct_search_file').empty().append('<option selected="selected" value="">--</option>');
											 
					});	
					$("#slct_search_month").change(function(){
					 // alert("The text has been changed.");
						//alert(this.value);
					var location = $('#slct_search_location').val();
					var year_ = $('#slct_search_yaer').val();
					var url = 'Temperature_backup/'+location+'/'+year_+'/'+this.value+'/';
					//alert(url);
						get_file_name_list_populate_to(url,'','slct_search_file','',);
						//callback_jquery(get_file_name_list,method1_param,alert,window.get_file_name_list_file_list);
						$('#slct_search_file').empty().append('<option selected="selected" value="">--</option>');
											 
					});
			
			});
		
	</script>
	<body>
        





        <div class="container-fluid">

            <div class="row content">

                <div class="col-xl-3 ">
                </div>
                <div class="col-xl-6 mb-5">

                    <div class="card">
						  <form method="get" class="" action="ConnMacro_search.php">
                        	<div class="card-header">
                            <h4><i class="fa fa-search " aria-hidden="true"></i> Search </h4>
							  </div>
							  <div class="row mb-3"></div>
							  <div class="row mb-3">
								  <div class="col-4 col-sm-4 text-right ">
										<label class="col-form-label font-weight-bold"> Search In:</label>
								  </div>
								<div class="col-8 col-sm-8">
								  <select id="slct_search" class="form-control" name="slct_search"   style="width:95%;margin-top:10px;" onchange = "
																																					
																																					if(this.value == 'syslogs'){
																																					element_hide('div_search_sys_logs',true);
																																					element_hide('div_search_temp_logs',false);
																																					}
																																					else if(this.value == 'templogs')
																																					{
																																					element_hide('div_search_sys_logs',false);
																																					element_hide('div_search_temp_logs',true);
																																					}
																																					else
																																					{
																																					element_hide('div_search_sys_logs',false);
																																					element_hide('div_search_temp_logs',false);
																																					}
																																					">
									<option value="">--</option>
									<option value="syslogs"<?php echo $slct_search_sys_logs; ?>>System Logs</option>
								<!--	<option value="templogs"<?php // echo $slct_search_temp_logs; ?>>Sensor Logs</option> -->
								</select>
							  </div>
							  </div>
							
					  <div id="div_search_sys_logs" class="card-block" style="<?php echo $div_display_syslog; ?>">
									
						  
										 <div class="row mb-3">
													<div class="col-4 col-sm-4 text-right ">
														<label class="col-form-label font-weight-bold"> Search:</label>
													</div>
													<div class="col-8 col-sm-8">
														<div class="input-group">
														  <input id="txt_search_syslogs" type="text" class="form-control" name="txt_search_syslogs" autocomplete="off">
														</div>
													</div>
												</div>
						  
						    <div class="row mb-3">
								  <div class="col-4 col-sm-4 text-right ">
										<label class="col-form-label font-weight-bold"> Category:</label>
								  </div>
								<div class="col-8 col-sm-8">
								  <select id="slct_search_categ_syslog" class="form-control" name="slct_search_categ_syslog"   style="width:95%;margin-top:10px;" >
									<option value="">--</option>
									<?php echo $slct_syslog_categ; ?>
								</select>
							  </div>
							  </div>
					  </div>
                        <div id="div_search_temp_logs" class="card-block" style="<?php echo $div_display_templog; ?>">
                          
                                <div class="row mb-3">
                                    <div class="col-8 col-sm-4 text-right ">
                                        <label class="col-form-label font-weight-bold">Location:</label>
                                    </div>
                                    <div class="col-8 col-sm-8">
                                        <div class="input-group">
                                        	 <select id="slct_search_location" class="form-control" name="slct_search_location"   style="width:95%;margin-top:10px;" onchange=" "  >
													<option value="">--</option> 
												<?php echo $slct_senlog_loc; ?>
											</select>
                                        </div>
                                    </div>
                                </div>   
								<div class="row mb-3">
                                    <div class="col-8 col-sm-4 text-right ">
                                        <label class="col-form-label font-weight-bold">Year:</label>
                                    </div>
                                    <div class="col-8 col-sm-8">
                                        <div class="input-group">
                                        	 <select id="slct_search_yaer" class="form-control" name="slct_search_yaer"   style="width:95%;margin-top:10px;" onchange=" " >
													<option value="">--</option>
												 <?php echo $slct_senlog_year; ?>
											</select>
                                        </div>
                                    </div>
                                </div>	
								<div class="row mb-3">
                                    <div class="col-8 col-sm-4 text-right ">
                                        <label class="col-form-label font-weight-bold">Month:</label>
                                    </div>
                                    <div class="col-8 col-sm-8">
                                        <div class="input-group">
                                        	 <select id="slct_search_month" class="form-control" name="slct_search_month"   style="width:95%;margin-top:10px;" onchange="" >
													<option value="">--</option>
												 	<?php echo $slct_senlog_month; ?>
											</select>
                                        </div>
                                    </div>
                                </div>
							<div class="row mb-3">
                                    <div class="col-8 col-sm-4 text-right ">
                                        <label class="col-form-label font-weight-bold">File:</label>
                                    </div>
                                    <div class="col-8 col-sm-8">
                                        <div class="input-group">
                                        	 <select id="slct_search_file" class="form-control" name="slct_search_file"   style="width:95%;margin-top:10px;" onchange="" >
													<option value="">--</option>
												 	<?php echo $slct_senlog_file; ?>
											</select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-3">

                                    <div class="col-8 col-sm-4 text-right ">
                                        <label class="col-form-label  font-weight-bold">Time Start:</label>
                                    </div>
                                    <div class="col-8 col-sm-8">
                                        <div class="input-group">
                                          <input type="time" class="form-control" name="txt_time_start" autocomplete="off" step="1" value="<?php echo $txt_time_start; ?>">
                                        </div>
                                    </div>
									
                                </div> <div class="row mb-3">

                                    <div class="col-8 col-sm-4 text-right ">
                                        <label class="col-form-label  font-weight-bold">Time End:</label>
                                    </div>
                                    <div class="col-8 col-sm-8">
                                        <div class="input-group">
                                          <input type="time" class="form-control" name="txt_time_end" autocomplete="off" step="1" value="<?php echo $txt_time_end; ?>">
                                        </div>
                                    </div>
									
                                </div>
                            
                           
                        
                              
                         
                        </div>
							    <div class="row mb-3">
                                    <div class="col-4 col-sm-4 text-right ">
										
                                    </div>
                                    <div class="col-4 col-sm-4">
                                        <button id="btn_search" class="btn btn-success font-weight-bold" type="submit" name="btn_search" value="search">Search</button>
                                    </div>
                                </div>
							  
							  
							 
                    </div>
						<input type="hidden" name="pageno" value = "<?php echo $page_no; ?>"> </input>
				  </form>
					
					
                </div>
				<div class="col-xl-3 "></div>
                <div class="col-md-12">
					 <div class="card data">
									<div class="card-header red text-black">
										<h4><i class="fa fa-list-alt fa-fw" aria-hidden="true"></i>
											<?php echo $table_header; ?></h4>
									</div>
									<div class="card-block" style="overflow:auto;max-height:800px;">
												<?php echo $logs_display; ?>
									</div>
								</div>
                </div>

            </div>
            <div class="row">
                <div class="col-md-12">
                                    </div>
            </div>

        </div>
        <div class="row navbar navbar-light red content footer">
            <div class="text-center">© PET BIT 2020</div>
        </div>
    




	</body>

</html>

<?php



if(isset($_GET['btn_search']))
{
	if($_GET['slct_search']== "templogs")
	{
		
		
		if(empty($_GET['slct_search_location']))
		{
			
		}else if(empty($_GET['slct_search_yaer']))
		{/*
			echo "<script>
					$(document).ready(function() 
					{
						$('#slct_search_location').val('".$_GET['slct_search_location']."');
							$('#slct_search_location').trigger('change');		
					});
					</script>";*/
		}
		else if(empty($_GET['slct_search_month']))
		{
		/*	echo '<script>
					$(document).ready(function() 
					{
						
					
					 var method1 = set_value;
					 var method2 = trigger_change_js;
					 var method3 = set_value;
					 var method4 = trigger_change_js;
					 
					 var method_arr1 = ["slct_search_location","'.$_GET['slct_search_location'].'"];
					 var method_arr2 = ["slct_search_location"];
					 var method_arr3 = ["slct_search_yaer","'.$_GET['slct_search_yaer'].'"];
					 var method_arr4 = ["slct_search_yaer"];
					 
					 var methods = [];
					 var method_params = [];
					 methods.push(method1);
					 methods.push(method2);
					 methods.push(method3);
					 methods.push(method4);
					 
					 method_params.push(method_arr1);
					 method_params.push(method_arr2);
					 method_params.push(method_arr3);
					 method_params.push(method_arr4);
				
					 multiple_callback_jquery(methods,method_params);
						
					});
					</script>';
			*/
		}
		else if(empty($_GET['slct_search_file']))
		{
			
				echo "<script>
					$(document).ready(function() 
					{
						set_value()
						$('#slct_search_location').val('".$_GET['slct_search_location']."');
						$('#slct_search_location').trigger('change');		
						$('#slct_search_yaer').val('".$_GET['slct_search_yaer']."');
						$('#slct_search_yaer').trigger('change');
						$('#slct_search_month').val('".$_GET['slct_search_month']."');
						$('#slct_search_month').trigger('change');		
					});
					</script>";
			
		}
		else
		{
	
		}
		
	}

	
}

	
?>