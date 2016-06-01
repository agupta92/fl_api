<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	define("REDISHOST", 'localhost');
	define("REDISPORT", 6379);
	define("REDISTTL", 96000);
class Rediscachinglib {
		public function __construct()
        {
            global $redisObj;
			$redisObj = new Redis();
        }		
		public function getValuefromKey($key){
			global $redisObj;
			$redisObj->connect(REDISHOST,REDISPORT);			
			
			try{ 				
				$getCallVars=$redisObj->get($key);
				return $getCallVars;
			}catch( Exception $e ){ 
				return $e->getMessage(); 
			} 
		} 
		public function setValuefromKey($key, $value){
			global $redisObj; 
			$redisObj->connect(REDISHOST,REDISPORT);				
			try{ 
				global $redisObj; 
				return $redisObj->setex($key,REDISTTL,$value);
			}catch( Exception $e ){ 
				return $e->getMessage(); 
			} 
		} 
		
		public function flush(){
			global $redisObj; 
			$redisObj->connect(REDISHOST,REDISPORT);				
			$redisObj->flushAll();
		} 
}
?>