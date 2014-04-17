<div class="sidebar-list margin-sm-bottom">
	<div class="sidebar-head h4 padding-sm-left padding-sm-right text-uppercase font-general">
		Top Rating
	</div>
	<div class="sidebar-body padding-sm">
		
		<?php 
		$limit = 3;
		
		$post_top_score = $this->statistic_m->get_top_score($limit);
		
		if (!empty($post_top_score))
		{
			$i = 0;
			$j = 1;
			foreach ($post_top_score as $key => $value)
			{
				$post_id = $post_top_score[$i]['post_id'];
				$score = $post_top_score[$i]['score'];
				
				$title = $this->mdl_custom_post->get_post_title($post_id);
				$slug = $this->mdl_custom_post->get_post_slug($post_id);
				$youtube_id = $this->mdl_custom_post->get_post_meta($post_id, 'link');
				$approve = $this->mdl_custom_post->get_post_meta($post_id, 'approve');
			
				if ($approve == 'yes')
				{
					?>
				
					<div class="list-item <?php echo ($i != $limit ? 'margin-sm-bottom border-side-bottom padding-sm-bottom' : ''); ?>">
						
						<div class="media">
							<a href="<?php echo site_url('song-gallery/'.$slug);?>" class="pull-left">
								<div class="circle-youtube-wr">
									<div class="thumb-ytb">
										<img src="<?php echo 'http://img.youtube.com/vi/'.$youtube_id.'/mqdefault.jpg'; ?>" class="full-width" width="70">
									</div>
								</div>
							</a>
							<div class="media-body">
								<div class="title font-general"><a href="<?php echo site_url('song-gallery/'.$slug);?>"><?php echo $title;?></a></div>
								<div class="desc">Rating: <span class="text-red"><?php echo $score;?></span></div>
							</div>
						</div>
						
					</div>
					
					<?php
					$j++;
					
				}
				
				$i++;
			}
		}
		else
		{
			{
				echo '<div class="alert alert-warning">Comming soon..</div>';
			}
		}
		?>
	
	</div>
</div>

<div class="sidebar-list margin-sm-bottom">
	<div class="sidebar-head h4 padding-sm-left padding-sm-right text-uppercase">
		Top Views
	</div>
	<div class="sidebar-body padding-sm">
		
		<?php 
		$i = 1;
		$limit = 3;
		$post_top_views = $this->statistic_m->get_top_views($limit);
		
		if (!empty($post_top_views))
		{
		
			foreach ($post_top_views as $row)
			{
				$title = $this->mdl_custom_post->get_post_title($row->custom_post_id);
				$slug = $this->mdl_custom_post->get_post_slug($row->custom_post_id);
				$youtube_id = $this->mdl_custom_post->get_post_meta($row->custom_post_id, 'link');
				$approve = $this->mdl_custom_post->get_post_meta($row->custom_post_id, 'approve');
				
				if ($approve == 'yes')
				{
					?>
				
					<div class="list-item <?php echo ($i != $limit ? 'margin-sm-bottom border-side-bottom padding-sm-bottom' : ''); ?>">
						
						<div class="media">
							<a href="<?php echo site_url('song-gallery/'.$slug);?>" class="pull-left">
								<div class="circle-youtube-wr">
									<div class="thumb-ytb">
										<img src="<?php echo 'http://img.youtube.com/vi/'.$youtube_id.'/mqdefault.jpg'; ?>" class="full-width" width="70">
									</div>
								</div>
							</a>
							<div class="media-body">
								<div class="title font-general"><a href="<?php echo site_url('song-gallery/'.$slug);?>"><?php echo $title;?></a></div>
								<div class="desc">View: <span class="text-red"><?php echo $row->meta_value_text; ?></span></div>
							</div>
						</div>
					
					</div>
				
					<?php
					$i++;
				}
				
			}
		}
		else
		{
			{
				echo '<div class="alert alert-warning">Comming soon..</div>';
			}
		}
		?>
		
	</div>
</div>

<div class="sidebar-list margin-sm-bottom">
	<div class="sidebar-head h4 padding-sm-left padding-sm-right text-uppercase">
		Top Comment
	</div>
	<div class="sidebar-body padding-sm">
		
		<?php 
		$i = 1;
		$limit = 3;
		$post_top_comment = $this->statistic_m->get_top_comment($limit);
		
		if (!empty($post_top_comment))
		{
		
			foreach ($post_top_comment as $row)
			{
				$title = $this->mdl_custom_post->get_post_title($row->post_id);
				$slug = $this->mdl_custom_post->get_post_slug($row->post_id);
				$youtube_id = $this->mdl_custom_post->get_post_meta($row->post_id, 'link');
				$approve = $this->mdl_custom_post->get_post_meta($row->post_id, 'approve');
				
				if ($approve == 'yes')
				{
					?>
				
					<div class="list-item <?php echo ($i != $limit ? 'margin-sm-bottom border-side-bottom padding-sm-bottom' : ''); ?>">
						
						<div class="media">
							<a href="<?php echo site_url('song-gallery/'.$slug);?>" class="pull-left">
								<div class="circle-youtube-wr">
									<div class="thumb-ytb">
										<img src="<?php echo 'http://img.youtube.com/vi/'.$youtube_id.'/mqdefault.jpg'; ?>" class="full-width" width="70">
									</div>
								</div>
							</a>
							<div class="media-body">
								<div class="title font-general"><a href="<?php echo site_url('song-gallery/'.$slug);?>"><?php echo $title;?></a></div>
								<div class="desc">Comment: <span class="text-red"><?php echo $row->total_comment; ?></span></div>
							</div>
						</div>
						
					</div>
			
					<?
					$i++;
				}
				
			}
		}
		else
		{
			{
				echo '<div class="alert alert-warning">Comming soon..</div>';
			}
		}
		?>
	
	</div>
</div>
