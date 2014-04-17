<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
if ( ! function_exists('segoecaptcha'))
{
	function segoecaptcha($number_1, $number_2){
	
		header('Content-Type: image/png');
		
		$img_path = './captcha/';
		$img_url = base_url().'captcha/';
		$font_path = './assets/font/segoesc.ttf';
		
		// Create the image
		$im = imagecreatetruecolor(220, 28);

		// Create some colors
		$white = imagecolorallocate($im, 223, 223, 223);
		$grey = imagecolorallocate($im, 234, 4, 15);
		$black = imagecolorallocate($im, 0, 0, 0);
		imagefilledrectangle($im, 0, 0, 399, 29, $white);

		// The text to draw
		$text = 'What is '.$number_1.' plus '.$number_2;
		// Replace path by your own font path
		//$font = 'font/segoesc.ttf';

		// Add some shadow to the text
		imagettftext($im, 14, 0, 11, 21, $grey, $font_path, $text);

		// Add the text
		imagettftext($im, 14, 0, 10, 20, $black, $font_path, $text);

		// Using imagepng() results in clearer text compared with imagejpeg()
		Imagepng($im); 
		ImageDestroy($im);

	}
}
