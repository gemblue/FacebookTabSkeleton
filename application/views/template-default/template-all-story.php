<?php $this->load->view($template_name.'partials/app_header'); ?>	


	<div class="main-content bg-general">
		
		<div class="main-container">
		
			<?php $this->load->view($template_name.'partials/app_navbar'); ?>
			
			
			<div class="content">

				<div class="content-all-stories padding-sm-top">
					
					<div class="row margin-sm-bottom">
						<div class="col-sm-5 col-sm-offset-7">
							<form method="post" action="<?php echo site_url('app/search');?>" class="form-inline nyan-form-search" role="form">					
								<input name="keyword" type="text" class="search-box-input form-control" id="input-search" placeholder="Search" />					
								<!--<button type="submit" class="btn-search" id="btn-search"><i class="fa fa-search"></i>Search</button>-->				
							</form>	
						</div>
					</div>
					
					<?php				
										
					foreach ($post_data as $row)				
					{					
						$post_author_username = $this->mdl_user->get_username($row->post_author,'id');
						$post_author_fb_id = $this->mdl_user->get_user_meta($row->post_author, 'facebook_id');
						$post_author_avatar = 'https://graph.facebook.com/'.$post_author_fb_id.'/picture?width=50&height=50';
						
						$image[0] = $this->mdl_post->get_post_meta($row->ID, 'image_story_0');
						$image[1] = $this->mdl_post->get_post_meta($row->ID, 'image_story_1');
						$image[2] = $this->mdl_post->get_post_meta($row->ID, 'image_story_2');
						$image[3] = $this->mdl_post->get_post_meta($row->ID, 'image_story_3');
						?>										
						<div class="item-post-wr margin-lg-bottom">	
							<div class="head-item-post">
								<div class="padding-md-left padding-md-right">
									<div class="row">
										<div class="col-sm-6">
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
										<div class="col-sm-6">
											<div class="head-table">
												<div class="inner-table-cell">
													<div class="view-n-share text-right">
														<?php echo ($image[0] != '' ? '<a href="'.site_url('assets/uploaded/img/post_thumb/'.$image[0]).'" class="fancy" data-fancybox-group="album-'.$row->post_name.'"><img src="'.site_url('assets/uploaded/img/post_thumb/crop_'.$image[0]).'" width="50" /></a>' : ''); ?>
														<?php echo ($image[1] != '' ? '<a href="'.site_url('assets/uploaded/img/post_thumb/'.$image[1]).'" class="fancy" data-fancybox-group="album-'.$row->post_name.'"><img src="'.site_url('assets/uploaded/img/post_thumb/crop_'.$image[1]).'" width="50" /></a>' : ''); ?>
														<?php echo ($image[2] != '' ? '<a href="'.site_url('assets/uploaded/img/post_thumb/'.$image[2]).'" class="fancy" data-fancybox-group="album-'.$row->post_name.'"><img src="'.site_url('assets/uploaded/img/post_thumb/crop_'.$image[2]).'" width="50" /></a>' : ''); ?>
														<?php echo ($image[3] != '' ? '<a href="'.site_url('assets/uploaded/img/post_thumb/'.$image[3]).'" class="fancy" data-fancybox-group="album-'.$row->post_name.'"><img src="'.site_url('assets/uploaded/img/post_thumb/crop_'.$image[3]).'" width="50" /></a>' : ''); ?>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="body-post">
								<div class="padding-sm-top padding-md-left padding-md-right">
									
									<?php
									$oldstring = $row->post_content;
									$wordsreturned = 35;
									
									//$retval = $string;
									$string = preg_replace('/(?<=\S,)(?=\S)/', ' ', $oldstring);
									$string = str_replace("\n", " ", $string);
									$array = explode(" ", $string);
									if (count($array)<=$wordsreturned)
									{
										$retval = $string;
									}
									else
									{
										array_splice($array, $wordsreturned);
										$retval = implode(" ", $array)."...";
									}
									echo $retval;
									?>
									
								</div>
							</div>
							<div class="foot-post padding-md-left padding-md-right text-right">
								<a href="<?php echo site_url('app/story_detail/'.$row->post_name)?>" class="btn btn-more text-uppercase">Read More</a>		
							</div>	
						</div>										
					<?php				
					}				
					?>	
				
				</div>
				
				
				<?php 
				if(isset($pagination)){
					echo '<div class="pagination">';
					echo $pagination; 
					echo '</div>';
				}
				?>
				
			</div>	
			
		</div>	
		
	</div>


<?php $this->load->view($template_name.'partials/app_footer'); ?>