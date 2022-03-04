<?php
//data base connection needed
//require_once("database_connect.php");

if(!empty($_GET['get_file_name_list_location']))
{
	$location = $_GET['get_file_name_list_location'];
	$file_type = $_GET['get_file_name_list_file_type'];
	$location_list = get_filename_list("$location/","$file_type");
//print_r($location_list);
	 
		echo json_encode($location_list,JSON_UNESCAPED_SLASHES);	
}

if(!empty($_GET['query_']))
{
	/*$test_arr = array();
	array_push($test_arr,"test2");
	echo json_encode($test_arr);
	*/

  $collumn_value_to_put = $_GET['collumn_value_to_put'];
  $result = mysqli_query($connection_borr_local, $_GET['query_']) or die(mysqli_error($connection_borr_local));    
  $rowcount=mysqli_num_rows($result);
            
  if($rowcount > 0)
    {
        
       while($row = $result->fetch_assoc()) 
	   {
		   
		$value  = $row["$collumn_value_to_put"];
			 	
					
	   }
		//var_dump(json_encode($value,JSON_UNESCAPED_SLASHES));
		echo json_encode($value,JSON_UNESCAPED_SLASHES);	
	}
	else
	{
		echo json_encode("no row found",JSON_UNESCAPED_SLASHES);
		
	}
	

}
if(!empty($_GET['checkdataexistqueryjs_query']))
{

  $result = mysqli_query($connection_borr_local, $_GET['checkdataexistqueryjs_query']) or die(mysqli_error($connection_borr_local));    
  $rowcount=mysqli_num_rows($result);
            
  if($rowcount > 0)
    {
        echo json_encode("$rowcount no. of rows",JSON_UNESCAPED_SLASHES);
 	}
	else
	{
		echo json_encode("no row found",JSON_UNESCAPED_SLASHES);
	}
	

}
if(!empty($_GET['ai_ctrl_no_query_query_4select']))
{

  $result = mysqli_query($connection_borr_local, $_GET['ai_ctrl_no_query_query_4select']) or die(mysqli_error($connection_borr_local));    
  $rowcount=mysqli_num_rows($result);
            
  if($rowcount > 0)
    {
        echo json_encode("$rowcount no. of rows",JSON_UNESCAPED_SLASHES);
 	}
	else
	{
		
		  $result = mysqli_query($connection_borr_local, $_GET['ai_ctrl_no_query_query_4select']) or die(mysqli_error($connection_borr_local));    
  		  $rowcount = mysqli_num_rows($result);
		 if($rowcount > 0)
			{
				echo json_encode("$rowcount no. of rows",JSON_UNESCAPED_SLASHES);
			}
		else
			{
			
			}
		echo json_encode("no row found",JSON_UNESCAPED_SLASHES);
	/*	ai_ctrl_no_query_query_4select
		ai_ctrl_no_query_query_4acro
		ai_ctrl_no_query_query_4acro*/
	}
	
	

}
if(!empty($_GET['query_id_to_name']))
{
	/*$test_arr = array();
	array_push($test_arr,"test2");
	echo json_encode($test_arr);
	*/

  $collumn_value_to_put = $_GET['collumn_value_to_put'];
  $result = mysqli_query($connection_emp_info, $_GET['query_id_to_name']) or die(mysqli_error($connection_emp_info));    
  $rowcount=mysqli_num_rows($result);
            
  if($rowcount > 0)
    {
        
       while($row = $result->fetch_assoc()) 
	   {
		   
		$value  = $row["$collumn_value_to_put"];
			 	
					
	   }
		//var_dump(json_encode($value,JSON_UNESCAPED_SLASHES));
		echo json_encode($value,JSON_UNESCAPED_SLASHES);	
	}
	else
	{
		echo json_encode("no row found",JSON_UNESCAPED_SLASHES);
		
	}
	

}



