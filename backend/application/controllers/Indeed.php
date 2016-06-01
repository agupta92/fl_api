<?php
    class Indeed extends CI_Controller {
		
		public function __construct()
        {
            parent::__construct();
            $this->load->model('Indeed_model','',TRUE);
			$this->output->set_header("Access-Control-Allow-Origin: *");
			$this->output->set_header("Access-Control-Expose-Headers: Access-Control-Allow-Origin");
			$this->output->set_status_header(200);
			//$this->output->set_content_type('application/json');
			$this->output->_display();
		}
		public function index()
        {	echo("You are in wrong motherhood! Neighbour fucker!");											
		}	
		
        public function getJobs($keywords,$city,$state){			
				$data['query'] = $this->Indeed_model->get_jobs($keywords,$city,$state);		
				//header('Content-Type: application/xml');
				//echo ($data);
				echo( json_encode($data['query'], JSON_HEX_QUOT | JSON_HEX_TAG));
			}
		}
?>