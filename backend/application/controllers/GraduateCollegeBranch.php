<?php
    class GraduateCollegeBranch extends CI_Controller {
		
        public function __construct()
        {
            parent::__construct();
            $this->load->model('Graduate_college_branch_model','',TRUE);
			$this->output->set_header("Access-Control-Expose-Headers: Access-Control-Allow-Origin");
			$this->output->set_status_header(200);
			$this->output->set_content_type('application/json');
			$this->output->_display();
			
			$all_methods=array('companyHiring'=>array('BRANCH','INSTITUTE'),'industryHiring'=>array('BRANCH','Industry'),'similarBranch'=>array('BRANCH','Industry'),'relatedSkills'=>array('BRANCH','Industry'),'relatedSkills'=>array('BRANCH','Industry'),
			'whatPeopleAreDoing'=>array('BRANCH','Industry'));
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
        
        public function companyHiring($branch , $institute){
			$branch = urldecode($branch);
			$institute = urldecode($institute);
			//$this->load->library('utility');
			//$memcached =$this->utility->createContentCache();
			//$result = $memcached->get('companyHiring'.$branch);
			//if($result) {					
			//	echo json_encode($result);
			//	} else {
				$data['query'] = $this->Graduate_college_branch_model->company_hiring($branch, $institute);
				//$memcached->set('companyHiring'.$getCompany,$data['query']);
				header('Content-Type: application/json');
				echo json_encode($data['query'],JSON_NUMERIC_CHECK);
			//} 
		}
		
		public function industryHiring($branch, $institute){
			$branch = urldecode($branch);
			$institute = urldecode($institute);
			//$this->load->library('utility');
			//$memcached =$this->utility->createContentCache();
			//$result = $memcached->get('industryHiring'.$branch);
			//if($result) {					
			//	echo json_encode($result);
			//	} else {
				$data['query'] = $this->Graduate_college_branch_model->industry_hiring($branch, $institute);
				//$memcached->set('industryHiring'.$getCompany,$data['query']);
				header('Content-Type: application/json');
				echo json_encode($data['query'],JSON_NUMERIC_CHECK);
			//} 
		}
		
		public function similarBranch($branch , $institute){
			$branch = urldecode($branch);
			$institute = urldecode($institute);
			//$this->load->library('utility');
			//$memcached =$this->utility->createContentCache();
			//$result = $memcached->get('companyHiring'.$branch);
			//if($result) {					
			//	echo json_encode($result);
			//	} else {
				$data['query'] = $this->Graduate_college_branch_model->similar_branch($branch , $institute);
				//$memcached->set('companyHiring'.$getCompany,$data['query']);
				header('Content-Type: application/json');
				echo json_encode($data['query'],JSON_NUMERIC_CHECK);
			//} 
		}
		
		public function relatedSkills($branch, $institute){
			$branch = urldecode($branch);
			$institute = urldecode($institute);
			//$this->load->library('utility');
			//$memcached =$this->utility->createContentCache();
			//$result = $memcached->get('companyHiring'.$branch);
			//if($result) {					
			//	echo json_encode($result);
			//	} else {
				$data['query'] = $this->Graduate_college_branch_model->related_skills($branch, $institute);
				//$memcached->set('companyHiring'.$getCompany,$data['query']);
				header('Content-Type: application/json');
				echo json_encode($data['query'],JSON_NUMERIC_CHECK);
			//} 
		}
		
		public function whatPeopleAreDoing($branch, $institute){
			$branch = urldecode($branch);
			$institute = urldecode($institute);
			//$this->load->library('utility');
			//$memcached =$this->utility->createContentCache();
			//$result = $memcached->get('companyHiring'.$branch);
			//if($result) {					
			//	echo json_encode($result);
			//	} else {
				$data['query'] = $this->Graduate_college_branch_model->what_people_are_doing($branch, $institute);
				//$memcached->set('companyHiring'.$getCompany,$data['query']);
				header('Content-Type: application/json');
				echo json_encode($data['query'],JSON_NUMERIC_CHECK);
			//} 
		}
		
		
        
       
	}
	
?>