<?php
    
    class Hits{
    	
		public function enterHits($searchTerm){
	    	include('mysqli.php');
			for($i=3;$i<=count($searchTerm);$i++){	
				$queryUserDetail = "UPDATE `search_v1` SET `hits`= hits+1,`last_update`= now() WHERE input = '".$searchTerm[$i]."' and type='".$searchTerm[1]."'";
				var_dump($queryUserDetail);
				mysqli_query($db,$queryUserDetail);
			}
		}
	}
?>