function create_select_dropdown($query,$conn,$name,$value,$text,$class="",$id="",$selected_value="",$selected_val_compare_to="",$onchange="",$required="",$style="")
{
    
    $select_list ="";
    $select_option="";
    $select_selected = "";
	
	
	if($query =="")
	{
		return "<B>Error:</B> Query not set";
	
	}
	if($conn =="")
	{
		return "<B>Error:</B> connection not set";
	}
	if($name =="")
	{
		return "<B>Error:</B>dropdown Name not set";
	}
	if($value =="")
	{
		return "<B>Error:</B>Option value not set";
	}
	if($text =="")
	{
		return "<B>Error:</B>Option Text not set";
	}
	
    
    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
           while($row = $result->fetch_assoc()) {
                    
                    if($selected_val_compare_to !=""){
                        
                          if($selected_value == $row[$selected_val_compare_to])
                            {
                        
                                $select_selected = "selected";
                            }
                        
                    }
                  
                    $select_option .="<option value='".$row[$value]."' ".$select_selected." style='".$style."' >".$row[$text]."</option>";
                    
                    $select_selected = "";
                    
                 }
    $select_list ="<select class='".$class."' id='".$id."' name='".$name."' onchange='".$onchange."' $required>
                            <option>--</option>
                                ".$select_option."
                    </select>";
    return $select_list;
    
}

function query_add($conn,$table_name,$columns,$column_values)
{
	if($conn =="")
	{
		return "<B>query_add:</B> connection not set";
	
	}
	if($table_name =="")
	{
		return "<B>query_add:</B> table name not set";
	}
	if(count($columns) == 0)
	{
		return "<B>query_add:</B>columns array not set";
	}
	if(count($column_values)==0)
	{
		return "<B>query_add:</B>column values not set";
	}

	
	if(count($columns)<count($column_values) || count($columns)>count($column_values)  )
	{
		return "<script>
					alert('PHP query_add:column and values to insert not match');
				</script>";
	}
	$columns_to_input = "";
	$values_to_input = "";
	for($i=0;$i<=count($columns)-1;$i++)
	{
		//echo $i;
		if((count($columns) - $i)  ==1 )
		{
			$columns_to_input .= $columns[$i]."";
			$values_to_input .= "'".$column_values[$i]."'";
	
		}
		else
		{
		$columns_to_input .= $columns[$i].",";
		$values_to_input .= "'".$column_values[$i]."',";
	
		}
		
	}
	//echo $columns_to_input." ".$values_to_input;
  $result = mysqli_query($conn, "INSERT INTO $table_name ($columns_to_input) VALUES($values_to_input)" ) or die(mysqli_error($conn));    
 
	
}
function query_update($conn,$table_name,$columns,$column_values,$condition)
{
	if($conn =="")
	{
		return "<B>query_update:</B> connection not set";
	
	}
	if($table_name =="")
	{
		return "<B>query_update:</B> table name not set";
	}
	if(count($columns) == 0)
	{
		return "<B>query_update:</B>columns array not set";
	}
	if(count($column_values)==0)
	{
		return "<B>query_update:</B>column values not set";
	}
	if($condition=="")
	{
		return "<B>query_update:</B>condition not set";
	}
	
	if(count($columns)<count($column_values) || count($columns)>count($column_values)  )
	{
		return "<script>
					alert('query_update:column and values to insert not match');
				</script>";
		
	}

	
	
	$query_to_input = "";
	
	for($i=0;$i<=count($columns)-1;$i++)
	{
		
		$query_to_input .= $columns[$i]."='".$column_values[$i]."', ";
		if((count($columns)-$i)  ==1  )
		{
				$query_to_input .= $columns[$i]."='".$column_values[$i]."'";
		}
		
	}
	
  $result = mysqli_query($conn, "UPDATE $table_name SET $query_to_input WHERE $condition" ) or die(mysqli_error($conn));    
 
}
function query_delete($conn,$table_name,$condition)
{
	if($conn =="")
	{
		return "<B>query_delete:</B> connection not set";
	
	}
	if($table_name =="")
	{
		return "<B>query_delete:</B> table name not set";
	}

	if($condition=="")
	{
		return "<B>query_delete:</B>condition not set";
	}
	
$result = mysqli_query($conn, "DELETE FROM $table_name  WHERE $condition" ) or die(mysqli_error($conn));    
 
}
function check_data_existquery($conn,$table_name,$column,$data,$id="",$column_id="")
{
	
	if($conn =="")
	{
		return "<B>PHP check_data_existquery:</B> connection not set";
	
	}
	if($table_name =="")
	{
		return "<B>PHP check_data_existquery:</B> table name not set";
	}	
	if($column =="")
	{
		return "<B>PHP check_data_existquery:</B> column not set";
	}	
	if($data =="")
	{
		return "<B>PHP check_data_existquery:</B> data not set";
	}
	$condition_same_id_and_data ="";
	if($id != "")
	{
		
		if($column_id =="")
		{
			return "<B>PHP check_data_existquery:</B> column_id not set ";
		}
		$condition_same_id_and_data= "AND NOT($column_id ='$id' AND $column ='$data')";
		
	}
	$result = select_data($conn,$table_name,"*","$column = '$data' $condition_same_id_and_data");
	//print_r($result);
	//echo mysqli_num_rows($result);
	if(mysqli_num_rows($result)>0)
	{
		return "true";
	}
	else
	{
		return "false";
	}
}

