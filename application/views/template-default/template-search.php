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

					Found <?php echo $post_data_total;?> results. <br/>

					<?php
					foreach ($post_data as $row)
					{
						$post_content = $this->mdl_post->get_post_field('post_content', 'id', $row->ID);
						$author_id = $this->mdl_post->get_post_field('post_author', 'id', $row->ID);
						$post_author_username = $this->mdl_user->get_username($author_id,'id');
						?>
						
						<div class="media">
							<div class="pull-left">
								<img src="https://graph.facebook.com/<?php echo $post_author_username; ?>/picture?type=small" width="30">
							</div>
							<div class="media-body">
						
								<?php
								$oldstring = $post_content;
								$wordsreturned = 20;
									
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
								<a href="<?php echo site_url('app/story_detail/'.$row->post_name)?>">More..</a>
							</div>
						</div>	
						<?php
					}
					?>
					
				</div>
				
			</div>
			
		</div>
		
	</div>
	
	
<?php $this->load->view($template_name.'partials/app_footer'); ?>
	