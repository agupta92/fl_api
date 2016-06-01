<?php

class content_model extends CI_Model {

	public function __construct() {
		parent::__construct();


	}

	public function get_alumini_detail($alumniId) {//$query= $contentDb->query('SELECT alumni_name,alumni_photo FROM alumni where alumni_id ='.$alumniId);
		$contentDb = $this -> load -> database('content', TRUE);
		$query = $contentDb -> select('alumni_id,alumni.alumni_name,alumni.alumni_photo,alumni.hidename,alumni.id');
		$query = $contentDb -> from('alumni');
		$query = $contentDb -> where('alumni_id', $alumniId);
		$query = $contentDb -> get();

		$count = $query -> num_rows();
		if ($count == 0) {
			$result['call'] = array('success' => false, 'code' => 1, 'message' => 'nothing found');
			$result['call']['meta'] = array('total' => 0);
			$result['call']['response'] = array();
		} else if ($count > 0) {
			$result['call'] = array('success' => true, 'code' => 0, 'message' => 'null');
			$result['call']['meta'] = array('total' => $count);
			$countLooper=0;
			foreach ($query->result() as $row)
			{
				$result['call']['response'][$countLooper]['alumni_id']=$row->alumni_id;
				if($row->hidename == 'N'){
					$imageNumber = intval($row->id) % 4;
					$result['call']['response'][$countLooper]['alumni_name']='Anonymous';
					if ($imageNumber == 0){
						$result['call']['response'][$countLooper]['alumni_photo']= "http://static-images.bloomigo.co.in/common/Anonymous-3.png";
					}else {
						$result['call']['response'][$countLooper]['alumni_photo']= "http://static-images.bloomigo.co.in/common/Anonymous-".$imageNumber.".png";
					}
				} else{
					$result['call']['response'][$countLooper]['alumni_name']=$row->alumni_name;
					$result['call']['response'][$countLooper]['alumni_photo']= 'http://static-images.bloomigo.co.in/interviews/'.$row->alumni_photo;
				}
				$countLooper++;
			}

			$result['call']['response'] = $result['call']['response'];
		} else {
			$result['call'] = array('success' => false, 'code' => 2, 'message' => 'something went wrong');
			$result['call']['meta'] = array('total' => 0);
			$result['call']['response'] = array();
		}
		return $result;
	}

	public function get_alumini_timeline($alumniId) {//$query= $contentDb->query('SELECT alumni_name,alumni_photo FROM alumni where alumni_id ='.$alumniId);
		$contentDb = $this -> load -> database('content', TRUE);
		$query = $contentDb -> select('timeline.org,timeline.pos,timeline.move_no,timeline.date,timeline.type');
		$query = $contentDb -> from('timeline');
		$query = $contentDb -> where('alumni_alumni_id', $alumniId);
		$contentDb -> order_by('move_no', 'DESC');
		$query = $contentDb -> get();
		$count = $query -> num_rows();
		if ($count == 0) {
			$result['call'] = array('success' => false, 'code' => 1, 'message' => 'nothing found');
			$result['call']['meta'] = array('total' => 0);
			$result['call']['response'] = array();
		} else if ($count > 0) {
			$result['call'] = array('success' => true, 'code' => 0, 'message' => 'null');
			$result['call']['meta'] = array('total' => $count);
			$result['call']['response'] = $query -> result();
		} else {
			$result['call'] = array('success' => false, 'code' => 2, 'message' => 'something went wrong');
			$result['call']['meta'] = array('total' => 0);
			$result['call']['response'] = array();
		}
		return $result;
	}

	public function get_all_posts($alumniId) {
		$contentDb = $this -> load -> database('content', TRUE);
		$contentDb -> select('questions_id,questions.question,answers.answer,category.category');
		$contentDb -> from('questions,answers,category');
		$contentDb -> where('questions.alumni_alumni_id', $alumniId);
		$contentDb -> where('questions.questions_id=answers.answers_id');
		$contentDb -> group_by("questions.questions_id");
		$query = $contentDb -> get();

		$count = $query -> num_rows();
		if ($count == 0) {
			$result['call'] = array('success' => false, 'code' => 1, 'message' => 'nothing found');
			$result['call']['meta'] = array('total' => 0);
			$result['call']['response'] = array();
		} else if ($count > 0) {
			$result['call'] = array('success' => true, 'code' => 0, 'message' => 'null');
			$result['call']['meta'] = array('total' => $count);
			$result['call']['response'] = $query -> result();
		} else {
			$result['call'] = array('success' => false, 'code' => 2, 'message' => 'something went wrong');
			$result['call']['meta'] = array('total' => 0);
			$result['call']['response'] = array();
		}
		return $result;
	}

