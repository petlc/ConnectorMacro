<?php



require_once('logs_function.php');
require_once('locker.php');
require_once("database_connect.php");
require_once("created_functions_php.php");
//require_once("TMS_function.php");
//require_once('TMS_modals.php');
require_once("mailer.php");
require_once('created_functions_js.php');
include 'PHPExcel.php';
include 'PHPExcel/Writer/Excel2007.php';
//$link = send_text("+639155190565","test","0");
//echo $link;
//echo "<iframe src='$link'></iframe>";
//$ds = 											
/*
$dn = "o=My Company, c=US";
$filter="(|(sn=$person*)(givenname=$person*))";
$justthese = array("ou", "sn", "givenname", "mail");

$sr=ldap_search($ds, $dn, $filter, $justthese);

$info = ldap_get_entries($ds, $sr);

echo $info["count"]." entries returned\n";

*/
 $datetime_now=date("Y-m-d H:i:s");
$temp_date_diff_now = strtotime($datetime_now)-strtotime("");
 
//echo "<B>$temp_date_diff_now</B><BR>";
//echo "<B>".strtotime($datetime_now)."</B>";


?>

    
<head>
        <link rel="stylesheet" type="text/css"href="css/bootstrap.min.css"/>
        <link rel="stylesheet" type="text/css"href="css/all.css"/>
        <link rel="stylesheet" type="text/css"href="css/basic-needs.css"/>
     <!--   <link rel="stylesheet" type="text/css"href="css/preload.css"/> -->
  <!--      <link rel="stylesheet" type="text/css"href="css/jquery.simple-dtpicker.css"/> -->
        <link rel="stylesheet" type="text/css"href="css/jquery-ui.css"/>
        <link rel="stylesheet" type="text/css"href="css/card-design.css"/>
        <link rel="stylesheet" type="text/css"href="css/topbar-notif.css"/>
    <!--    <link rel="stylesheet" type="text/css"href="css/bootstrap-datetimepicker.min.css"/> -->
      <!--  <link href="css/mdb.min.css" rel="stylesheet"> -->
	 <!-- 	<link href="js/jQuery-Form-Validator-master/form-validator/theme-default.min.css" rel="stylesheet"> -->
             
        <script src="js/jquery-3.1.1.min.js"></script>
	    <script src="js/jquery-ui.js"></script>
     
	 	<script src="js/popper.min.js"></script>
        <script src="js/tether.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/aui-min.js"></script>
        <script src="js/jquery.simple-dtpicker.js"></script>
     <!--  <script src="js/view.js"></script> 
        <script src="js/requestform.js"></script> -->
        <script src="js/topbar.js"></script>
    	

      
    
    <style>
        .dropdown-menu-center {
  left: 50% !important;
  right: auto !important;
  text-align: center !important;
  transform: translate(-50%, 0) !important;
}

        .badge-notify{
   background:red;
   position:relative;
   top: -20px;
   left: -10px;
   border-radius: 50%;
   font-size: 14;
}
    @-webkit-keyframes invalid {
  from { background-color: red; }
  to { background-color: inherit; }
}
@-moz-keyframes invalid {
  from { background-color: red; }
  to { background-color: inherit; }
}
@-o-keyframes invalid {
  from { background-color: red; }
  to { background-color: inherit; }
}
@keyframes invalid {
  from { background-color: red; }
  to { background-color: inherit; }
}
.invalid {
  -webkit-animation: invalid 1s infinite; /* Safari 4+ */
  -moz-animation:    invalid 1s infinite; /* Fx 5+ */
  -o-animation:      invalid 1s infinite; /* Opera 12+ */
  animation:         invalid 1s infinite; /* IE 10+ */

        }
.tr_link {
    cursor: pointer;
}
		 
		#auto_sms_txt{ 
			   			display: none;
			 		} 
		#auto_email_a1{
			display: none;
		}
		#auto_email_a2{
			display: none;
		}
		#auto_email_ath{
			display: none;
		}
    </style>       
    
<script>
	
	
    $(document).ready(function(){
		
$(".search_emp_info").autocomplete({
    source: "function/search.php",
    minLength: 2,
	appendTo : $(".search_emp_info").parent()
      
    });
	$(".search_emp_info_sms").autocomplete({
    source: "function/search.php",
    minLength: 2,
	appendTo : $(".search_emp_info_sms").parent()
      
    });
    $('.tr_link').click(function(){
        var link_ = $(this).attr('href');
        if($(this).attr('href'))
            {
             
                       
  
            }
        else
            {
                  return false;
  
            }
        window.location = link_;
            
   });
});
	$(document).ready(function() {
  $('[data-toggle="tooltip"]').tooltip();
		

	


});

	
function pad_with_zeroes(number, length)
{

    var my_string = '' + number;
    while (my_string.length < length) {
        my_string = '0' + my_string;
    }

    return my_string;

}
		function get_month_num(month_num)
		{
			month_num = month_num+1;
			return	pad_with_zeroes(month_num,2);
		}
		

		
            
</script>
    </head>
<!--	<div id="error-dialog" class="has-error"><span class="help-block form-error">Deivice shortcut name has to be an alphanumeric</span></div> 
<div class="form-error alert alert-danger"><strong>Form submission failed!</strong><ul><li>Device name cannot be empty</li><li>Deivice shortcut name has to be an alphanumeric</li></ul></div> -->
	


