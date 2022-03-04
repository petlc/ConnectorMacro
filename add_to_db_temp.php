<html>
   <head>
   <META HTTP-EQUIV="CONTENT-Type" CONTENT="text/html;CHARSET=utf-8" >
   <title>ActiveXperts Serial Port Component PHP Sample</title>
   </head>
   <body>
   <font face="sans-serif" size="2">
   <hr size="1" color="#707070">
   <font size="4">ActiveXperts Serial Port Component PHP Sample</font>
   <br>
   <br>
   <b>Initialize a Hayes compatible modem with some AT commands.</b>
   <br>
   <br>
   <hr size="1" color="#707070" >
   <br>
	   
<script>
//alert("test");
	   </script>
   <?php
	   
   require_once('connect.php');
       
   $objComport	= new COM ( "AxSerial.ComPort" );
  
   $objComport->Logfile     = "C:\\PhpSerialLog.txt";
   $objComport->Device      = "COM4";
   $objComport->Baudrate    = 9600;
   $objComport->ComTimeout  = 1000;

   $objComport->Open ();

   if ( $objComport->LastError == 0 )
   {     
        Echo "Sending 'ATZ'...<BR>";
        Echo "<BR>";
    

        $objComport->WriteString      ( "ATZ" );
        
        while ( $objComport->LastError == 0 )
        {
            Echo $objComport->ReadString  ();
            Echo "<BR>";
        }

        Echo "Sending 'ATI'...<BR>";
        Echo "<BR>";

        $objComport->WriteString      ( "ATI" );

        while ( $objComport->LastError == 0 )
        {
            Echo $objComport->ReadString  ();
            Echo "<BR>";
        }

        Echo "Sending 'AT&C0'...<BR>";
        Echo "<BR>";

        $objComport->WriteString      ( "AT&C0" );

        while ( $objComport->LastError == 0 )
        {
           // Echo $objComport->ReadString  ();
            Echo "<BR>";
            $date_now=date("y-m-d");
            $time_now=date("h:i:sa");
           // $hum_temp =  explode(",",$objComport->ReadString  ());
           $hum_temp = explode(",",$objComport->ReadString());
           $hum_temp2 = explode(PHP_EOL,$objComport->ReadString());
           $hum_temp2 = explode(",",$hum_temp2[0]);
            $query = "SELECT MAX(Temp_id)
                        FROM tbl_temp_data";
            $result = mysqli_query($connection, $query) or die(mysqli_error($connection));    
            $row = mysqli_fetch_array($result);
            $temp_id = $row['MAX(Temp_id)']+1;
            echo $objComport->ReadString();
			print_r($hum_temp2);
			print_r($hum_temp);
            $query = "INSERT INTO tbl_temp_data (Temp_id,Humidity_data,Temperature_data,Water_data,Temp_date,Temp_time ) VALUES (
            '".$temp_id."',
            '".$hum_temp[1]."',
            '".$hum_temp[0]."',
            '".$hum_temp2[4]."',
            '".$date_now."',
            '".$time_now."'
            
            )";
            $result = mysqli_query($connection, $query) or die(mysqli_error($connection));	
            
           
           /* echo "<script>
			alert('".$hum_temp[4]."')
			</script>";
				*/
				
            break;
            
        }
   }
   else
   {
       $ErrorNum = $objComport->LastError;
       $ErrorDes = $objComport->GetErrorDescription ( $ErrorNum );

       Echo "Error sending commands: #$ErrorNum ($ErrorDes).";
   }
 
   Echo "Ready.";

   $objComport->Close ();
 
?>

   <br>
   <br>
   <hr size="1" color="#707070">
   <font size="1" face="Verdana">This demo uses ActiveXperts Serial Port Component</font>
   </body>
</html>