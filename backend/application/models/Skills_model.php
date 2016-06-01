<?php

class skills_model extends CI_Model {

        public function __construct()
            {
                    parent::__construct();
            }
    
         public function get_assoc_industries($getSkill)
            {
                $sql="Select stan_industry as industry, count(*) as freq from search_pro where skill_token='".urldecode($getSkill)."' group by 1 order by 2 DESC LIMIT 10";
             
                $query = $this->db->query($sql);
		      $count = $query->num_rows();				
                    if($count==0)
                    {
                         $result['call']=array('success'=>false,'code'=>1,'message'=>'nothing found');
                         $result['call']['meta']=array('total'=>0);
                         $result['call']['response'][0]=array('industry'=>'http://www.suplugins.com/podium/images/placeholder-03.png','freq'=>'0');
                    }
		          else if ($count>0)
                    {
                        $result['call']=array('success'=>true,'code'=>0,'message'=>'null');
                        $result['call']['meta']=array('total'=>$count);
                        $result['call']['response'] = $query->result();                       
                    }
		          else
                    {
                        $result['call']=array('success'=>false,'code'=>2,'message'=>'something went wrong');
                        $result['call']['meta']=array('total'=>0);
                        $result['call']['response']=array('image'=>'http://www.suplugins.com/podium/images/placeholder-03.png');                
                    }
                    return $result;
            }
    
    
        public function get_assoc_designations($getSkill)
            {
                $sql="Select JD,count(*) as freq from search_pro where skill_token='".urldecode($getSkill)."' group by 1 order by 2 DESC LIMIT 10";
                $query = $this->db->query($sql);
				$count = $query->num_rows();				
                if($count==0)
                    {
                         $result['call']=array('success'=>false,'code'=>1,'message'=>'nothing found');
                         $result['call']['meta']=array('total'=>0);
                         $result['call']['response']=array();
                    }
		          else if ($count>0)
                    {
                        $result['call']=array('success'=>true,'code'=>0,'message'=>'null');
                        $result['call']['meta']=array('total'=>$count);
                        $result['call']['response']=$query->result();                       
                    }
		          else
                    {
                        $result['call']=array('success'=>false,'code'=>2,'message'=>'something went wrong');
                        $result['call']['meta']=array('total'=>0);
                        $result['call']['response']=array();                
                    }
                    return $result;
            }    
    
        public function get_assoc_companies($getSkill,$order)
            {
                
                $sql="Select a.stan_company, count(distinct case when a.skill_token='".urldecode($getSkill)."' then a.JD end) as qualifier,(count(distinct case when a.skill_token='".urldecode($getSkill)."' then a.JD end)/count(distinct a.JD)) as aukat from search_pro a, (Select stan_company, total_people from search_pro where skill_token='".urldecode($getSkill)."' group by 1 order by 2 DESC) b where a.stan_company=b.stan_company group by 1 having qualifier>4 order by 3 DESC LIMIT 10";
                
             
                $query = $this->db->query($sql);
				$count = $query->num_rows();				
                if($count==0)
                    {
                         $result['call']=array('success'=>false,'code'=>1,'message'=>'nothing found');
                         $result['call']['meta']=array('total'=>0);
                         $result['call']['response']=array();
                    }
		          else if ($count>0)
                    {
                        $result['call']=array('success'=>true,'code'=>0,'message'=>'null');
                        $result['call']['meta']=array('total'=>$count);
                        $countLooper=0;
                        foreach ($query->result() as $row)
                        {
                           $result['call']['response'][$countLooper]['company']=$row->stan_company;
                           $result['call']['response'][$countLooper]['logo']= 'http://static-images.bloomigo.co.in/company-logos/'.str_replace(' ', '-',strtolower(trim($row->stan_company))).'.png';
                           $result['call']['response'][$countLooper]['aukat']=$row->aukat;
                           $result['call']['response'][$countLooper]['qualifier']=$row->qualifier;
                           $countLooper++;
                        }
                        
                        //$result['call']['response']=$query->result();
                        
                    }
		          else
                    {
                        $result['call']=array('success'=>false,'code'=>2,'message'=>'something went wrong');
                        $result['call']['meta']=array('total'=>0);
                        $result['call']['response']=array();                
                    }
                    return $result;
            }  
}

?>