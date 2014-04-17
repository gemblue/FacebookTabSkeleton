<?php $this->load->view($template_name.'partials/app_header'); ?>	


	<div class="main-content bg-general">	
	
		<div class="main-container">					
		
			<?php $this->load->view($template_name.'partials/app_navbar'); ?>	
			
			<div class="content">	

				<?php
				# setup data
				$post_author_username = $this->mdl_user->get_username($post_author,'id');
				$post_author_fb_id = $this->mdl_user->get_user_meta($post_author, 'facebook_id');
				$post_author_avatar = 'https://graph.facebook.com/'.$post_author_fb_id.'/picture?width=50&height=50';

				# get image story
				$image[0] = $this->mdl_post->get_post_meta($post_id, 'image_story_0');
				$image[1] = $this->mdl_post->get_post_meta($post_id, 'image_story_1');
				$image[2] = $this->mdl_post->get_post_meta($post_id, 'image_story_2');
				$image[3] = $this->mdl_post->get_post_meta($post_id, 'image_story_3');
				?>
				
				<div class="head-post">
					<div class="padding-md-left padding-md-right">
						<div class="row">
							<div class="col-sm-5">
								<div class="head-table">
									<div class="inner-table-cell">
										<div class="media">
											<div class="pull-left">
												<div class="ava-wr-sm">
													<img src="<?php echo $post_author_avatar;?>">
												</div>
											</div>
											<div class="media-body">
												<div class="h4 text-bold text-black margin-sm-top">
												<?php 
												/*
												$pageContent = file_get_contents('http://graph.facebook.com/'.$post_author_username);
												$parsedJson  = json_decode($pageContent);
												echo $parsedJson->name;
												*/
												echo $post_author_username;
												?>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-7">
								<div class="head-table">
									<div class="inner-table-cell">
										<div class="view-n-share text-right form-inline">
											<div class="row">
												<div class="col-sm-7 text-right">
													<!--
													<div class="fb-like" data-href="<?php echo site_url('app/story_detail/'.$this->uri->segment(3)); ?>" data-layout="button_count" data-action="like" data-show-faces="false" data-share="false"></div>
													<a href="https://twitter.com/share" class="twitter-share-button" data-url="<?php echo site_url('app/story_detail/'.$this->uri->segment(3)); ?>" data-lang="en">Tweet</a>
													-->
												</div>
												<div class="col-sm-5">
													<div class="text-right">
														<span class="margin-sm-right">Views</span> <div class="count pull-right"><?php echo $this->mdl_post->get_post_meta($post_id, 'views'); ?></div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<div class="body-detail">
				
					<div class="inner-body">
						<div class="margin-md-bottom"><?php echo $post_content?></div>
						
						<?php echo ($image[0] != '' ? '<div class="margin-md-bottom"><img src="'.site_url('assets/uploaded/img/post_thumb/'.$image[0]).'" class="full-width" /></div>' : ''); ?>
						<?php echo ($image[1] != '' ? '<div class="margin-md-bottom"><img src="'.site_url('assets/uploaded/img/post_thumb/'.$image[1]).'" class="full-width" /></div>' : ''); ?>
						<?php echo ($image[2] != '' ? '<div class="margin-md-bottom"><img src="'.site_url('assets/uploaded/img/post_thumb/'.$image[2]).'" class="full-width" /></div>' : ''); ?>
						<?php echo ($image[3] != '' ? '<div class="margin-md-bottom"><img src="'.site_url('assets/uploaded/img/post_thumb/'.$image[3]).'" class="full-width" /></div>' : ''); ?>
						
					</div>
				</div>
				
				<div class="margin-sm-top text-center">
					<a href="<?php echo site_url('app/story'); ?>" class="btn btn-gold text-uppercase btn-space">Back</a>
				</div>

				

				
				
			</div>
			
		</div>
		
	</div>
	
	<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="https://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
	
<?php $this->load->view($template_name.'partials/app_footer'); ?>