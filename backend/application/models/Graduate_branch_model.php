<?php
    class Graduate_branch_model extends CI_Model {
		
        public function __construct()
		{       
			parent::__construct();
		}
		
		public function company_hiring($branch)
		{ 
			$sql= "Select a.stan_company, z.recruits from (SELECT stan_company from branch_company_rel where branches like '%".$branch."%' group by 1) a, (Select p.stan_company, count(*) as recruits from edu_pro p, (SELECT old_bid from edu_pro where (stan_branch_1 like '%".$branch."%' or stan_branch_2 like '%".$branch."%') and degree_type = 'Graduate' group by 1) q where p.old_bid=q.old_bid and p.stan_company is not null and p.stan_company<>'' group by 1) z where a.stan_company=z.stan_company group by 1 order by 2 DESC LIMIT 30";   
			//echo ($sql);
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
					$result['call']['response'][$countLooper]['stan_company']=$row->stan_company;
					$result['call']['response'][$countLooper]['logo']= 'http://static-images.bloomigo.co.in/company-logos/'.str_replace(' ', '-',strtolower(trim($row->stan_company))).'.png';
					$result['call']['response'][$countLooper]['rel']=$row->recruits;
					$countLooper++;
				}
				$result['call']['response']=$result['call']['response'];
				
			}
			else
			{
				$result['call']=array('success'=>false,'code'=>2,'message'=>'something went wrong');
				$result['call']['meta']=array('total'=>0);
				$result['call']['response']=array();   
			}
			return $result;
		}
		
		public function industry_hiring($branch)
		{ 
			$sql= "SELECT `stan_industry`, COUNT(*) AS aukat from stan_company_industry where `stan_company` in (Select a.stan_company from (SELECT stan_company from branch_company_rel where branches like '".$branch."' group by 1) a, (Select p.stan_company from edu_pro p, (SELECT old_bid from edu_pro where (stan_branch_1 like '".$branch."' OR stan_branch_1 like '".$branch."') and degree_type = 'Graduate' group by 1) q where p.old_bid=q.old_bid and p.stan_company is not null and p.stan_company<>'' group by 1) z where a.stan_company=z.stan_company            group by 1) group by 1 order by 2 DESC LIMIT 20"; 
			//echo ($sql);
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
		
		public function similar_branch($branch)
		{ 
			$sql= "Select stan_branch_1 as branch, degree_genre, count(*) as freq from edu_pro where old_bid in (SELECT old_bid from edu_pro where (stan_branch_1 like '".$branch."' or stan_branch_2 like '".$branch."') and degree_type = 'Graduate')  and degree_type='Higher' and (degree_genre='Tech%' or degree_genre='Research') and stan_branch_1 not in ('management','Science','') and stan_branch_1 not like '".$branch."' group by 1,2 order by 3 DESC limit 0,15"; 
			//echo ($sql);
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
		
		public function related_skills($branch)
		{ 
			$sql= "SELECT skill_token as skill, people_with_skill as aukat from branch_skill_relation where ug_branch like '".$branch."' group by 1 order by people_with_skill DESC LIMIT 20"; 
			//echo ($sql);
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
		
		public function what_people_are_doing($branch)
		{   $finalarray = array();           
			$common_sql= "(SELECT old_bid, mega_mov_no, duration_with_2015 FROM edu_pro WHERE (stan_branch_1 like '%".$branch."%' or stan_branch_2 like '%".$branch."%') and degree_type = 'Graduate' and chutiya_admi is null group by 1)"; 
			$sql_placement = "select count(distinct a.old_bid) as total, count(distinct case when a.s_char='P' then a.old_bid end) as Job, count(distinct case when a.s_char='E' then a.old_bid end) as higher_edu, count(distinct case when a.s_char='E' and a.degree_genre='Management' then a.old_bid end) as higher_edu_manag, count(distinct case when a.s_char='E' and a.degree_genre='Tech' then a.old_bid end) as higher_edu_tech, count(distinct case when a.s_char='E' and a.degree_genre='Research' then a.old_bid end) as higher_edu_research from edu_pro a, ".$common_sql." b where a.old_bid=b.old_bid and a.mega_mov_no-1=b.mega_mov_no and a.chutiya_admi is null";
			//echo ($sql_placement);
			$query_placement = $this->db->query($sql_placement);
			$result_placement = $query_placement -> result();
			if(intval($result_placement[0]->total) >0){
				$per_job =  round((intval($result_placement[0]->Job)/intval($result_placement[0]->total)) * 100);
				$per_edu =  100 - (int)$per_job;
				$finalarray[0] = array("category"=> 'Placements', 'column-1'=> $per_job, 'column-2'=> $per_edu);	
				} else {
				$finalarray[$i] = array("category"=> $temp_cat, 'column-1'=> 0, 'column-2'=> 0);
			}
			//var_dump($finalarray);
			
			for ( $i=1; $i <=5 ; $i++){
				$year = 12*$i;
				//echo ($year);
				$sqlgradualyear = "select count(distinct a.old_bid) as total, count(distinct case when a.s_char='P' then a.old_bid end) as Job, count(distinct case when a.s_char='E' then a.old_bid end) as higher_edu, count(distinct case when a.s_char='E' and a.degree_genre='Management' then a.old_bid end) as higher_edu_manag, count(distinct case when a.s_char='E' and a.degree_genre='Tech' then a.old_bid end) as higher_edu_tech, count(distinct case when a.s_char='E' and a.degree_genre='Research' then a.old_bid end) as higher_edu_research from edu_pro a, ".$common_sql." b, (SELECT a.old_bid, MIN(a.mega_mov_no) as first_year_mov from edu_pro a, ".$common_sql." b where a.old_bid=b.old_bid and a.mega_mov_no>b.mega_mov_no and a.cum_exp-b.duration_with_2015>= ".$year." and a.chutiya_admi is null group by 1) c where a.old_bid=b.old_bid and a.mega_mov_no=c.first_year_mov and a.old_bid=c.old_bid and a.chutiya_admi is null";
				$query_gradualyear = $this->db->query($sqlgradualyear);
				$result_gradualyear = $query_gradualyear -> result();
				if(intval($result_gradualyear[0]->total) > 0){
					$per_job =  round((intval($result_gradualyear[0]->Job)/intval($result_gradualyear[0]->total)) * 100);
					$per_edu =  100 - (int)$per_job;
					$temp_cat = "After ".($year/12). " yrs";
					$finalarray[$i] = array("category"=> $temp_cat, 'column-1'=> $per_job, 'column-2'=> $per_edu);
					} else {
					$finalarray[$i] = array("category"=> $temp_cat, 'column-1'=> 0, 'column-2'=> 0);
				}
			}				
			$count = count ($finalarray);				
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
				$result['call']['response']=$finalarray;					
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