<?php
    class CompanyJdIndustrySkills extends CI_Controller {
		
        public function __construct()
        {
            parent::__construct();
            $this->load->model('Company_jd_industry_skills_model','',TRUE);
			$this->output->set_header("Access-Control-Allow-Origin: *");
			$this->output->set_header("Access-Control-Expose-Headers: Access-Control-Allow-Origin");
			$this->output->set_status_header(200);
			$this->output->set_content_type('application/json');
			$this->output->_display();
			
            $all_methods=array('getAssocIndustries'=>array('COMPANY'),'getAssocSkills'=>array('COMPANY','JD'),
			'getAssocCompanies'=>array('COMPANY'),'getAssocJd'=>array('COMPANY','SKILLS'),
			'getSimilarCompanies'=>array('COMPANY','JD'),'getLateralVsHigher'=>array('COMPANY','JD'),
			'getHowToGetInThere'=>array('COMPANY','JD'),
			'getAvailableSalaries'=>array('COMPANY','JD'),'getAvgRateOfStay'=>array('COMPANY','JD'),
			'getPopularSwitchesFromCompany'=>array('COMPANY','JD'),'getPopularSwitchesToCompany'=>array('COMPANY','JD'));
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
				$data['query'] = $this->Company_jd_industry_skills_model->get_assoc_industries($getCompany);
				$memcached->set('getAssocIndustries'.$getCompany,$data['query']);
				header('Content-Type: application/json');
				echo json_encode($data['query'],JSON_NUMERIC_CHECK);
			}
		}
		
        public function getAssocSkills($getCompany , $getJd){
			$this->load->library('utility');
			$memcached =$this->utility->createContentCache();
			$result = $memcached->get('getAssocSkills'.$getCompany.'-'.$getJd );
			if($result) {					
				echo json_encode($result);
				} else {
				$data['query'] = $this->Company_jd_industry_skills_model->get_assoc_skills($getCompany, $getJd);
				$memcached->set('getAssocSkills'.$getCompany.'-'.$getJd ,$data['query']);
				header('Content-Type: application/json');
				echo json_encode($data['query'],JSON_NUMERIC_CHECK);
			}
		}		
        
        public function getAssocCompanies($getCompany){
			$this->load->library('utility');
			$memcached =$this->utility->createContentCache();
			$result = $memcached->get('getAssocCompanies'.$getCompany );
			if($result) {					
				echo json_encode($result);
				} else {
				$data['query'] = $this->Company_jd_industry_skills_model->get_assoc_companies($getCompany);
				$memcached->set('getAssocCompanies'.$getCompany,$data['query']);
				header('Content-Type: application/json');
				echo json_encode($data['query'],JSON_NUMERIC_CHECK);
			}
		}
		
		public function getAssocJd($getCompany, $getSkills){
			$this->load->library('utility');
			$memcached =$this->utility->createContentCache();
			$result = $memcached->get('getAssocJd'.$getCompany.'-'.$getSkills );
			if($result) {					
				echo json_encode($result);
				} else {
				$data['query'] = $this->Company_jd_industry_skills_model->get_assoc_jd($getCompany, $getSkills);
				$memcached->set('getAssocJd'.$getCompany.'-'.$getSkills ,$data['query']);
				header('Content-Type: application/json');
				echo json_encode($data['query'],JSON_NUMERIC_CHECK);
			}
		}
		
		public function getSimilarCompanies($getCompany , $getJd){
			$this->load->library('utility');
			$memcached =$this->utility->createContentCache();
			$result = $memcached->get('getSimilarCompanies'.$getCompany.'-'.$getJd );
			if($result) {					
				echo json_encode($result);
				} else {
				$data['query'] = $this->Company_jd_industry_skills_model->get_similar_companies($getCompany , $getJd);
				$memcached->set('getSimilarCompanies'.$getCompany.'-'.$getJd ,$data['query']);
				header('Content-Type: application/json');
				echo json_encode($data['query'],JSON_NUMERIC_CHECK);
			}
		}
        
        public function getLateralVsHigher($getCompany , $getJd){
			$this->load->library('utility');
			$memcached =$this->utility->createContentCache();
			$result = $memcached->get('getLateralVsHigher'.$getCompany.'-'.$getJd );
			if($result) {					
				echo json_encode($result);
				} else {
				$data['query'] = $this->Company_jd_industry_skills_model->lateral_switch_vs_higher($getCompany , $getJd);
				$memcached->set('getLateralVsHigher'.$getCompany.'-'.$getJd ,$data['query']);
				header('Content-Type: application/json');
				echo json_encode($data['query'],JSON_NUMERIC_CHECK);
			}
		}
		
		public function getHowToGetInThere($getCompany, $getJd){
			$this->load->library('utility');
			$memcached =$this->utility->createContentCache();
			$result = $memcached->get('howToGetInThere'.$getCompany.'-'.$getJd );
			if($result) {					
				echo json_encode($result);
				} else {
				$data['query'] = $this->Company_jd_industry_skills_model->get_howToGetInThere($getCompany, $getJd);
				$memcached->set('howToGetInThere'.$getCompany.'-'.$getJd ,$data['query']);
				header('Content-Type: application/json');
				echo json_encode($data['query'],JSON_NUMERIC_CHECK);
			}
		}
		
		public function getAvailableSalaries($getCompany, $getJd){
			$this->load->library('utility');
			$memcached =$this->utility->createContentCache();
			$result = $memcached->get('getAvailableSalaries'.$getCompany.'-'.$getJd );
			if($result) {					
				echo json_encode($result);
				} else {
				$data['query'] = $this->Company_jd_industry_skills_model->get_available_salaries($getCompany, $getJd);
				$memcached->set('getAvailableSalaries'.$getCompany.'-'.$getJd ,$data['query']);
				header('Content-Type: application/json');
				echo json_encode($data['query'],JSON_NUMERIC_CHECK);
			}
		}
		
		public function getAvgRateOfStay($getCompany, $getJd){
			$this->load->library('utility');
			$memcached =$this->utility->createContentCache();
			$result = $memcached->get('getAvgRateOfStay'.$getCompany.'-'.$getJd );
			if($result) {					
				echo json_encode($result);
				} else {
				$data['query'] = $this->Company_jd_industry_skills_model-> get_avg_rate_of_stay($getCompany, $getJd);
				$memcached->set('getAvgRateOfStay'.$getCompany.'-'.$getJd ,$data['query']);
				header('Content-Type: application/json');
				echo json_encode($data['query'],JSON_NUMERIC_CHECK);
			}
		}
		
		public function getPopularSwitchesFromCompany($getCompany, $getJd){
			$this->load->library('utility');
			$memcached =$this->utility->createContentCache();
			$result = $memcached->get('getPopularSwitchesFromCompany'.$getCompany.'-'.$getJd );
			if($result) {					
				echo json_encode($result);
				} else {
				$data['query'] = $this->Company_jd_industry_skills_model-> get_Popular_Switches_FromCompany($getCompany, $getJd);
				$memcached->set('getPopularSwitchesFromCompany'.$getCompany.'-'.$getJd ,$data['query']);
				header('Content-Type: application/json');
				echo json_encode($data['query'],JSON_NUMERIC_CHECK);
			}
		}
		
		public function getPopularSwitchesToCompany($getCompany, $getJd){
			$this->load->library('utility');
			$memcached =$this->utility->createContentCache();
			$result = $memcached->get('getPopularSwitchesToCompany'.$getCompany.'-'.$getJd );
			if($result) {					
				echo json_encode($result);
				} else {
				$data['query'] = $this->Company_jd_industry_skills_model-> get_Popular_Switches_ToCompany($getCompany, $getJd);
				$memcached->set('getPopularSwitchesToCompany'.$getCompany.'-'.$getJd ,$data['query']);
				header('Content-Type: application/json');
				echo json_encode($data['query'],JSON_NUMERIC_CHECK);
			}
		}
	}
	
?>