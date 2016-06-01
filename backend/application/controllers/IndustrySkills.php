<?php
    class IndustrySkills extends CI_Controller {
		
        public function __construct()
        {
            parent::__construct();
            $this->load->model('Industry_skills_model','',TRUE);
            $this->output->set_header("Access-Control-Allow-Origin: *");
			$this->output->set_header("Access-Control-Expose-Headers: Access-Control-Allow-Origin");
			$this->output->set_status_header(200);
			$this->output->set_content_type('application/json');
			$this->output->_display();
            
			
			
            $all_methods=array('getAssocIndustries'=>array('INDUSTRY'),'getAssocSkills'=>array('INDUSTRY'),'getAssocCompanies'=>array('INDUSTRY','SKILLS'),'getAssocJd'=>array('INDUSTRY','SKILLS'));
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
		
        public function getAssocIndustries($getIndustry){
			$this->load->library('utility');
			$memcached =$this->utility->createContentCache();
			$result = $memcached->get('getAssocIndustries_'.$getIndustry);
			if($result) {					
				echo json_encode($result);
				} else {
				$data['query'] = $this->Industry_skills_model->get_assoc_industries($getIndustry);
				$memcached->set('getAssocIndustries_'.$getIndustry,$data['query']);
				header('Content-Type: application/json');
				echo json_encode($data['query'],JSON_NUMERIC_CHECK);
			}
		}
		
        public function getAssocSkills($getIndustry){
			$this->load->library('utility');
			$memcached =$this->utility->createContentCache();
			$result = $memcached->get('getAssocSkills'.$getIndustry);
			if($result) {					
				echo json_encode($result);
				} else {
				$data['query'] = $this->Industry_skills_model->get_assoc_top_skills($getIndustry);
				$memcached->set('getAssocIndustries_'.$getIndustry,$data['query']);
				header('Content-Type: application/json');
				echo json_encode($data['query'],JSON_NUMERIC_CHECK);
			}
		}		
        
        public function getAssocCompanies($getIndustry, $getSkills){
			$this->load->library('utility');
			$memcached =$this->utility->createContentCache();
			$result = $memcached->get('getAssocCompanies_'.$getIndustry.'-'.$getSkills );
			if($result) {					
				echo json_encode($result);
				} else {
				$data['query'] = $this->Industry_skills_model->get_assoc_companies($getIndustry, $getSkills);
				$memcached->set('getAssocCompanies_'.$getIndustry.'-'.$getSkills ,$data['query']);
				header('Content-Type: application/json');
				echo json_encode($data['query'],JSON_NUMERIC_CHECK);
			}
		}
		
		public function getAssocJd($getIndustry, $getSkills){
			$this->load->library('utility');
			$memcached =$this->utility->createContentCache();
			$result = $memcached->get('getAssocJd_'.$getIndustry.'-'.$getSkills );
			if($result) {					
				echo json_encode($result);
				} else {
				$data['query'] = $this->Industry_skills_model->get_assoc_jd($getIndustry, $getSkills);
				$memcached->set('getAssocJd_'.$getIndustry.'-'.$getSkills ,$data['query']);
				header('Content-Type: application/json');
				echo json_encode($data['query'],JSON_NUMERIC_CHECK);
			}
		}       
	}
?>