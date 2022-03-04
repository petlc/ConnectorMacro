<?php

$notif_time = "";
$tr_notif_time ="";
$slct_notification_list = "";
$result = select_data($connection_TMS,"tbl_tms_settings","*","tms_setting_item = 'email_notification_time'");
  while($row = $result->fetch_assoc()) {
                   $notif_time = explode(",",$row['tms_settings_value']);
	  				$notif_time_value = $row['tms_settings_value'];
  }
$result = select_data($connection_TMS,"tbl_tms_settings","*","tms_setting_item = 'email_notification_last_sent'");
  while($row = $result->fetch_assoc()) {
                   $notif_date_value = $row['tms_settings_value'];
  }
for($i = 0 ;$i<= count($notif_time)-1;$i++)
{
	$tr_notif_time .= "<tr><td>$notif_time[$i]</td></tr>";
	$time_to_display = date('h:i:s a', strtotime($notif_time[$i]));
	$slct_notification_list .= "<option value = '$notif_time[$i]'>$time_to_display</option>";
}





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



if($settings_alert_notification == "TRUE")
{
	$slct_alert_notification_on = "Selected";
	$slct_alert_notification_off = "";
}
else
{
	$slct_alert_notification_off = "Selected";
	$slct_alert_notification_on = "";
}

if($settings_sms_notification_day == "weekdays")
{
	$opt_sms_notification_weekdays = "Selected";
	$opt_sms_notification_weekends = "";
	$opt_sms_notification_everyday = "";
}
else if($settings_sms_notification_day == "weekends")
{
	$opt_sms_notification_weekdays = "";
	$opt_sms_notification_weekends = "Selected";
	$opt_sms_notification_everyday = "";
}else if($settings_sms_notification_day == "everyday")
{
	$opt_sms_notification_weekdays = "";
	$opt_sms_notification_weekends = "";
	$opt_sms_notification_everyday = "Selected";
}

if($settings_sms_notification == "TRUE")
{
	$opt_sms_notification_on = "Selected";
	$opt_sms_notification_off = "";

}else
{
	$opt_sms_notification_on = "";
	$opt_sms_notification_off = "Selected";
}


$email_list_tr = "";
$sms_list_tr = "";
$slct_email_list = "";
$slct_sms_no_list = "";
$email_list_arr = explode(",",$settings_email_notification_to);

$sms_list_arr = explode(",",$settings_sms_notification_to);




$email_notification_to = explode(",",$settings_email_notification_to);
for($i = 0 ;$i<= count($email_notification_to)-1;$i++)
{
	
	$result = select_data($connection_emp_info,"emp_email","*","email_account ='$email_notification_to[$i]'");
		while($row = $result->fetch_assoc()) {
								 $email_notif_pet_id = $row['email_pet_id'];
			}
	$result = select_data($connection_emp_info,"emp_info","*","pet_id ='$email_notif_pet_id'");
	while($row = $result->fetch_assoc()) {
							 $email_notif_full_name = $row['full_name'];
		}
	if(mysqli_num_rows($result)==0)
	{
		$email_notif_full_name = "Uknown";
	}
	$email_list_tr .= "<tr>
						<td>$email_notif_full_name</td>
						<td>$email_notification_to[$i]</td>
					  </tr>";
	
	$slct_email_list .= "<option value = '$email_notification_to[$i]'>$email_notification_to[$i]</option>";
}
$sms_list_arr = explode(",",$settings_sms_notification_to);
for($i = 0 ;$i<= count($sms_list_arr)-1;$i++)
{
	
	$result = select_data($connection_emp_info,"emp_info","*","mobile_number ='$sms_list_arr[$i]'");
		while($row = $result->fetch_assoc()) {
								 $sms_notif_pet_id = $row['pet_id'];
								 $sms_notif_full_name = $row['full_name'];
			}
	
	if(mysqli_num_rows($result)==0)
	{
		$sms_notif_full_name = "Uknown";
	}
	
	$sms_list_tr .= "<tr>
						<td>$sms_notif_full_name</td>
						<td>$sms_list_arr[$i]</td>
					  </tr>";
	
	$slct_sms_no_list .= "<option value = '$sms_list_arr[$i]'>$sms_list_arr[$i]</option>";
}
?>
<script>
	
</script>


