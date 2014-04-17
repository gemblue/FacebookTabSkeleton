<div class="border-side-bottom padding-sm-bottom">
	<span class="text-uppercase text-bold">Comment</span>
	
	<?php if($user_login != 'yes'): ?>
	<div class="pull-right">
		<small>
		You have to be a L.A. Lights member to leave your comment. <a href="#">Login</a> atau <a href="#">Daftar</a>
		</small>
	</div>
	<?php endif ?>
</div>


<?php if($user_login == 'yes'): ?>
<div class="form-comment-wrapper padding-sm-left padding-sm-right padding-md-top padding-md-bottom border-side-bottom">
	
	<?php echo $this->session->flashdata('message');?>
	
	<form method="post" action="<?php echo site_url('commentar/create/entries');?>">
	<input type="hidden" name="url" value="<?php echo $this->config->site_url().$this->uri->uri_string();?>">
	<input type="hidden" name="post_id" value="<?php echo $post_id;?>">
	<div><textarea name="comment" class="form-control boxed" rows="3"></textarea></div>
	<div class="margin-sm-top text-right"><button type="submit" class="btn btn-la-login">SUBMIT COMMENT</button></div>
	</form>
		
</div>
<?php endif ?>


<div class="loop-comment-wrapper">

	<?php 
	$comment_data = $this->mdl_comm->get_comment('approved', 'array', 'post_id', $post_id, null, null, 'entries');
	foreach ($comment_data as $row)
	{	
		$name_view = $this->custom_show->user_name('username', $row->username);
		
		# facebook avatar
		$data['la_facebook_id'] = $this->mdl_user->get_user_meta($row->user_id, 'la_facebook_id');
		
		if (!empty($data['la_facebook_id']))
		{
			$avatar = 'https://graph.facebook.com/'.$data['la_facebook_id'].'/picture?type=large';
		}
		else
		{
			# gravatar
			$la_email = $this->mdl_user->get_user_meta($row->user_id, 'la_email');
			$grava_code = md5(strtolower(trim($la_email)));
			$avatar = 'http://www.gravatar.com/avatar/'.$grava_code.'?s=200&f=y&d=mm';
		}
		?>
		
		<div class="comment-item padding-sm-left padding-sm-right padding-md-top padding-md-bottom border-side-bottom">
			<div class="media">
				<a href="#" class="pull-left">
					<img width="80" src="<?php echo $avatar?>" class="ava-sm img-circle" />
				</a>
				<div class="media-body">
					<div class="post-title text-bold"><a href="#"><?php echo $name_view;?></a></div>
					<div class="post-date"><small>Commented | <?php echo time_ago($row->created_at)?></small></div>
					<div class="desc margin-sm-top">
						<?php echo $row->content;?>
					</div>
				</div>
			</div>
		</div>
	
		<?php 
	} 
	?>
	
</div>