	public function get_alumni_posts($alumniId) {
		// $query= $contentDb->query("SELECT questions_id,questions.question,answers.answer,category_category_id FROM questions,answers,category WHERE questions.alumni_alumni_id=".$alumniId." AND questions.questions_id=answers.answers_id GROUP BY questions.questions_id");
		$contentDb = $this -> load -> database('content', TRUE);
		$contentDb -> select('questions.questions_id,questions.question,answers.answer');
		$contentDb -> from('questions,answers');
		$contentDb -> where('questions.alumni_alumni_id', $alumniId);
		$contentDb -> where('questions.questions_id = answers.questions_questions_id');
		//$contentDb->group_by("questions.questions_id");
		$query = $contentDb -> get();
		// /var_dump($query);
		$count = $query -> num_rows();

		if ($count == 0) {
			$result['call'] = array('success' => false, 'code' => 1, 'message' => 'nothing found');
			$result['call']['meta'] = array('total' => 0);
			$result['call']['response'] = array();
		} else if ($count > 0) {
			$result['call'] = array('success' => true, 'code' => 0, 'message' => 'null');
			$result['call']['response'] = $query -> result();
			$result['call']['reading'] = round(str_word_count(http_build_query($result['call']['response'])) / 200);
			$result['call']['meta'] = array('total' => $count);
		} else {
			$result['call'] = array('success' => false, 'code' => 2, 'message' => 'something went wrong');
			$result['call']['meta'] = array('total' => 0);
			$result['call']['response'] = array();
		}
		return $result;
	}

	public function get_alumni_quotes($alumniId) {//$query= $contentDb->query('SELECT alumni_name,alumni_photo FROM alumni where alumni_id ='.$alumniId);
		$contentDb = $this -> load -> database('content', TRUE);
		// $contentDb -> select('quote_id,quote');
		// $contentDb -> from('quotes');
		// $contentDb -> where('alumni_alumni_id', $alumniId);
		$sql = "SELECT `quote_id`,`quote` FROM `quotes` WHERE `alumni_alumni_id` ='".$alumniId."'";
		$query= $contentDb->query($sql);
		//var_dump($query -> result()	);
		$count = $query -> num_rows();
		if ($count == 0) {
			$result['call'] = array('success' => false, 'code' => 1, 'message' => 'nothing found');
			$result['call']['meta'] = array('total' => 0);
			$result['call']['response'] = array();
		} else if ($count > 0) {

			$result['call'] = array('success' => true, 'code' => 0, 'message' => 'null');
			$result['call']['response'] = $query -> result();
			$result['call']['meta'] = array('total' => $count);
		} else {
			$result['call'] = array('success' => false, 'code' => 2, 'message' => 'something went wrong');
			$result['call']['meta'] = array('total' => 0);
			$result['call']['response'] = array();
		}

		return $result;
	}

	public function get_posts_popularity($alumniId, $limit) {	$contentDb = $this -> load -> database('content', TRUE);
		$query = $contentDb -> select('questions_id,popularity,question');
		$query = $contentDb -> from('questions');
		$query = $contentDb -> where('alumni_alumni_id', $alumniId);
		$contentDb -> limit($limit);
		$contentDb -> order_by('popularity', 'ASC');
		$query = $contentDb -> get();
		$count = $query -> num_rows();
		if ($count == 0) {
			$result['call'] = array('success' => false, 'code' => 1, 'message' => 'nothing found');
			$result['call']['meta'] = array('total' => 0);
			$result['call']['response'] = array();
		} else if ($count > 0) {

			$result['call'] = array('success' => true, 'code' => 0, 'message' => 'null');
			$result['call']['response'] = $query -> result();
			$result['call']['meta'] = array('total' => $count);
		} else {
			$result['call'] = array('success' => false, 'code' => 2, 'message' => 'something went wrong');
			$result['call']['meta'] = array('total' => 0);
			$result['call']['response'] = array();
		}

		return $result;
	}