<!-- notification time-->
<div class="modal fade bd-example-modal-md" id="manage_notification_time" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display:none;">
    <div class="modal-dialog modal-md" role="document">
        <form method="post" action = "TMS_submit.php">
            <div class="card">
                <div class="card-header">
                <h5>Manage Notification Time </h5>
                </div>
                <div class="card-block">
                    <div class="row">
                        <label class="col-3 col-form-label text-right">Notification Time:</label></BR>
                       
                        <div class="col-6">
                            <select name="slct_notification_list" class="custom-select form-control" required onchange=' if(this.value == "add_time" || this.value =="" ){    
																										   clear_data_components("txt_time");
																										   clear_data_components("txt_date");
																										   element_hide("btn_add_time",true);
																										   element_hide("btn_update_time",false);
																										   element_hide("btn_delete_time",false);
																										   }
																										   else {
																										   var date_split = document.getElementById("txt_date_value").value.split(",");
																										   var date_value = date_split[this.selectedIndex-2];
																										   set_value("txt_time",this.value); 
																										   set_value("txt_date",date_value); 
																										   element_hide("btn_add_time",false);
																										   element_hide("btn_update_time",true);
																										   element_hide("btn_delete_time",true);
																										   }
																										   '>
								<option value="">--</option>
								<option value="add_time">Add Time</option>
                                <?php
								   echo $slct_notification_list; // 2020-02-07,2020-02-06,2020-02-03,2020-02-07,2020-02-07,2020-02-06
								?>
								
                            </select><BR>
							<input id="txt_time" class="form-control" type="time" name="txt_time" step="1"  style="margin-top:10px;"required ></input>
							
                        </div>
				</div>   
				<div class="row"></div>
				<div class="row" style="height:10px;"></div>
				<div class="row">
                        <label class="col-3 col-form-label text-right">Notification Last Sent:</label></BR>
                       
                    
							<input id="txt_date" class="form-control" type="date" name="txt_date" style="width:50%;"  required ></input>
							<input id="txt_time_value" type="hidden" name="txt_time_value"  value="<?php echo $notif_time_value; ?>" ></input>
							<input id="txt_date_value" type="hidden" name="txt_date_value"  value="<?php echo $notif_date_value; ?>" ></input>
							
                        </div>
                    </div>
                    
                    <div name="remarks" class="row">
                     
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-2"></div>
                        <button id="btn_add_time" type="submit" class="btn btn-success col-3" name="btn_add_time"  style="margin:5px;" onClick="">Add</button>
                        <button id="btn_update_time" type="submit" class="btn btn-success col-3" name="btn_update_time" onClick="" style="display:none;margin:5px;">Update</button>
                        <button id="btn_delete_time" type="submit" class="btn btn-danger col-3" name="btn_delete_time" onClick="" style="display:none;margin:5px;">Delete</button>
                       
                        <button type="button" class="btn btn-light col-3" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- alert level-->