function get_changes_query($conn,$table_name,$updated_columns_arr,$updated_columns_val_arr,$id_column,$id,$identification_arr)
{
	$result = select_data($conn,$table_name,"*","$id_column = '$id'");
	$row = mysqli_fetch_array($result); 
	$from_arr = array();
	$to_arr = array();
	$identification_change_arr = array();
	
	for($i=0;$i <= count($updated_columns_arr)-1;$i++)
	{
		//echo $row[$updated_columns_arr[$i]];
		if(trim($row[$updated_columns_arr[$i]]) !=  $updated_columns_val_arr[$i] )
		{
			//echo $updated_columns_arr[$i];
			array_push($from_arr,$row[$updated_columns_arr[$i]]);
			array_push($to_arr,$updated_columns_val_arr[$i]);
			array_push($identification_change_arr,$identification_arr[$i]);
		}
	}
	return array($identification_change_arr,$from_arr,$to_arr);
}
function get_changes_string($identification_arr,$from_value_arr,$value_arr)
{
	if(count($identification_arr) !=  count($from_value_arr))
	{
		return "<B>get_changes_string: count identification_arr != from_value_arr  </B>";
		
	}
	if(count($from_value_arr) != count($value_arr) )
	{
		return "<B>get_changes_string: count from_value_arr != value_arr  </B>";
	}
	
	$changes_string = "";
	for($i = 0 ; $i <= count($identification_arr)-1;$i++ )
	{
		$changes_string .= "$identification_arr[$i] from $from_value_arr[$i] to $value_arr[$i],";
	}
	return $changes_string;
}

