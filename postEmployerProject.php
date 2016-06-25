<?php
include ('database.php');
$now = date("Y-m-d H:i:s");
$project_name = $_POST['project_name'];
$project_desc = $_POST['project_desc'];
$project_technologies = $_POST['project_technologies'];
$time_required = $_POST['time_required'];
$amount = $_POST['amount'];
$session_id = $_POST['session_id'];
$sql_session = "select user_id from user_session where user_session='$session_id'";
$result = $mysqli->query($sql_session);
$count  = $result->num_rows;
if($count){
	$row = $result->fetch_array(MYSQLI_ASSOC);
	$user_id = $row["user_id"];
	$query_project_inset = "INSERT INTO `project_by_employer`(`project_id`, `project_name`, `project_desc`, `project_technologies`, `user_id`, `time_required`, `amount`, `created_by`, `created_at`, `updated_by`, `updated_at`) VALUES ('DEFAULT','".$project_name."','".$project_desc."','".$project_technologies."','".$user_id."','".$time_required."','".$amount."','".$user_id."','".$now."','".$user_id."','".$now."')";
	$query = $mysqli->query($query_project_inset );
	echo json_encode(array('m'=>'Data Saved','s'=>1,'d'=>array()));
} else {
	echo json_encode(array('m'=>'Data Not Saved','s'=>0,'d'=>array()));
}
header('Content-Type: application/json');
exit;
?>