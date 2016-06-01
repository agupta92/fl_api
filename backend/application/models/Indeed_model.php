<?php

class indeed_model extends CI_Model {

        public function __construct()
            {
                    parent::__construct();
            }
    
         public function get_jobs($getSkill,$city,$state)
            {
					$temp = file_get_contents("http://api.indeed.com/ads/apisearch?publisher=7347363940871567&q=".urlencode($getSkill)."&l=".urlencode($city.','.$state)."&sort=&radius=&st=&jt=&start=&limit=&fromage=&filter=&latlong=1&co=in&chnl=&userip=1.2.3.4&useragent=Mozilla/%2F4.0%28Firefox%29&v=2&format=json");	
					
					$obj =  json_decode(($temp));
					//var_dump($obj);
                    return $obj;
            }
    
    
        
}

?>