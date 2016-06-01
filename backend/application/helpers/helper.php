<?php

if(!function_exists('my_decrypt'))
{
   function my_decrypt($data, $key, $base64_safe = true, $expand = true) {
		if ($base64_safe)
			$data = base64_decode($data . '==');
		$data = @mcrypt_encrypt(MCRYPT_ARCFOUR, $key, $data, MCRYPT_MODE_STREAM);
		if ($expand)
			$data = base_convert($data, 36, 10);
		return $data;
	}
}

if(!function_exists('my_encrypt'))
{
   function my_encrypt($data, $key, $base64_safe=true, $shrink=true) {
        if ($shrink) $data = base_convert($data, 10, 36);
        $data = @mcrypt_encrypt(MCRYPT_ARCFOUR, $key, $data, MCRYPT_MODE_STREAM);
        if ($base64_safe) $data = str_replace('=', '', base64_encode($data));
        return $data;
	}
}

?>