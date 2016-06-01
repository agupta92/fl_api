<?php
class Utility {

	public function createContentCache() {
		$memcached = new Memcache();
		$memcached -> addServer("127.0.0.1", 11211);
		return $memcached;
	}

	public function createContentRedis() {
		$redis = new PredisClient();
		$redis -> addServer("127.0.0.1", 6379);
		return $redis;
	}

	public function my_decrypt($encrypted_id, $key) {
		//echo $encrypted_id;
		$key = md5($key, true);
		$data = pack('H*', $encrypted_id); // Translate back to binary
		$data = mcrypt_decrypt(MCRYPT_BLOWFISH, $key, $data, 'ecb');
		$data = base_convert($data, 36, 10);
		//var_dump ($data);
		return $data;
	}

	public function my_encrypt($id, $key) {
		$key = md5($key, true);
		$id = base_convert($id, 10, 36); // Save some space
		$data = mcrypt_encrypt(MCRYPT_BLOWFISH, $key, $id, 'ecb');
		$data = bin2hex($data);
		return $data;
	}

}
?>