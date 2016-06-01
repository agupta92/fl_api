<?php

class wiki_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}


	public function get_wiki($type,$keyword) {
		$contentDb = $this -> load -> database('search', TRUE);
		$contentDb -> select('wiki_id,intro');
		$contentDb -> from('wiki');
		$contentDb -> where('type', $type);
		$contentDb -> where('input',$keyword);
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


}
?>