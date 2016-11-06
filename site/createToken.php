<?php
	function createToken($length=8){
		$chars = 'bcdfghjklmnpqrstvwxyzBCDFGHJKLMNPQRSTVWXYZ0123456789';
		$charLength = strlen($chars);
		$pw = '';
		
		for ($i =0; $i<$length; $i++){
			$pw .= $chars[rand(0, $charLength-1)];
		}
	return $pw;		
	}
?>
