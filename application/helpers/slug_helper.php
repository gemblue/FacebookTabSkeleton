<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
	fungsi untuk generate unic password
*/
if ( ! function_exists('get_slug'))
{

	function get_slug($kata){
	
		$kata = strtolower($kata);
		$kata = strip_tags($kata,""); 
		$kata = preg_replace('/[^A-Za-z0-9\s.\s-]/','',$kata); 
		$kata = str_replace( ' ', '-', $kata);
		$slug = str_replace( '.', '', $kata);
		
		return $slug;

	}

}

/* End of file slug_helper.php */
/* Location: ./system/helpers/slug_helper.php */