	public function get_Related_alumini_edu($id, $keywords, $limit) {
		$keywords = urldecode($keywords);
		$contentDb = $this -> load -> database('content', TRUE);
		$keywordArray = explode('|', urldecode($keywords));
		$looper = 0;
		//var_dump($keywordArray);
		$idArray = array();
		if (count($keywordArray) > 0) {

			foreach ($keywordArray as $keys) {

				if ($keys == 'c' || $keys == 'C' || $keys == 'R' || $keys == 'r') {
					$keys = ' ' . $keys . ' ';
				}

				$sql = "select alumni_alumni_id from timeline where UPPER(pos) like UPPER('%" . $keys . "%') OR UPPER(org) like UPPER('%" . $keys . "%')";
				$query = $contentDb -> query($sql);

				foreach ($query->result() as $row) {
					array_push($idArray, $row -> alumni_alumni_id);
				}
			}

			if (count($idArray) < 4) {
				foreach ($keywordArray as $keys) {

					if ($keys == 'c' || $keys == 'C' || $keys == 'R' || $keys == 'r') {
						$keys = ' ' . $keys . ' ';
					}
					$sql = "select id from skills where skill='" . $keys . "'";
					$query = $contentDb -> query($sql);

					foreach ($query->result() as $row) {

						array_push($idArray, $row -> id);
					}
				}
			}

			if (count($idArray) < 4) {
				foreach ($keywordArray as $keys) {

					if ($keys == 'c' || $keys == 'C' || $keys == 'R' || $keys == 'r') {
						$keys = ' ' . $keys . ' ';
					}
					$sql1 = "select alumni_alumni_id from questions where UPPER(question) like UPPER('%" . $keys . "%')";
					$query1 = $contentDb -> query($sql1);
					foreach ($query1->result() as $row) {
						array_push($idArray, $row -> alumni_alumni_id);
					}
				}
			}

			if (count($idArray) < 4) {
				foreach ($keywordArray as $keys) {

					if ($keys == 'c' || $keys == 'C' || $keys == 'R' || $keys == 'r') {
						$keys = ' ' . $keys . ' ';
					}
					$sql2 = "select alumni_alumni_id from answers where UPPER(answer) like UPPER('%" . $keys . "%')";
					$query2 = $contentDb -> query($sql2);
					foreach ($query2->result() as $row) {
						array_push($idArray, $row -> alumni_alumni_id);
					}
				}
			}

		}
		$idArray = array_unique($idArray);
		if (count($idArray) < 4) {

			$sql2 = "SELECT `alumni_id` FROM alumni ORDER BY RAND()LIMIT 3";
			$query2 = $contentDb -> query($sql2);
			foreach ($query2->result() as $row) {
				array_push($idArray, $row -> alumni_id);
			}
		}
		$idArray = array_unique($idArray);
		if (($key = array_search($id, $idArray)) !== false) {
			unset($idArray[$key]);
		}
		array_slice($idArray, 0, 5);
		//
		$idArray = array_values(array_slice($idArray, 0, $limit));
		shuffle($idArray);
		$count = count($idArray);
		$finalArray;
		$i = 0;
		foreach ($idArray as $value) {
			$contentDb1 = $this -> load -> database('content', TRUE);
			$queryAlumDetail = $contentDb1 -> select('alumni_id,alumni.alumni_name,alumni.alumni_photo,alumni.hidename');
			$queryAlumDetail = $contentDb1 -> from('alumni');
			$queryAlumDetail = $contentDb1 -> where('alumni_id', $value);
			$queryAlumDetail = $contentDb1 -> get();
			$contentDb2 = $this -> load -> database('content', TRUE);
			$sqlSkills = "select skill from skills where id=" . $value . " LIMIT 5";
			$querySkills = $contentDb2 -> query($sqlSkills);
			$query = $contentDb -> select('timeline.org,timeline.pos');
			$query = $contentDb -> from('timeline');
			$query = $contentDb -> where('alumni_alumni_id', $value);
			$query = $contentDb -> order_by("move_no","desc");
			$query = $contentDb -> get();
			$finalArray[$i]['details'] = $queryAlumDetail -> result();
			if($finalArray[$i]['details'][0]->hidename == 'N'){
				$imageNumber = intval($finalArray[$i]['details'][0]->alumni_id) % 4;
				$finalArray[$i]['details'][0]->alumni_name='Anonymous';
				if ($imageNumber == 0){
					$finalArray[$i]['details'][0]->alumni_photo= "http://static-images.bloomigo.co.in/common/Anonymous-3.png";
				}else {
					$finalArray[$i]['details'][0]->alumni_photo= "http://static-images.bloomigo.co.in/common/Anonymous-".$imageNumber.".png";
				}
			}else {
				$finalArray[$i]['details'][0]->alumni_photo= "http://static-images.bloomigo.co.in/interviews/".$finalArray[$i]['details'][0]->alumni_photo;
			}
			$finalArray[$i]['skills'] = $querySkills -> result();
			$tempDesignation = $query -> result();
			$finalArray[$i]['designation'] = array($tempDesignation[0]);
			$name = strtolower(preg_replace('/\s+/', '', $finalArray[$i]['details'][0] -> alumni_name));
			$this->load->library('utility');
			$id = $finalArray[$i]['details'][0] -> alumni_id;
			$temp = $this->utility-> my_encrypt($id,"bawaseer123$*123");
			$str = "http://bloomigo.website/interviews/id/" .$temp . "/" . $name;
			$finalArray[$i]['route'] = $str;
			$i++;
		}

		if ($count == 0) {
			$result['call'] = array('success' => false, 'code' => 1, 'message' => 'nothing found');
			$result['call']['meta'] = array('total' => 0);
			$result['call']['response'] = array();
		} else if ($count > 0) {
			$result['call'] = array('success' => true, 'code' => 0, 'message' => 'null');
			$result['call']['response'] = $finalArray;

			$result['call']['meta'] = array('total' => $count);
		} else {
			$result['call'] = array('success' => false, 'code' => 2, 'message' => 'something went wrong');
			$result['call']['meta'] = array('total' => 0);
			$result['call']['response'] = array();
		}
		return $result;
	}

