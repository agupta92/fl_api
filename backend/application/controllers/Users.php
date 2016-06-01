<?php
    class Users extends CI_Controller {
        
    public function __construct()
        {
            parent::__construct();
            $this->load->model('Users_model','',TRUE);
        }    
        
	public function index()
        {	echo "yo";
			//$redisObj = new Redis(); 
        }
        public function setUser($user_name,$user_email,$skype,$contact_no,$pass,$linkedin,$github,$stackoverflow,$degree,$user_college,$user_type)
        { //echo "yo";exit;
            //var_dump($user_name);exit;
        //print_r($_POST);
            $data['query'] = $this->Users_model->set_user($user_name,$user_email,$skype,$contact_no,$pass,$linkedin,$github,$stackoverflow,$degree,$user_college,$user_type);
            echo json_encode($data['query']);
        }
        
        public function getAssocCompanies($sessionId)
        {
            $data['query'] = $this->Users_model->get_assoc_companies($sessionId);
            echo json_encode($data['query']);
        }
		
		public function getAssocSkills($sessionId)
        {
            $data['query'] = $this->Users_model->get_assoc_skills($sessionId);
            echo json_encode($data['query']);
        }
		
		public function getAssocJd($sessionId)
        {
            $data['query'] = $this->Users_model->get_assoc_jd($sessionId);
            echo json_encode($data['query']);
        }

		public function setStudentDetails($sessionId,$curr_colg,$curr_branch,$curr_skills,$company_aspire){
					
               $data['query'] = $this->load->model('Users_model','',TRUE);
				$data['query'] =$this->Users_model->set_student_details($sessionId,$curr_colg,$curr_branch,$curr_skills,$company_aspire);				
        		echo json_encode($data['query']);
		}
		
		public function setProfessionalDetails($sessionId,$curr_commpany,$curr_jd,$curr_skills,$company_aspire){
					
               $data['query'] = $this->load->model('Users_model','',TRUE);
				$data['query'] =$this->Users_model->set_professional_details($sessionId,$curr_commpany,$curr_jd,$curr_skills,$company_aspire);
				echo json_encode($data['query']);
        }
    }
?>