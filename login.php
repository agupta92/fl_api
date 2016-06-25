<?php
include ('database.php');
$password = md5($_GET['password']);
$user_email = $_GET['user_email'];
$sql_check_user = "select user_id from user_details where user_email='$user_email' AND user_password = '$password'";
$result = $mysqli->query($sql_check_user);
$now = date("Y-m-d H:i:s");
//var_dump($result);exit;
if($result->num_rows){
	$session_string = md5($user_email.$now);
	$sql_session = "INSERT INTO `user_session`(`user_session_id`, `user_id`, `user_session`, `is_active`, `created_at`, `updated_at`) VALUES ('DEFAULT',$mysqli->insert_id,'$session_string','Yes','$now','$now')";
	$query = $mysqli->query($sql_session );
	if ($query) {
		header('Content-Type: application/json');
		echo json_encode(array('m'=>'Login Successsful','s'=>1,'d'=>array('sessionId'=> $session_string)));
	}
} else {
	header('Content-Type: application/json');
	echo json_encode(array('m'=>'Username Password Invalid','s'=>1,'d'=>array()));
}
?>