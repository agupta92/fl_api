<?php
    class PgBranch extends CI_Controller {
		
        public function __construct()
        {
            parent::__construct();
            $this->load->model('Pg_branch_model','',TRUE);
			$this->output->set_header("Access-Control-Expose-Headers: Access-Control-Allow-Origin");
			$this->output->set_status_header(200);
			$this->output->set_content_type('application/json');
			$this->output->_display();
			
			$all_methods=array('popularColleges'=>array('BRANCH', 'LOCATION'), 'popularDegree'=>array('BRANCH', 'LOCATION'),'companyHiring'=>array('BRANCH', 'LOCATION'),'industryHiring'=>array('BRANCH', 'LOCATION'),
			'similarTechBranch'=>array('BRANCH', 'LOCATION'),'similarNontechBranch'=>array('BRANCH', 'LOCATION'),'relatedSkills'=>array('BRANCH', 'LOCATION'),'relatedSkills'=>array('BRANCH', 'LOCATION'),
			'peopleComingFrom'=>array('BRANCH', 'LOCATION'),'peopleGettingHiredSectors'=>array('BRANCH', 'LOCATION'),'peopleGettingThere'=>array('BRANCH', 'LOCATION'));
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
		
		public function popularColleges($branch, $location){
			$branch  = urldecode($branch);
			$location = urldecode($location);
			//$this->load->library('utility');
			//$memcached =$this->utility->createContentCache();
			//$result = $memcached->get('companyHiring'.$branch, $location);
			//if($result) {					
			//	echo json_encode($result);
			//	} else {
				$data['query'] = $this->Pg_branch_model->popular_colleges($branch, $location);
				//$memcached->set('companyHiring'.$getCompany,$data['query']);
				header('Content-Type: application/json');
				echo json_encode($data['query'],JSON_NUMERIC_CHECK);
			//} 
		}
		
		 public function popularDegree($branch, $location){
			$branch  = urldecode($branch);
			$location = urldecode($location);
			//$this->load->library('utility');
			//$memcached =$this->utility->createContentCache();
			//$result = $memcached->get('companyHiring'.$branch, $location);
			//if($result) {					
			//	echo json_encode($result);
			//	} else {
				$data['query'] = $this->Pg_branch_model->popular_degree($branch, $location);
				//$memcached->set('companyHiring'.$getCompany,$data['query']);
				header('Content-Type: application/json');
				echo json_encode($data['query'],JSON_NUMERIC_CHECK);
			//} 
		}
        
        public function companyHiring($branch, $location){
			$branch  = urldecode($branch);
			$location = urldecode($location);
			//$this->load->library('utility');
			//$memcached =$this->utility->createContentCache();
			//$result = $memcached->get('companyHiring'.$branch, $location);
			//if($result) {					
			//	echo json_encode($result);
			//	} else {
				$data['query'] = $this->Pg_branch_model->company_hiring($branch, $location);
				//$memcached->set('companyHiring'.$getCompany,$data['query']);
				header('Content-Type: application/json');
				echo json_encode($data['query'],JSON_NUMERIC_CHECK);
			//} 
		}
		
		public function industryHiring($branch, $location){
			$branch  = urldecode($branch);
			$location = urldecode($location);
			//$this->load->library('utility');
			//$memcached =$this->utility->createContentCache();
			//$result = $memcached->get('industryHiring'.$branch, $location);
			//if($result) {					
			//	echo json_encode($result);
			//	} else {
				$data['query'] = $this->Pg_branch_model->industry_hiring($branch, $location);
				//$memcached->set('industryHiring'.$getCompany,$data['query']);
				header('Content-Type: application/json');
				echo json_encode($data['query'],JSON_NUMERIC_CHECK);
			//} 
		}
		
		public function similarTechBranch($branch, $location){
			$branch  = urldecode($branch);
			$location = urldecode($location);
			//$this->load->library('utility');
			//$memcached =$this->utility->createContentCache();
			//$result = $memcached->get('companyHiring'.$branch, $location);
			//if($result) {					
			//	echo json_encode($result);
			//	} else {
				$data['query'] = $this->Pg_branch_model->similar_tech_branch($branch, $location);
				//$memcached->set('companyHiring'.$getCompany,$data['query']);
				header('Content-Type: application/json');
				echo json_encode($data['query'],JSON_NUMERIC_CHECK);
			//} 
		}
		
		public function similarNontechBranch($branch, $location){
			$branch  = urldecode($branch);
			$location = urldecode($location);
			//$this->load->library('utility');
			//$memcached =$this->utility->createContentCache();
			//$result = $memcached->get('companyHiring'.$branch, $location);
			//if($result) {					
			//	echo json_encode($result);
			//	} else {
				$data['query'] = $this->Pg_branch_model->similar_nontech_branch($branch, $location);
				//$memcached->set('companyHiring'.$getCompany,$data['query']);
				header('Content-Type: application/json');
				echo json_encode($data['query'],JSON_NUMERIC_CHECK);
			//} 
		}
		
		public function peopleComingFrom($branch, $location){
			$branch  = urldecode($branch);
			$location = urldecode($location);
			//$this->load->library('utility');
			//$memcached =$this->utility->createContentCache();
			//$result = $memcached->get('companyHiring'.$branch, $location);
			//if($result) {					
			//	echo json_encode($result);
			//	} else {
				$data['query'] = $this-> Pg_branch_model-> people_coming_from($branch, $location);
				//$memcached->set('companyHiring'.$getCompany,$data['query']);
				header('Content-Type: application/json');
				echo json_encode($data['query'],JSON_NUMERIC_CHECK);
			//} 
		}
		
		public function peopleGettingHiredSectors($branch, $location){
			$branch  = urldecode($branch);
			$location = urldecode($location);
			//$this->load->library('utility');
			//$memcached =$this->utility->createContentCache();
			//$result = $memcached->get('companyHiring'.$branch, $location);
			//if($result) {					
			//	echo json_encode($result);
			//	} else {
				$data['query'] = $this-> Pg_branch_model-> people_getting_hired_sectors($branch, $location);
				//$memcached->set('companyHiring'.$getCompany,$data['query']);
				header('Content-Type: application/json');
				echo json_encode($data['query'],JSON_NUMERIC_CHECK);
			//} 
		}
		
		public function peopleGettingThere($branch, $location){
			$branch  = urldecode($branch);
			$location = urldecode($location);
			//$this->load->library('utility');
			//$memcached =$this->utility->createContentCache();
			//$result = $memcached->get('companyHiring'.$branch, $location);
			//if($result) {					
			//	echo json_encode($result);
			//	} else {
				$data['query'] = $this-> Pg_branch_model-> people_getting_there($branch, $location);
				//$memcached->set('companyHiring'.$getCompany,$data['query']);
				header('Content-Type: application/json');
				echo json_encode($data['query'],JSON_NUMERIC_CHECK);
			//} 
		}
		
		
        
       
	}
	
?>