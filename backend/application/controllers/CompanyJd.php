<?php
	class CompanyJd extends CI_Controller {
		
		public function __construct() {
			parent::__construct();
			$this -> load -> model('Company_jd_model', '', TRUE);
			$this -> output -> set_header("Access-Control-Allow-Origin: *");
			$this -> output -> set_header("Access-Control-Expose-Headers: Access-Control-Allow-Origin");
			$this -> output -> set_status_header(200);
			$this -> output -> set_content_type('application/json');
			$this -> output -> _display();
			
			$all_methods=array('getAssocIndustries'=>array('COMPANY'),'getAssocSkills'=>array('COMPANY','JD'),
			'getSimilarCompanies'=>array('COMPANY','JD'),'howToGetInThere'=>array('COMPANY','JD'),
			'getPopularSwitchesFromCompanySpiderTool'=>array('COMPANY','JD'),
			'getSalJdCompany'=>array('COMPANY','JD'),'getAvgRateOfStay'=>array('COMPANY','JD'),
			'getLateralVsHigher'=>array('COMPANY','JD'),
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
		
		public function index() {
			//$redisObj = new Redis();
			
		}
		
		public function getAssocIndustries($getCompany) {
			$this->load->library('utility');
			$memcached =$this->utility->createContentCache();
			$result = $memcached->get('getAssocIndustries'.$getCompany);
			if($result) {					
				echo json_encode($result);
				} else {
				$data['query'] = $this -> Company_jd_model -> get_assoc_industries($getCompany);
				$memcached->set('getAssocIndustries'.$getCompany,$data['query']);
				header('Content-Type: application/json');
				echo json_encode($data['query'],JSON_NUMERIC_CHECK);
			}
		}
		
		public function getAssocSkills($getCompany, $getJd) {
			$this->load->library('utility');
			$memcached =$this->utility->createContentCache();
			$result = $memcached->get('getAssocSkills'.$getCompany.'-'.$getJd );
			if($result) {					
				echo json_encode($result);
				} else {
				$data['query'] = $this -> Company_jd_model -> get_assoc_skills($getCompany, $getJd);
				$memcached->set('getAssocSkills'.$getCompany.'-'.$getJd ,$data['query']);
				header('Content-Type: application/json');
				echo json_encode($data['query'],JSON_NUMERIC_CHECK);
			}
		}
		
		public function getSimilarCompanies($getCompany, $getJd) {
			$this->load->library('utility');
			$memcached =$this->utility->createContentCache();
			$result = $memcached->get('getSimilarCompanies'.$getCompany.'-'.$getJd );
			if($result) {					
				echo json_encode($result);
				} else {
				$data['query'] = $this -> Company_jd_model -> get_similar_companies($getCompany, $getJd);
				$memcached->set('getSimilarCompanies'.$getCompany.'-'.$getJd ,$data['query']);
				header('Content-Type: application/json');
				echo json_encode($data['query'],JSON_NUMERIC_CHECK);
			}
		}
		
		public function howToGetInThere($getCompany, $getJd) {
			$this->load->library('utility');
			$memcached =$this->utility->createContentCache();
			$result = $memcached->get('howToGetInThere'.$getCompany.'-'.$getJd );
			if($result) {					
				echo json_encode($result);
				} else {
				$data['query'] = $this -> Company_jd_model -> get_howToGetInThere($getCompany, $getJd);
				$memcached->set('howToGetInThere'.$getCompany.'-'.$getJd ,$data['query']);
				header('Content-Type: application/json');
				echo json_encode($data['query'],JSON_NUMERIC_CHECK);
			}
		}
		
		/***Not Working (For future use)***/
		public function getSalJdCompany($getCompany, $getJd) {
			$this->load->library('utility');
			$memcached =$this->utility->createContentCache();
			$result = $memcached->get('getSalJdCompany'.$getCompany.'-'.$getJd );
			if($result) {					
				echo json_encode($result);
				} else {
				$data['query'] = $this -> Company_jd_model -> get_sal_jd_company($getCompany, $getJd);
				$memcached->set('getSalJdCompany'.$getCompany.'-'.$getJd ,$data['query']);
				header('Content-Type: application/json');
				echo json_encode($data['query'],JSON_NUMERIC_CHECK);
			}
		}
		
		public function getAvgRateOfStay($getCompany, $getJd) {
			$this->load->library('utility');
			$memcached =$this->utility->createContentCache();
			$result = $memcached->get('getAvgRateOfStay'.$getCompany.'-'.$getJd );
			if($result) {					
				echo json_encode($result);
				} else {
				$data['query'] = $this -> Company_jd_model -> get_avg_stay($getCompany, $getJd);
				$memcached->set('getAvgRateOfStay'.$getCompany.'-'.$getJd ,$data['query']);
				header('Content-Type: application/json');
				echo json_encode($data['query'],JSON_NUMERIC_CHECK);
			}
		}
		
		public function getPopularSwitchesFromCompany($getCompany, $getJd) {
			$this->load->library('utility');
			$memcached =$this->utility->createContentCache();
			$result = $memcached->get('getPopularSwitchesFromCompany'.$getCompany.'-'.$getJd );
			if($result) {					
				echo json_encode($result);
				} else {
				$data['query'] = $this -> Company_jd_model -> get_popular_switches_from_company($getCompany, $getJd);
				$memcached->set('getPopularSwitchesFromCompany'.$getCompany.'-'.$getJd ,$data['query']);
				header('Content-Type: application/json');
				echo json_encode($data['query'],JSON_NUMERIC_CHECK);
			}
		}
		
		public function getPopularSwitchesToCompany($getCompany, $getJd) {
			$this->load->library('utility');
			$memcached =$this->utility->createContentCache();
			$result = $memcached->get('getPopularSwitchesToCompany'.$getCompany.'-'.$getJd );
			if($result) {					
				echo json_encode($result);
				} else {
				$data['query'] = $this -> Company_jd_model -> get_popular_switches_to_company($getCompany, $getJd);
				$memcached->set('getPopularSwitchesToCompany'.$getCompany.'-'.$getJd ,$data['query']);
				header('Content-Type: application/json');
				echo json_encode($data['query'],JSON_NUMERIC_CHECK);
			}
		}
		
		public function getLateralVsHigher($getCompany, $getJd) {
			$this->load->library('utility');
			$memcached =$this->utility->createContentCache();
			$result = $memcached->get('getLateralVsHigher'.$getCompany.'-'.$getJd );
			if($result) {					
				echo json_encode($result);
				} else {
				$data['query'] = $this -> Company_jd_model -> get_Lateral_Vs_Higher($getCompany, $getJd);
				$memcached->set('getLateralVsHigher'.$getCompany.'-'.$getJd ,$data['query']);
				header('Content-Type: application/json');
				echo json_encode($data['query'],JSON_NUMERIC_CHECK);
			}
		}
		
		public function getPopularSwitchesFromCompanySpiderTool($getCompany, $getJd) {
			$this->load->library('utility');
			$memcached =$this->utility->createContentCache();
			$result = $memcached->get('getPopularSwitchesFromCompanySpiderTool'.$getCompany.'-'.$getJd );
			if($result) {					
				echo json_encode($result);
				} else {
				$data['query'] = $this -> Company_jd_model -> get_Popular_Switches_FromCompany_forSpiderTool($getCompany, $getJd);
				$memcached->set('getPopularSwitchesFromCompanySpiderTool'.$getCompany.'-'.$getJd ,$data['query']);
				header('Content-Type: application/json');
				echo json_encode($data['query'],JSON_NUMERIC_CHECK);
			}
		}
		
	}
?>