	public function get_Related_alumini($id, $keywords, $limit) {
		$keywords = urldecode($keywords);
		$contentDb = $this -> load -> database('content', TRUE);
		$keywordArray = explode('|', urldecode($keywords));
		$looper = 0;
		//var_dump($keywordArray);
		$idArray = array();
		if (count($keywordArray) > 0) {

			foreach ($keywordArray as $keys) {

				if ($keys == 'c' || $keys == 'C' || $keys == 'R' || $keys == 'r') {
					$keys = ' ' . $keys . ' ';
				}

				$sql = "select alumni_alumni_id from timeline where UPPER(pos) like UPPER('%" . $keys . "%') OR UPPER(org) like UPPER('%" . $keys . "%')";
				$query = $contentDb -> query($sql);

				foreach ($query->result() as $row) {
					array_push($idArray, $row -> alumni_alumni_id);
				}
			}

			if (count($idArray) < 4) {
				foreach ($keywordArray as $keys) {

					if ($keys == 'c' || $keys == 'C' || $keys == 'R' || $keys == 'r') {
						$keys = ' ' . $keys . ' ';
					}
					$sql = "select id from skills where skill='" . $keys . "'";
					$query = $contentDb -> query($sql);

					foreach ($query->result() as $row) {

						array_push($idArray, $row -> id);
					}
				}
			}

			if (count($idArray) < 4) {
				foreach ($keywordArray as $keys) {

					if ($keys == 'c' || $keys == 'C' || $keys == 'R' || $keys == 'r') {
						$keys = ' ' . $keys . ' ';
					}
					$sql1 = "select alumni_alumni_id from questions where UPPER(question) like UPPER('%" . $keys . "%')";
					$query1 = $contentDb -> query($sql1);
					foreach ($query1->result() as $row) {
						array_push($idArray, $row -> alumni_alumni_id);
					}
				}
			}

			if (count($idArray) < 4) {
				foreach ($keywordArray as $keys) {

					if ($keys == 'c' || $keys == 'C' || $keys == 'R' || $keys == 'r') {
						$keys = ' ' . $keys . ' ';
					}
					$sql2 = "select alumni_alumni_id from answers where UPPER(answer) like UPPER('%" . $keys . "%')";
					$query2 = $contentDb -> query($sql2);
					foreach ($query2->result() as $row) {
						array_push($idArray, $row -> alumni_alumni_id);
					}
				}
			}

		}
		$idArray = array_unique($idArray);
		if (count($idArray) < 4) {

			$sql2 = "SELECT `alumni_id` FROM alumni ORDER BY RAND()LIMIT 3";
			$query2 = $contentDb -> query($sql2);
			foreach ($query2->result() as $row) {
				array_push($idArray, $row -> alumni_id);
			}
		}
		$idArray = array_unique($idArray);
		if (($key = array_search($id, $idArray)) !== false) {
			unset($idArray[$key]);
		}
		array_slice($idArray, 0, 5);
		//
		$idArray = array_values(array_slice($idArray, 0, $limit));
		shuffle($idArray);
		$count = count($idArray);
		$finalArray;
		$i = 0;
		foreach ($idArray as $value) {
			$contentDb1 = $this -> load -> database('content', TRUE);
			$queryAlumDetail = $contentDb1 -> select('alumni_id,alumni.alumni_name,alumni.alumni_photo,alumni.hidename,alumni.id');
			$queryAlumDetail = $contentDb1 -> from('alumni');
			$queryAlumDetail = $contentDb1 -> where('alumni_id', $value);
			$queryAlumDetail = $contentDb1 -> get();
			$contentDb2 = $this -> load -> database('content', TRUE);
			$sqlSkills = "select skill from skills where id=" . $value . " LIMIT 5";
			$querySkills = $contentDb2 -> query($sqlSkills);
			$query = $contentDb -> select('timeline.org,timeline.pos');
			$query = $contentDb -> from('timeline');
			$query = $contentDb -> where('alumni_alumni_id', $value);
			$query = $contentDb -> order_by("move_no","desc");
			$query = $contentDb -> get();
			$finalArray[$i]['details'] = $queryAlumDetail -> result();
			if($finalArray[$i]['details'][0]->hidename == 'N'){
				$imageNumber = intval($finalArray[$i]['details'][0]->id) % 4;
				$finalArray[$i]['details'][0]->alumni_name='Anonymous';
				if ($imageNumber == 0){
					$finalArray[$i]['details'][0]->alumni_photo= "http://static-images.bloomigo.co.in/common/Anonymous-3.png";
				}else {
					$finalArray[$i]['details'][0]->alumni_photo= "http://static-images.bloomigo.co.in/common/Anonymous-".$imageNumber.".png";
				}
			}else {
				$finalArray[$i]['details'][0]->alumni_photo= "http://static-images.bloomigo.co.in/interviews/".$finalArray[$i]['details'][0]->alumni_photo;
			}
			$finalArray[$i]['skills'] = $querySkills -> result();
			$tempDesignation = $query -> result();
			$finalArray[$i]['designation'] = array($tempDesignation[0]);
			$name = strtolower(preg_replace('/\s+/', '', $finalArray[$i]['details'][0] -> alumni_name));
			$this->load->library('utility');
			$id = $finalArray[$i]['details'][0] -> alumni_id;
			$temp = $this->utility-> my_encrypt($id,"bawaseer123$*123");
			$str = "http://bloomigo.website/interviews/id/" .$temp . "/" . $name;
			$finalArray[$i]['route'] = $str;
			$i++;
		}

		if ($count == 0) {
			$result['call'] = array('success' => false, 'code' => 1, 'message' => 'nothing found');
			$result['call']['meta'] = array('total' => 0);
			$result['call']['response'] = array();
		} else if ($count > 0) {
			$result['call'] = array('success' => true, 'code' => 0, 'message' => 'null');
			$result['call']['response'] = $finalArray;

			$result['call']['meta'] = array('total' => $count);
		} else {
			$result['call'] = array('success' => false, 'code' => 2, 'message' => 'something went wrong');
			$result['call']['meta'] = array('total' => 0);
			$result['call']['response'] = array();
		}
		return $result;
	}

