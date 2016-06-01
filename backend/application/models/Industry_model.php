<?php
    class industry_model extends CI_Model {

        public function __construct()
            {
                    parent::__construct();
            }
    
         public function get_assoc_industries($getIndustry)
            {
                /* $sql="Select f.stan_industry, count(*) as rel from stan_company_industry f,(select d.`stan_company`, count(*) from stan_company_industry d, ";
                $sql.="(select b.stan_industry from stan_company_industry b,(Select `stan_company` from stan_company_industry where ";
                $sql.="stan_industry='".urldecode($getIndustry)."') a  where a.stan_company=b.stan_company group by 1) c where d.stan_industry=c.stan_industry ";
                $sql.="group by 1 order by 2 DESC limit 0,10) e where f.stan_company= e.stan_company group by 1 having rel>=3 order by 2 DESC limit 0,10"; */
                $sql = "select b.stan_industry , count(b.stan_industry) as rel from stan_company_industry b where stan_company in (select a.stan_company from stan_company_industry a where `stan_industry` = 'INTERNET') Group by 1 having rel<( select count(stan_company) from stan_company_industry where `stan_industry` = 'INTERNET') order by 2 desc LIMIT 10";
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
        
        public function get_assoc_skills($getIndustry)
            {
                $sql="Select skill_token as skill,count(*) as freq from search_pro where stan_industry='".urldecode($getIndustry)."' group by 1 order by 2 DESC LIMIT 10";
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
    
    
        public function get_assoc_designations($getIndustry)
            {
                $sql="Select JD, count(*) as freq from search_pro where stan_industry='".urldecode($getIndustry)."' group by 1 order by 2 DESC LIMIT 10";    
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
    
         public function get_assoc_companies($getIndustry)
            {
                
                $sql="Select a.stan_company as company, a.total_people as freq from search_pro a, (Select stan_company, count(*) as industries from ";
                $sql.="stan_company_industry group by 1 having industries<10) b where a.stan_industry='".urldecode($getIndustry)."' and a.stan_company=b.stan_company ";
				$sql.="group by 1 order by 2 DESC LIMIT 20";     
                
             
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
                           $result['call']['response'][$countLooper]['company']=$row->company;
                           $result['call']['response'][$countLooper]['logo']= 'http://static-images.bloomigo.co.in/company-logos/'.str_replace(' ', '-',strtolower(trim($row->company))).'.png';
                           $result['call']['response'][$countLooper]['freq']=$row->freq;
                           
                           $countLooper++;
                        }                                     
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