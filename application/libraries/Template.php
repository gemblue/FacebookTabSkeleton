<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
|
|  Author : Oriza Sahputra
|  Custom post/page template library for This CMS
|  http://orizasahputra.com
|
*/

class Template 
{
	var $ci = null;
	
	function template()
	{
		$this->ci =& get_instance();
	}
	
	public function comment_form($post_id, $mode = null)
	{
		$logged_in = $this->ci->session->userdata('logged_in');
		
		if ($logged_in == 'hore')
		{
			echo
			'
			<form method="post" action="'.site_url('commentar/create/'.$mode).'">
				<input type="hidden" name="url" value="'.$this->ci->config->site_url().$this->ci->uri->uri_string().'">
				<input type="hidden" name="post_id" value="'.$post_id.'">
				<div><textarea name="comment" rows="5"></textarea></div>
				<button type="submit">SUBMIT</button>
			</form>
			';
		}
		else
		{
			echo 'Login to comment.';
		}
	}

	public function comment_data($post_id = null, $mode = null)
	{
		if ($mode == 'entries')
		{
			$comment_data = $this->ci->mdl_comm->get_comment('approved', 'array', 'post_id', $post_id, null, null, 'entries');
		}
		else
		{
			$comment_data = $this->ci->mdl_comm->get_comment('approved', 'array', 'post_id', $post_id);								
		}
		
		if(!empty($comment_data))
		{
			foreach ($comment_data as $row)
			{
				$name_view = $this->ci->custom_show->user_name('username', $row->username);
					
				echo
				'
				<a href="'.site_url('profile/'.$row->username).'">
				<img width="70" src="'.$this->ci->mdl_user->get_avatar($row->user_id).'">
				</a>
														
				<div><a href="'.site_url('profile/'.$row->username).'">'.$name_view.'</a></div>
				<div>Commented at '.time_ago($row->created_at).'</div>
				<div>'.$row->content.'</div><br/><br/>
				';
			}
		}
	}
	
}
  