	public function get_Related_que($keywords) {
		$contentDb = $this -> load -> database('content', TRUE);

		$keywordArray = explode('|', urldecode($keywords));
		shuffle($keywordArray);
		$looper = 0;
		$idArray = array();
		foreach ($keywordArray as $keys) {
			if ($keys == 'c' || $keys == 'C' || $keys == 'R' || $keys == 'r') {
				$keys = ' ' . $keys . ' ';
			}

			if (count($idArray) < 13) {
				$sql1 = "select questions_id from questions where UPPER(question) like UPPER('%" . $keys . "%') LIMIT 13";
				$query1 = $contentDb -> query($sql1);
				foreach ($query1->result() as $row) {
					$idArray[$looper] = $row -> questions_id;
					$looper++;
				}
			}

			if (count($idArray) < 13) {
				$sql2 = "select questions_questions_id from answers where UPPER(answer) like UPPER('%" . $keys . "%') LIMIT 10";
				$query2 = $contentDb -> query($sql2);
				foreach ($query2->result() as $row) {
					$idArray[$looper] = $row -> questions_questions_id;
					$looper++;
				}
			}

		}
		if (count($idArray) < 10) {
			$sql2 = "SELECT `questions_id` FROM questions ORDER BY RAND() LIMIT 10";
			$query2 = $contentDb -> query($sql2);
			foreach ($query2->result() as $row) {
				$idArray[$looper] = $row -> questions_id;
				$looper++;
			}
		}
		array_slice(array_unique($idArray), 0, 10);
		//shuffle($idArray);
		$idArray = array_values(array_slice(array_unique($idArray), 0, 10));
		$qCount = count($idArray);
		$count = 0;
		$newlooper = 0;
		if ($qCount > 0) {
			foreach ($idArray as $qIds) {
				$sql4 = "select questions.questions_id,questions.question,questions.alumni_alumni_id,alumni.alumni_name,alumni.hidename from questions,alumni where alumni.alumni_id=questions.alumni_alumni_id and questions_id=" . $qIds;
				$query4 = $contentDb -> query($sql4);
				foreach ($query4->result() as $row) {
					$queArray[$newlooper]['text'] = $row -> question;
					$this->load->library('utility');
					$id = $row -> alumni_alumni_id;
					$queArray[$newlooper]['alumni_ids'] = $this->utility-> my_encrypt($id,"bawaseer123$*123");//$row ->alumni_alumni_id;//
					//echo ;
					$queArray[$newlooper]['questions_id'] = $row ->questions_id;
					if($row->hidename == 'N'){
						$queArray[$newlooper]['name']='Anonymous';
					} else{
						$queArray[$newlooper]['name']= $row->alumni_name;
					}

					$name = strtolower(preg_replace('/\s+/', '', $queArray[$newlooper]['name']));
					$str = "http://bloomigo.website/interviews/id/" . $queArray[$newlooper]['alumni_ids'] . "/" . $name."#ques-".$queArray[$newlooper]['questions_id'];
					$queArray[$newlooper]['route'] = $str;
					$newlooper++;
				}
			}
		}
		$count = $newlooper;
		if ($count == 0) {
			$result['call'] = array('success' => false, 'code' => 1, 'message' => 'nothing found');
			$result['call']['meta'] = array('total' => 0);
			$result['call']['response'] = array();
		} else if ($count > 0) {

			$result['call'] = array('success' => true, 'code' => 0, 'message' => 'null');
			$result['call']['response'] = $queArray;
			$result['call']['meta'] = array('total' => $newlooper);
		} else {
			$result['call'] = array('success' => false, 'code' => 2, 'message' => 'something went wrong');
			$result['call']['meta'] = array('total' => 0);
			$result['call']['response'] = array();
		}
		return $result;
	}

