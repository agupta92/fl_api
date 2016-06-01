<?php
/** Mysql Starts **/
    $host="localhost"; // Host name
    $username="bloomigo_search"; // Mysql username
    $password="9893044015"; // Mysql password
    $db_name="bloomigo_search"; // Database name
    // Connect to server and select database.
   $db = mysqli_connect("$host", "$username", "$password") or die("cannot connect");
mysqli_select_db($db,$db_name) or die("cannot select DB");
/** MySql Ends **/
function array_delete($array, $element) {
    return array_diff($array, [$element]);
}

/** Function Ends **/

header('Access-Control-Allow-Origin: *'); 
header("Access-Control-Expose-Headers: Access-Control-Allow-Origin");
header("HTTP/1.1 200 OK");
header('Content-Type: application/json');
if(empty($_GET)||!isset($_GET)){
            $x=0;
            $sql="SELECT s_no as id, input as name FROM search_v1 where type='company' ";
            //echo($sql);
            $result=mysqli_query($db,$sql);
            
            while($row = mysql_fetch_assoc($result)){
               $emparray['values'][$x]=$row;
                $x++;
            }
     
        $result=array('call'=>array('success'=>true,'code'=>0,'message'=>'null'));
        $result['call']['meta']=array('total'=>count($emparray));
        $result['call']['response']=$emparray;  
        echo(json_encode($result));
}else{
            
            $allCompany=explode('|',$_GET['company']);
            $condition='';
            foreach($allCompany as $singleCompany){
               $condition.=" AND input!='".$singleCompany."'";
            }

            $x=0;
            $sql="SELECT s_no as id, input as name FROM search_v1 where type='company' ".$condition;
            //echo($sql);
            $result=mysqli_query($db,$sql);
            while($row = mysql_fetch_assoc($result)){
               $emparray['values'][$x]=$row;
                $x++;
            }
     
        $result=array('call'=>array('success'=>true,'code'=>0,'message'=>'null'));
        $result['call']['meta']=array('total'=>count($emparray));
        $result['call']['response']=$emparray;  
        echo(json_encode($result));
}
?>