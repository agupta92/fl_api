<?php

class feedback_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		
	}

	public function set_emailid($email) {
		
		$db1 = $this -> load -> database('feedback', TRUE);
		$sqlsverify = "select * from subscription where emailid ='". urldecode($email) . "'";
		$queyverify = $db1 -> query($sqlsverify);
		$count = $queyverify -> num_rows();
		$query=false;
		if($count==0){	
			$sql = "INSERT INTO `subscription` VALUES ('DEFAULT','none','" . urldecode($email) . "','Y')";			
			$query = $db1 -> query($sql);
		}
		//var_dump($query )
		//$count = $query -> num_rows();
		if (!$query) {
			$result['call'] = array('success' => true, 'code' => 0, 'message' => 'You have alredy been Subscribed');
			$result['call']['meta'] = array('total' => 0);
		} else if ($query) {
			$result['call'] = array('success' => true, 'code' => 0, 'message' => 'null');
			$result['call']['meta'] = array();
			$result['call']['response'] = array('message'=> 'Thank you for Subscribing');
		} else {
			$result['call'] = array('success' => false, 'code' => 2, 'message' => 'something went wrong');
			$result['call']['meta'] = array('total' => 0);
		}
		return $result;
	}
	
	public function set_emailidOnSignup($name, $email) {
		
		$db1 = $this -> load -> database('feedback', TRUE);
		$sqlsverify = "select * from subscription where emailid ='". urldecode($email) . "'";
		$queyverify = $db1 -> query($sqlsverify);
		$count = $queyverify -> num_rows();
		$query=false;
		if($count==0){	
			$sql = "INSERT INTO `subscription` VALUES ('DEFAULT','".$name."','" . urldecode($email) . "','Y')";			
			$query = $db1 -> query($sql);
		}
		//var_dump($query )
		//$count = $query -> num_rows();
		if (!$query) {
			$result['call'] = array('success' => true, 'code' => 0, 'message' => 'You have alredy been Subscribed');
			$result['call']['meta'] = array('total' => 0);
		} else if ($query) {
			$result['call'] = array('success' => true, 'code' => 0, 'message' => 'null');
			$result['call']['meta'] = array();
			$result['call']['response'] = array('message'=> 'Thank you for Subscribing');
		} else {
			$result['call'] = array('success' => false, 'code' => 2, 'message' => 'something went wrong');
			$result['call']['meta'] = array('total' => 0);
		}
		return $result;
	}
	
	public function send_mail_on_subcription($email){
		
		$email = urldecode($email);
		$this->load->library('sendgrid');
		$db = $this -> load -> database('feedback',TRUE);
		$sqlOnSubscritpion = "select * from mailformat where type='onsubscribing'";
		$queryOnSubscription = $db -> query($sqlOnSubscritpion);
		$result = $queryOnSubscription->result();
		//var_dump($result);
		$to = $email;
		$subject =  $result[0]->subject;
		$message = $result[0]->body;
		$message = str_replace("UNSUBSCRIBEDEMAIL",$email,$message);
		$toname = "User";
		$fromname = "Bloomigo";
		$from = "info@bloomigo.in";
		
		$sendgrid = $this->sendgrid->sendgrid_email($to,$subject,$message,$toname,$fromname,$from);
		//var_dump($sendgrid);
	}
	
	public function send_mail_on_signup($email,$name){
		
		$this->load->library('sendgrid');
		$db = $this -> load -> database('feedback',TRUE);
		$sqlOnSubscritpion = "select * from mailformat where type='onsignup'";
		$queryOnSubscription = $db -> query($sqlOnSubscritpion);
		$result = $queryOnSubscription->result();
		//var_dump($result);
		$to = $email;
		$subject =  $result[0]->subject;
		$message = $result[0]->body;
		$message = str_replace("NAME",$name,$message);
		$message = str_replace("UNSUBSCRIBEDEMAIL",$email,$message);
		$toname = $name;
		$fromname = "Bloomigo";
		$from = "info@bloomigo.in";
		
		$sendgrid = $this->sendgrid->sendgrid_email($to,$subject,$message,$toname,$fromname,$from);
		$result = "";
		if ($sendgrid) {
			$result['call'] = array('success' => true, 'code' => 0, 'message' => 'Mail Sent');		
		} 
		return $result;
	}
	
	public function send_mail_weekly($email){
		
		$this->load->library('sendgrid');
		$db_feedback = $this -> load -> database('feedback',TRUE);
		$sqlOnSubscritpion = "select * from mailformat where type='wd'";
		$queryOnSubscription = $db_feedback -> query($sqlOnSubscritpion);
		$result = $queryOnSubscription->result();
		
		//var_dump ($result);
		$subject =  $result[0]->subject;
		$message = $result[0]->body;
		$toname = "User";
		$fromname = "Bloomigo";
		$from = "no-reply@bloomigo.in";
		
		$sql1 = "SELECT  distinct(`emailid`) FROM `subscription` WHERE `status` = 'Y'";
		$query1 = $db_feedback -> query($sql1);
		
		
		$to = $email;
		$sendgrid = $this->sendgrid->sendgrid_email($to,$subject,$message,$toname,$fromname,$from);
		if ($sendgrid) {
			$result['call'] = array('success' => true, 'code' => 0, 'message' => 'Mail Sent');		
		} 
		return $result;
	
	}
	
	public function get_interview_request($email,$pno){
		
		$db1 = $this -> load -> database('feedback', TRUE);
		$sqlsverify = "select * from getinterview where email ='". $email . "'";
		$queyverify = $db1 -> query($sqlsverify);
		$count = $queyverify -> num_rows();
		$query=false;
		if($count==0){	
			$sqlsverify = "INSERT INTO `getinterview`(`id`, `email`, `pno`) VALUES ('default','".$email."',".$pno.")";			
			$query = $db1 -> query($sqlsverify);
		}	
		
		if (!$query) {
			$result['call'] = array('success' => true, 'code' => 0, 'message' => 'You have alredy been Subscribed');
			$result['call']['meta'] = array('total' => 0);
		} else if ($query) {
			$result['call'] = array('success' => true, 'code' => 0, 'message' => 'null');
			$result['call']['meta'] = array();
			$result['call']['response'] = array('message'=> 'Thank you for Registering');
		} else {
			$result['call'] = array('success' => false, 'code' => 2, 'message' => 'something went wrong');
			$result['call']['meta'] = array('total' => 0);
		}
		return $result;
	}

