<?php
    class Jd extends CI_Controller {
		
        public function __construct()
        {
            parent::__construct();
            $this->load->model('Jd_model','',TRUE);
			$this->output->set_header("Access-Control-Allow-Origin: *");
			$this->output->set_header("Access-Control-Expose-Headers: Access-Control-Allow-Origin");
			$this->output->set_status_header(200);
			$this->output->set_content_type('application/json');
			$this->output->_display();
			
            $all_methods=array('getAssocIndustries'=>array('JD'),'getAssocSkills'=>array('JD'),'getAssocCompanies'=>array('JD'),'getAssocSal'=>array('JD'));
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
        
		public function getAssocIndustries($jd){
			$this->load->library('utility');
			$memcached =$this->utility->createContentCache();
			$result = $memcached->get('getAssocIndustries'.$jd);
			if($result) {					
				echo json_encode($result);
				} else {
				$data['query'] = $this->Jd_model->get_assoc_industries($jd);
				$memcached->set('getAssocIndustries'.$jd,$data['query']);
				header('Content-Type: application/json');
				echo json_encode($data['query'],JSON_NUMERIC_CHECK);
			}
		}
		
        public function getAssocSkills($jd){
			$this->load->library('utility');
			$memcached =$this->utility->createContentCache();
			$result = $memcached->get('getAssocSkills'.$jd);
			if($result) {					
				echo json_encode($result);
				} else {
				$data['query'] = $this->Jd_model->get_assoc_skills($jd);
				$memcached->set('getAssocSkills'.$jd,$data['query']);
				header('Content-Type: application/json');
				echo json_encode($data['query'],JSON_NUMERIC_CHECK);
			}
		}
		
        
        public function getAssocCompanies($jd){
			$this->load->library('utility');
			$memcached =$this->utility->createContentCache();
			$result = $memcached->get('getAssocCompanies'.$jd);
			if($result) {					
				echo json_encode($result);
				} else {
				$data['query'] = $this->Jd_model->get_assoc_company($jd);
				$memcached->set('getAssocCompanies'.$jd,$data['query']);
				header('Content-Type: application/json');
				echo json_encode($data['query'],JSON_NUMERIC_CHECK);
			}
		}
		
		public function getAssocSal($jd){
			$this->load->library('utility');
			$memcached =$this->utility->createContentCache();
			$result = $memcached->get('getAssocSal'.$jd);
			if($result) {					
				echo json_encode($result);
				} else {
				$data['query'] = $this->Jd_model->get_available_salary($jd);
				$memcached->set('getAssocSal'.$jd,$data['query']);
				header('Content-Type: application/json');
				echo json_encode($data['query'],JSON_NUMERIC_CHECK);
			}
		}      
	}
?>