<?php
    class CompanyIndustrySkills extends CI_Controller {
		
        public function __construct()
        {
            parent::__construct();
            $this->load->model('Company_industry_skills_model','',TRUE);
			$this->output->set_header("Access-Control-Allow-Origin: *");
			$this->output->set_header("Access-Control-Expose-Headers: Access-Control-Allow-Origin");
			//$this->output->set_status_header(200);
			$this->output->set_content_type('application/json');
			$this->output->_display();
			
            $all_methods=array('getAssocIndustries'=>array('COMPANY'),'getAssocSkills'=>array('COMPANY'),
			'getAssocCompanies'=>array('COMPANY','SKILLS'),'getAssocJd'=>array('COMPANY','SKILLS'),
			'getSimilarCompanies'=>array('COMPANY'),'getInThere'=>array('COMPANY','SKILLS'),
			'getAvailableSalaries'=>array('COMPANY','SKILLS'),
			'getAttritionRate'=>array('COMPANY'),'getPopularSwitchesFromCompanySpiderTool'=>array('COMPANY','SKILLS'),
			'getPopularSwitchesFromCompany'=>array('COMPANY','SKILLS'),'getPopularSwitchesToCompany'=>array('COMPANY','SKILLS'));
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
        public function getAssocIndustries($getCompany){
			$this->load->library('utility');
			$memcached =$this->utility->createContentCache();
			$result = $memcached->get('getAssocIndustries'.$getCompany);
			if($result) {					
				echo json_encode($result);
				} else {
				$data['query'] = $this->Company_industry_skills_model->get_assoc_industries($getCompany);
				$memcached->set('getAssocIndustries'.$getCompany,$data['query']);
				header('Content-Type: application/json');
				echo json_encode($data['query'],JSON_NUMERIC_CHECK);
			}
		}
		
        public function getAssocSkills($getCompany){
			$this->load->library('utility');
			$memcached =$this->utility->createContentCache();
			$result = $memcached->get('getAssocSkills'.$getCompany);
			if($result) {					
				echo json_encode($result);
				} else {
				$data['query'] = $this->Company_industry_skills_model->get_assoc_skills($getCompany);
				$memcached->set('getAssocSkills'.$getCompany,$data['query']);
				header('Content-Type: application/json');
				echo json_encode($data['query'],JSON_NUMERIC_CHECK);
			}
		}		
        
        /*public function getAssocCompanies($getCompany, $getSkills){
			$data['query'] = $this->Company_industry_skills_model->get_assoc_companies($getCompany, $getSkills);
			echo json_encode($data['query'],JSON_NUMERIC_CHECK);
		}*/
		
		public function getAssocJd($getCompany, $getSkills){
			$this->load->library('utility');
			$memcached =$this->utility->createContentCache();
			$result = $memcached->get('getAssocJd'.$getCompany.'-'.$getSkills );
			if($result) {					
				echo json_encode($result);
				} else {
				$data['query'] = $this->Company_industry_skills_model->get_assoc_jd($getCompany, $getSkills);
				$memcached->set('getAssocJd'.$getCompany.'-'.$getSkills ,$data['query']);
				header('Content-Type: application/json');
				echo json_encode($data['query'],JSON_NUMERIC_CHECK);
			}
		}
		
		public function getSimilarCompanies($getCompany){
			$this->load->library('utility');
			$memcached =$this->utility->createContentCache();
			$result = $memcached->get('getSimilarCompanies'.$getCompany);
			if($result) {					
				echo json_encode($result);
				} else {
				$data['query'] = $this->Company_industry_skills_model->get_similar_companies($getCompany);
				$memcached->set('getSimilarCompanies'.$getCompany,$data['query']);
				header('Content-Type: application/json');
				echo json_encode($data['query'],JSON_NUMERIC_CHECK);
			}
		}
		
		public function getInThere($getCompany, $getSkills){
			$this->load->library('utility');
			$memcached =$this->utility->createContentCache();
			$result = $memcached->get('getInThere'.$getCompany.'-'.$getSkills );
			if($result) {					
				echo json_encode($result);
				} else {
				$data['query'] = $this->Company_industry_skills_model->get_in_there($getCompany, $getSkills);
				$memcached->set('getInThere'.$getCompany.'-'.$getSkills ,$data['query']);
				header('Content-Type: application/json');
				echo json_encode($data['query'],JSON_NUMERIC_CHECK);
			}
		}
		
		
		public function getAvailableSalaries($getCompany, $getSkills){
			$this->load->library('utility');
			$memcached =$this->utility->createContentCache();
			$result = $memcached->get('getAvailableSalaries'.$getCompany.'-'.$getSkills );
			if($result) {					
				echo json_encode($result);
				} else {
				$data['query'] = $this->Company_industry_skills_model->get_available_salaries($getCompany, $getSkills);
				$memcached->set('getAvailableSalaries'.$getCompany.'-'.$getSkills ,$data['query']);
				header('Content-Type: application/json');
				echo json_encode($data['query'],JSON_NUMERIC_CHECK);
			}
		}
		
		public function getAttritionRate($getCompany){
			$this->load->library('utility');
			$memcached =$this->utility->createContentCache();
			$result = $memcached->get('getAttritionRate'.$getCompany);
			if($result) {					
				echo json_encode($result);
				} else {
				$data['query'] = $this->Company_industry_skills_model->get_attrition_rate($getCompany);
				$memcached->set('getAttritionRate'.$getCompany,$data['query']);
				header('Content-Type: application/json');
				echo json_encode($data['query'],JSON_NUMERIC_CHECK);
			}
		}
		
		public function getPopularSwitchesFromCompany($getCompany, $getSkills){
			$this->load->library('utility');
			$memcached =$this->utility->createContentCache();
			$result = $memcached->get('getPopularSwitchesFromCompany'.$getCompany.'-'.$getSkills );
			if($result) {					
				echo json_encode($result);
				} else {
				$data['query'] = $this->Company_industry_skills_model->get_Popular_Switches_FromCompany($getCompany, $getSkills);
				$memcached->set('getPopularSwitchesFromCompany'.$getCompany.'-'.$getSkills ,$data['query']);
				header('Content-Type: application/json');
				echo json_encode($data['query'],JSON_NUMERIC_CHECK);
			}
		}
		
		public function getPopularSwitchesToCompany($getCompany, $getSkills){
			$this->load->library('utility');
			$memcached =$this->utility->createContentCache();
			$result = $memcached->get('getPopularSwitchesToCompany'.$getCompany.'-'.$getSkills );
			if($result) {					
				echo json_encode($result);
				} else {
				$data['query'] = $this->Company_industry_skills_model->get_Popular_Switches_ToCompany($getCompany, $getSkills);
				$memcached->set('getPopularSwitchesToCompany'.$getCompany.'-'.$getSkills ,$data['query']);
				header('Content-Type: application/json');
				echo json_encode($data['query'],JSON_NUMERIC_CHECK);
			}
		}
		
		#vikram
		public function getPopularSwitchesFromCompanySpiderTool($getCompany, $getSkills) {
			$this->load->library('utility');
			$memcached =$this->utility->createContentCache();
			$result = $memcached->get('getPopularSwitchesFromCompanySpiderTool'.$getCompany.'-'.$getSkills );
			if($result) {					
				echo json_encode($result);
				} else {
				$data['query'] = $this -> Company_industry_skills_model -> get_Popular_Switches_FromCompany_forSpiderTool($getCompany, $getSkills);
				$memcached->set('getPopularSwitchesFromCompanySpiderTool'.$getCompany.'-'.$getSkills ,$data['query']);
				header('Content-Type: application/json');
				echo json_encode($data['query'],JSON_NUMERIC_CHECK);
			}
		}
	}
	
?>