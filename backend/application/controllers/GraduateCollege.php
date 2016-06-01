<?php
    class GraduateCollege extends CI_Controller {
		
        public function __construct()
        {
            parent::__construct();
            $this->load->model('Graduate_college_model','',TRUE);
			$this->output->set_header("Access-Control-Expose-Headers: Access-Control-Allow-Origin");
			$this->output->set_status_header(200);
			$this->output->set_content_type('application/json');
			$this->output->_display();
			
			$all_methods=array('coreCompanyHiring'=>array('COLLEGE'),'nonCoreCompanyHiring'=>array('COLLEGE'),'whatPeopleAreDoing'=>array('COLLEGE'),'wherePeopleAreMoving'=>array('COLLEGE'));
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
        
        public function coreCompanyHiring($college){
			$college = urldecode($college);
			//$this->load->library('utility');
			//$memcached =$this->utility->createContentCache();
			//$result = $memcached->get('companyHiring'.$college);
			//if($result) {					
			//	echo json_encode($result);
			//	} else {
				$data['query'] = $this-> Graduate_college_model-> core_company_hiring($college);
				//$memcached->set('companyHiring'.$getCompany,$data['query']);
				header('Content-Type: application/json');
				echo json_encode($data['query'],JSON_NUMERIC_CHECK);
			//} 
		}
		
		public function nonCoreCompanyHiring($college){
			$college = urldecode($college);
			//$this->load->library('utility');
			//$memcached =$this->utility->createContentCache();
			//$result = $memcached->get('industryHiring'.$college);
			//if($result) {					
			//	echo json_encode($result);
			//	} else {
				$data['query'] = $this->Graduate_college_model->noncore_industry_hiring($college);
				//$memcached->set('industryHiring'.$getCompany,$data['query']);
				header('Content-Type: application/json');
				echo json_encode($data['query'],JSON_NUMERIC_CHECK);
			//} 
		}
		
		public function whatPeopleAreDoing($college){
			$college = urldecode($college);
			//$this->load->library('utility');
			//$memcached =$this->utility->createContentCache();
			//$result = $memcached->get('companyHiring'.$college);
			//if($result) {					
			//	echo json_encode($result);
			//	} else {
				$data['query'] = $this->Graduate_college_model->what_people_are_doing($college);
				//$memcached->set('companyHiring'.$getCompany,$data['query']);
				header('Content-Type: application/json');
				echo json_encode($data['query'],JSON_NUMERIC_CHECK);
			//} 
		}
		
		public function wherePeopleAreMoving($college){
			$college = urldecode($college);
			//$this->load->library('utility');
			//$memcached =$this->utility->createContentCache();
			//$result = $memcached->get('companyHiring'.$college);
			//if($result) {					
			//	echo json_encode($result);
			//	} else {
				$data['query'] = $this->Graduate_college_model->where_people_are_moving($college);
				//$memcached->set('companyHiring'.$getCompany,$data['query']);
				header('Content-Type: application/json');
				echo json_encode($data['query'],JSON_NUMERIC_CHECK);
			//} 
		}
		
		
        
       
	}
	
?>