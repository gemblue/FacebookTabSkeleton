<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
|
|  Author : Oriza Sahputra
|  Custom post/page template library for This CMS
|  http://orizasahputra.com
|
*/

class Custom_template 
{

	public function is_this_use_custom($slug)
	{
		/*
		this is for check any custom template setted in a post
		false : the post is not using custom template or custom post/page file is gone
		true : the post is using custom template and the custom post/page file still exist
		*/
		$ci =& get_instance(); 
		
		$id_post = $ci->mdl_post->get_id_post($slug);
		$post_template_name = $ci->mdl_post->get_post_meta($id_post, 'post_template');
		
		if ($post_template_name == 'default' || $post_template_name == '')
		{
			return false;
		}
		else
		{
			/*if the post using custom template, then check is the custom template still exist in an active theme*/
			
			# get current active theme
			$template_name = $ci->mdl_options->get_options('template');
		
			# get template path
			$template_path = 'application/views/'.$template_name;
			
			$check = $this->is_custom_template_still_exist($template_path,$post_template_name);
			
			# if file still exist allow custom post/page template
			if ($check == true) {
				return true;
			}
		}
	}

	public function get_custom_page()
	{
		/*this method will return array custom page template in active theme*/
		$ci =& get_instance(); 
		
		# get current active theme
		$template_name = $ci->mdl_options->get_options('template');
		
		# get template path
		$template_path = 'application/views/'.$template_name;
			
		$result = $this->get_custom_template($template_path,'page');
		
		return $result;
	}
	
	public function get_custom_post()
	{
		/*this method will return array custom post template in active theme*/
		$ci =& get_instance(); 
		
		# get current active theme
		$template_name = $ci->mdl_options->get_options('template');
		
		# get template path
		$template_path = 'application/views/'.$template_name;
			
		$result = $this->get_custom_template($template_path,'post');
		
		return $result;
	}

	private function count_custom_template($template_path, $type)
	{
		if ($handle = opendir($template_path)) 
		{
			/* check, is there a custom page template */
			$counter = 0;
			
			while (false !== ($entry = readdir($handle))) 
			{
				if ($type == 'page') {
					$param = '/my-page/';
				} else {
					$param = '/my-post/';
				}
				
				$check = preg_match($param, $entry); 
				
				if ($check == true)
				{
					$counter++;
				}
			}
			
			return $counter;	
			closedir($handle);
		}
	}
	
	private function get_custom_template($template_path, $type)
	{
		/*this will return array*/
		$data = null;
		
		
		if ($handle = opendir($template_path))
		{
			/*check, is there a custom page template*/
			while (false !== ($entry = readdir($handle))) 
			{
				if ($type == 'page') {
					$param = '/my-page/';
				} else {
					$param = '/my-post/';
				}
				
				$check = preg_match($param, $entry); 
				
				if ($check == true)
				{
					$data[] = str_replace('.php','',$entry);
				}
			}
			
			return $data;
			closedir($handle);
		}
	}

	private function is_custom_template_still_exist($template_path,$post_template_name)
	{
		/*
		this method will check is the custom template file still exist in an active theme
		true : file still exist
		false : file is gone
		*/
		if ($handle = opendir($template_path))
		{	
			/*check, is there a custom page template*/
			$counter = 0;
			
			while (false !== ($entry = readdir($handle))) 
			{
				$param = '/'.$post_template_name.'/';
				
				$check = preg_match($param, $entry); 
				
				if ($check == true)
				{
					$counter++;
				}
			}
			
			if ($counter >= 1) {
				return true;
			}
			
			closedir($handle);
		}
	}
	
	
}
  