<?php
    class Test extends CI_Controller {
		
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
        {	echo("You are in wrong motherhood! Neighbour fucker!");											
		}	
		
        public function test(){
			$ip = $this->input->ip_address();
			echo $ip;
        }
		
		
}
?>
