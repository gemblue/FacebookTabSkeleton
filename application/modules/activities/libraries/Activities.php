<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 

class Activities {

	var $ci = null;
	
	# constructor
	function Activities()
	{
		$this->ci =& get_instance();
	}
	
	function get_feed()
	{
		$activity_stream = $this->ci->activities_m->get_stream(null, 'array', 15, 'latest');
				
		$lk = 1;
		foreach ($activity_stream as $row)
		{
			# actor
			$actor_name = $this->ci->mdl_user->get_user_meta($row->user_id, 'first_name');
			$actor_username =  $this->ci->mdl_user->get_username($row->user_id,'id');
			$avatar = '<a class="pull-left" href="'.site_url('member/wall/'.$actor_username).'"><img width="50" src="'.$this->ci->mdl_user->get_avatar($row->user_id).'" class="media-object"></a>';
					
			# control actor link
			if (!empty($actor_name)) {
				$actor_link = '<a href="'.site_url('member/wall/'.$actor_username).'">'.$actor_name.'</a>';
			} else {
				$actor_link = '<a href="'.site_url('member/wall/'.$actor_username).'">'.$actor_username.'</a>';
			}
					
			# show the content control
			if ($row->object == 'Wp_Post' || $row->object == 'Post')
			{
				$link = site_url($this->ci->mdl_post->get_post_slug($row->object_id));
				$title = $this->ci->mdl_post->get_post_title('id', $row->object_id);
				$display = $actor_link.' '.ucfirst(str_replace('_',' ',$row->action)).' di <a href='.$link.'>'.$title.'</a>, '.time_ago($row->created_at);					
			}
			else if ($row->object == 'Referral')
			{
				$log = explode('-',$row->log);
				$log_name = $this->ci->mdl_user->get_username($log[1],'id');
				$display = $actor_link.' '.'dapat point referral dari <a href='.site_url('member/wall/'.$log_name).'>'.$log_name.'</a> yang sukses registrasi, '.$row->created_at;	
			}
			else if ($row->object == 'User')
			{
				if ($row->action == 'register')
				{
					$link = '';	
					$display = $actor_link.' '.'register di la-lights, '.time_ago($row->created_at);
				}
				else if ($row->action == 'login')
				{
					$link = '';	
					$display = $actor_link.' '.'login di la-lights, '.time_ago($row->created_at);
				}
				else
				{
				
				}
			}
			else if ($row->object == 'Wall')
			{
				if ($row->action == 'wall_post')
				{
					$link = '';	
					$display = $actor_link.' '.'post status di timeline, '.time_ago($row->created_at);
				}
			}
			else if ($row->object == 'Entry')
			{
				if ($row->action == 'public_vote_stage2_1')
				{
					$link = '';	
					$display = $actor_link.' '.'vote stage, '.time_ago($row->created_at);
				}
			}
			else if ($row->object == 'Status')
			{
				if ($row->action == 'Update_status')
				{
					$link = '';	
					$display = $actor_link.' '.'update status, '.time_ago($row->created_at);
				}
				else
				{
					$action_plode = explode('_', $row->action);
					$author_id = $this->ci->status_m->get_author($row->object_id);
					$author_username = $this->ci->mdl_user->get_username($author_id, 'id');
					$author_name = $this->ci->mdl_user->get_user_meta($author_id, 'first_name');
					$status = '<a href="'.site_url('member/status/'.$row->object_id).'">status</a>';	
							
					# display control author
					if ($author_username == $actor_username) 
					{
						$author_show = 'sendiri';
					} 
					else 
					{
						$author_show = '<a href="'.site_url('member/wall/'.$author_username).'">'.$author_username.'</a>';
						if (!empty($author_name)) {
							$author_show = '<a href="'.site_url('member/wall/'.$author_username).'">'.$author_name.'</a>';
						} else {
							$author_show = '<a href="'.site_url('member/wall/'.$author_username).'">'.$author_username.'</a>';
						}
					}	
			
					$display =  $actor_link.' '.$action_plode[0].' '.$status.' '.$author_show;
				}
			}
			else
			{
				$link = 'undefined';
				$display = $actor_link.' '.ucfirst(str_replace('_',' ',$row->action)).' di <a href='.$link.'>'.$link.'</a>, '.time_ago($row->created_at);
			}
				
			echo '<div class="item '.($lk == 1 ? 'active' : '').'"><div class="media">'.$avatar.'<div class="media-body">'.$display.'</div></div></div>';
			$lk++;
		}	
	}
	
}


