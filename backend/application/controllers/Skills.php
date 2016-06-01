<?php
    class Skills extends CI_Controller {
		
		public function __construct()
        {
            parent::__construct();
            $this->load->model('Skills_model','',TRUE);
			$this->output->set_header("Access-Control-Allow-Origin: *");
			$this->output->set_header("Access-Control-Expose-Headers: Access-Control-Allow-Origin");
			$this->output->set_status_header(200);
			$this->output->set_content_type('application/json');
			$this->output->_display();
			
			
            $all_methods=array('getAssocIndustries'=>array('SKILL'),'getAssocJobs'=>array('SKILL'),'getAssocCompanies'=>array('SKILL','ORDER'));
            $all_params='';
            if($this->uri->total_segments() == 1){
                $result['call']=array('success'=>false,'code'=>3,'message'=>$all_methods);
                $result['call']['meta']=array('total'=>0);
                $result['call']['response']=array();
                exit(json_encode($result));
			}
            foreach($all_methods[$this->router->fetch_method()] as $param){
                $all_params.=$param." ";
                //Start
			}
            if(((count($all_methods[$this->router->fetch_method()])+2))>($this->uri->total_segments())){
                $result['call']=array('success'=>false,'code'=>3,'message'=>'This function '.$this->router->fetch_method().' takes '.(count($all_methods[$this->router->fetch_method()])).' params!  Pass '.$all_params);
                $result['call']['meta']=array('total'=>0);
                $result['call']['response']=array();
                exit(json_encode($result));
			}
		}
		public function index()
        {	echo("You are in wrong motherhood! Neighbour fucker!");											
		}	
		
        public function getAssocIndustries($skill){
			$this->load->library('utility');
			$memcached =$this->utility->createContentCache();
			$result = $memcached->get('getAssocIndustries_'.$skill);
			if($result) {					
				echo json_encode($result);
				} else {
				$data['query'] = $this->Skills_model->get_assoc_industries($skill);
				$memcached->set('getAssocIndustries_'.$skill,$data['query']);
				header('Content-Type: application/json');
				echo json_encode($data['query'],JSON_NUMERIC_CHECK);
			}
		}
		
		public function getAssocJobs($skill){
			
			$this->load->library('utility');
			$memcached =$this->utility->createContentCache();
			$result = $memcached->get('getAssocJobs_'.$skill);
			if($result) {					
				echo json_encode($result);
				} else {
				$data['query'] = $this->Skills_model->get_assoc_designations($skill);
				$memcached->set('getAssocJobs_'.$skill,$data['query']);
				header('Content-Type: application/json');
				echo json_encode($data['query'],JSON_NUMERIC_CHECK);
			}
		}
		
        public function getAssocCompanies($skill,$order){
			$this->load->library('utility');
			$memcached =$this->utility->createContentCache();
			$result = $memcached->get('getAssocCompanies_'.$skill);
			if($result) {					
				echo json_encode($result);
				} else {
				$data['query'] = $this->Skills_model->get_assoc_companies($skill,$order);
				$memcached->set('getAssocCompanies_'.$skill,$data['query']);
				header('Content-Type: application/json');
				echo json_encode($data['query'],JSON_NUMERIC_CHECK);
			}
		}      
	}
?>