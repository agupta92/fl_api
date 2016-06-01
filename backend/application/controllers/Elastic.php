<?php
    class Elastic extends CI_Controller {
        
        public function __construct()
	       {
	            parent::__construct(); //This is Compulsary to Call
	            $this->load->library('elasticsearch');	//Initiates the ElasticSearch Library for whole file
                    $this->output->set_header("Access-Control-Allow-Origin: *");
                    $this->output->set_header("Access-Control-Expose-Headers: Access-Control-Allow-Origin");
                    $this->output->set_status_header(200);
                    $this->output->set_content_type('application/json');
                    $this->output->_display();
                    
	       }

        public function index()
        {
			/* Check the status of elastic search */
			echo(json_encode($this->elasticsearch->status(),JSON_NUMERIC_CHECK));
		}	
        
		public function countAll(){
			/* Get Count of All */
			echo(json_encode($this->elasticsearch->count()));
		}


		public function deleteData(){
			/* Get Count of All */
			$id=1;
			echo(json_encode($this->elasticsearch->delete($id)));
		}
        
        public function addDataMain(){
			/* Get Count of All */
			
			$id=$_POST['getId'];
			$data=$_POST['getData'];
			//echo($id." - ".$data."<br />");
			$this->load->library('elasticmain');
            echo(json_encode($this->elasticmain->add($id,$data)));
		}
		
		public function addData(){
			/* Get Count of All */
			
			$id=$_POST['getId'];
			$data=$_POST['getData'];
			//echo($id." - ".$data."<br />");
			echo(json_encode($this->elasticsearch->add($id,$data)));
		}
		public function search(){
			$term=$_GET['q'];
			echo(json_encode($this->elasticsearch->query_all($term)));
			
		}
        public function searchAlone(){
			$term=$_GET['q'];
			$len=(strlen($term));
            $this->load->library('elasticmain');
            if($len<3){
                echo(json_encode($this->elasticmain->query($term)));
            }else{
                echo(json_encode($this->elasticmain->query_three($term)));
            }
			
		}


		public function setAllSearch(){
                //echo($id);
                $this->load->model('contentmodel','',TRUE);
                $data['query'] = $this->contentmodel->get_all_questions();
                echo json_encode($data['query'],JSON_NUMERIC_CHECK);
        }
	
    }
?>	