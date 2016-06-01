<?php
    class NF404 extends CI_Controller {
		public function __construct()
        {
            parent::__construct();

            header('HTTP/ 404 Nothing Found');
			$this->output->set_header("Access-Control-Allow-Origin: *");
			$this->output->set_header("Access-Control-Expose-Headers: Access-Control-Allow-Origin");
			$this->output->set_status_header(200);
			$this->output->set_content_type('application/json');
			$this->output->_display();
		}
		public function index()
        {
			$result['call']=array('success'=>false,'code'=>4,'message'=>'404 Not found');
			$result['call']['meta']=array('total'=>0);
			$result['call']['response']=array('description'=>'You are in wrong neighbourhood! ');
			echo(json_encode($result));
		}
	}
?>