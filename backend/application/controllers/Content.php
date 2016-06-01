<?php
class Content extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Content_model','',TRUE);
        $this->output->set_header("Access-Control-Expose-Headers: Access-Control-Allow-Origin");
        $this->output->set_status_header(200);
        $this->output->set_content_type('application/json');
        $this->output->_display();

        $all_methods=array('getAllPosts'=>array('USER ID'),'getAlumniPosts'=>array('USER ID'),'getAlumniQuotes'=>array('USER ID'),'getAlumniDetails'=>array('USER ID'),'getPostsPopularity'=>array('USER ID','LIMIT'),'getRelatedAlumni'=>array('USER ID','KEYWORDS','LIMIT'),'getRelatedQue'=>array('tags'),'getRelatedSkills'=>array('Alumni ID'),'setHelpful'=>array('Alumni ID'));
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

    public function getAllPosts($userId){

        $this->load->library('utility');
        $memcached =$this->utility->createContentCache();
        $userId = $this->utility->my_decrypt($userId,"bawaseer123$*123");
        //$memcached->flush();
        $result = $memcached->get('allPost_'.$userId);
        if($result) {
            echo json_encode($result);
        } else {
            $this->load->model('content_model','',TRUE);
            $data['query'] = $this->content_model->get_all_posts($userId);
            $memcached->set('allPost_'.$userId,$data['query']);
            header('Content-Type: application/json');
            echo json_encode($data['query'],JSON_NUMERIC_CHECK);
        }
    }

    public function getAlumniPosts($userId){
        $this->load->library('utility');
        $userId = $this->utility->my_decrypt($userId,"bawaseer123$*123");

        $memcached =$this->utility->createContentCache();
        //$memcached->flush();
        $result = $memcached->get('AlumniPosts_'.$userId);
        if($result) {
            echo json_encode($result);
        } else {
            $this->load->model('content_model','',TRUE);
            $data['query'] = $this->content_model->get_alumni_posts($userId);
            $memcached->set('AlumniPosts_'.$userId,$data['query']);
            echo json_encode($data['query'],JSON_NUMERIC_CHECK);
        }
    }

    public function getAlumniQuotes($userId){
        $this->load->library('utility');
        $userId = $this->utility->my_decrypt($userId,"bawaseer123$*123");
        $memcached =$this->utility->createContentCache();
        //$memcached->flush();
        $result = $memcached->get('AlumniQuotes_'.$userId);
        if($result) {
            echo json_encode($result);
        } else {
            $this->load->model('content_model','',TRUE);
            $data['query'] = $this->content_model->get_alumni_quotes($userId);
            $memcached->set('AlumniQuotes_'.$userId,$data['query']);
            echo json_encode($data['query'],JSON_NUMERIC_CHECK);
        }
    }

    public function getAlumniDetails($userId){
        $this->load->library('utility');
        $userId = $this->utility->my_decrypt($userId,"bawaseer123$*123");
        $memcached =$this->utility->createContentCache();
        $memcached->flush();
        $result = $memcached->get('AlumniDetails_'.$userId);
        if($result) {
            echo json_encode($result);
        } else {
            $this->load->model('content_model','',TRUE);
            $data['query'] = $this->content_model->get_alumini_detail($userId);
            $data['query']['timeline'] = $this->content_model->get_alumini_timeline($userId);
            $memcached->set('AlumniDetails_'.$userId,$data['query']);
            echo json_encode($data['query'],JSON_NUMERIC_CHECK);
        }

    }
    public function getPostsPopularity($userId,$limit){
        $time_pre = microtime(true);
        $this->load->library('utility');
        $memcached =$this->utility->createContentCache();
        //$memcached->flush();
        $result = $memcached->get('PostsPopularity_'.$userId.'limit'.$limit);
        if($result) {
            echo json_encode($result);
        } else {
            $this->load->model('content_model','',TRUE);
            $data['query'] = $this->content_model->get_posts_popularity($userId,$limit);
            $memcached->set('PostsPopularity_'.$userId.'limit'.$limit,$data['query']);
            echo json_encode($data['query'],JSON_NUMERIC_CHECK);
        }
    }

    public function getRelatedAlumni($id,$keywords,$limit){
        $this->load->library('utility');
        $id = $this->utility->my_decrypt($id,"bawaseer123$*123");
        $this->load->model('content_model','',TRUE);
        $data['query'] = $this->content_model->get_Related_alumini($id,$keywords,$limit);
        echo json_encode($data['query'],JSON_NUMERIC_CHECK);
    }

    public function getRelatedQue($keywords){
        $this->load->model('content_model','',TRUE);
        $data['query'] = $this->content_model->get_Related_que($keywords);
        echo json_encode($data['query'],JSON_NUMERIC_CHECK);
    }

    public function getRelatedSkills($alumniId){
        $this->load->library('utility');
        $id = $this->utility->my_decrypt($alumniId,"bawaseer123$*123");
        $this->load->model('content_model','',TRUE);
        $data['query'] = $this->content_model->get_alumni_skills($id);
        echo json_encode($data['query'],JSON_NUMERIC_CHECK);
    }

    public function setHelpful($alumniId){
        $this->load->helper('encrypt');
        $this->load->library('utility');
        $this->load->model('content_model','',TRUE);
        $data['query'] = $this->content_model->sethelpful($alumniId);
        echo json_encode($data['query'],JSON_NUMERIC_CHECK);
    }

    public function getRelatedAlumniEdu($id,$keywords,$limit){
        $this->load->library('utility');
        $id = $this->utility->my_decrypt($id,"bawaseer123$*123");
        $this->load->model('content_model','',TRUE);
        $data['query'] = $this->content_model->get_Related_alumini_edu($id,$keywords,$limit);
        echo json_encode($data['query'],JSON_NUMERIC_CHECK);
    }

    public function getRelatedQueEdu($keywords){
        $this->load->model('content_model','',TRUE);
        $data['query'] = $this->content_model->get_Related_que_edu($keywords);
        echo json_encode($data['query'],JSON_NUMERIC_CHECK);
    }
}