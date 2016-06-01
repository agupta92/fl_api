<?php
    class Feedback extends CI_Controller {
		
    public function __construct()
        {
            parent::__construct();
            $this->load->model('feedback_model','',TRUE);
			$this->output->set_header("Access-Control-Allow-Origin: *");
			$this->output->set_header("Access-Control-Expose-Headers: Access-Control-Allow-Origin");
			$this->output->set_status_header(200);
			$this->output->set_content_type('application/json');
			$this->output->_display();
			
            $all_methods=array('setEmailId'=>array('EMAIL ID'),'sendMailOnSubscritpion'=>array('EMAIL ID'),'getInterviewRequest'=>array('EMAIL ID' , 'P NO'),'sendMailOnSignup'=>array('EMAIL ID'),'onUnsubscribed'=>array('EMAIL ID'),'contactUs'=>array('NAME','EMAIL ID','COMMMENT'),'joinUs'=>array('NAME', 'EMAIL ID')'sendMailWeekly'=>array('EMAIL ID'));
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
        {	echo("You are in wrong motherhood! Neighbour fucker!");											
		}	
		
        public function setEmailId($email){
                	
                $data['query'] = $this->feedback_model->set_emailid($email);
				//var_dump($data['query']['call']['message']);
				if(strcmp($data['query']['call']['message'], "You have alredy been Subscribed")!=0){
					$this->feedback_model->send_mail_on_subcription($email);
				}
				
                echo json_encode($data['query'],JSON_NUMERIC_CHECK);
        }
		
		public function sendMailOnSubscritpion($email){
                	
                $data['query'] = $this->feedback_model->send_mail_on_subcription($email);
				
                //echo json_encode($data['query'],JSON_NUMERIC_CHECK);
        }
		
		public function sendMailOnSignup($email,$name){
                	
                $data['query'] = $this->feedback_model->send_mail_on_signup($email,$name);
			    $this->feedback_model-> set_emailidOnSignup($name, $email);
					
                echo json_encode($data['query'],JSON_NUMERIC_CHECK);
        }
		
		public function getInterviewRequest($email,$pno){
                $email = urldecode($email);	
                $data['query'] = $this->feedback_model->get_interview_request($email,$pno);				
                echo json_encode($data['query'],JSON_NUMERIC_CHECK);
        }
		
		public function onUnsubscribed($email){
                $email = urldecode($email);	
                $data['query'] = $this->feedback_model->on_unsubscribed($email);				
                echo json_encode($data['query'],JSON_NUMERIC_CHECK);
        }
		
		public function joinUs($name, $email){
                $email = urldecode($email);	
                $data['query'] = $this->feedback_model->set_joinus($name, $email);				
                echo json_encode($data['query'],JSON_NUMERIC_CHECK);
        }
		
		public function contactUs($name, $email, $comment){
                $email = urldecode($email);	
                $data['query'] = $this->feedback_model->set_contactus($name, $email, $comment);				
                echo json_encode($data['query'],JSON_NUMERIC_CHECK);
        }
		
		public function sendMailWeekly($email){  
        	$email = urldecode($email);     
                $data['query'] = $this->feedback_model-> send_mail_weekly($email);				
                echo json_encode($data['query'],JSON_NUMERIC_CHECK);
        }
	
        
    }
?>