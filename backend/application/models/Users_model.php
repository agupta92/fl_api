<?php

class Users_model extends CI_Model {
	public $db1;
	public function __construct() {
		parent::__construct();

	}

	public function set_User($user_name,$user_email,$skype,$contact_no,$pass,$linkedin,$github,$stackoverflow,$degree,$user_college,$user_type) {
		$now = date("Y-m-d H:i:s");
		$db1 = $this -> load -> database('users', TRUE);
		$queryUserDetail = "INSERT INTO `user_details`(`user_id`, `user_name`, `user_email`, `user_skype_id`, `user_contact_no`, `user_password`, `user_linkedin`, `user_github`, `user_stackoverflow`, `user_degree`, `user_college`, `user_type`, `created_at`, `updated_at`) VALUES ('DEFAULT','".$user_name."','".$user_email."','".$skype."','".$contact_no."','".$pass."','".$linkedin."','".$github."','".$stackoverflow."','".$degree."','".$user_college."','".$user_type."','".$now."','".$now."')";
		$query = $db1 -> query($queryUserDetail);
		if (!$query) {
			$result['call'] = array('success' => true, 'code' => 0, 'message' => 'Nopes');
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

	public function get_assoc_companies($sessionId) {
		$db1 = $this -> load -> database('users', TRUE);
		$queryUserDetail = "select user_type,ref_id from user_details where session_id ='" . $sessionId . "'";
		$queryUserDetail = $db1 -> query($queryUserDetail);
		$queryUserDetailCount = $queryUserDetail -> num_rows();
		if ($queryUserDetailCount <= 0) {
			$result['call'] = array('success' => false, 'code' => 1, 'message' => 'nothing found');
			$result['call']['meta'] = array('total' => 0);
			$result['call']['response'] = array();
			return $result;
		}
		$queryUserResult = ($queryUserDetail -> result());
		$sqlSkills;
		$ref_id = $queryUserResult[0] -> ref_id;
		if ($queryUserResult[0] -> user_type == "professional") {
			$sqlSkills = "select user_professional.current_skills,companies_aspire from user_professional where user_professional.reference_id='" . $ref_id . "'";
		} else if ($queryUserResult[0] -> user_type == "student") {
			$sqlSkills = "select user_student.current_skills,companies_aspire from user_student where user_student.reference_id='" . $ref_id . "'";

		}
		$querySkills = $db1 -> query($sqlSkills);
		$temp = $querySkills -> result();
		if($temp[0] -> current_skills != ""){
			$skillsArray = (explode('|', $temp[0] -> current_skills));
		}else{
			$result['call'] = array('success' => false, 'code' => 2, 'message' => 'something went wrong');
			$result['call']['meta'] = array('total' => 0);
			$result['call']['response'] = array();
			return $result;
		}
		if($temp[0]->companies_aspire != ""){
			$aspiringcompanyarray = explode('|',$temp[0]->companies_aspire);
		}
		
		$skillsWhere = "";
		$skill_token = "";
		$count = 0;
		$loop = 1;
		while ($count <= 0) {
			if($loop > count($skillsArray)){
				break;
			}
			shuffle($skillsArray);
			$skill_token = "";
			if (count($skillsArray)-1 > 2) {
				for ($i = 0; $i < count($skillsArray) ; $i++) {
					if(strpos($skillsArray[$i], " ") !== false){
						$tempskill = explode(' ', $skillsArray[$i]);
						shuffle($tempskill);
						foreach($tempskill as $value){
							array_push($skillsArray, $value);
						}
						continue;
					}
					
					$skill_token .= " skill_token='" . $skillsArray[$i] . "' OR";
				}
			} else {
				foreach ($skillsArray as $value) {
					$skill_token .= " skill_token='" . $value . "' OR";
				}
			}
			$loop++;
			$skill_token = rtrim($skill_token, "' OR");
			$sql = "Select a.stan_company, count(distinct case when ".$skill_token."' then a.JD end) as qualifier,(count(distinct case when ".$skill_token."' then a.JD end)/count(distinct a.JD)) as aukat from search_pro a, (Select stan_company, total_people from search_pro where ".$skill_token."' group by 1 order by 2 DESC) b where a.stan_company=b.stan_company group by 1 having qualifier>3 order by 3,2 DESC LIMIT 15";
			//var_dump($sql);
			$query = $this -> db -> query($sql);
			$count = $query -> num_rows();
		}
		if ($count == 0) {
			$result['call'] = array('success' => false, 'code' => 1, 'message' => 'nothing found');
			$result['call']['meta'] = array('total' => 0);
			$result['call']['response'] = array();
		} else if ($count > 0) {
			$result['call'] = array('success' => true, 'code' => 0, 'message' => 'null');			
			$countLooper = 0;
			foreach ($query->result() as $row) {
				$key = array_search($row -> stan_company, $aspiringcompanyarray);
				if (false !== $key)
				{
				continue;
				}
				$result['call']['response'][$countLooper]['company'] = $row -> stan_company;
				$result['call']['response'][$countLooper]['logo'] = 'http://static-images.bloomigo.co.in/company-logos/' . str_replace(' ', '-', strtolower(trim($row -> stan_company))) . '.png';
				$result['call']['response'][$countLooper]['aukat'] = $row -> aukat;
				$result['call']['response'][$countLooper]['qualifier'] = $row -> qualifier;
				$countLooper++;
			}
			$result['call']['meta'] = array('total' => $countLooper);
		} else {
			$result['call'] = array('success' => false, 'code' => 2, 'message' => 'something went wrong');
			$result['call']['meta'] = array('total' => 0);
			$result['call']['response'] = array();
		}
		return $result;
	}

	public function get_assoc_skills($sessionId) {//var_dump($sessionId);
		$db1 = $this -> load -> database('users', TRUE);
		$queryUserDetail = "select user_type,ref_id from user_details where session_id ='" . $sessionId . "'";
		$queryUserDetail = $db1 -> query($queryUserDetail);
		$queryUserDetailCount = $queryUserDetail -> num_rows();
		if ($queryUserDetailCount <= 0) {
			$result['call'] = array('success' => false, 'code' => 1, 'message' => 'nothing found');
			$result['call']['meta'] = array('total' => 0);
			$result['call']['response'] = array();
			return $result;
		}
		$queryUserResult = ($queryUserDetail -> result());
		$sqlCompanies;
		$ref_id = $queryUserResult[0] -> ref_id;
		if ($queryUserResult[0] -> user_type == "professional") {
			$sqlCompanies = "select user_professional.companies_aspire,user_professional.current_skills from user_professional where user_professional.reference_id='" . $ref_id . "'";
		} else if ($queryUserResult[0] -> user_type == "student") {
			$sqlCompanies = "select user_student.companies_aspire,user_student.current_skills from user_student where user_student.reference_id='" . $ref_id . "'";

		}
		$queryCompanies = $db1 -> query($sqlCompanies);
		$temp = $queryCompanies -> result();
		if($temp[0] -> companies_aspire != ""){
			$CompaniesArray = (explode('|', $temp[0] -> companies_aspire));
		}else{
			$result['call'] = array('success' => false, 'code' => 2, 'message' => 'something went wrong');
			$result['call']['meta'] = array('total' => 0);
			$result['call']['response'] = array();
			return $result;
		}
		if($temp[0]->current_skills != ""){
			$currentskillsarray = explode('|',$temp[0]->current_skills);
		}
		$CompaniesWhere = "";
		$count = 0;
		$looper =0;
		while ($count <= 0) {
			if ($looper > count($CompaniesArray)){
				break;
			}
			shuffle($CompaniesArray);
			$Companies_token = "";
			if (count($CompaniesArray) > 2) {
				for ($i = 0; $i < count($CompaniesArray) / 2; $i++) {
					$Companies_token .= " stan_company='" . $CompaniesArray[$i] . "' OR";
				}
			} else {
				foreach ($CompaniesArray as $value) {
					$Companies_token .= " stan_company='" . $value . "' OR";
				}
			}
			$looper++;
			$Companies_token = rtrim($Companies_token, "' OR");
			$sql = "Select skill_token as skill, count(*) as freq  from search_pro where " . $Companies_token . "' group by 1 order by 2 DESC  LIMIT 15";
			//var_dump($sql);
			$query = $this -> db -> query($sql);
			$count = $query -> num_rows();
			//$count=3;
		}
		if ($count == 0) {
			$result['call'] = array('success' => false, 'code' => 1, 'message' => 'nothing found');
			$result['call']['meta'] = array('total' => 0);
			$result['call']['response'] = array();
		} else if ($count > 0) {
			$result['call'] = array('success' => true, 'code' => 0, 'message' => 'null');
			$countLooper = 0;
			foreach ($query->result() as $row) {
				$key = array_search($row -> skill, $currentskillsarray);
				if (false !== $key)
				{
				continue;
				}
				$result['call']['response'][$countLooper]['skill'] = $row -> skill;

				$result['call']['response'][$countLooper]['freq'] = $row -> freq;

				$countLooper++;
			}
			$result['call']['meta'] = array('total' => $countLooper);
		} else {
			$result['call'] = array('success' => false, 'code' => 2, 'message' => 'something went wrong');
			$result['call']['meta'] = array('total' => 0);
			$result['call']['response'] = array();
		}
		return $result;
	}

	public function get_assoc_jd($sessionId) {//var_dump($sessionId);
		$db1 = $this -> load -> database('users', TRUE);
		$queryUserDetail = "select user_type,ref_id from user_details where session_id ='" . $sessionId . "'";
		$queryUserDetail = $db1 -> query($queryUserDetail);
		$queryUserDetailCount = $queryUserDetail -> num_rows();
		 
		if ($queryUserDetailCount <= 0) {
			$result['call'] = array('success' => false, 'code' => 1, 'message' => 'nothing found');
			$result['call']['meta'] = array('total' => 0);
			$result['call']['response'] = array();
			return $result;
		}
		$queryUserResult = ($queryUserDetail -> result());
		$sqlCompanies;
		$ref_id = $queryUserResult[0] -> ref_id;
		
		if ($queryUserResult[0] -> user_type == "professional") {
			$sqlCompanies = "select user_professional.companies_aspire from user_professional where user_professional.reference_id='" . $ref_id . "'";
		} else if ($queryUserResult[0] -> user_type == "student") {
			$sqlCompanies = "select user_student.companies_aspire from user_student where user_student.reference_id='" . $ref_id . "'";

		}
		$queryCompanies = $db1 -> query($sqlCompanies);
		
		$temp = $queryCompanies -> result();
		
		if($temp[0] -> companies_aspire != ""){
			$CompaniesArray = (explode('|', $temp[0] -> companies_aspire));
			
		}else{
			$result['call'] = array('success' => false, 'code' => 2, 'message' => 'something went wrong');
			$result['call']['meta'] = array('total' => 0);
			$result['call']['response'] = array();
			return $result;
		}
		$CompaniesWhere = "";
		$count = 0;
		$counter=0;
		while ($count <= 0) {
			shuffle($CompaniesArray);
			$Companies_token = "";
			if (count($CompaniesArray) > 2) {
				for ($i = 0; $i < count($CompaniesArray) / 2; $i++) {
					$Companies_token .= " stan_company='" . $CompaniesArray[$i] . "' OR";
				}
			} else {
				foreach ($CompaniesArray as $value) {
					$Companies_token .= " stan_company='" . $value . "' OR";
				}
			}

			$Companies_token = rtrim($Companies_token, "' OR");
			
			$sql = "Select a.JD, Format(b.tent_sal,0) as tent_sal , a.total_people from (Select pro_s_no, JD, total_people from search_pro where stan_company=" . $Companies_token . "' group by 1) a, available_salaries b where a.pro_s_no=b.pro_s_no group by 1 order by 3 DESC LIMIT 10";
			//var_dump($sql);
			$query = $this -> db -> query($sql);
			//var_dump($query->result());
			$count = $query -> num_rows();
			$counter++;
			if($counter ==3){ 
				break;
			}
			//$count=3;
		}
		if ($count == 0) {
			$result['call'] = array('success' => false, 'code' => 1, 'message' => 'nothing found');
			$result['call']['meta'] = array('total' => 0);
			$result['call']['response'] = array();
		} else if ($count > 0) {
			$result['call'] = array('success' => true, 'code' => 0, 'message' => 'null');
			$result['call']['meta'] = array('total' => $count);
			$countLooper = 0;
			foreach ($query->result() as $row) {
				$result['call']['response'][$countLooper]['jd'] = $row -> JD;
				$result['call']['response'][$countLooper]['total_people'] = $row -> total_people;
				$result['call']['response'][$countLooper]['sal'] = $row -> tent_sal;

				$countLooper++;
			}
		} else {
			$result['call'] = array('success' => false, 'code' => 2, 'message' => 'something went wrong');
			$result['call']['meta'] = array('total' => 0);
			$result['call']['response'] = array();
		}
		return $result;
	}
	
	public function set_student_details($sessionId, $curr_colg, $curr_branch, $curr_skills, $company_aspire) {	$curr_colg = urldecode($curr_colg);
		$curr_branch = urldecode($curr_branch);
		$curr_skills = urldecode($curr_skills);
		$company_aspire = urldecode($company_aspire);

		$contentDb = $this -> load -> database('users', TRUE);
		$queryUserDetail = "select user_type,ref_id from user_details where session_id ='" . $sessionId . "'";
		$queryUserDetail = $contentDb -> query($queryUserDetail);
		$queryUserDetailCount = $queryUserDetail -> num_rows();
		if ($queryUserDetailCount <= 0) {
			$result['call'] = array('success' => false, 'code' => 1, 'message' => 'nothing found');
			$result['call']['meta'] = array('total' => 0);
			$result['call']['response'] = array();
			return $result; 
		}
		$queryUserResult = ($queryUserDetail -> result());
		$refId = $queryUserResult[0] -> ref_id;

		//var_dump($curr_branch);
		$query = "";
		if ($refId != "null" && $curr_colg != "null" && $curr_branch != "null" && $curr_skills == "null" && $company_aspire == "null") {
			$query = "UPDATE `user_student` SET `current_college`='" . $curr_colg . "',`current_branch`='" . $curr_branch . "',`step`=1 WHERE `reference_id`='".$refId."'";
			//$query = "UPDATE `user_student` SET `current_college`='".$curr_colg."',`current_branch`='".$curr_branch."',`current_skills`='".$curr_skills."',`companies_aspire`='".$company_aspire."' WHERE `reference_id`=$refId";
		} else if ($refId != "null" && $curr_colg == "null" && $curr_branch == "null" && $curr_skills != "null" && $company_aspire == "null") {
			$query = "UPDATE `user_student` SET `current_skills`='" . urldecode($curr_skills) . "',`step`=2 WHERE `reference_id`='".$refId."'";
		} else if ($refId != "null" && $curr_colg == "null" && $curr_branch == "null" && $curr_skills == "null" && $company_aspire != "null") {
			$query = "UPDATE `user_student` SET `companies_aspire`='" . urldecode($company_aspire) . "',`step`=3 WHERE `reference_id`='".$refId."'";
		}
		//var_dump($query);
		$query = $contentDb -> query($query);
		return $result['call'] = array('success' => true, 'code' => 0, 'message' => 'Data Updated');
	}

	public function set_professional_details($sessionId, $curr_commpany, $curr_jd, $curr_skills, $company_aspire) {	$curr_commpany = urldecode($curr_commpany);
		$curr_jd = urldecode($curr_jd);
		$curr_skills = urldecode($curr_skills);
		$company_aspire = urldecode($company_aspire);

		$contentDb = $this -> load -> database('users', TRUE);
		$queryUserDetail = "select user_type,ref_id from user_details where session_id ='" . $sessionId . "'";
		$queryUserDetail = $contentDb -> query($queryUserDetail);
		$queryUserDetailCount = $queryUserDetail -> num_rows();
		if ($queryUserDetailCount <= 0) {
			$result['call'] = array('success' => false, 'code' => 1, 'message' => 'nothing found');
			$result['call']['meta'] = array('total' => 0);
			$result['call']['response'] = array();
			return $result;
		}
		$queryUserResult = ($queryUserDetail -> result());
		$refId = $queryUserResult[0] -> ref_id;

		$contentDb = $this -> load -> database('users', TRUE);
		$query = "";
		
		$queryCheckRefID = "select * from user_professional where reference_id ='".$refId."'";
		$queryCheckRefID = $contentDb -> query($queryCheckRefID);
		$countCheckRefId = $queryCheckRefID-> num_rows();
		if($countCheckRefId ==0){
		$queryProUpdate = "INSERT INTO `user_professional`(`reference_id`) VALUES ('" . $refId . "')";
		$query = $contentDb -> query($queryProUpdate);
		
		$queryProUpdate1 = "UPDATE `user_details` SET `user_type`='professional' WHERE `ref_id`='".$refId."'";
		$query1 = $contentDb -> query($queryProUpdate1);

		$queryDeleteFromStudent = "DELETE FROM `user_student` WHERE `reference_id`='" . $refId . "'";
		$query = $contentDb -> query($queryDeleteFromStudent);
		}

		if ($refId != "null" && $curr_commpany != "null" && $curr_jd != "null" && $curr_skills == "null" && $company_aspire == "null") {
			$query = "UPDATE `user_professional` SET `current_company`='" . $curr_commpany . "',`current_jd`='" . $curr_jd . "',`step`=1 WHERE `reference_id`='".$refId."'";
			//$query = "UPDATE `user_student` SET `current_college`='".$curr_colg."',`current_branch`='".$curr_branch."',`current_skills`='".$curr_skills."',`companies_aspire`='".$company_aspire."' WHERE `reference_id`=$refId";
		} else if ($refId != "null" && $curr_commpany == "null" && $curr_jd == "null" && $curr_skills != "null" && $company_aspire == "null") {
			$query = "UPDATE `user_professional` SET `current_skills`='" . urldecode($curr_skills) . "',`step`=2 WHERE `reference_id`='".$refId."'";
		} else if ($refId != "null" && $curr_commpany == "null" && $curr_jd == "null" && $curr_skills == "null" && $company_aspire != "null") {
			$query = "UPDATE `user_professional` SET `companies_aspire`='" . urldecode($company_aspire) . "',`step`=3 WHERE `reference_id`='".$refId."'";
		}

		$query = $contentDb -> query($query);
		//var_dump($query);
		return $result['call'] = array('success' => true, 'code' => 0, 'message' => 'null');
		;
	}

}
?>