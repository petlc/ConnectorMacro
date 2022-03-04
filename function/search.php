<?php            
require_once 'core.php';
if (isset($_GET['term'])){
    
    $return_arr = array();
    $searchie = $_GET['term'];
    
    $search = new Employees();
    $search2 = new Employees();
    
 //   $search->query("Select * from emp_info where full_name like '%$searchie%' or pet_id like '%$searchie%' or id like '%$searchie%'");
    $search->query("SELECT emp_info.pet_id, emp_info.full_name, emp_info.department, emp_info.mobile_number ,  emp_email.email_account
                    FROM emp_info
                    LEFT JOIN emp_email
                    ON emp_info.pet_id = emp_email.email_pet_id
                    where emp_info.full_name like '%$searchie%' or emp_info.pet_id like '%$searchie%' or emp_info.mobile_number like '%$searchie%'");
    $search->execute();
    $row=$search->resultset();

        foreach($row as $rows){
           // $return_arr[] = $rows['full_name'];
                  
                 
             
           // $return_arr[] = $rows['full_name']." | ".$rows['department']." | ".$rows['pet_id'];
            $return_arr[] = $rows['full_name']." | ".$rows['department']." | ".$rows['pet_id']." | ".$rows['email_account']." | ".$rows['mobile_number'];
            
        }
    
    



    echo json_encode($return_arr);
}
?>
