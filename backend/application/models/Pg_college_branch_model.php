<?php
    class Pg_college_branch_model extends CI_Model {
		
        public function __construct()
		{       
			parent::__construct();
		}
		
		
		public function popular_degree($branch, $institute)
		{  
			$sql= "SELECT stan_degree_1 as degree, count(*) as freq FROM search_edu WHERE branch like 'Civil' and stan_degree_1<>'' and degree_type = 'Higher' and stan_insti='IIT Bombay' group by 1 limit 0,5"; 
			//echo $sql;
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
		
		
		public function company_hiring($branch, $institute)
		{  
			$sql= "Select a.stan_company, z.recruits from (SELECT stan_company from branch_company_rel where branches like '%".$branch."%'  group by 1)a, (Select p.stan_company, count(*) as recruits from edu_pro p, (SELECT old_bid from edu_pro where (stan_branch_1 like '%".$branch."%' or stan_branch_2 like '%".$branch."%') and stan_insti= '".$institute."' and degree_type = 'Higher' group by 1) q where p.old_bid=q.old_bid and p.stan_company is not null and p.stan_company<>'' group by 1)z where a.stan_company=z.stan_company group by 1 order by 2 DESC LIMIT 30"; 
			//echo $sql;
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
		
		public function industry_hiring($branch, $institute)
		{  
			$sql= "SELECT `stan_industry`, COUNT(*) AS aukat from stan_company_industry where `stan_company` in (Select a.stan_company from (SELECT stan_company from branch_company_rel where branches like '".$branch."' group by 1) a,  (Select p.stan_company from edu_pro p, (SELECT old_bid from edu_pro where (stan_branch_1 like '%".$branch."%' or stan_branch_2 like '%".$branch."%') and stan_insti= '".$institute."' and degree_type = 'Graduate' group by 1) q where p.old_bid=q.old_bid and p.stan_company is not null and p.stan_company<>'' group by 1) z where a.stan_company=z.stan_company group by 1) group by 1 order by 2 DESC LIMIT 20"; 
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
		
		public function similar_tech_branch($branch , $institute)
		{  
			$sql= "Select y.branch, y.degree_genre, y.freq from 			(Select e.stan_branch_1 as branch, count(*) as freq, e.degree_genre from edu_pro e, (Select m.old_bid from edu_pro m, (SELECT a.stan_branch_1, count(*) from edu_pro a, (SELECT old_bid from edu_pro where (stan_branch_1 like '".$branch."' or stan_branch_2 like '".$branch."') and degree_type = 'Higher' group by 1) b where 						a.old_bid=b.old_bid and a.degree_type = 'Graduate' and a.stan_branch_1<>'' group by 1 order by 2 DESC limit 0,2) c where (m.stan_branch_1=c.stan_branch_1 or m.stan_branch_2=c.stan_branch_1) ) d where e.old_bid=d.old_bid and e.degree_type = 'Higher' and (e.degree_genre like 'tech' or e.degree_genre like 'research') and e.stan_branch_1<>'' Group by 1 having freq>=2 order by 2 DESC limit 0,50) y, (Select 						p.stan_branch_1 from edu_pro p, (SELECT old_bid from edu_pro where (stan_branch_1 like '".$branch."' or stan_branch_2 like '".$branch."') and stan_insti='".$institute."' group by 1) q where p.old_bid=q.old_bid and p.stan_branch_1 <>'' group by 1) z where z.stan_branch_1=y.branch 						and y.branch<>'".$branch."' group by 1 ORDER BY 3 DESC LIMIT 20"; 
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
		
		public function similar_nontech_branch($branch , $institute)
		{  
			$sql= "Select y.branch, y.degree_genre, y.freq from (Select e.stan_branch_1 as branch, count(*) as freq, e.degree_genre from edu_pro e,  (Select m.old_bid from edu_pro m, (SELECT a.stan_branch_1, count(*) from edu_pro a, (SELECT old_bid from edu_pro where (stan_branch_1 like '".$branch."' or stan_branch_2 like '".$branch."' ) and degree_type = 'Higher' group by 1) b where a.old_bid=b.old_bid and a.degree_type = 'Graduate' and a.stan_branch_1<>'' group by 1 order by 2 DESC limit 0,2) c where m.stan_branch_1=c.stan_branch_1 ) d where e.old_bid=d.old_bid and e.degree_type = 'Higher' and (e.degree_genre not like 'tech' and e.degree_genre not like 'research') and e.stan_branch_1<>'' Group by 1 having freq>=2 order by 2 DESC limit 0,50) y, (Select p.stan_branch_1 from edu_pro p, (SELECT old_bid from edu_pro where (stan_branch_1 like '".$branch."' or stan_branch_2 like '".$branch."') and stan_insti='".$institute."' group by 1) q 			where p.old_bid=q.old_bid and p.stan_branch_1 <>'' group by 1) z where z.stan_branch_1=y.branch and y.branch<>'".$branch."' group by 1 ORDER BY 3 DESC LIMIT 20"; 
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
		
		public function related_skills($branch, $institute)
		{  
			$sql= "Select x.skill_token as skill, count(distinct y.old_bid) as aukat 		from skills x, edu_pro y, (SELECT skill_token as skill, people_with_skill as aukat_1 from branch_skill_relation where ug_branch like '".$branch."' 		group by 1    order by people_with_skill DESC) z 			where x.skill_token=z.skill and 		y.stan_insti='".$institute."' and (y.stan_branch_1 like '".$branch."' or y.stan_branch_2 like '".$branch."') and x.old_bid=y.old_bid group by 1 order by 2 DESC LIMIT 20"; 
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
		
		public function people_coming_from($branch, $institute)
		{  
			$sql_placement = "select 							d.stan_industry, a.role_1, avg(a.duration_with_2015) as time_spent_there, count(*) as freq from edu_pro a, (SELECT old_bid, mega_mov_no, duration_with_2015 FROM edu_pro WHERE (stan_branch_1='".$branch."' or stan_branch_2 = '".$branch."') and degree_type = 'Higher' and chutiya_admi is null  and stan_insti='".$institute."' group by 1) b, stan_company_industry d where a.old_bid=b.old_bid and a.mega_mov_no<b.mega_mov_no and a.chutiya_admi is null and a.stan_company=d.stan_company and a.s_char='P' and a.role_1<>'' group by 1,2 ORDER BY 3 DESC limit 0,50";
			//echo ($sql_placement);
			$query = $this->db->query($sql_placement);
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
		
		public function people_getting_there($branch, $institute)
		{  
			$sql_placement = "select count(distinct a.old_bid) as total, count(distinct case when a.s_char='P' then a.old_bid end) as Job, count(distinct case when a.s_char='E' then a.old_bid end) as edu from edu_pro a, (SELECT old_bid, mega_mov_no, duration_with_2015 FROM edu_pro WHERE (stan_branch_1='".$branch."' or stan_branch_2 = '".$branch."') and degree_type = 'Higher' and chutiya_admi is null  and stan_insti='".$institute."' group by 1) b where a.old_bid=b.old_bid and a.mega_mov_no-1=b.mega_mov_no and a.chutiya_admi is null";
			//echo ($sql_placement);
			$query = $this->db->query($sql_placement);
			$count = $query->num_rows();				
			if($count==0)
			{
				$result['call']=array('success'=>false,'code'=>1,'message'=>'nothing found');
				$result['call']['meta']=array('total'=>0);
				$result['call']['response']=array();
			}
			else if ($count>0)				
			{	$result['call']=array('success'=>true,'code'=>0,'message'=>'null');
				$result['call']['meta']=array('total'=>$count);
				$finalarray = array();
				$sqldistribution = "select (CASE
				WHEN (a.cum_exp-a.duration_with_2015-48)<12 then '1 year'
				WHEN (a.cum_exp-a.duration_with_2015-48)>=12 and (a.cum_exp-a.duration_with_2015-48)<24  then '1-2 year'
				WHEN (a.cum_exp-a.duration_with_2015-48)>=24 and (a.cum_exp-a.duration_with_2015-48)<36 then '2-3 year'
				WHEN (a.cum_exp-a.duration_with_2015-48)>=36 and (a.cum_exp-a.duration_with_2015-48)<48 then '3-4 year'
				WHEN (a.cum_exp-a.duration_with_2015-48)>=48 and (a.cum_exp-a.duration_with_2015-48)<60 then '4-5 year'
				WHEN (a.cum_exp-a.duration_with_2015-48)>=60 then '>5 year'
				END) as prof_exp,
				count(DISTINCT(a.old_bid)) as freq
				from
				edu_pro a, 
				(SELECT old_bid, mega_mov_no, duration_with_2015 FROM edu_pro WHERE (stan_branch_1='computer science' or stan_branch_2 = 'computer science') and degree_type = 'Higher' and chutiya_admi is null  and stan_insti='iit bombay' group by 1) b
				where a.old_bid=b.old_bid and
				a.chutiya_admi is null and
				a.degree_type = 'Higher' and
				(a.stan_branch_1 like 'computer science' OR a.stan_branch_2 like 'computer science' ) and
				a.stan_insti='iit bombay' 
				group by 1 having prof_exp <> ''";
				
				$querydistribution = $this->db-> query($sqldistribution);
				$result_distribution = $querydistribution->result();
				//var_dump($result_distribution);
				$temp_result = array();
				$sum = 0;
				for ($i=0; $i< count($result_distribution);$i++){
					$result_distribution[$i]-> freq = (int)$result_distribution[$i]-> freq;
					$sum += $result_distribution[$i]-> freq;
				}
				for ($i=0; $i< count($result_distribution);$i++){
					$result_distribution[$i]-> freq = round(($result_distribution[$i]-> freq/$sum)*100);
				}
				//var_dump($result_distribution);
				$tempresult = $query->result();
				if($tempresult[0]-> total > 0){
					$finalarray[0] = array('key'=> 'Higher Education','value'=> round(($tempresult[0]-> Job/$tempresult[0]-> total)*100));
					$finalarray[1] = array('key'=> 'Job experience','value'=> round(($tempresult[0]-> edu/$tempresult[0]-> total)*100));
					} else {
					$finalarray[0] = array('key'=> 'Higher Education','value'=> 0);
					$finalarray[1] = array('key'=> 'Job experience','value'=> 0);
				}
				$finalarray['Distribution'] = $result_distribution;
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