//columns in condition , data values to check in columns 
function select_data($conn,$table_name,$selected_columns,$condition)
{
	if($conn =="")
	{
		return "<B>PHP select_data:</B> connection not set";
	
	}
	if($table_name =="")
	{
		return "<B>PHP select_data:</B> table name not set";
	}	
	if($selected_columns =="")
	{
		return "<B>PHP select_data:</B> table name not set";
	}	
	if($condition =="")
	{
		return "<B>PHP select_data:</B> table name not set";
	}
	$result = mysqli_query($conn, "SELECT $selected_columns FROM $table_name WHERE $condition" ) or die(mysqli_error($conn));    
 
	return $result;
}
function count_data($conn,$table_name,$condition)
{
	if($conn =="")
	{
		return "<B>PHP count_data:</B> connection not set";
	
	}
	if($table_name =="")
	{
		return "<B>PHP count_data:</B> table name not set";
	}	
	if($condition =="")
	{
		return "<B>PHP count_data:</B> table name not set";
	}
	$result = mysqli_query($conn, "SELECT * FROM $table_name WHERE $condition" ) or die(mysqli_error($conn));    
	$row_count = mysqli_num_rows($result);
	return $row_count;
}
function select_distinct($conn,$table_name,$column,$condition)
{
	if($conn =="")
	{
		return "<B>PHP count_data:</B> connection not set";
	
	}
	if($table_name =="")
	{
		return "<B>PHP count_data:</B> table name not set";
	}	
	if($condition =="")
	{
		return "<B>PHP count_data:</B> table name not set";
	}
	$result = mysqli_query($conn, "SELECT DISTINCT $column FROM $table_name WHERE $condition" ) or die(mysqli_error($conn));    
	$row_count = mysqli_num_rows($result);
	return $result;
}
function query_copy_row_to_table($conn,$table_name_from,$table_name_to,$condition)
{ 
	
	if($conn =="")
	{
		return "<B>PHP count_data:</B> connection not set";
	
	}
	if($table_name_from =="")
	{
		return "<B>PHP count_data:</B> table name1 not set";
	}
	if($table_name_to =="")
	{
		return "<B>PHP count_data:</B> table name2 not set";
	}	
	if($condition =="")
	{
		return "<B>PHP count_data:</B> condition not set";
	}
	$result = mysqli_query($conn, "INSERT INTO $table_name_to SELECT * FROM $table_name_from WHERE $condition" ) or die(mysqli_error($conn));    
	
	return $result;
}
function query_truncate($conn,$table_name)
{
	if($conn =="")
	{
		return "<B>PHP count_data:</B> connection not set";
	
	}
	if($table_name =="")
	{
		return "<B>PHP count_data:</B> table name not set";
	}	
	
	$result = mysqli_query($conn, "TRUNCATE TABLE $table_name" ) or die(mysqli_error($conn));    
	return $result;
}

function select_data_leftjoin($conn,$table_name1,$selected_columns1,$table_name2,$selected_columns2,$condition,$compare_column_tbl1,$compare_column_tbl2)
{
	if($conn =="")
	{
		return "<B>PHP select_data_leftjoin:</B> connection not set";
	}
	if($table_name1 =="")
	{
		return "<B>PHP select_data_leftjoin:</B> table name not set";
	}
	if($table_name2 =="")
	{
		return "<B>PHP select_data_leftjoin:</B> table name not set";
	}	
	if(count($selected_columns1) ==0)
	{
		return "<B>PHP select_data_leftjoin:</B> selected column on table1 not set";
	}
	if(count($selected_columns2) ==0)
	{
		return "<B>PHP select_data_leftjoin:</B> selected column on table2 not set";
	}	
	if($condition =="")
	{
		return "<B>PHP select_data_leftjoin:</B> condition not set";
	}
	if($compare_column_tbl1 =="")
	{
		return "<B>PHP select_data_leftjoin:</B> column to be compare in table1 not set";
	}
	if($compare_column_tbl2 =="")
	{
		return "<B>PHP select_data_leftjoin:</B> column to be compare in table1 not set";
	}
	
	$selected_columns = "";
	for($i = 0;$i <= count($selected_columns1)-1;$i++ )
	{
		$selected_columns .= $table_name1.".".$selected_columns1[$i].",";
	}
	for($i = 0;$i <= count($selected_columns2)-1;$i++ )
	{
		
		
		if((count($selected_columns2) - $i)  ==1 )
		{
			$selected_columns .= $table_name2.".".$selected_columns2[$i]." ";
		}
		else
		{
			$selected_columns .= $table_name2.".".$selected_columns2[$i].",";
		}
	
	}
	$result = mysqli_query($conn, "SELECT $selected_columns FROM $table_name1 LEFT JOIN $table_name2 ON $table_name1.$compare_column_tbl1 = $table_name2.$compare_column_tbl2  WHERE $condition" ) or die(mysqli_error($conn));    
 	return $result;
	
}
function get_filename_list($locaion,$file_type)
{ 
	if($file_type == "")
	{
		$file_type = "*";
	}
	else
	{
		$file_type = "*.$file_type";
	}
	$file_list = array();
	foreach (glob("$locaion/$file_type") as $filename) {
    $p = pathinfo($filename);
     $file_list[] = $p['filename'];
	}
	return $file_list;
}

