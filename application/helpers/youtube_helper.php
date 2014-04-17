<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
if ( ! function_exists('get_total_views'))
{
	function get_total_views($video_id)	
	{
		$data = file_get_contents("https://gdata.youtube.com/feeds/api/videos/{$video_id}?v=2&alt=json");
		$data = json_decode($data);
		$views = $data->{'entry'}->{'yt$statistics'}->{'viewCount'};		
		return $views;
	}
}