<nav class="topbar">
    <div class="topbar-brand">
            <h3 class="font-weight-bold" data-toggle="dropdown" id="forms-dropdown">BITRR004</h3> 
    </div>
    <div class="topbar-menu">
        <ul>
            <?php
					if($_SESSION['login_user_connmacro'] != "")
					{
						echo "<font size='5' >Hi ".$_SESSION['sess_displayname']."</font>";
					}
					else
					{
						echo "Welcome";
					}
			?>
             <!--  <li data-content="Notification"> <i class="far fa-envelope fa-2x" data-toggle="dropdown" id="forms-dropdown" ><span class="badge badge-notify"  >1</span> </i>
                  
                    <div class="notifdbs-menu dropdown-menu dropdown-menu-right">
                        <ul class="">
                            <li class="justify-content-between" toggle="popover" data-placement="bottom" data-content="Manage System Request" data-toggle="modal" data-target="#csrf-form">
                                <div class="">

                                    <a href="mis_main.php"><i class="fas fa-comments fa-2x"></i>sample notification 
                                    
                                    
                                    </a>
                                </div>
                            </li>
                          
                        </ul>
                    </div>
                  
                </li> -->
                 
                <li><i class="fa fa-2x fa-home fa-2x" onclick="window.location.href = 'ConnectorMacro_Home.php'" ></i></li>
             
          
         
            <?php
			if($_SESSION['sess_department'] =="asds")
			{
				
			
			?>
                <li><i class="fa fa-cog fa-2x" data-toggle="dropdown" id="forms-dropdown"></i>
                    <div class="others-menu dropdown-menu dropdown-menu-right">
                        <ul class="">
                            <li class=" justify-content-between" toggle="popover" data-placement="bottom" data-content="Manage System Request" data-toggle="modal" data-target="#csrf-form">
                                <div class="">

                                   <a href="#" data-toggle='modal' data-target='#manage_notification_time'><i class="fas fa-user-clock fa-2x" ></i> Manage Notification Time</a>
                               
                                    
                                    </a>
                                </div>
                            </li>
                             <li class=" justify-content-between" toggle="popover" data-placement="bottom" data-content="Add modify or delete devices in the system" data-toggle="modal" data-target="#csrf-form">
                                <div class="">

                                    <a href="#" data-toggle='modal' data-target='#manage_alert_level'><i class="fas fa-exclamation-triangle fa-2x"></i> Manage Alert Level of Sensors </a>
                                </div>
                            </li> 
							<li class=" justify-content-between" toggle="popover" data-placement="bottom" data-content="Add modify or delete devices in the system" data-toggle="modal" data-target="#csrf-form">
                                <div class="">
                                    <a href="#" data-toggle='modal' data-target='#manage_sms_notification'><i class="far fa-comments fa-2x"></i> Manage Alert SMS Notif.</a>
                                </div>
                            </li>
							<li class=" justify-content-between" toggle="popover" data-placement="bottom" data-content="Add modify or delete devices in the system" data-toggle="modal" data-target="#csrf-form">
                                <div class=""> 
                                    <a href="#" data-toggle='modal' data-target='#manage_email_list'><i class="fas fa-at fa-2x" ></i> Manage Email List</a>
                                </div>
                            </li>	
							<li class=" justify-content-between" toggle="popover" data-placement="bottom" data-content="Add modify or delete devices in the system" data-toggle="modal" data-target="#csrf-form">
                                <div class=""> 
                                    <a href="#" data-toggle='modal' data-target='#manage_sms_contact_no'><i class="fas fa-phone-square fa-2x"></i> Manage SMS Contact List </a>
                                </div>
                            </li>
			
						
                     <!--       <li class=" justify-content-between" toggle="popover" data-placement="bottom" data-content="Add modify or delete devices in the system" data-toggle="modal" data-target="#csrf-form">
                                <div class="">

                                    <a href="mis_device.php"><i class="fas fa-headphones fa-2x"></i>Manage Device list</a>
                                </div>
                            </li> 
                           
                            <li class=" justify-content-between" toggle="popover" data-placement="bottom" data-content="Veiw device Images" data-toggle="modal" data-target="#cprf-form">
                                <div class="">

                                     <a href="mis_devicegal.php"><i class="fas fa-tablet-alt fa-2x"></i>Device Gallery</a>
                                </div>
                            </li>
                            <li class=" justify-content-between" toggle="popover" data-placement="bottom" data-content="Important Details in Borrowing" data-toggle="modal" data-target="#">
                                <div class="">

                                     <a href="#"><i class="fas fa-info-circle fa-2x" aria-hidden="true"></i>Information</a> 
                                </div> 
                            </li> -->
                        </ul>
                    </div>
                </li>
			<?php
			}
			if($_SESSION['sess_department'] =="MIS")
			//if($_SESSION['login_user_connmacro'] == "admin")
					{
						
					
			?>
           
            <li class="">
        
                <i class="fa fa-search fa-2x" aria-hidden="true" toggle="popover" data-placement="bottom" data-content="Search" onclick="window.location.href = 'ConnMacro_search.php'"></i>
            </li> 

			<?php
					}
			?>
            <li class="">
               <i class="fa fas fa-sign-out-alt fa-2x" aria-hidden="true" toggle="popover" data-placement="left" data-content="Log-out" onclick="window.location.href = 'LogOut.php'"></i>
            </li>

        </ul>
			
    </div>
</nav>

<iframe id="auto_email_a1" name="auto_email_a1"></iframe>
<iframe id="auto_email_a2" name="auto_email_a2"></iframe>
<iframe id="auto_email_ath" name="auto_email_ath"></iframe>
<iframe id="auto_sms_txt" name="auto_sms_txt"></iframe>

	
	</iframe>
       
<?php
//require_once('logs/logs_function.php');



//require_once('function/top_bar_submit.php');
//require_once('dbs_modals.php');

?>