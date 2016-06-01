<?php
class search_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	public function get_search() {
		$searchDb = $this -> load -> database('search', TRUE);
		$catArray = array('company', 'job', 'skill', 'industry');
		$checkArray = array();
		$emparray = array();
		// if (empty($_GET) || !isset($_GET)) {
			// $y = 0;

			foreach ($catArray as $type) {
				$sql = "SELECT s_no as id, input as name FROM search_v1 where type='" . $type . "' ";
				//echo($sql);
				$query = $searchDb-> query($sql); //mysql_query($sql);
				$result = $query->result();
				$emparray[$y]['category'] = $type;
				$x = 0;
				while ($row = mysql_fetch_assoc($result)) {
					$emparray[$y]['values'][$x] = $row;
					$x++;
				}
				$y++;
			}
			$result = array('call' => array('success' => true, 'code' => 0, 'message' => 'null'));
			$result['call']['meta'] = array('total' => count($emparray));
			$result['call']['response'] = $emparray;
			echo(json_encode($result));
		// } else {
			// $pastSql = '';
			// $z = 0;
			// foreach ($_GET as $key => $values) {
				// $catArray = array_delete($catArray, $key);
				// if ($z < 1) {
					// $pastSql = $key . "='" . $values . "' ";
				// } else {
					// $pastSql .= " and " . $key . "='" . $values . "' ";
				// }
				// $z++;
				// //var_dump($catArray);
		// }
			$y = 0;
			foreach ($catArray as $cat) {
				$sql = "SELECT s_no as id, " . $cat . " as name FROM search where " . $pastSql . " group by 2";
				$query = $searchDb -> query($sql);
				$result = $query->result();// mysql_query($sql);
				$emparray[$y]['category'] = $cat;
				$x = 0;
				while ($row = mysql_fetch_assoc($result)) {
					$emparray[$y]['values'][$x] = $row;
					$x++;
				}
				$y++;
			}

			$result = array('call' => array('success' => true, 'code' => 0, 'message' => 'null'));
			$result['call']['meta'] = array('total' => count($emparray));
			$result['call']['response'] = $emparray;
			echo(json_encode($result));
		
		return $result;
	}
		
		public function get_trends() {
			$searchDb = $this -> load -> database('search', TRUE);
			$sql = "select input,type as category from search_v1 order by hits desc LIMIT 10";
			$query = $searchDb->query($sql);
			$Result = $query-> result();
			foreach($Result as $temp){
				if($temp->category == 'job'){
					$temp->category = 'jobs';
				}
				if($temp->category == 'skill'){
					$temp->category = 'skills';
				}
				//var_dump($a);
			}
			$result = array('call' => array('success' => true, 'code' => 0, 'message' => 'null'));
			$result['call']['meta'] = array('total' => 10);
			$result['call']['response'] = $Result;
			return $result;
		}
		
		public function set_hits($type,$input) {
			$searchDb = $this -> load -> database('search', TRUE);
			$sql = "UPDATE `search_v1` SET `hits`= hits+1,`last_update`= now() WHERE input = '".$input."' and type='".$type."'";
			$query = $searchDb->query($sql);
			$result = array('call' => array('success' => true, 'code' => 0, 'message' => 'null'));
			$result['call']['meta'] = array('total' => 0);
			$result['call']['response'] = $query;
			return $result;
		}
		
		public function get_type($college, $branch) {
			$result = array('call' => array('success' => true, 'code' => 0, 'message' => 'null'));
			$searchDb = $this -> load -> database('search', TRUE);
			if($college == "undefined"){
				$sql = "SELECT  `type`, `UG`, `PG` FROM `search_v1` WHERE `input` ='".$branch."'";
				$query = $searchDb->query($sql);
				$result['call']['response'] = $query-> result();
				$result['call']['response'][0]->UG = (bool)$result['call']['response'][0]->UG;
				$result['call']['response'][0]->PG = (bool)$result['call']['response'][0]->PG;
				$count = $query->num_rows();
			} else if($branch == "undefined"){
				$sql = "SELECT  `type`, `UG`, `PG` FROM `search_v1` WHERE `input` ='".$college."'";
				$query = $searchDb->query($sql);
				$result['call']['response'] = $query-> result();
				$result['call']['response'][0]->UG = (bool)$result['call']['response'][0]->UG;
				$result['call']['response'][0]->PG = (bool)$result['call']['response'][0]->PG;
				$count = $query->num_rows();
			}else {			
				$sqlCollege = "SELECT   `UG`, `PG` FROM `search_v1` WHERE `input` ='".$college."' and type= 'college'";
				$queryCollege = $searchDb->query($sqlCollege);
				$ResultCollege = $queryCollege-> result();
				$count = $queryCollege->num_rows();				
				$sqlBranch = "SELECT  `UG`, `PG` FROM `search_v1` WHERE `input` ='".$branch."' and type= 'branch'";
				$queryBranch = $searchDb->query($sqlBranch);
				$ResultBranch = $queryBranch-> result();				
				$ResultCollege[0]->UG = (bool)$ResultCollege[0]->UG;
				$ResultCollege[0]->PG = (bool)$ResultCollege[0]->PG;
				$ResultBranch[0]->UG = (bool)$ResultBranch[0]->UG;
				$ResultBranch[0]->PG = (bool)$ResultBranch[0]->PG;				
				if($ResultCollege[0]->UG and $ResultBranch[0]->UG){
					$result['call']['response']['type'] = "college-branch";
					$result['call']['response']['UG'] = true;
				}else {
					$result['call']['response']['type'] = "college-branch";
					$result['call']['response']['UG'] = false;
				}
				if($ResultBranch[0]->UG and $ResultBranch[0]->PG){
					$result['call']['response']['PG'] = true;
				}else {
					$result['call']['response']['PG'] = false;
				}
			}
			$result['call']['meta'] = array('total' => $count);
			//$result['call']= $result;
			return $result;
		}
}
?>