function get_file_name_list_populate_to_opt($location,$file_type,$selected_value)
{
	$file_list = get_filename_list($location,$file_type);
	$opt_selected = "";
	$opt_return = "";
	
	for($i =0 ; $i <= count($file_list)-1;$i++)
	{
		if($file_list[$i] == $selected_value)
		{
			$opt_selected = "selected";
		}
		$opt_return .= "<option value = '$file_list[$i]' $opt_selected>$file_list[$i]</option>";
		$opt_selected = "";
	}
	return $opt_return;
}

function pagination_sql_query($conn,$query,$current_page,$no_of_records_per_page)
{
	$offset = ($current_page - 1) * $no_of_records_per_page;
	
	//echo $query." LIMIT $offset, $no_of_records_per_page";
	$result = mysqli_query($conn, $query." LIMIT $offset, $no_of_records_per_page" ) or die(mysqli_error($conn));    
 	//echo $query." LIMIT $offset, $no_of_records_per_page";
	return $result;
}
function custom_pagination_php($total_count_rows,$total_count_table_row,$current_page,$pages_show_count,$url)
{
    $offset = ($current_page - 1) * $total_count_table_row;
	
	//$total_pages = intdiv($total_count_rows, $total_count_table_row);
    $total_pages = (int)($total_count_rows / $total_count_table_row);
	if($total_count_rows % $total_count_table_row != 0)
	{
		$total_pages += 1;
	}
	/*$offset = ($current_page - 1) * $total_count_table_row;
	try
	{
		$total_pages = intdiv($total_count_rows, $total_count_table_row);
	}
	
	catch(Exception $e)
	{
		
		$total_pages = (int)($total_count_table_row / $total_count_rows);
	}
	if($total_count_rows % $total_count_table_row != 0)
	{
		$total_pages += 1;
	}
	*/
	
//	echo "<BR>total count rows ".$total_count_rows."<BR>";
//	echo "total pages ".$total_pages."<BR>";
//	echo "page show count ".$pages_show_count."<BR>";
//	echo "Current page ".$current_page."<BR>";
	
	$pager_bottom_no = "";
	$last_page = "";
	$page_no_links = "";
	

	
	if(($pages_show_count % 2) == 1 )
	{
		
		
			
					for($i = 0; $i <= $total_pages-1; $i++)
					{
						if($i > $pages_show_count -1)
						{
							
							break;
						}
						if($current_page == ($current_page + $i))
						{
							$active_page = "active";
						}
						else
						{
							$active_page = "";
						}
						$_page_no = "";
						$page_no_links_front = "";
						if( ($current_page + $i) > $total_pages  )
						{
							$ctr_back = ($current_page + $i ) - $total_pages;
							$_page_no = $current_page - $ctr_back;
							$page_no_links = "<li class='page-item $active_page'><a class='page-link' href='?$url&pageno=".$_page_no."&custom_pagination_php=1'>".$_page_no."</a></li>".$page_no_links;
							
					
						}
						else 
						{
							  $_page_no = $current_page  +  $i;
							$page_no_links  .= "<li class='page-item $active_page'><a class='page-link' href='?$url&pageno=".$_page_no."&custom_pagination_php=1'>".$_page_no."</a></li>";
						
						}
					
						//	 echo $i." index<BR>";
						//	 echo $_page_no." page no<BR>";
					   //	 echo $current_page." current page<BR>";
					
						
						$active_page = "";
					}
	
		
			if($current_page == 1)
			{
				$previous_link = "";
				$previous_page = "#";
				$first_page = "";
				$next_page = "<li class='page-item '>
					  <a class='page-link' href='?$url&pageno=".($current_page+1)."&custom_pagination_php=1' tabindex='-1'>Next</a>
					  </li>";
				
			}
			else
			{
				$previous_link = "<li class='page-item '>
			  <a class='page-link' href='?$url&pageno=".($current_page-1)."&custom_pagination_php=1' tabindex='-1'>Previous</a>
			  </li>";
				$first_page = "";
				$next_page = "";

			}

			if($total_pages > $pages_show_count)
			{

				if($current_page == $total_pages)
				{
					$first_page = "<li class='page-item'>
			  				<a class='page-link' href='?$url&pageno=1&custom_pagination_php=1'>1&laquo;</a>
							</li>";
					$last_page = "";
					$next_page = "";
					
				}
				else if($current_page  == 1)
				{
					$first_page = "";
					$previous_page = "";
					$last_page = "<li class='page-item'>
			  				<a class='page-link' href='?$url&pageno=".$total_pages."&custom_pagination_php=1'>&raquo;$total_pages</a>
							</li>";
						$next_page = "<li class='page-item '>
					  <a class='page-link' href='?$url&pageno=".($current_page+1)."&custom_pagination_php=1' tabindex='-1'>Next</a>
					  </li>";
				}
				else if($current_page  < $total_pages)
				{
					$first_page = "<li class='page-item'>
			  				<a class='page-link' href='?$url&pageno=1&custom_pagination_php=1'>1&laquo;</a>
							</li>";
					$last_page = "<li class='page-item'>
			  				<a class='page-link' href='?$url&pageno=".$total_pages."&custom_pagination_php=1'>&raquo;$total_pages</a>
							</li>";
						$next_page = "<li class='page-item '>
					  <a class='page-link' href='?$url&pageno=".($current_page+1)."&custom_pagination_php=1' tabindex='-1'>Next</a>
					  </li>";
				}
				else
				{
					
				}

			}
		
			$pager_bottom_no = "<nav aria-label='Page navigation'>
		  <ul class='pagination justify-content-end'>
			$first_page
			$previous_link
			$page_no_links
			$next_page
			$last_page
			
		  </ul>
		</nav>";
		if($total_pages == 0)
		{
			$pager_bottom_no = "";
		}
		
	}
	else
	{
		echo "page show count not odd number or  > = 3 ";
	}
	

	return $pager_bottom_no;
	
}

