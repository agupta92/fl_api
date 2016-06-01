<?php
    class Pg_college_model extends CI_Model {
		
		public function __construct()
		{  
			parent::__construct();
		}
		
		
		public function popular_degree($college)
		{ 
			$sql= "SELECT `stan_degree_1`, sum(freq) as people FROM search_edu WHERE `stan_insti`='".$college."'  and degree_type = 'Higher' 	group by 1 having people>=5 order by 2 DESC"; 
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
		
		public function noncore_company_hiring($college)
		{ 
			
			$sql= "Select j.stan_company, j.recruits from (Select p.stan_company, count(*) as recruits from edu_pro p,     (SELECT old_bid from edu_pro where stan_insti='".$college."' group by 1) q where p.old_bid=q.old_bid and p.stan_company is not null and p.stan_company<>'' group by 1 order by 2 DESC limit  0,100) j     where j.stan_company not in     (   Select y.stan_company   from     (SELECT a.stan_company from   (SELECT stan_company, rel_keywords from branch_company_rel where rel_keywords>=5   group by 1   order by rel_keywords DESC) a   group by 1) y, (Select    p.stan_company, count(*) as recruits from edu_pro p, (SELECT old_bid from edu_pro where stan_insti='".$college."' group by 1) q    where p.old_bid=q.old_bid and p.stan_company is not null and p.stan_company<>'' group by 1) z     where y.stan_company=z.stan_company   group by 1 ) group by 1     order by 2 DESC LIMIT 20"; 
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
		
		public function core_company_hiring($college)
		{ 
			$sql= "Select y.stan_company, z.recruits from branch_company_rel y, (Select p.stan_company, count(distinct p.old_bid) as recruits from edu_pro p, (SELECT old_bid from edu_pro where stan_insti='".$college."' and degree_type = 'Higher' group by 1) q where p.old_bid=q.old_bid and p.stan_company is not null and p.stan_company<>'' group by 1) z where y.stan_company=z.stan_company group by 1 having recruits>=4 order by 2 DESC LIMIT 30"; 
			
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
		
		
		public function people_coming_from($college)
		{ 	
			$sql_placement = "select d.stan_industry, a.role_1, avg(a.duration_with_2015) as time_spent_there, count(*) as freq from edu_pro a, (SELECT old_bid, mega_mov_no, duration_with_2015 FROM edu_pro WHERE stan_insti='".$college."' and degree_type = 'Higher'  and chutiya_admi is null group by 1) b, stan_company_industry d     where a.old_bid=b.old_bid and a.mega_mov_no<b.mega_mov_no and a.chutiya_admi is null and a.stan_company=d.stan_company and a.s_char='P' and a.role_1<>'' group by 1,2 ORDER BY 3 DESC limit 0,20";
			
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
		
		
		public function people_getting_there($college)
		{ 	
			$sql_placement = "select count(distinct a.old_bid) as total, count(distinct case when a.s_char='P' then a.old_bid end) as Job, count(distinct case when a.s_char='E' then a.old_bid end) as edu from edu_pro a, (SELECT old_bid, mega_mov_no, duration_with_2015 FROM edu_pro WHERE stan_insti='".$college."' and degree_type = 'Higher'  and chutiya_admi is null group by 1) b where a.old_bid=b.old_bid and a.mega_mov_no-1=b.mega_mov_no and a.chutiya_admi is null";
			
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
				$sqldistribution = "select 
				(CASE
				WHEN (a.cum_exp-a.duration_with_2015-48)<12 then '<1 year'
				WHEN (a.cum_exp-a.duration_with_2015-48)>=12 and (a.cum_exp-a.duration_with_2015-48)<24  then '1-2 year'
				WHEN (a.cum_exp-a.duration_with_2015-48)>=24 and (a.cum_exp-a.duration_with_2015-48)<36 then '2-3 year'
				WHEN (a.cum_exp-a.duration_with_2015-48)>=36 and (a.cum_exp-a.duration_with_2015-48)<48 then '3-4 year'
				WHEN (a.cum_exp-a.duration_with_2015-48)>=48 and (a.cum_exp-a.duration_with_2015-48)<60 then '4-5 year'
				WHEN (a.cum_exp-a.duration_with_2015-48)>=60 then '>5 year'
				END) as prof_exp,
				count(DISTINCT(a.old_bid)) as freq
				from
				edu_pro a, 
				(SELECT old_bid, mega_mov_no, duration_with_2015 FROM edu_pro 
				WHERE stan_insti='".$college."' and degree_type = 'Higher'  and chutiya_admi is null group by 1) b
				where a.old_bid=b.old_bid and
				a.chutiya_admi is null and
				a.degree_type = 'Higher'
				group by 1
				order by 2";
				
				//echo ($sqldistribution);
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
		
		// public function what_people_are_doing($college)
		// {   $finalarray = array();     
			// $common_sql= "(SELECT old_bid, mega_mov_no, duration_with_2015 FROM edu_pro WHERE stan_insti='".$college."' and degree_type = 'Higher'  and chutiya_admi is null group by 1)";
			// $sql_placement = "select   c.stan_industry, a.role_1, count(*) as freq   from   edu_pro a,   ".$common_sql." b,   stan_company_industry c   where a.old_bid=b.old_bid and   a.mega_mov_no-1=b.mega_mov_no and   a.chutiya_admi is null and   a.stan_company=c.stan_company and   a.s_char='P' and   a.role_1<>''   group by 1,2   order by 3 DESC   limit 0,50";
			// //echo ($sql_placement);
			// $query_placement = $this->db->query($sql_placement);
			// $result_placement = $query_placement -> result();			
			// if(intval($result_placement[0]->total) > 0){
				// $per_job =  round((intval($result_placement[0]->Job)/intval($result_placement[0]->total)) * 100);
				// $per_edu =  100 - (int)$per_job;
				// $finalarray[0] = array("category"=> 'Placements', 'column-1'=> $per_job, 'column-2'=> $per_edu);	
				// } else {
				// $finalarray[0] = array("category"=> 'Placements', 'column-1'=> 0, 'column-2'=> 0);	
			// }
			
			// for ( $i=1; $i <=5 ; $i++){
				// $year = 12*$i;
				// //echo ($year);
				// $sqlgradualyear = "select d.stan_industry, a.role_1, count(*) from edu_pro a, ".$common_sql." b, (SELECT a.old_bid, MIN(a.mega_mov_no) as first_year_mov from edu_pro a, ".$common_sql." b where  a.old_bid=b.old_bid and a.mega_mov_no>b.mega_mov_no and a.cum_exp-b.duration_with_2015>=".$year." and a.chutiya_admi is null  group by 1) c, stan_company_industry d where a.old_bid=b.old_bid and a.mega_mov_no=c.first_year_mov and a.old_bid=c.old_bid and a.chutiya_admi is null and a.stan_company=d.stan_company and a.s_char='P' and a.role_1<>'' group by 1,2 ORDER BY 3 DESC limit 0,50";
				// $query_gradualyear = $this->db->query($sqlgradualyear);
				// $result_gradualyear = $query_gradualyear -> result();
				// if (intval($result_gradualyear[0]->total) > 0){
					// $per_job =  round((intval($result_gradualyear[0]->Job)/intval($result_gradualyear[0]->total)) * 100);
					// $per_edu =  100 - (int)$per_job;
					// $temp_cat = "After ".($year/12). " yrs";
					// $finalarray[$i] = array("category"=> $temp_cat, 'column-1'=> $per_job, 'column-2'=> $per_edu);
					// } else {
					// $finalarray[$i] = array("category"=> $temp_cat, 'column-1'=> 0, 'column-2'=> 0);
				// }				
			// }				
			// $count = count ($finalarray);				
			// if($count==0)
			// {
				// $result['call']=array('success'=>false,'code'=>1,'message'=>'nothing found');
				// $result['call']['meta']=array('total'=>0);
				// $result['call']['response']=array();
			// }
			// else if ($count>0)
			// {
				
				// $result['call']=array('success'=>true,'code'=>0,'message'=>'null');
				// $result['call']['meta']=array('total'=>$count);
				// $result['call']['response']=$finalarray;
				
			// }
			// else
			// {
				// $result['call']=array('success'=>false,'code'=>2,'message'=>'something went wrong');
				// $result['call']['meta']=array('total'=>0);
				// $result['call']['response']=array();   
			// }
			// return $result;
		// }
		
	}
	
?>