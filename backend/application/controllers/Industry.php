<?php
    class Industry extends CI_Controller {
		
        public function __construct()
        {
            parent::__construct();
            $this->load->model('industry_model','',TRUE);
			$this->output->set_header("Access-Control-Allow-Origin: *");
			$this->output->set_header("Access-Control-Expose-Headers: Access-Control-Allow-Origin");
			$this->output->set_status_header(200);
			$this->output->set_content_type('application/json');
			$this->output->_display();
			
            $all_methods=array('getAssocIndustries'=>array('INDUSTRY'),'getAssocSkills'=>array('INDUSTRY'),'getAssocCompanies'=>array('INDUSTRY'),'getAssocJobs'=>array('INDUSTRY'));
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
        {	
			//$redisObj = new Redis(); 
			
		}	
        public function getAssocIndustries($industry){
			$this->load->library('utility');
			$memcached =$this->utility->createContentCache();
			$result = $memcached->get('getAssocIndustries_'.$industry);
			if($result) {					
				echo json_encode($result);
				} else {
				$data['query'] = $this->industry_model->get_assoc_industries($industry);
				$memcached->set('getAssocIndustries_'.$industry,$data['query']);
				header('Content-Type: application/json');
				echo json_encode($data['query'],JSON_NUMERIC_CHECK);
			}
		}
		
        public function getAssocSkills($industry){
			$this->load->library('utility');
			$memcached =$this->utility->createContentCache();
			$result = $memcached->get('getAssocSkills'.$industry);
			if($result) {					
				echo json_encode($result);
				} else {
				$data['query'] = $this->industry_model->get_assoc_skills($industry);
				$memcached->set('getAssocSkills'.$industry,$data['query']);
				header('Content-Type: application/json');
				echo json_encode($data['query'],JSON_NUMERIC_CHECK);
			}
		}
		
		public function getAssocJobs($industry){
			$this->load->library('utility');
			$memcached =$this->utility->createContentCache();
			$result = $memcached->get('getAssocJobs'.$industry);
			if($result) {					
				echo json_encode($result);
				} else {
				$data['query'] = $this->industry_model->get_assoc_designations($industry);
				$memcached->set('getAssocJobs'.$industry,$data['query']);
				header('Content-Type: application/json');
				echo json_encode($data['query'],JSON_NUMERIC_CHECK);
			}
			
		}
		       
        public function getAssocCompanies($industry){
			$this->load->library('utility');
			$memcached =$this->utility->createContentCache();
			$result = $memcached->get('getAssocCompanies'.$industry);
			if($result) {					
				echo json_encode($result);
				} else {
				$data['query'] = $this->industry_model->get_assoc_companies($industry);
				$memcached->set('getAssocCompanies'.$industry,$data['query']);
				header('Content-Type: application/json');
				echo json_encode($data['query'],JSON_NUMERIC_CHECK);
			}
		}       
	}
?>