function run($command) {
    $command .= ' 2>&1';
    $handle = popen($command, 'r');
    $log = '';

    while (!feof($handle)) {
        $line = fread($handle, 1024);
        $log .= $line;
    }

    pclose($handle);
    return $log;
}
/*
function ServiceOnline($ip, $port = 3389) {
    $rdp_sock = @fsockopen($ip, $port, null, null, 5); // 5 sec timeout so that it doesn't hang for a whole minute if not available
    if (!$rdp_sock) {
        return false;
    } else {
        fclose($rdp_sock);
        return true;
    }
}*/
function ping($host,$port=3389,$timeout=1)
{
        $fsock = @fsockopen($host, $port, $errno, $errstr, $timeout);
        if ( ! $fsock )
        {
                return FALSE;
        }
        else
        {
                return TRUE;
        }
}
function ping_scan($host,$port=80,$timeout=1)
{
        $fsock = @fsockopen($host, $port, $errno, $errstr, $timeout);
        if ( ! $fsock )
        {
                return FALSE;
        }
        else
        {
                return TRUE;
        }
}
function forceDownLoad($filename)

{


/*
    header("Pragma: public");

    header("Expires: 0"); // set expiration time

    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	
	header("Content-Type: application/text/x-vCard");



    header("Content-Disposition: attachment; filename=".basename($filename).";");

    header("Content-Transfer-Encoding: binary");

    header("Content-Length: ".filesize($filename));



    @readfile($filename);

    exit(0);
*/
	
header("Content-Type: application/force-download");
header("Content-Type: application/octet-stream");
header("Content-Type: application/download");
    readfile($filename); //show)ing the path to the server where the file is to be download
    exit;
}


