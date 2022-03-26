<?php

if (!function_exists('hashPassword')) {
	function hashPassword($pass) {
		return sha1(md5($pass));
	}
}

if (!function_exists('GeneratePassword')) {
    function GeneratePassword(){
     $str = '1234567890?*@#^&+-<!>';
     $passlength = 6;
     $password = '';

     for($i = 0; $i < $passlength; $i++) {
          $password .= chr(rand(33, 126));
     }

     return $password . substr(str_shuffle($str), 0, 2);
     
   }
}

if (!function_exists('generateCode')) {
    function generateCode(){
     $data = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ';
     $rand = rand(0,9000);
     
     return substr(str_shuffle($data), 0, 6).substr($rand, 0, 5);
   }
}

if (!function_exists('checkFileExt')) {
    function checkFileExt($file){
         $expFile = explode('.', $file); //RETURN ARRAY

         $getExt = strtolower(end($expFile)); // RETURN LAST VALUE OF ARRAY

         return $getExt;
   }
}


?>