public function on_unsubscribed($email){
		
		$db1 = $this -> load -> database('feedback', TRUE);
		$sqlsverify = "select * from subscription where emailid ='". $email ."'";
		$queyverify = $db1 -> query($sqlsverify);
		$resulttemp = $queyverify->result();		
		$resullt;
		$query=false;
		if(!empty($resulttemp)){
			
			if($resulttemp[0]->status == 'Y'){	
				$sqlsverify = "UPDATE `subscription` SET `status`='N' WHERE `emailid`='".$resulttemp[0]->emailid."'";			
				//var_dump($sqlsverify);
				$query = $db1 -> query($sqlsverify);
				$query=true;
			}	
		}
		
		if (!$query) {
			$result['call'] = array('success' => true, 'code' => 0, 'message' => 'Your data is not Present');
			$result['call']['meta'] = array('total' => 0);
			$result['call']['response'] = array('message'=> 'You data is not Present');
		} else if ($query) {
			$result['call'] = array('success' => true, 'code' => 0, 'message' => 'null');
			$result['call']['meta'] = array();
			$result['call']['response'] = array('message'=> 'Your are Unsubscribed');
		} else {
			$result['call'] = array('success' => false, 'code' => 2, 'message' => 'something went wrong');
			$result['call']['meta'] = array('total' => 0);
			$result['call']['response'] = array('message'=> 'Something went wrong');
		}
		return $result;
	}

	public function set_contactus($name, $email, $comment) {
		$comment = urldecode($comment);
		$name = urldecode($name);
		$email = urldecode($email);
		$db1 = $this -> load -> database('feedback', TRUE);
		$this->load->library('sendgrid');	
		$sql = "INSERT INTO `contactus`( `name`, `email`, `comment`) VALUES ('".$name."','".$email."','".$comment."')";			
		$query = $db1 -> query($sql);
		
		$to = "info@bloomigo.in";
		$subject = "Contact Us";
		$message = "<b>Name:</b> ".$name. "<br><b>Email Id:</b> ".$email. "<br><b>Comment:</b> ".$comment;
		$toname = "Admin";
		$fromname = "Contact Us";
		$from = "admin@bloomigo.in";		
		$sendgrid = $this->sendgrid->sendgrid_email($to,$subject,$message,$toname,$fromname,$from);
		if (!$query) {
			$result['call'] = array('success' => true, 'code' => 0, 'message' => 'You have alredy been Subscribed');
			$result['call']['meta'] = array('total' => 0);
		} else if ($query) {
			$result['call'] = array('success' => true, 'code' => 0, 'message' => 'null');
			$result['call']['meta'] = array();
			$result['call']['response'] = array('message'=> 'Successful');
		} else {
			$result['call'] = array('success' => false, 'code' => 2, 'message' => 'something went wrong');
			$result['call']['meta'] = array('total' => 0);
		}
		return $result;
	}
	
	public function set_joinus($name, $email) {
		$email = urldecode($email);
		$db1 = $this -> load -> database('feedback', TRUE);
		$this->load->library('sendgrid');
		$sql = "INSERT INTO `joinus`( `name`, `email`) VALUES ('".$name."','".$email."')";
		//var_dump($sql);
		$query = $db1 -> query($sql);
		$to = "info@bloomigo.in";
		$subject = "Alert Info";
		$message = "<b>Name:</b> ".$name. "<br><b>Email Id:</b> ".$email;
		$toname = "Admin";
		$fromname = "Join Us";
		$from = "admin@bloomigo.in";		
		$sendgrid = $this->sendgrid->sendgrid_email($to,$subject,$message,$toname,$fromname,$from);	

		if (!$query) {
			$result['call'] = array('success' => true, 'code' => 0, 'message' => 'You have alredy been Subscribed');
			$result['call']['meta'] = array('total' => 0);
		} else if ($query) {
			$result['call'] = array('success' => true, 'code' => 0, 'message' => 'null');
			$result['call']['meta'] = array();
			$result['call']['response'] = array('message'=> 'Successful');
		} else {
			$result['call'] = array('success' => false, 'code' => 2, 'message' => 'something went wrong');
			$result['call']['meta'] = array('total' => 0);
		}
		return $result;
	}
	
}
?>