class ldap_login{


		public function ldap_loginAccount($domain, $adserver, $username, $pass){
			global $db;
		//	$adServer = "ldap://petsvr1100.petcad1100";
			$adServer = "ldap://$adserver.$domain";

			$ldap = ldap_connect($adServer);
			$ldaprdn = $domain . "\\" . $username;

			ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
			ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);
			$bind = @ldap_bind($ldap, $ldaprdn, $pass);
			if ($bind) {
				$filter="(sAMAccountName=$username)";
				$result = ldap_search($ldap,"dc=$domain",$filter);
				ldap_sort($ldap,$result,"sn");
				$info = ldap_get_entries($ldap, $result);

				for ($i=0; $i<$info["count"]; $i++){
				 /*   $cn	= $info[$i]["cn"][0];
					$firstname = $info[$i]["givenname"][0];
					$middlename = $info[$i]["initials"][0];
					$lastname = $info[$i]["sn"][0];
					$mailing = $info[$i]["mail"][0];
					$ldap_displayname = $info[$i]["displayname"][0];
					$ldap_department = $info[$i]["department"][0];
				  */
					//$dept = $info[$i]["department"][0];
					//@ldap_close($ldap);

					}

				return($username);



			   }else {


					return "false";

					//$msg = "Invalid email address / password";
					//echo $msg;
						}

		}

	}
class TELNET
{
  private $host;
  private $name;
  private $pass;
  private $port;
  private $connected;
  private $connect_timeout;
  private $stream_timetout;

  private $socket;

  public function TELNET()
  {
    $this->port = 23;
    $this->connected = false;         // connected?
    $this->connect_timeout = 10;      // timeout while asking for connection
    $this->stream_timeout = 380000;   // timeout between I/O operations
  }

  public function __destruct()
  {
    if($this->connected) { fclose($this->socket); }
  }

  // Connects to host
  // @$_host - addres (or hostname) of host
  // @$_user - name of user to log in as
  // $@_pass - password of user
  //
  // Return: TRUE on success, other way function will return error string got by fsockopen()
  public function Connect($_host, $_user, $_pass)
  {
    // If connected successfully
    if( ($this->socket = @fsockopen($_host, $this->port, $errno, $errorstr, $this->connect_timeout)) !== FALSE )
    {
      $this->host = $_host;
      $this->user = $_user;
      $this->pass = $_pass;

      $this->connected = true;

      stream_set_timeout($this->socket, 0, 380000);
      stream_set_blocking($this->socket, 1);

      return true;
    }
    // else if coulnt connect
    else return $errorstr;
  }


  // LogIn to host
  //
  // RETURN: will return true on success, other way returns false
  public function LogIn()
  {
    if(!$this->connected) return false;

    // Send name and password
    $this->SendString($this->user, true);
    $this->SendString($this->pass, true);

    // read answer
    $data = $this->ReadTo(array('#'));

    // did we get the prompt from host?
    if( strtolower(trim($data[count($data)-1])) == strtolower($this->host).'#' ) return true;
    else return false;
  }