	public function get_alumni_skills($alumniId) {

		// $alumniId = my_encrypt($alumniId, "bawaseer");
		// var_dump($alumniId);

		$contentDb = $this -> load -> database('content', TRUE);
		$sql = "select distinct skill from skills where id='" . $alumniId."'";
		$query = $contentDb -> query($sql);
		$count = $query -> num_rows();
		$skills = "";
		$row = $query -> result();
		$x = 1;
		foreach ($row as $temp) {
			if ($x == $count) {
				$skills .= $temp -> skill;
				break;
			}
			$skills .= $temp -> skill . "|";
			$x++;
		}

		if ($count == 0) {
			$result['call'] = array('success' => false, 'code' => 1, 'message' => 'nothing found');
			$result['call']['meta'] = array('total' => 0);
			$result['call']['response'] = array();
		} else if ($count > 0) {

			$result['call'] = array('success' => true, 'code' => 0, 'message' => 'null');
			$result['call']['response']['skills'] = $skills;
			$result['call']['meta'] = array('total' => $count);
		} else {
			$result['call'] = array('success' => false, 'code' => 2, 'message' => 'something went wrong');
			$result['call']['meta'] = array('total' => 0);
			$result['call']['response'] = array();
		}
		return $result;
	}

	public function sethelpful($alumniId) {

		// $alumniId = my_encrypt($alumniId, "bawaseer");
		// var_dump($alumniId);

		$contentDb = $this -> load -> database('content', TRUE);
		$sql = "UPDATE `alumni` SET helpful = helpful + 1  WHERE `alumni_id` = '" . $alumniId."'";
		$query = $contentDb -> query($sql);
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


}