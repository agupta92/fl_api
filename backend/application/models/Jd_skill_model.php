<?php
    class Jd_skill_model extends CI_Model {

        public function __construct()
            {
                    parent::__construct();
            }
    
		 public function get_assoc_industries($getJD)
            {
                $sql="Select stan_industry,	count(*) as freq from search_pro where JD='".urldecode($getJD)."' group by 1 order by 2 DESC LIMIT 10";
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
                //return $sql;
                return $result;
            }
			
		public function get_assoc_skills($getJD)
            {
                $sql= "Select skill_token as skill, count(*) as freq from search_pro where JD='".urldecode($getJD)."' group by 1 order by 2 DESC LIMIT 10";
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
                //return $sql;
                return $result;
            }
			
		public function get_assoc_company($getJD)
            {
                $sql= "Select stan_company as company, count(*) as freq from search_pro where JD='".urldecode($getJD)."' group by 1 order by 2 DESC LIMIT 10";			
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
                //return $sql;
                return $result;
            }
			
		public function get_available_salary($getJD)
            {
                $sql= "Select stan_company, JD,  tent_sal from available_salaries where JD='".urldecode($getJD)."' group by 1,2 order by 3 DESC LIMIT 20";			
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
                    $maxSal="";
					$minSal="";
					$result['call']=array('success'=>true,'code'=>0,'message'=>'null');
                    $result['call']['meta']=array('total'=>$count);
					$x = 0;
					foreach($query->result_array() as $row){
                            if($x==0){
								$maxSal = $row['tent_sal'];
							}
							if($x == ($count)-1){
								$minSal = $row['tent_sal'];
							}
							$x++;
                         }
					$result['call']['meta']['facets_maxSal']= $maxSal;
					$result['call']['meta']['facets_minSal']= $minSal;
					$result['call']['response']=$query->result();
                }
				else
				{
					$result['call']=array('success'=>false,'code'=>2,'message'=>'something went wrong');
                        $result['call']['meta']=array('total'=>0);
                        $result['call']['response']=array();      
				}
                //return $sql;
                return $result;
            }
        
}

?>