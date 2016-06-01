<?php
    class Company_jd_industry_model extends CI_Model {

        public function __construct()
            {
                    parent::__construct();
            }
    
         public function get_assoc_industries($getCompany)
            {
                $sql="Select stan_industry from stan_company_industry where stan_company='".urldecode($getCompany)."'";
                $query = $this->db->query($sql);
				$count = $query->num_rows();				
                if($count==0)
                {
                     $result['call'] = array('success' => false, 'code' => 1, 'message' => 'nothing found');
					$result['call']['meta'] = array('total' => 0);
					$result['call']['response'] = array();
                }
				else if ($count>0)
                {
                    
					$result['call'] = array('success' => true, 'code' => 0, 'message' => 'null');
					$result['call']['meta'] = array('total' => $count);
					$result['call']['response']=$query->result();
                }
				else
				{
					$result['call'] = array('success' => false, 'code' => 2, 'message' => 'something went wrong');
					$result['call']['meta'] = array('total' => 0);
					$result['call']['response'] = array();
				}
                //return $sql;
                return $result;
            }
        
        public function get_assoc_skills($getCompany, $getJd)
            {
                $sql= "Select skill_token as skill from search_pro where stan_company='".urldecode($getCompany)."' and JD='".urldecode($getJd)."' group by 1";
                $query = $this->db->query($sql);
				$count = $query->num_rows();				
                if($count==0)
                {
                     $result['call'] = array('success' => false, 'code' => 1, 'message' => 'nothing found');
					$result['call']['meta'] = array('total' => 0);
					$result['call']['response'] = array();
                }
				else if ($count>0)
                {
                    
					$result['call'] = array('success' => true, 'code' => 0, 'message' => 'null');
					$result['call']['meta'] = array('total' => $count);
					$result['call']['response']=$query->result();
                }
				else
				{
					$result['call'] = array('success' => false, 'code' => 2, 'message' => 'something went wrong');
					$result['call']['meta'] = array('total' => 0);
					$result['call']['response'] = array();
				}

                return $result;
            }    
    
 		public function get_similar_companies($getCompany , $getJd)
            {
                
                ///$sql= "Select j.stan_company, j.JD, j.similarity, FORMAT(k.tent_sal,0) as tent_sal from  (Select z.pro_s_no, z.stan_company, z.JD, z.similarity from  (Select f.stan_company, count(*) as rel from stan_company_industry f, ( select d.`stan_industry`, count(*) from stan_company_industry d, (select b.stan_company  from stan_company_industry b, (  Select `stan_industry`  from stan_company_industry  where stan_company='".urldecode($getCompany)."'  ) a where a.stan_industry=b.stan_industry group by 1) c where d.stan_company=c.stan_company group by 1 order by 2 DESC limit 0,10 ) e where f.stan_industry= e.stan_industry group by 1 having rel>=3 order by 2 DESC) y, (Select u.pro_s_no, u.stan_company, u.JD, count(distinct u.skill_token)/(Select count(distinct skill_token) from search_pro where JD='".urldecode($getJd)."' and stan_company='".urldecode($getCompany)."') as similarity  from search_pro u, (Select r.JD from  search_pro r,  (Select skill_token as skill from search_pro where JD='".urldecode($getJd)."' and stan_company='".urldecode($getCompany)."' group by 1) q  where r.skill_token=q.skill  group by 1) t, (Select skill_token as skill from search_pro where JD='".urldecode($getJd)."' and stan_company='".urldecode($getCompany)."' group by 1) v  where u.skill_token=v.skill and u.JD = t.JD  group by 1  having similarity>=0.4  order by 2 DESC) z  where y.stan_company=z.stan_company) j  LEFT JOIN  available_salaries k  ON k.pro_s_no=j.pro_s_no ORDER BY 3 DESC LIMIT 15	;";
				$sql = "SELECT b.stan_company, b.stan_industry, COUNT( stan_company ) AS rel FROM stan_company_industry b WHERE stan_industry IN ( SELECT  a.`stan_industry` FROM stan_company_industry a WHERE  `stan_company` =  '".urldecode($getCompany)."' ) GROUP BY 1 having rel < (select count(`stan_industry`) FROM stan_company_industry WHERE  `stan_company` =  '".urldecode($getCompany)."') ORDER BY 3 DESC LIMIT 10";
                $query = $this->db->query($sql);
				$count = $query->num_rows();				
                if($count==0)
                {
                     $result['call'] = array('success' => false, 'code' => 1, 'message' => 'nothing found');
						$result['call']['meta'] = array('total' => 0);
						$result['call']['response'] = array();
                }
				else if ($count>0)
                {
                    
					$result['call'] = array('success' => true, 'code' => 0, 'message' => 'null');
					$result['call']['meta'] = array('total' => $count);$countLooper = 0;
				foreach ($query->result() as $row) {
				$result['call']['response'][$countLooper]['stan_company'] = $row -> stan_company;
				$result['call']['response'][$countLooper]['logo'] = 'http://static-images.bloomigo.co.in/company-logos/' . str_replace(' ', '-', strtolower(trim($row -> stan_company))) . '.png';
				//$result['call']['response'][$countLooper]['similarity'] = $row -> similarity;
				//$result['call']['response'][$countLooper]['tent_sal'] = $row -> tent_sal;
				//$result['call']['response'][$countLooper]['JD'] = $row -> JD;

				$countLooper++;
			}
					//$result['call']['response']=$query->result();
                }
				else
				{
					$result['call'] = array('success' => false, 'code' => 2, 'message' => 'something went wrong');
					$result['call']['meta'] = array('total' => 0);
					$result['call']['response'] = array();
				}

                return $result;
            }

		public function get_howToGetInThere($getCompany, $getJd)
         {
                
        $sql = "Select a.total_people as 'Total People', a.graduation as Graduation, a.direct_placement as 'Direct Placement', (a.graduation-a.direct_placement) as Laterals, a.`<1 year`, a.`1-3 year`, a.`3-5 year`, a.`5-7 year`, a.`>7 year`, a.`higher_man` as 'Higher Management', a.`higher_tech` as 'Higher Technical', a.`higher_res` as 'Higher Research' from 	edu_pro_relation a,  (Select pro_s_no from search_pro where stan_company='" . urldecode($getCompany) . "' and JD='" . urldecode($getJd) . "') b 	where a.pro_s_no=b.pro_s_no 	group by 1";

		$query = $this -> db -> query($sql);
		$count = $query -> num_rows();
		if ($count == 0) {
			$result['call'] = array('success' => false, 'code' => 1, 'message' => 'nothing found');
			$result['call']['meta'] = array('total' => 0);
			$result['call']['response'] = array();
		} else if ($count > 0) {
			$result['call'] = array('success' => true, 'code' => 0, 'message' => 'null');
			$result['call']['meta'] = array('total' => 2);
			$resultObj = $query->result();
			$resultObj = get_object_vars($resultObj[0]);
			$totalCandid = intval($resultObj['Graduation']) + $resultObj['Higher Management'] + $resultObj['Higher Technical'] + $resultObj['Higher Research'];
            $tpPer = round(($resultObj['Total People']/$totalCandid)*100,0);
			$gradPer = round(($resultObj['Graduation']/$totalCandid)*100,0);
            $eduPer=100-$gradPer;
            $dpPer = round(($resultObj['Direct Placement']/$totalCandid)*100,0);
            $lPer = round(($resultObj['Laterals']/$totalCandid)*100,2);
            $lessThanOneYearPer = round(($resultObj['<1 year']/$totalCandid)*100,0);
            $oneToThreeYearPer = round(($resultObj['1-3 year']/$totalCandid)*100,0);
            $threeToFiveYearPer = round(($resultObj['3-5 year']/$totalCandid)*100,0);
            $fiveToSevenYearPer = round(($resultObj['5-7 year']/$totalCandid)*100,0);
            $greaterThanSevenYearPer = round(($resultObj['>7 year']/$totalCandid)*100,0);
            $hmPer=round(($resultObj['Higher Management']/$totalCandid)*100,0);
            $htPer = round(($resultObj['Higher Technical']/$totalCandid)*100,0);
            $hrPer = round(($resultObj['Higher Research']/$totalCandid)*100,0);
            
			$array[0] = array('key'=>'Higher Education', 'value' => $eduPer,'subvalue'=>array(),'donut_text1'=>'Distribution for the type of','donut_text2'=>'higher education of the people hired');
			$array[0]['subvalue'][0] = array('key'=> 'Technical', 'value' => $htPer,'color'=> "#9CCC65");
			$array[0]['subvalue'][1] = array('key'=> 'Research', 'value' => $hrPer,'color'=> "#558B2F");
			$array[0]['subvalue'][2] = array('key'=> 'Management', 'value' => $hmPer,'color'=> "#114D08");
			
			$array[1] = array('key'=> 'Graduation', 'value' => $gradPer,'subvalue'=>array(),'donut_text1'=>'Distribution for the prior','donut_text2'=>'work experience of the people hired');
			$array[1]['subvalue'][0] = array('key'=> 'Direct Placement', 'value' => $dpPer,'color'=> "#75000E ");
			$array[1]['subvalue'][1] = array('key'=> '<1 yr Exp', 'value' => $lessThanOneYearPer,'color'=> "#B11D00");
			$array[1]['subvalue'][2] = array('key'=> '1-3yr Exp', 'value' => $oneToThreeYearPer,'color'=> "#D12400");
			$array[1]['subvalue'][3] = array('key'=> '3-5yr Exp', 'value' => $threeToFiveYearPer,'color'=> "#E95337");
			$array[1]['subvalue'][4] = array('key'=> '5-7yr Exp', 'value' => $fiveToSevenYearPer,'color'=> "#F46F5A");
			$array[1]['subvalue'][5] = array('key'=> '>7yr Exp', 'value' => $greaterThanSevenYearPer,'color'=> "#F79A84");
			
			$allPer = array('Total People'=>$tpPer,'Graduation '=>$gradPer,'Direct Placement'=>$dpPer,'Laterals'=>$lPer,
                            '<1 year'=>$lessThanOneYearPer,'1-3 year'=>$oneToThreeYearPer,'3-5 year'=>$threeToFiveYearPer,
                            '5-7 year'=>$threeToFiveYearPer,'>7 year'=>$greaterThanSevenYearPer,'Higher Management'=>$hmPer,
                            'Higher Technical'=>$htPer,'Higher Research: '=>$hrPer);
            $result['call']['response'] = $array;
		} else {
			$result['call'] = array('success' => false, 'code' => 2, 'message' => 'something went wrong');
			$result['call']['meta'] = array('total' => 0);
			$result['call']['response'] = array();
		}

		return $result;


            }
		
		public function get_available_salaries($getCompany, $getJd)
            {
                
                $sql= "Select FORMAT(tent_sal,0) as tent_sal from available_salaries where JD='".urldecode($getJd)."' and stan_company='".urldecode($getCompany)."'";
             
                $query = $this->db->query($sql);
				$count = $query->num_rows();				
                if($count==0)
                {
                    $result['call'] = array('success' => false, 'code' => 1, 'message' => 'nothing found');
					$result['call']['meta'] = array('total' => 0);
					$result['call']['response'] = array();
                }
				else if ($count>0)
                {
                    
					$result['call'] = array('success' => true, 'code' => 0, 'message' => 'null');
					$result['call']['meta'] = array('total' => $count);
					$result['call']['response']=$query->result();
                }
				else
				{
					$result['call'] = array('success' => false, 'code' => 2, 'message' => 'something went wrong');
					$result['call']['meta'] = array('total' => 0);
					$result['call']['response'] = array();
				}

                return $result;
            }

		public function get_avg_rate_of_stay($getCompany, $getJd)
            {
                
               $bool = true;	
		$sql = "Select ROUND((AVG(a.duration_with_2015) - 0.4*(STDDEV(a.duration_with_2015))),0) as 'Min. time of stay', ROUND(AVG(a.duration_with_2015),0) as 'Avg. duration of stay', ROUND( (AVG(a.duration_with_2015) + 0.4*(STDDEV(a.duration_with_2015))),0) as 'Max. time of stay' from edu_pro a,  (Select pro_s_no from search_pro where stan_company='".urldecode($getCompany)."' and JD='".urldecode($getJd)."' group by 1) b  where a.pro_s_no=b.pro_s_no and  a.chutiya_admi is null";

		$query = $this -> db -> query($sql);
		$count = $query -> num_rows();
		foreach ($query->result() as $key ) {
			foreach ($key as $key1 => $value1) {
				if($value1 <2){
					$sql = "Select ROUND((AVG(a.duration_with_2015) - 0.2*(STDDEV(a.duration_with_2015))),0) as 'Min. time of stay', ROUND(AVG(a.duration_with_2015),0) as 'Avg. duration of stay', ROUND( (AVG(a.duration_with_2015) + 0.2*(STDDEV(a.duration_with_2015))),0) as 'Max. time of stay' from edu_pro a,  (Select pro_s_no from search_pro where stan_company='".urldecode($getCompany)."' and JD='".urldecode($getJd)."' group by 1) b  where a.pro_s_no=b.pro_s_no and  a.chutiya_admi is null";
					//echo $sql;
					break;
				}
			}
		}
		if ($count == 0) {
			$result['call'] = array('success' => false, 'code' => 1, 'message' => 'nothing found');
			$result['call']['meta'] = array('total' => 0);
			$result['call']['response'] = array();
		} else if ($count > 0) {
			$result['call'] = array('success' => true, 'code' => 0, 'message' => 'null');
			$result['call']['meta'] = array('total' => $count);
			$objectResult = $query->result();
			$x=0;
			foreach ($objectResult as $key => $value) {
				foreach ($value as $key => $value) {
					$finalArray[$x] = array('key' => $key,'value' => round($value,1));
					$x++;		
				}
			}
			$result['call']['meta'] = array('total' => $x); 
			$result['call']['response'] = $finalArray;
			
		} else {
			$result['call'] = array('success' => false, 'code' => 2, 'message' => 'something went wrong');
			$result['call']['meta'] = array('total' => 0);
			$result['call']['response'] = array();
		}
		return $result;
            }

		public function get_Popular_Switches_FromCompany($getCompany, $getJd)
            {
                
                $sql= "Select s.company_1, s.JD_1, FORMAT(s.tent_sal,0) as tent_sal_1, s.company_2, s.JD_2, FORMAT(t.tent_sal,0) as tent_sal_2 ,  s.freq from (Select m.company_1, m.JD_1, n.tent_sal, m.pro_s_no, m.company_2, m.JD_2, m.freq from (Select z.pro_s_no_1, z.company_1, z.JD_1, y.pro_s_no, y.stan_company as company_2, y.JD as JD_2, z.freq  from (Select p.old_bid, p.mega_mov_no as mega_mov_no_1, p.pro_s_no as pro_s_no_1,  p.stan_company as company_1, p.JD as JD_1, (p.mega_mov_no+1) as mega_mov_no_2, q.pro_s_no as pro_s_no_2, count(q.old_bid) as freq from (Select old_bid, mega_mov_no, pro_s_no,stan_company, JD, duration_with_2015 as stay from edu_pro where stan_company='".urldecode($getCompany)."' and JD='".urldecode($getJd)."' group by 1,2) p,  edu_pro q where p.old_bid=q.old_bid and q.mega_mov_no=(p.mega_mov_no+1) and (p.pro_s_no is not null and q.pro_s_no is not null) and p.pro_s_no <> q.pro_s_no group by 1,3,7) z,  search_pro y where z.pro_s_no_2=y.pro_s_no group by 1,4 order by 5 DESC) m  LEFT JOIN available_salaries n on m.pro_s_no_1=n.pro_s_no) s LEFT JOIN available_salaries t on s.pro_s_no=t.pro_s_no ORDER BY 7 DESC";
             
                $query = $this->db->query($sql);
				$count = $query->num_rows();				
                if($count==0)
                {
                    $result['call'] = array('success' => false, 'code' => 1, 'message' => 'nothing found');
					$result['call']['meta'] = array('total' => 0);
					$result['call']['response'] = array();
                }
				else if ($count>0)
                {
                    
					$result['call'] = array('success' => true, 'code' => 0, 'message' => 'null');
					$result['call']['meta'] = array('total' => $count);
					$result['call']['response']=$query->result();
                }
				else
				{
					$result['call'] = array('success' => false, 'code' => 2, 'message' => 'something went wrong');
					$result['call']['meta'] = array('total' => 0);
					$result['call']['response'] = array();
				}

                return $result;
            }			
			
		public function get_Popular_Switches_ToCompany($getCompany, $getJd)
            {
                
                $sql= "Select s.company_2 as prev_company, s.JD_2 as prev_jd, FORMAT(t.tent_sal,0) as prev_sal , s.company_1 as next_company, s.JD_1 as next_jd, FORMAT(s.tent_sal,0) as next_sal, s.freq from (Select m.company_1, m.JD_1, n.tent_sal, m.pro_s_no, m.company_2, m.JD_2, m.freq from (Select z.pro_s_no_1, z.company_1, z.JD_1, y.pro_s_no, y.stan_company as company_2, y.JD as JD_2, z.freq  from (Select p.old_bid, p.mega_mov_no as mega_mov_no_1, p.pro_s_no as pro_s_no_1,  p.stan_company as company_1, p.JD as JD_1, (p.mega_mov_no-1) as mega_mov_no_2, q.pro_s_no as pro_s_no_2, count(q.old_bid) as freq from (Select old_bid, mega_mov_no, pro_s_no,stan_company, JD, duration_with_2015 as stay from edu_pro where stan_company='".urldecode($getCompany)."' and JD='".urldecode($getJd)."' group by 1,2) p,  edu_pro q where p.old_bid=q.old_bid and q.mega_mov_no=(p.mega_mov_no-1) and (p.pro_s_no is not null and q.pro_s_no is not null) and p.pro_s_no <> q.pro_s_no group by 1,3,7) z,  search_pro y where z.pro_s_no_2=y.pro_s_no group by 1,4 order by 5 DESC) m  LEFT JOIN available_salaries n on m.pro_s_no_1=n.pro_s_no) s LEFT JOIN available_salaries t on s.pro_s_no=t.pro_s_no order by 7 DESC";
             
                $query = $this->db->query($sql);
				$count = $query->num_rows();				
                if($count==0)
                {
                      $result['call']=array('success'=>false,'code'=>1,'message'=>'nothing found');
                }
				else if ($count>0)
                {
                    
					$result['call'] = array('success' => true, 'code' => 0, 'message' => 'null');
					$result['call']['meta'] = array('total' => $count);
					$result['call']['response']=$query->result();
                }
				else
				{
					$result['call'] = array('success' => false, 'code' => 2, 'message' => 'something went wrong');
			$result['call']['meta'] = array('total' => 0);
			$result['call']['response'] = array();
				}

                return $result;
            }			
		
		public function get_Lateral_Vs_Higher($getCompany, $getJd) {

		$sql= "Select 'Lateral Switch', count(CASE WHEN t.mov_type='Lateral Switch' then t.old_bid end) as C1, 
'Education' as 'Higher Education', count(CASE WHEN t.s_char='E' then t.old_bid end) as C2, 'Tech' as 'Technical Education', count(CASE WHEN t.mov_type='Tech' then t.old_bid end) as C2a, 'Research' , count(CASE WHEN t.mov_type='Research' then t.old_bid end) as C2b, 'Management' as 'Management Education', count(CASE WHEN t.mov_type='Management' then t.old_bid end) as C2c from ( Select z.old_bid, z.mega_mov_no, z.next_mov_no, z.s_char, (case when z.s_char='E' then y.degree_genre when z.s_char='P' then 'Lateral switch' end) as mov_type from edu_pro y,
 (Select a.old_bid, a.mega_mov_no, (a.mega_mov_no+1) as next_mov_no, b.s_char from (Select old_bid, mega_mov_no from edu_pro where JD='".urldecode($getJd)."' and stan_company='".urldecode($getCompany)."' and chutiya_admi is null group by 1,2) a, edu_pro b where a.old_bid=b.old_bid and (a.mega_mov_no+1)=b.mega_mov_no group by 1,2) z where z.old_bid=y.old_bid and z.next_mov_no=y.mega_mov_no) t";
             
                $query = $this->db->query($sql);
				$count = $query->num_rows();				
                if($count==0)
                {
                      $result['call']=array('success'=>false,'code'=>1,'message'=>'nothing found');
                }
				else if ($count>0)
                {
                    
					$result['call'] = array('success' => true, 'code' => 0, 'message' => 'null');
					$result['call']['meta'] = array('total' => $count);
					
					$array = $query->result();
					$x=0;
					$y=0;
					$flag=0;
                                        $myTotal=(($array[0]->{'C1'})+($array[0]->{'C2'}));
                                        //echo($myTotal);
                                        //var_dump($array);
                                        foreach ($array[0] as $key => $value) {
						if ($flag == 0){
							if($x>1){		
								$finalArray[1]['subvalue'][$y]['key'] = $key;									
								$flag=1;
							}else{
								$finalArray[$x]['key'] = $key;
								$flag=1;
							}
							}
						elseif($flag ==1){
							if($x>1){
								$finalArray[1]['subvalue'][$y]['value'] = round((($value/$myTotal)*100),0);
								$flag=0;
								$y++;
								$x++;
							}else{
								$finalArray[$x]['value'] = round((($value/$myTotal)*100),0);
								$finalArray[$x]['subvalue'] = array();
								$flag=0;
								$x++;
							}							
						}
						
					}
					$result['call']['response']=$finalArray;
                }
				else
				{
					$result['call'] = array('success' => false, 'code' => 2, 'message' => 'something went wrong');
					$result['call']['meta'] = array('total' => 0);
					$result['call']['response'] = array();
					}

                return $result;
	}

	public function get_Popular_Switches_FromCompany_forSpiderTool($getCompany, $getJd) {

		$sql = "Select skill_token as skill, count(*) as total from search_pro r, (Select z.pro_s_no_1, z.company_1, z.JD_1, y.pro_s_no, y.stan_company as company_2, y.JD as JD_2, z.freq from (Select p.old_bid, p.mega_mov_no as mega_mov_no_1, p.pro_s_no as pro_s_no_1,  p.stan_company as company_1, p.JD as JD_1, (p.mega_mov_no+1) as mega_mov_no_2, q.pro_s_no as pro_s_no_2, count(q.old_bid) as freq from (Select old_bid, mega_mov_no, pro_s_no,stan_company, JD, duration_with_2015 as stay from edu_pro where stan_company='" . urldecode($getCompany) . "' and JD='" . urldecode($getJd) . "' group by 1,2) p, edu_pro q where p.old_bid=q.old_bid and q.mega_mov_no=(p.mega_mov_no+1) and (p.pro_s_no is not null and q.pro_s_no is not null) and p.pro_s_no <> q.pro_s_no group by 1,3,7) z, search_pro y where z.pro_s_no_2=y.pro_s_no group by 1,4 order by 5 DESC) m where r.pro_s_no=m.pro_s_no group by 1 order by 2 DESC";

		$skillsArray = array();
		$skillString = '';
		$jd_1 = '';
		$query = $this -> db -> query($sql);
		$count = $query -> num_rows();
		if ($count == 0) {
			$result['call'] = array('success' => false, 'code' => 1, 'message' => 'nothing found');
			$result['call']['meta'] = array('total' => 0);
			$result['call']['response'] = array();
		} else if ($count > 0) {

			$result['call'] = array('success' => true, 'code' => 0, 'message' => 'null');
			$result['call']['meta'] = array('total' => $count);
			$result['call']['response'] = $query -> result();			
		} else {
			$result['call'] = array('success' => false, 'code' => 2, 'message' => 'something went wrong');
			$result['call']['meta'] = array('total' => 0);
			$result['call']['response'] = array();
		}
		return $result;
	}
}

?>