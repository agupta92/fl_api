<?php
    class Company_industry_model extends CI_Model {

        public function __construct()
            {       
                    parent::__construct();
            }
    
		public function get_assoc_jd($getCompany)
            {
                
                $sql= "Select JD, count(*) as freq from search_pro where stan_company='".urldecode($getCompany)."' group by 1 order by 2 DESC LIMIT 10";
             
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

           public function get_assoc_skills($getCompany)
            {
                $sql= "Select skill_token as skill, count(*)  as freq from search_pro where stan_company='".urldecode($getCompany)."' group by 1 order by 2 DESC LIMIT 10";
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
     
         public function get_assoc_industries($getCompany)
            {
                $sql="Select stan_industry from stan_company_industry where stan_company='".urldecode($getCompany)."' LIMIT 10";
                //$sql = "select b.stan_industry , count(b.stan_industry) as rel from stan_company_industry b where stan_company in (select a.stan_company from stan_company_industry a where `stan_industry` = '".urldecode($getCompany)."') Group by 1 having rel<( select count(stan_company) from stan_company_industry where `stan_industry` = '".urldecode($getCompany)."') order by 2 desc LIMIT 10";
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
        
        
			

		public function get_similar_companies($getCompany)
            {
                
                //$sql= "Select f.stan_company, count(*) as rel from stan_company_industry f, ( select d.`stan_industry`, count(*) from stan_company_industry d, (select  b.stan_company  from stan_company_industry b, (  Select `stan_industry`  from stan_company_industry  where stan_company='".urldecode($getCompany)."'  ) a where  a.stan_industry=b.stan_industry group by 1) c where d.stan_company=c.stan_company group by 1 order by 2 DESC limit 0,10 ) e where f.stan_industry= e.stan_industry group by 1 having rel>=3 order by 2 DESC LIMIT 20";
				$sql = "SELECT b.stan_company, b.stan_industry, COUNT( stan_company ) AS rel FROM stan_company_industry b WHERE stan_industry IN ( SELECT  a.`stan_industry` FROM stan_company_industry a WHERE  `stan_company` =  '".urldecode($getCompany)."' ) GROUP BY 1 having rel < (select count(`stan_industry`) FROM stan_company_industry WHERE  `stan_company` =  '".urldecode($getCompany)."') ORDER BY 3 DESC LIMIT 10";
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
                           $result['call']['response'][$countLooper]['rel']=$row->rel;
                           
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

		public function get_in_there($getCompany)
            {
                
                $sql_graduation= "Select b.JD, a.total_people from  (Select pro_s_no, total_people from edu_pro_relation where graduation/total_people>=0.15 and stan_company='".urldecode($getCompany)."' group by 1 order by 2 DESC) a, (select pro_s_no, JD from search_pro where stan_company='".urldecode($getCompany)."' group by 1) b where a.pro_s_no=b.pro_s_no group by 1 order by 2 DESC";            
                $query_graduation = $this->db->query($sql_graduation);
				$count_graduation = $query_graduation->num_rows();	

				$sql_directPlacement= "Select b.JD, a.total_people from  (Select pro_s_no, total_people from edu_pro_relation where direct_placement/total_people>=0.15 and stan_company='".urldecode($getCompany)."' group by 1 order by 2 DESC) a, (select pro_s_no, JD from search_pro where stan_company='".urldecode($getCompany)."' group by 1) b where a.pro_s_no=b.pro_s_no group by 1 order by 2 DESC";             
                $query_directPlacement = $this->db->query($sql_directPlacement);
				$count_directPlacement = $query_directPlacement->num_rows();

				$sql_lessThanOneYear= "Select b.JD, a.total_people from  (Select pro_s_no, total_people from edu_pro_relation where `<1 year`/total_people>=0.15 and stan_company='".urldecode($getCompany)."' group by 1 order by 2 DESC) a, (select pro_s_no, JD from search_pro where stan_company='".urldecode($getCompany)."' group by 1) b where a.pro_s_no=b.pro_s_no group by 1 order by 2 DESC";
                $query_lessThanOneYear = $this->db->query($sql_lessThanOneYear);
				$count_lessThanOneYear = $query_lessThanOneYear->num_rows();
				
				
				$sql_oneToThreeYear = "Select b.JD, a.total_people from  (Select pro_s_no, total_people from edu_pro_relation where `1-3 year`/total_people>=0.15 and stan_company='".urldecode($getCompany)."' group by 1 order by 2 DESC) a, (select pro_s_no, JD from search_pro where stan_company='".urldecode($getCompany)."' group by 1) b where a.pro_s_no=b.pro_s_no group by 1 order by 2 DESC";             
                $query_oneToThreeYear = $this->db->query($sql_oneToThreeYear);
				$count_oneToThreeYear = $query_oneToThreeYear->num_rows();
				
				$sql_threeToFiveYear= "Select b.JD, a.total_people from  (Select pro_s_no, total_people from edu_pro_relation where `3-5 year`/total_people>=0.15 and stan_company='".urldecode($getCompany)."' group by 1 order by 2 DESC) a, (select pro_s_no, JD from search_pro where stan_company='".urldecode($getCompany)."' group by 1) b where a.pro_s_no=b.pro_s_no group by 1 order by 2 DESC";            
                $query_threeToFiveYear = $this->db->query($sql_threeToFiveYear);
				$count_threeToFiveYear = $query_threeToFiveYear->num_rows();
				
				$sql_fiveToSeavenYear = "Select b.JD, a.total_people from  (Select pro_s_no, total_people from edu_pro_relation where `5-7 year`/total_people>=0.15 and stan_company='".urldecode($getCompany)."' group by 1 order by 2 DESC) a, (select pro_s_no, JD from search_pro where stan_company='".urldecode($getCompany)."' group by 1) b where a.pro_s_no=b.pro_s_no group by 1 order by 2 DESC";            
                $query_fiveToSeavenYear = $this->db->query($sql_fiveToSeavenYear);
				$count_fiveToSeavenYear = $query_fiveToSeavenYear->num_rows();

				$sql_greaterThanSeavenYears= "Select b.JD, a.total_people from  (Select pro_s_no, total_people from edu_pro_relation where `>7 year`/total_people>=0.15 and stan_company='".urldecode($getCompany)."' group by 1 order by 2 DESC) a, (select pro_s_no, JD from search_pro where stan_company='".urldecode($getCompany)."' group by 1) b where a.pro_s_no=b.pro_s_no group by 1 order by 2 DESC";            
                $query_greaterThanSeavenYears = $this->db->query($sql_greaterThanSeavenYears);
				$count_greaterThanSeavenYears = $query_greaterThanSeavenYears->num_rows();

				$sql_higherManagement= "Select b.JD, a.total_people from  (Select pro_s_no, total_people from edu_pro_relation where `higher_man`/total_people>=0.15 and stan_company='".urldecode($getCompany)."' group by 1 order by 2 DESC) a, (select pro_s_no, JD from search_pro where stan_company='".urldecode($getCompany)."' group by 1) b where a.pro_s_no=b.pro_s_no group by 1 order by 2 DESC";             
                $query_higherManagement = $this->db->query($sql_higherManagement);
				$count_higherManagement = $query_higherManagement->num_rows();
				
				$sql_higherTech= "Select b.JD, a.total_people from  (Select pro_s_no, total_people from edu_pro_relation where `higher_tech`/total_people>=0.15 and stan_company='".urldecode($getCompany)."' group by 1 order by 2 DESC) a, (select pro_s_no, JD from search_pro where stan_company='".urldecode($getCompany)."' group by 1) b where a.pro_s_no=b.pro_s_no group by 1 order by 2 DESC";             
                $query_higherTech = $this->db->query($sql_higherTech);
				$count_higherTech = $query_higherTech->num_rows();
				
				$sql_higherResearch = "Select b.JD, a.total_people from  (Select pro_s_no, total_people from edu_pro_relation where `higher_res`/total_people>=0.15 and stan_company='".urldecode($getCompany)."' group by 1 order by 2 DESC) a, (select pro_s_no, JD from search_pro where stan_company='".urldecode($getCompany)."' group by 1) b where a.pro_s_no=b.pro_s_no group by 1 order by 2 DESC";             
                $query_higherResearch = $this->db->query($sql_higherResearch);
				$count_higherResearch = $query_higherResearch->num_rows();	
				$finalArray;
                if($count_higherResearch==0)
                {
                      $result['call']=array('success'=>false,'code'=>1,'message'=>'nothing found');
					 $result['call']['meta']=array('total'=>0);
					 $result['call']['response']=array();
                }
				else if ($count_higherResearch>0)
                {
                    $tempkeys = array('<1','1-2','3-5','5-7','>7','MANAGEMENT','TECHNICAL','RESEARCH');
                    $query = array($query_lessThanOneYear->result(),$query_oneToThreeYear->result(),$query_threeToFiveYear->result(),$query_fiveToSeavenYear->result(),$query_greaterThanSeavenYears->result(),$query_higherManagement->result(),$query_higherTech->result(),$query_higherResearch->result());
					
					$x=0;
					$y=0;
					foreach ($tempkeys as $key ) {
						if($x  <=4){
							$finalArray[0]["tab"] = "GRADUATION";
							$finalArray[0]["subtab"][$x] = array("key" => $key,'value' => $query[$x]);
							
							
						}else {
							$finalArray[1]["tab"] = "HIGHER STUDIES";
							$finalArray[1]["subtab"][$y] = array("key" => $key,'value' => $query[$x]);
							$y++;
						}

						$x++;
					}
					
					$result['call']=array('success'=>true,'code'=>0,'message'=>'null');
					$result['call']['meta']=array('total'=>  5);
                    $result['call']['response']=$finalArray;
					
                }
				else
				{
					$result['call']=array('success'=>false,'code'=>2,'message'=>'something went wrong');
                        $result['call']['meta']=array('total'=>0);
                        $result['call']['response']=array();  
				}

                return $result;
            }
		
		public function get_available_salaries($getCompany)
            {
                
                $sql= "Select a.JD, FORMAT(b.tent_sal,0) as tent_sal, a.total_people from  (Select pro_s_no, JD, total_people from search_pro where stan_company='".urldecode($getCompany)."' group by 1) a, available_salaries b where a.pro_s_no=b.pro_s_no group by 1 order by 3 DESC LIMIT 20";
             
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

		public function get_Popular_Switches_FromCompany($getCompany)
            {
                
                $sql= "Select s.company_1, s.JD_1, FORMAT(s.tent_sal,0) as tent_sal_1, s.company_2, s.JD_2, FORMAT(t.tent_sal,0) as tent_sal_2 ,  s.freq from (Select m.company_1, m.JD_1, n.tent_sal, m.pro_s_no, m.company_2, m.JD_2, m.freq from (Select z.pro_s_no_1, z.company_1, z.JD_1, y.pro_s_no, y.stan_company as company_2, y.JD as JD_2, z.freq  from (Select p.old_bid, p.mega_mov_no as mega_mov_no_1, p.pro_s_no as pro_s_no_1,  p.stan_company as company_1, p.JD as JD_1, (p.mega_mov_no+1) as mega_mov_no_2, q.pro_s_no as pro_s_no_2, count(q.old_bid) as freq from (Select old_bid, mega_mov_no, pro_s_no,stan_company, JD, duration_with_2015 as stay from edu_pro where stan_company='".urldecode($getCompany)."' group by 1,2) p,  edu_pro q where p.old_bid=q.old_bid and q.mega_mov_no=(p.mega_mov_no+1) and (p.pro_s_no is not null and q.pro_s_no is not null) and p.pro_s_no <> q.pro_s_no group by 1,3,7) z,  search_pro y where z.pro_s_no_2=y.pro_s_no group by 1,4 order by 5 DESC) m  LEFT JOIN available_salaries n on m.pro_s_no_1=n.pro_s_no) s LEFT JOIN available_salaries t on s.pro_s_no=t.pro_s_no ORDER BY 7 DESC LIMIT 10";
             
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
			
		public function get_Popular_Switches_ToCompany($getCompany)
            {
                
                $sql= "Select s.company_2 as prev_company, s.JD_2 as prev_jd, FORMAT(t.tent_sal,0) as prev_sal , s.company_1 as next_company, s.JD_1 as next_jd, FORMAT(s.tent_sal,0) as next_sal, s.freq from (Select m.company_1, m.JD_1, n.tent_sal, m.pro_s_no, m.company_2, m.JD_2, m.freq from (Select z.pro_s_no_1, z.company_1, z.JD_1, y.pro_s_no, y.stan_company as company_2, y.JD as JD_2, z.freq  from (Select p.old_bid, p.mega_mov_no as mega_mov_no_1, p.pro_s_no as pro_s_no_1,  p.stan_company as company_1, p.JD as JD_1, (p.mega_mov_no-1) as mega_mov_no_2, q.pro_s_no as pro_s_no_2, count(q.old_bid) as freq from (Select old_bid, mega_mov_no, pro_s_no,stan_company, JD, duration_with_2015 as stay from edu_pro where stan_company='".urldecode($getCompany)."' group by 1,2) p,  edu_pro q where p.old_bid=q.old_bid and q.mega_mov_no=(p.mega_mov_no-1) and (p.pro_s_no is not null and q.pro_s_no is not null) and p.pro_s_no <> q.pro_s_no group by 1,3,7) z,  search_pro y where z.pro_s_no_2=y.pro_s_no group by 1,4 order by 5 DESC) m  LEFT JOIN available_salaries n on m.pro_s_no_1=n.pro_s_no) s LEFT JOIN available_salaries t on s.pro_s_no=t.pro_s_no order by 7 DESC";
             
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
            
            public function get_attritionRate($getCompany)
            {
                
                $count=0;
             	$sqlString=array('and (cum_exp-duration_with_2015-48)<12','and (cum_exp-duration_with_2015-48)>=12 and (cum_exp-duration_with_2015-48)<24','and (cum_exp-duration_with_2015-48)>=24  and (cum_exp-duration_with_2015-48)<36','and (cum_exp-duration_with_2015-48)>=36  and (cum_exp-duration_with_2015-48)<48','and (cum_exp-duration_with_2015-48)>=48  and (cum_exp-duration_with_2015-48)<60','and (cum_exp-duration_with_2015-48)>=60');
                    
 				$qCount=0;               
				foreach($sqlString as $condition){
                    
				$sql= "Select (count( CASE WHEN z.stan_company_1<>z.stan_company_2 and  z.stay<6 then z.old_bid end))/c.total as '<0.5 year', 
				(count( CASE WHEN z.stan_company_1<>z.stan_company_2 and z.stay>=6 and z.stay<12 then z.old_bid end))/c.total as '0.5 - 1 year', 
				(count( CASE WHEN z.stan_company_1<>z.stan_company_2 and z.stay>=12 and z.stay<24 then z.old_bid end))/c.total as '1-2 year', 
				(count( CASE WHEN z.stan_company_1<>z.stan_company_2 and z.stay>=24 and z.stay<36 then z.old_bid end))/c.total as '2-3 year', 
				(count( CASE WHEN z.stan_company_1<>z.stan_company_2 and z.stay>=36  and z.stay<48 then z.old_bid end))/c.total as '3-4 year', 
				(count( CASE WHEN z.stan_company_1<>z.stan_company_2 and z.stay>=48  and z.stay<60 then z.old_bid end))/c.total as '4-5 year', 
				(count( CASE WHEN z.stan_company_1<>z.stan_company_2 and z.stay>=60 then z.old_bid end))/c.total as '>5 year' from  
				(Select a.old_bid, a.mega_mov_no as mega_mov_no_1, a.stan_company as stan_company_1, a.stay, (a.mega_mov_no+1) as mega_mov_no_2, b.stan_company as stan_company_2 from  
				(Select old_bid, mega_mov_no, stan_company, duration_with_2015 as stay from edu_pro where stan_company='".urldecode($getCompany)."' ".$condition." group by 1,2) a, 
				edu_pro b  where a.old_bid=b.old_bid and b.mega_mov_no=(a.mega_mov_no+1) group by 1,2,5) z,  (Select (count( CASE WHEN y.stan_company_1<>y.stan_company_2 and y.stay>=0 then y.old_bid end))
				as 'total' from (Select p.old_bid, p.mega_mov_no as mega_mov_no_1, p.stan_company as stan_company_1, p.stay, (p.mega_mov_no+1) 
				as mega_mov_no_2, q.stan_company as stan_company_2 from  (Select old_bid, mega_mov_no, stan_company, duration_with_2015 as stay 
				from edu_pro where stan_company='".urldecode($getCompany)."' ".$condition." group by 1,2) p,  edu_pro q  
				where p.old_bid=q.old_bid and q.mega_mov_no=(p.mega_mov_no+1) group by 1,2,5) y ) c";
    					$query[$qCount] = $this->db->query($sql);
    					$count+=$query[$qCount]->num_rows();
    					$qCount++;   
				}	
                if($count==0)
                {
                     $result['call']=array('success'=>false,'code'=>1,'message'=>'nothing found');
					 $result['call']['meta']=array('total'=>0);
					 $result['call']['response']=array();
                }
				else if ($count>0)
                {
                    $arrayMain=array($query[0]->result(),$query[1]->result(),$query[2]->result(),$query[3]->result(),$query[4]->result(),$query[5]->result());
                    $allKeys=array('<1','1-2','2-3','3-4','4-5','>5');
                    $y=0;
                    foreach($arrayMain as $obj){
                        foreach($obj as $key=>$value) {
                            $valueArray[$y]['key']=$allKeys[$y];
                            $valueArray[$y]['value']=array();
                            $x=0;
                            foreach($value as $keys=>$values) {
                                $values = round($values*100,1);                           	
                                $valueArray[$y]['value'][$x]['value']=$values;
								$newstr = substr_replace($keys, "<br>", strlen ($keys)-4, 0);
                                $valueArray[$y]['value'][$x]['key']= $newstr;
                                $x++;
                            } 
                        }
                        $y++;
                    }
                    $result['call']=array('success'=>true,'code'=>0,'message'=>'null');
					$result['call']['meta']=array('total'=>$count);
                    $result['call']['response']=$valueArray;
                    
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