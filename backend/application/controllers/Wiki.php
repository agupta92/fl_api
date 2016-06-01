<?php
    class Wiki extends CI_Controller {
        
        public function __construct()
        {
            parent::__construct();
            $this->output->set_header("Access-Control-Allow-Origin: *");
            $this->output->set_header("Access-Control-Expose-Headers: Access-Control-Allow-Origin");
            $this->output->set_status_header(200);
            $this->output->set_content_type('application/json');
            $this->output->_display();
            $all_methods=array('getWiki'=>array('KeyWord'));
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
		
		public function getWiki($type,$keyword){
				$keyword = urldecode($keyword);
			    $this->load->library('utility');
				$memcached =$this->utility->createContentCache();
				// //$userId = $this->utility->my_decrypt($userId,"bawaseer123$*123");
				// $memcached->flush();
				$result = $memcached->get($type.":".$keyword);
				if($result) {
					echo json_encode($result);
				} else {
				  $this->load->model('wiki_model','',TRUE);
				  $data['query'] = $this->wiki_model->get_wiki($type,$keyword);
				  $memcached->set($type.":".$keyword,$data['query']);
				  header('Content-Type: application/json');
				  echo json_encode($data['query'],JSON_NUMERIC_CHECK);
				}
				
				
        }
     

        
    }
?>