<div class="modal fade bd-example-modal-md" id="manage_alert_level" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display:none;">
    <div class="modal-dialog modal-md" role="document">
        <form method="post" action = "TMS_submit.php">
            <div class="card">
                <div class="card-header">
                <h5>Manage Alert Level of Sensors </h5>
                </div>
                <div class="card-block">
               <!--     <div class="row">
                        <label class="col-3 col-form-label text-right">Water Sensor Alerts if:</label></BR>
                        <div class="col-6">
							<select name="slct_alert_water" class="custom-select form-control" required onchange=''>
								<option value="">--</option>
								<option value="Empty">Has Water</option>
								<option value="Low,Medium,High">No Water</option>
							</select>
					  </div>
					</div> -->
					<div class="row">
                        <label class="col-3 col-form-label text-right">Alert Notification::</label></BR>
                        <div class="col-6">
							<select id="slct_alert_notification" class="form-control" name="slct_alert_notification"   style="width:100%;margin-top:10px;"required disabled>
								<option value="">--</option>
								<option value="TRUE"<?php echo $slct_alert_notification_on; ?>>ON</option>
								<option value="FALSE"<?php echo $slct_alert_notification_off; ?>>OFF</option>
							</select>
						 </div>
					</div>	
					<div class="row">
                        <label class="col-3 col-form-label text-right">Temperature Equals/Greater than:</label></BR>
                        <div class="col-6">
							<input id="txt_alert_temp" type="number" class="form-control" name="txt_alert_temp"   style="width:100%;margin-top:10px;"required readonly  value ='<?php echo $settings_alert_level_temp_greater_than; ?>'></input>°C
                        </div>
					</div>  
					<div class="row">
                        <label class="col-3 col-form-label text-right">Humidity Equals/Greater than:</label></BR>
                        <div class="col-6">
							<input id="txt_alert_hum" type="number" class="form-control" name="txt_alert_hum"  style="width:100%;margin-top:10px;"required readonly  value ='<?php echo $settings_alert_hum_level_greater_than; ?>'></input>	%
                        </div> 
					
					</div> 
					<div class="row">
                        <label class="col-3 col-form-label text-right ">Alert Time Repeat:</label></BR>
                        <div class="col-6">
							<input id="txt_alert_repeat_seconds" class="form-control" type="number" name="txt_alert_repeat_seconds"   style="width:100%;margin-top:10px;"required readonly  value ='<?php echo $settings_alert_time_every_how_many_seconds; ?>'> </input>	Seconds
                        </div>
					</div>   
				<div class="row"></div>
				<div class="row" style="height:10px;"></div>
		
                    </div>
                    
                    <div name="remarks" class="row">
                     
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-2"></div>
                       <button id="btn_save_alert" type="submit" class="btn btn-success col-3" name="btn_save_alert" onClick="" style="display:none;margin:5px;">Save</button>
                       <button id="btn_edit_alert" type="button" class="btn btn-success col-3" name="btn_edit_alert" onClick="set_readonly('txt_alert_temp',false);set_readonly('txt_alert_hum',false);set_readonly('txt_alert_repeat_seconds',false);set_disable('slct_alert_notification',false);element_hide(this.id,false);element_hide('btn_save_alert',true);" style="margin:5px;">Edit</button>
                        <button type="button" class="btn btn-light col-3" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- sms notification-->
<div class="modal fade bd-example-modal-md" id="manage_sms_notification" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display:none;">
    <div class="modal-dialog modal-md" role="document">
        <form method="post" action = "TMS_submit.php" >
            <div class="card">
                <div class="card-header">
                <h5>Manage Alert SMS Notification </h5>
                </div>
                <div class="card-block">
                    <div class="row">
                        <label class="col-3 col-form-label text-right">SMS Notification:</label></BR>
                       
                        <div class="col-6">
							<select class="form-control custom-select" id="slct_sms_notification" name="slct_sms_notification">
								<option value="">--</option>
								<option value="TRUE" <?php echo $opt_sms_notification_on; ?>>ON</option>
								<option value="FALSE" <?php echo $opt_sms_notification_off; ?>>OFF</option>
							</select>

                        </div>
					</div>  
					<div class="row">
                        <label class="col-3 col-form-label text-right">SMS Notification day:</label></BR>
                       
                        <div class="col-6">
							<select class="form-control custom-select" id="slct_sms_notification_day" name="slct_sms_notification_day">
								<option value="">--</option>
								<option value="everyday" <?php echo $opt_sms_notification_everyday;?> >EVERYDAY</option>
								<option value="weekdays" <?php echo $opt_sms_notification_weekdays;?> >WEEKDAYS</option>
								<option value="weekends" <?php echo $opt_sms_notification_weekends;?> >WEEKENDS</option>
							</select>

                        </div>
					</div>   
			
                    </div>
                    
                    <div name="remarks" class="row">
                     
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-2"></div>
                        <button id="btn_update_sms_notification" type="submit" class="btn btn-success col-3" name="btn_update_sms_notification" onClick="" style="margin:5px;">Update</button>
                        <button type="button" class="btn btn-light col-3" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- manage email-->
