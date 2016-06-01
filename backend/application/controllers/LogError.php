<?php
    class LogError extends CI_Controller {
		
		public function __construct()
        {
            parent::__construct();
			$this->output->set_header("Access-Control-Allow-Origin: *");
			$this->output->set_header("Access-Control-Expose-Headers: Access-Control-Allow-Origin");
			$this->output->set_status_header(200);
			$this->output->set_content_type('application/json');
			$this->output->_display();
			
			
            $all_methods=array('logError'=>array('data'),'getLogError'=>array());
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
		
        public function logError($data){
			$datetime = date('l jS \of F Y h:i:s A');
			$data = "********". $datetime . "********\n".urldecode($data)."\n\n";
			$data = str_replace("~","/",$data);
			$this->load->helper('file');
			$return = array();
			if ( ! write_file('application/logs/frontend_log.txt', $data,'a+'))
			{
					$return = array('status'=>'falied');
			}
			else
			{
					$return = array('status'=>'success');
			}	
			
			echo json_encode($return);
		}
		
		public  function getLogError(){
			$result = file_get_contents('application/logs/frontend_log.txt');
			echo $result;
		}
		
		
	}
?>