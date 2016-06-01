<?php
    class Company extends CI_Controller {
		
        public function __construct()
        {
            parent::__construct();
            $this->load->model('Company_model','',TRUE);
			$this->output->set_header("Access-Control-Expose-Headers: Access-Control-Allow-Origin");
			$this->output->set_status_header(200);
			$this->output->set_content_type('application/json');
			$this->output->_display();
			
			$all_methods=array('getAssocIndustries'=>array('COMPANY'),'getAssocSkills'=>array('COMPANY'),
			'getSimilarCompanies'=>array('COMPANY'),'getInThere'=>array('COMPANY'),
			'getPopularSwitchesFromCompanySpiderTool'=>array('COMPANY'),'getJdPath'=>array('COMPANY'),
			'getAssocJd'=>array('COMPANY'),'getAttritionRate'=>array('COMPANY'),
			'getAvailableSalaries'=>array('COMPANY'),'getPopularSwitchesFromCompany'=>array('COMPANY'),
			'getPopularSwitchesToCompany'=>array('COMPANY'));
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
			echo("You are in wrong motherhood! Neighbour fucker!");						
		}	
        
        public function getAssocJd($getCompany){
			$this->load->library('utility');
			$memcached =$this->utility->createContentCache();
			$result = $memcached->get('getAssocJd'.$getCompany);
			if($result) {					
				echo json_encode($result);
				} else {
				$data['query'] = $this->Company_model->get_assoc_jd($getCompany);
				$memcached->set('getAssocJd'.$getCompany,$data['query']);
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
				$data['query'] = $this->Company_model->get_assoc_skills($getCompany);
				$memcached->set('getAssocSkills'.$getCompany,$data['query']);
				header('Content-Type: application/json');
				echo json_encode($data['query'],JSON_NUMERIC_CHECK);
			}
		}		
		
        public function getAssocIndustries($getCompany){
			$this->load->library('utility');
			$memcached =$this->utility->createContentCache();
			$result = $memcached->get('getAssocIndustries'.$getCompany);
			if($result) {					
				echo json_encode($result);
				} else {
				$data['query'] = $this->Company_model->get_assoc_industries($getCompany);
				$memcached->set('getAssocIndustries'.$getCompany,$data['query']);
				header('Content-Type: application/json');
				echo json_encode($data['query'],JSON_NUMERIC_CHECK);
			}
		}
		
        /** How to Get in There Starts Here **/
        
		public function getSimilarCompanies($getCompany){
			$this->load->library('utility');
			$memcached =$this->utility->createContentCache();
			$result = $memcached->get('getSimilarCompanies'.$getCompany);
			if($result) {					
				echo json_encode($result);
				} else {
				$data['query'] = $this->Company_model->get_similar_companies($getCompany);
				$memcached->set('getSimilarCompanies'.$getCompany,$data['query']);
				header('Content-Type: application/json');
				echo json_encode($data['query'],JSON_NUMERIC_CHECK);
			}
		}
		
		public function getInThere($getCompany){
			$this->load->library('utility');
			$memcached =$this->utility->createContentCache();
			$result = $memcached->get('getInThere'.$getCompany);
			if($result) {					
				echo json_encode($result);
				} else {
				$data['query'] = $this->Company_model-> get_jd_path($getCompany);
				$memcached->set('getInThere'.$getCompany,$data['query']);
				header('Content-Type: application/json');
				echo json_encode($data['query'],JSON_NUMERIC_CHECK);
			}
		}
		
		public function getAvailableSalaries($getCompany){
			$this->load->library('utility');
			$memcached =$this->utility->createContentCache();
			$result = $memcached->get('getAvailableSalaries'.$getCompany);
			if($result) {					
				echo json_encode($result);
				} else {
				$data['query'] = $this->Company_model->get_available_salaries($getCompany);
				$memcached->set('getAvailableSalaries'.$getCompany,$data['query']);
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
				$data['query'] = $this->Company_model-> get_attritionRate($getCompany);
				$memcached->set('getAttritionRate'.$getCompany,$data['query']);
				header('Content-Type: application/json');
				echo json_encode($data['query'],JSON_NUMERIC_CHECK);
			}
		}
		
		public function getPopularSwitchesFromCompany($getCompany){
			$this->load->library('utility');
			$memcached =$this->utility->createContentCache();
			$result = $memcached->get('getPopularSwitchesFromCompany'.$getCompany);
			if($result) {					
				echo json_encode($result);
				} else {
				$data['query'] = $this->Company_model-> get_Popular_Switches_FromCompany($getCompany);
				$memcached->set('getPopularSwitchesFromCompany'.$getCompany,$data['query']);
				header('Content-Type: application/json');
				echo json_encode($data['query'],JSON_NUMERIC_CHECK);
			}
		}
		
		public function getPopularSwitchesFromCompanySpiderTool($getCompany){
			$this->load->library('utility');
			$memcached =$this->utility->createContentCache();
			$result = $memcached->get('getPopularSwitchesFromCompanySpiderTool'.$getCompany);
			if($result) {					
				echo json_encode($result);
				} else {
				$data['query'] = $this->Company_model-> get_Popular_Switches_FromCompany_forSpiderTool($getCompany);
				$memcached->set('getPopularSwitchesFromCompanySpiderTool'.$getCompany,$data['query']);
				header('Content-Type: application/json');
				echo json_encode($data['query'],JSON_NUMERIC_CHECK);
			}
		}
		
		public function getPopularSwitchesToCompany($getCompany){
			$this->load->library('utility');
			$memcached =$this->utility->createContentCache();
			$result = $memcached->get('getPopularSwitchesToCompany'.$getCompany);
			if($result) {					
				echo json_encode($result);
				} else {
				$data['query'] = $this->Company_model-> get_Popular_Switches_ToCompany($getCompany);
				$memcached->set('getPopularSwitchesToCompany'.$getCompany,$data['query']);
				header('Content-Type: application/json');
				echo json_encode($data['query'],JSON_NUMERIC_CHECK);
			}
			
		}
	}
	
?>