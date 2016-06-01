<?php
    class Search extends CI_Controller {
		
    public function __construct()
        {
            parent::__construct();
            $this->load->model('Search_model','',TRUE);
			$this->output->set_header("Access-Control-Expose-Headers: Access-Control-Allow-Origin");
			$this->output->set_status_header(200);
			$this->output->set_content_type('application/json');
			$this->output->_display();
        }
    public function index()
        {	echo("You are in wrong motherhood! Neighbour fucker!");											
		}	
		
        public function search(){
                $data['query'] = $this->Search_model->get_search();
                echo json_encode($data['query'],JSON_NUMERIC_CHECK);
        }
		public function getTrends(){
                $data['query'] = $this->Search_model->get_trends();
                echo json_encode($data['query'],JSON_NUMERIC_CHECK);
        }
		public function setHits($type,$input){
                $data['query'] = $this->Search_model->set_hits($type,$input);
                echo json_encode($data['query'],JSON_NUMERIC_CHECK);
        }
		public function getType($college, $branch){
			$college = urldecode($college);
			$branch = urldecode($branch);
			$data['query'] = $this->Search_model->get_type($college, $branch);
                echo json_encode($data['query'],JSON_NUMERIC_CHECK);
        }
		
}
?>
