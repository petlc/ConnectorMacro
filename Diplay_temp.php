<?php
require_once("Display_temp_function.php");

require_once('connect.php');
       

         /*
   $objComport	= new COM ( "AxSerial.ComPort" );
  
   $objComport->Logfile     = "C:\\PhpSerialLog.txt";
   $objComport->Device      = "COM4";
   $objComport->Baudrate    = 9600;
   $objComport->ComTimeout  = 1000;

   $objComport->Open ();
*/

?>

<html>
   <head>
   <META HTTP-EQUIV="CONTENT-Type" CONTENT="text/html;CHARSET=utf-8" >
   <title>Temp Display Arduno</title>
         <script type="text/javascript" src="js/jquery-3.1.1.min.js"></script>
   </head>
       <style>
           #theFrame { 
    display: none;
                        } 
       </style>
<script>
           
           function openInNewTab(url) {
  window.open(url, '_blank');
 // win.focus();
}
              function openLink() {
	       window.location.href="http://10.49.1.213/QueryDevice/add_to_db_temp.php";
	       return false;
	   }
	
    function runFunction()
      {
          //        Push.create('yeah');            
          var collect_temp = 1;
          //alert(collect_temp);
         var temp_add = "";
        
               
           $.ajax({
                
              type: "GET",
              url: 'Display_temp_function.php',
              data: {
                                             
            collect_temp: collect_temp  },
                                                
              success: function(data){
                 var display_temp = jQuery.parseJSON(data);
                              
                               //Push.create(push_info[0]);

                              for(var i=0;i < display_temp.length; i++)
                                  {
                                      var data_ = display_temp[i].split(",");
                                      var humidity_data ="Humidity: "+data_[0];
                                      var temperature_data = "Celsius: "+data_[1];
                                      var water_data = "Water: "+data_[2];
                                      temp_add += humidity_data+" "+temperature_data+" "+water_data+"<BR>";
                                  }
                  $('#lbl_display_temp').empty();
                  $('#lbl_display_temp').append(temp_add);
              }
               
                                           
          });
           var url_ = "http://10.49.1.213/QueryDevice/add_to_db_temp.php";
      
         //  openLink();
           
                  window.open(url_, "theFrame");
              // alert("test");
              // openInNewTab(url_);
          //alert(collect_temp);
      }
               
            var t=setInterval(runFunction,4000); 
           // runFunction();
       </script>
   <body>
	   <button name="read_line" onclick = " var url_ = 'http://10.49.1.213/QueryDevice/add_to_db_temp.php'; 
										   window.open(url_, 'theFrame');" value="read line"> read line</button> 
	   
       <div id='myHiddenPage'></div>
	
       <iframe id="theFrame" name="theFrame"></iframe>
	   
       <label id="lbl_display_temp"></label>
   </body>
</html>
    
    