<div class="modal fade bd-example-modal-md" id="manage_email_list" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display:none;">
    <div class="modal-dialog modal-md" role="document">
        <form method="post" action = "TMS_submit.php" >
            <div class="card">
                <div class="card-header">
                <h5>Manage Email List </h5>
                </div>
                <div class="card-block">
                   
					<div class="row">
						<table border="1" class="table table-bordered" style="width:100%;" >
							<thead >
								<tr>
									<th >Name</th>
									<th >Email</th>
								</tr>
							</thead>
							<tbody>
								<?php echo $email_list_tr; ?>
							</tbody>
						</table>
					</div>
					<div class="row">
						    <label class="col-3 col-form-label text-right">Email List:</label></BR>
					 <div class="col-6">
						   <select id="slct_email_list" name="slct_email_list" class="custom-select form-control" onchange='set_value("txt_email",this.value); clear_data_components("txt_search_emp");  '>
								<option value="">--</option>
							    <?php
								   echo $slct_email_list; // 2020-02-07,2020-02-06,2020-02-03,2020-02-07,2020-02-07,2020-02-06
								?>
								
                            </select>
						</div>
					</div>
					<div class="row">
                      
                        <label class="col-3 col-form-label text-right">Search PET Employee:</label></BR>
                       
                        <div class="col-6">
							<input id="txt_search_emp" class="form-control search_emp_info" type="text" name="txt_search_emp"   style="width:100%;margin-top:10px;" value ='' onchange="
							var emp_info = this.value.split('|');
							if(emp_info.length == 5)
							{
							 clear_data_components('txt_email');
							 set_value('txt_email',emp_info[3]);
							 $('#txt_search_emp').val(emp_info[0]);
							 clear_data_components('slct_email_list');
							}
							
							"> </input>

                        </div>
					</div>  
					<div class="row">
                      
                        <label class="col-3 col-form-label text-right">Email:</label></BR>
                       
                        <div class="col-6">
							<input id="txt_email" class="form-control" type="email" name="txt_email"   style="width:100%;margin-top:10px;" value ='' required> </input>
                        </div>
					</div>   
			
                    </div>
                    
                    <div name="remarks" class="row">
                     
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-2"></div>
                        <button id="btn_manage_email_add" type="submit" class="btn btn-success col-3" name="btn_manage_email_add" onClick="" style="margin:5px;">Add</button>
                        <button id="btn_manage_email_delete" type="submit" class="btn btn-danger col-3" name="btn_manage_email_delete" onClick="" style="margin:5px;">Delete</button>
                        <button type="button" class="btn btn-light col-3" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- sms notification-->
<div class="modal fade bd-example-modal-md" id="manage_sms_contact_no" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="display:none;">
  <div class="modal-dialog modal-md" role="document">
        <form method="post" action = "TMS_submit.php" >
            <div class="card">
                <div class="card-header">
                <h5>Manage SMS Contact List </h5>
                </div>
                <div class="card-block">
                   
					<div class="row">
						<table border="1" class="table table-bordered" style="width:100%;" >
							<thead >
								<tr>
									<th >Name</th>
									<th >Contact #</th>
								</tr>
							</thead>
							<tbody>
								<?php echo $sms_list_tr; ?>
							</tbody>
						</table>
					</div>
					<div class="row">
						    <label class="col-3 col-form-label text-right">SMS Contact List:</label></BR>
					 <div class="col-6">
						   <select id="slct_sms_no_list" name="slct_sms_no_list" class="custom-select form-control" onchange='set_value("txt_sms_no",this.value); clear_data_components("txt_search_emp_sms");  '>
								<option value="">--</option>
							    <?php
								   echo $slct_sms_no_list; // 2020-02-07,2020-02-06,2020-02-03,2020-02-07,2020-02-07,2020-02-06
								?>
								
                            </select>
						</div>
					</div>
					<div class="row">
                      
                        <label class="col-3 col-form-label text-right">Search PET Employee:</label></BR>
                       
                        <div class="col-6">
							<input id="txt_search_emp_sms" class="form-control search_emp_info_sms" type="text" name="txt_search_emp_sms"   style="width:100%;margin-top:10px;" value ='' onchange="
							var emp_info = this.value.split('|');
							if(emp_info.length == 5)
							{
							 clear_data_components('txt_sms_no');
							 set_value('txt_sms_no',emp_info[4]);
							 $('#txt_search_emp_sms').val(emp_info[0]);
							 clear_data_components('slct_sms_no_list');
							}
							"> </input>

                        </div>
					</div>  
					<div  class="row">
                      
                        <label class="col-3 col-form-label text-right">Contact #:</label></BR>
                       
                        <div class="col-6">
							<input id="txt_sms_no" class="form-control" type="text" name="txt_sms_no"   style="width:100%;margin-top:10px;" value ='' required> </input>
                        </div>
					</div>   
			
                    </div>
                    
                    <div name="remarks" class="row">
                     
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-2"></div>
                        <button id="btn_manage_sms_add" type="submit" class="btn btn-success col-3" name="btn_manage_sms_add" onClick="" style="margin:5px;">Add</button>
                        <button id="btn_manage_sms_delete" type="submit" class="btn btn-danger col-3" name="btn_manage_sms_delete" onClick="" style="margin:5px;">Delete</button>
                        <button type="button" class="btn btn-light col-3" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>