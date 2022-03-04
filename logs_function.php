    <?php
//require_once('database_connect.php');
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
    
//session_start();
$user_agent = $_SERVER['HTTP_USER_AGENT'];

function getOS() { 

    global $user_agent;

    $os_platform  = "Unknown OS Platform";

    $os_array     = array(
                          '/windows nt 10/i'      =>  'Windows 10',
                          '/windows nt 6.3/i'     =>  'Windows 8.1',
                          '/windows nt 6.2/i'     =>  'Windows 8',
                          '/windows nt 6.1/i'     =>  'Windows 7',
                          '/windows nt 6.0/i'     =>  'Windows Vista',
                          '/windows nt 5.2/i'     =>  'Windows Server 2003/XP x64',
                          '/windows nt 5.1/i'     =>  'Windows XP',
                          '/windows xp/i'         =>  'Windows XP',
                          '/windows nt 5.0/i'     =>  'Windows 2000',
                          '/windows me/i'         =>  'Windows ME',
                          '/win98/i'              =>  'Windows 98',
                          '/win95/i'              =>  'Windows 95',
                          '/win16/i'              =>  'Windows 3.11',
                          '/macintosh|mac os x/i' =>  'Mac OS X',
                          '/mac_powerpc/i'        =>  'Mac OS 9',
                          '/linux/i'              =>  'Linux',
                          '/ubuntu/i'             =>  'Ubuntu',
                          '/iphone/i'             =>  'iPhone',
                          '/ipod/i'               =>  'iPod',
                          '/ipad/i'               =>  'iPad',
                          '/android/i'            =>  'Android',
                          '/blackberry/i'         =>  'BlackBerry',
                          '/webos/i'              =>  'Mobile'
                    );

    foreach ($os_array as $regex => $value)
        if (preg_match($regex, $user_agent))
            $os_platform = $value;

    return $os_platform;
}


function getBrowser() {

    global $user_agent;

    $browser        = "Unknown Browser";

    $browser_array = array(
                            '/msie/i'      => 'Internet Explorer',
                            '/firefox/i'   => 'Firefox',
                            '/safari/i'    => 'Safari',
                            '/chrome/i'    => 'Chrome',
                            '/edge/i'      => 'Edge',
                            '/opera/i'     => 'Opera',
                            '/netscape/i'  => 'Netscape',
                            '/maxthon/i'   => 'Maxthon',
                            '/konqueror/i' => 'Konqueror',
                            '/mobile/i'    => 'Handheld Browser'
                     );

    foreach ($browser_array as $regex => $value)
        if (preg_match($regex, $user_agent))
            $browser = $value;

    return $browser;
}

     function getIP() {
              $IP = '';
              if (getenv('HTTP_CLIENT_IP')) {
                $IP =getenv('HTTP_CLIENT_IP');
              } elseif (getenv('HTTP_X_FORWARDED_FOR')) {
                $IP =getenv('HTTP_X_FORWARDED_FOR');
              } elseif (getenv('HTTP_X_FORWARDED')) {
                $IP =getenv('HTTP_X_FORWARDED');
              } elseif (getenv('HTTP_FORWARDED_FOR')) {
                $IP =getenv('HTTP_FORWARDED_FOR');
              } elseif (getenv('HTTP_FORWARDED')) {
                $IP = getenv('HTTP_FORWARDED');
              } else {
                $IP = $_SERVER['REMOTE_ADDR'];
              }
            return $IP;
            }
function AddLogs($connection,$username,$usertype,$dept,$categ_log,$act){

      
    
        $query_logid = "SELECT MAX(Log_ID) AS maxid
            FROM tbl_logs;";
        $result_logid = mysqli_query($connection, $query_logid) or die(mysqli_error($connection));    
        $row_logid = mysqli_fetch_array($result_logid);                    
        
    $log_id =((int)$row_logid['maxid'])+1;
    
    //$log_date = new DateTime('now');
    $log_date = date('Y/m/d H:i:s');
    $user_name = $username;
   $user_type ="";
 /*

    if($_SESSION["login_user"] !="" || empty($_SESSION["login_user"])){
        $query_emp = "SELECT * 
            FROM tbl_employee
            WHERE 	Pet_ID='".$_SESSION["login_user"]."';";
            $result_emp = mysqli_query($connection, $query_emp) or die(mysqli_error($connection));    
            $row_emp = mysqli_fetch_array($result_emp); 
            $row_emp_count = mysqli_num_rows($result_emp);
        $user_name = $_SESSION['F_N'];
        if($row_emp_count>0)
        {
            $user_type =$row_emp['User_Type'];
        }
       
    }*/
    

    
    
            //  echo getIP()."<BR>";
    //echo "<script> alert('".getOS."');</script>";
    $query_log = "INSERT INTO tbl_logs(
    Log_ID, 
    Emp_id,
    Department,
    Category,
    Activity,
    log_date,
    user_name,
    Log_os,
    Log_browser,
    User_Type,
    user_IP
    )
    VALUES 
    (
    '".$log_id."',
    '".$_SESSION["login_user_connmacro"]."',
    '".$dept."',
    '".$categ_log."',
    '".$act."',
    '".$log_date."',
    '".$user_name."',
    '".getOS()."',
    '".getBrowser()."',
    '".$user_type."',
    '".getIP()."
    ')";
    $result_log = mysqli_query($connection, $query_log) or die(mysqli_error($connection));
    
    
}

        
           
    
    ?>
            