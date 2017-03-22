<?php session_start();

    function randomString($length) {
           $string = ""; 
           $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	   for ($i = 0; $i < $length; $i++) {
		$string.= $chars[mt_rand(0, strlen($chars)-1)];
            }
                return $string;
    }
    /*******DATOS PRINCIPALES********/
        $rantxt = $_SESSION["tmptxt"] = randomString(7);
        $imgcap = '../../images/principal/fondo_captcha.png';
        $font = 5;
        $x = 30;
        $y = 7; 
        $size = 14;
    /*******END DATOS PRINCIPALES********/
        
        $captimg = imagecreatefrompng($imgcap); /*IMAGEN DEL FONDO*/
        
        $coltext = imagecolorallocate($captimg, 168,168,168);
        
        imagestring($captimg, $font, $x, $y, $rantxt, $coltext); 
        
        header("Content-type: image/gif");
        
        imagepng($captimg);
?>