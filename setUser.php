<?php
include ('database.php');
$now = date("Y-m-d H:i:s");
$user_name = $_POST['user_name'];
$user_email = $_POST['user_email'];
$skype = $_POST['skype'];
$contact_no = $_POST['contact_no'];;
$pass = md5($_POST['pass']);
$linkedin = $_POST['linkedin'];
$github = $_POST['github'];
$stackoverflow = $_POST['stackoverflow'];
$degree = $_POST['degree'];
$user_college = $_POST['user_college'];
$user_type = $_POST['user_type'];

$queryUserDetail = "INSERT INTO `user_details`(`user_id`, `user_name`, `user_email`, `user_skype_id`, `user_contact_no`, `user_password`, `user_linkedin`, `user_github`, `user_stackoverflow`, `user_degree`, `user_college`, `user_type`, `created_at`, `updated_at`) VALUES ('DEFAULT','".$user_name."','".$user_email."','".$skype."','".$contact_no."','".$pass."','".$linkedin."','".$github."','".$stackoverflow."','".$degree."','".$user_college."','".$user_type."','".$now."','".$now."')";
$query = $mysqli->query($queryUserDetail );
$session_string = md5($user_email.$now);

$sql_session = "INSERT INTO `user_session`(`user_session_id`, `user_id`, `user_session`, `is_active`, `created_at`, `updated_at`) VALUES ('DEFAULT',$mysqli->insert_id,'$session_string','Yes','$now','$now')";
$query = $mysqli->query($sql_session );

if (!$query) {
	echo json_encode(array('m'=>'Data Not Saved','s'=>0,'d'=>array()));
} else if ($query) {
	echo json_encode(array('m'=>'Data Saved','s'=>1,'d'=>array('sessionId'=> $session_string)));
} else {
	echo json_encode(array('m'=>'Data Not Saved','s'=>2,'d'=>array()));
}
header('Content-Type: application/json');
echo json_encode($result);
?>