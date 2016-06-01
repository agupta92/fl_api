	<?php
    class ContentRedis extends CI_Controller {
        
        public function __construct()
        {
            parent::__construct();
            $this->output->set_header("Access-Control-Allow-Origin: *");
            $this->output->set_header("Access-Control-Expose-Headers: Access-Control-Allow-Origin");
            $this->output->set_status_header(200);
            $this->output->set_content_type('application/json');
            $this->output->_display();
        }
        
        public function index()
        {
            echo 'Hello !';
			$this->load->library('rediscachinglib');
			$key="LoduTwo";
			$value="Lodu Chatterjee";
			$myObj1=$this->rediscachinglib->setValuefromKey($key, $value);
			$myObj2=$this->rediscachinglib->getValuefromKey($key );
			echo($myObj1."->".$myObj2);
		}	
        public function getAllQuestions(){
                //echo($id);
                $this->load->model('contentmodel','',TRUE);
                $data['query'] = $this->contentmodel->get_all_questions();
                echo json_encode($data['query'],JSON_NUMERIC_CHECK);
        }
		
		
        public function getLatestQuestions(){
                //echo($id);
				$this->load->model('contentmodel','',TRUE);
                $data['query'] = $this->contentmodel->get_new_questions();
                echo json_encode($data['query'],JSON_NUMERIC_CHECK);
        }
        
        public function getAllAnswers(){
                //echo($id);
                $this->load->model('contentmodel','',TRUE);
                $data['query'] = $this->contentmodel->get_all_answers();
                echo json_encode($data['query'],JSON_NUMERIC_CHECK);
        }
        
        public function getLatestAnswers(){
				$this->load->library('rediscachinglib');
				$result = $this->rediscachinglib->getValuefromKey('LatestAnswers');
				if($result) {
					echo ($result);
				} else {
					$this->load->model('contentmodel','',TRUE);
					$data['query'] = $this->contentmodel->get_new_answers();
					$this->rediscachinglib->setValuefromKey('LatestAnswers', json_encode($data['query']));
					echo json_encode($data['query'],JSON_NUMERIC_CHECK);
				}
        }
		
		public function getAllPosts($userId){
				
				$this->load->library('rediscachinglib');
				$result = $this->rediscachinglib->getValuefromKey('allPost_'.$userId);
				if($result) {
					echo ($result);
				} else {
				  $this->load->model('contentmodel','',TRUE);
				  $data['query'] = $this->contentmodel->get_all_posts($userId);
				  $this->rediscachinglib->setValuefromKey('allPost_'.$userId, json_encode($data['query']));
				  echo json_encode($data['query'],JSON_NUMERIC_CHECK);
				}
				
				
        }
        
        public function getAlumniPosts($userId){                             
                $this->load->library('rediscachinglib');
				$result = $this->rediscachinglib->getValuefromKey('allPost_'.$userId);
				if($result) {
					echo ($result);
				} else {
				$this->load->model('contentmodel','',TRUE);    
                $data['query'] = $this->contentmodel->get_alumni_posts($userId);
				$this->rediscachinglib->setValuefromKey('allPost_'.$userId, json_encode($data['query']));
                echo json_encode($data['query'],JSON_NUMERIC_CHECK);
                }
        }
		
		public function getAlumniQuotes($userId){ 
				$this->load->library('rediscachinglib');
				$result = $this->rediscachinglib->getValuefromKey('allPost_'.$userId);
				if($result) {
					echo ($result);
				} else {		
                $this->load->model('contentmodel','',TRUE);    
                $data['query'] = $this->contentmodel->get_alumni_quotes($userId);
				$this->rediscachinglib->setValuefromKey('allPost_'.$userId, json_encode($data['query']));
                echo json_encode($data['query'],JSON_NUMERIC_CHECK);
                }
        }
		
        public function getAlumniDetails($userId){
				$this->load->library('rediscachinglib');
				$result = $this->rediscachinglib->getValuefromKey('allPost_'.$userId);
				if($result) {
					echo ($result);
				} else {		
				$this->load->model('contentmodel','',TRUE);    
                $data['query'] = $this->contentmodel->get_alumini_detail($userId);   
                $data['query']['timeline'] = $this->contentmodel->get_alumini_timeline($userId);
				$this->rediscachinglib->setValuefromKey('allPost_'.$userId, json_encode($data['query']));
                echo json_encode($data['query'],JSON_NUMERIC_CHECK);
				}
                
        }
		public function getPostsPopularity($userId,$limit){
                $time_pre = microtime(true);
				$this->load->library('rediscachinglib');
				//$this->rediscachinglib->flush();
				$result = $this->rediscachinglib->getValuefromKey('allPost_'.$userId);
				if($result) {
					echo $result;
					$time_post = microtime(true);
					$exec_time = $time_post - $time_pre;
				echo 'Time taken'.$exec_time;  	
				} else {	
				$this->load->model('contentmodel','',TRUE);    
                $data['query'] = $this->contentmodel->get_posts_popularity($userId,$limit);
				$this->rediscachinglib->setValuefromKey('allPost_'.$userId, json_encode($data['query']));
                echo json_encode($data['query']);
				$time_post = microtime(true);
				$exec_time = $time_post - $time_pre;
				echo 'Time taken'.$exec_time;  				
				}
				
              
        }
        
        
    }
?>	