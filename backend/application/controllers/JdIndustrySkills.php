<?php
    class JdIndustrySkills extends CI_Controller {
		
        public function __construct()
        {
            parent::__construct();
            $this->load->model('Jd_industry_skills_model','',TRUE);
            $this->output->set_header("Access-Control-Allow-Origin: *");
			$this->output->set_header("Access-Control-Expose-Headers: Access-Control-Allow-Origin");
			$this->output->set_status_header(200);
			$this->output->set_content_type('application/json');
			$this->output->_display();
			
            $all_methods=array('getAssocIndustries'=>array('JD','SKILLS'),'getAssocSkills'=>array('JD','INDUSTRY'),'getAssocCompanies'=>array('JD','INDUSTRY','SKILLS'),'getAvailableSal'=>array('JD'));
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
        public function getAssocIndustries($getJD, $getSkills){
			$this->load->library('utility');
			$memcached =$this->utility->createContentCache();
			$result = $memcached->get('getAssocIndustries'.$getJD.'-'.$getSkills );
			if($result) {					
				echo json_encode($result);
				} else {
				$data['query'] = $this->Jd_industry_skills_model->get_assoc_industries($getJD, $getSkills);
				$memcached->set('getAssocIndustries'.$getJD.'-'.$getSkills ,$data['query']);
				header('Content-Type: application/json');
				echo json_encode($data['query'],JSON_NUMERIC_CHECK);
			}
		}
		
        public function getAssocSkills($getJD, $getIndustry){
			$this->load->library('utility');
			$memcached =$this->utility->createContentCache();
			$result = $memcached->get('getAssocSkills'.$getJD.'-'.$getIndustry );
			if($result) {					
				echo json_encode($result);
				} else {
				$data['query'] = $this->Jd_industry_skills_model->get_assoc_skills($getJD, $getIndustry);
				$memcached->set('getAssocSkills'.$getJD.'-'.$getIndustry ,$data['query']);
				header('Content-Type: application/json');
				echo json_encode($data['query'],JSON_NUMERIC_CHECK);
			}
		}		
        
        public function getAssocCompanies($getJD, $getIndustry, $getSkills){
			$this->load->library('utility');
			$memcached =$this->utility->createContentCache();
			$result = $memcached->get('getAssocCompanies'.$getJD.'-'.$getIndustry.'-'.$getSkills );
			if($result) {					
				echo json_encode($result);
				} else {
				$data['query'] = $this->Jd_industry_skills_model->get_assoc_companies($getJD, $getIndustry, $getSkills);
				$memcached->set('getAssocCompanies'.$getJD.'-'.$getIndustry.'-'.$getSkills ,$data['query']);
				header('Content-Type: application/json');
				echo json_encode($data['query'],JSON_NUMERIC_CHECK);
			}
		}
		
		public function getAvailableSal($getJD){
			$this->load->library('utility');
			$memcached =$this->utility->createContentCache();
			$result = $memcached->get('getAvailableSal'.$getJD);
			if($result) {					
				echo json_encode($result);
				} else {
				$data['query'] = $this->Jd_industry_skills_model->get_avail_sal($getJD);
				$memcached->set('getAvailableSal'.$getJD ,$data['query']);
				header('Content-Type: application/json');
				echo json_encode($data['query'],JSON_NUMERIC_CHECK);
			}
		}
        
	}
?>