  // Function will execute command on host and returns output
  //
  // @$_command - command to be executed, only commands beginning with "show " can be executed, you can change this by adding
  //              "true" (bool type) as the second argument for function SendString($command) inside this function (3rd line)
  //
  function GetOutputOf($_command)
  {
    if(!$this->connected) return false;

    $this->SendString($_command);

    $output = array();
    $work = true;

    //
    // Read whole output
    //
    // read_to( array( STRINGS ) ), STRINGS are meant as possible endings of outputs
    while( $work && $data = $this->ReadTo( array("--More--","#") ) )
    {
      // CHeck wheter we actually did read any data
      $null_data = true;
      foreach($data as $line)
      {
        if(trim($line) != "") {$null_data = false;break;}
      }
      if($null_data) { break;}

      // if device is paging output, send space to get rest
      if( trim($data[count($data)-1]) == '--More--')
      {
        // delete line with prompt (or  "--More--")
        unset($data[count($data)-1]);

        // if second line is blank, delete it
        if( trim($data[1]) == '' ) unset($data[1]);
        // If first line contains send command, delete it
        if( strpos($data[0], $_command)!==FALSE ) unset($data[0]);

        // send space
        fputs($this->socket, " ");
      }

      // ak ma vystup max dva riadky
      // alebo sme uz nacitali prompt
      // IF we got prompt (line ending with #)
      // OR string that we've read has only one line
      //    THEN we reached end of data and stop reading
      if( strpos($data[count($data)-1], '#')!==FALSE /* || (count($data) == 1 && $data[0] == "")*/  )
      {
        // delete line with prompt
        unset($data[count($data)-1]);

        // if second line is blank, delete it
        if( trim($data[1]) == '' ) unset($data[1]);
        // If first line contains send command, delete it
        if( strpos($data[0], $_command)!==FALSE ) unset($data[0]);

        // stop while cyclus
        $work = false;
      }

      // get rid of empty lines at the end
      for($i = count($data)-1; $i>0; $i--)
      {
        if(trim($data[$i]) == "") unset($data[$i]);
        else break;
      }

      // add new data to $output
      foreach($data as $v)
      { $output[] = $v; }
    }

    // return output
    return $output;
  }


  // Read from host until occurence of any index from $array_of_stops
  // @array_of_stops - array that contains strings of texts that may be at the end of output
  // RETURNS: output of command as array of lines
  function ReadTo($array_of_stops)
  {
    $ret = array();
    $max_empty_lines = 3;
    $count_empty_lines = 0;

    while( !feof($this->socket) )
    {
      $read = fgets($this->socket);
      $ret[] = $read;

      //
      // Stop reading after (int)"$max_empty_lines" empty lines
  //
      if(trim($read) == "")
      {
        if($count_empty_lines++ > $max_empty_lines) break;
      }
      else $count_empty_lines = 0;

      //
      // Does last line of readed data contain any of "Stop" strings ??
      $found = false;
      foreach($array_of_stops AS $stop)
      {
        if( strpos($read, $stop) !== FALSE ) { $found = true; break; }
      }
      // If so, stop reading
      if($found) break;
    }

    return $ret;
  }



  // Send string to host
  // If force is set to false (default), function sends to host only strings that begins with "show "
  //
  // @$string - command to be executed
  // @$force - force command? Execute if not preceeded by "show " ?
  // @$newLine - append character of new line at the end of command?
  function SendString($string, $force=false, $newLine=true)
  {
    $t1 = microtime(true);
    $string = trim($string);

    // execute only strings that are preceded by "show"
    // and execute only one command (no new line characters) !
    if(!$force && strpos($string, 'show ') !== 0 && count(explode("\n", $string)) == 1)
    {
      return 1;
    }


    if($newLine) $string .= "\n";
    fputs($this->socket, $string);

    $t2 = microtime(true);
  }

}

function hyphenate($str,$position) {
    return implode("-", str_split($str, $position));
}
function pingAddress($ip) {    
    
    $pingresult = exec("C:\Windows\System32\PING -n 1 $ip", $outcome, $status);
    
    if ($status == 0 ) {
   //     echo "<i class='fa fa-check-circle' style='font-size:20px;color:green'></i>";
        $status = "";
    } 
    else {
      //  echo "<i class='fa fa-times-circle' style='font-size:20px;color:red'></i>";
        $status = "";
    }  
   return $status;}

?>