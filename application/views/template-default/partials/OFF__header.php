<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>LA Music Project App</title>
	
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<meta name="description" content="<?php echo (!empty($post_metadesc)) ? $post_metadesc : 'Music apps la-lights';?>">
	<meta name="keywords" content="<?php echo (!empty($post_metakey)) ? $post_metakey : 'music, music apps, android apps, blackberry apps, music project, la-lights';?>">
	<meta name="author" content="L.A. Lights">
	
	<meta name='robots' content='noindex, nofollow' />
	
	<link href="favicon.ico" rel="shortcut icon">
	
	<meta property="og:title" content="" />
	<meta property="og:type" content="blog" />
	<meta property="og:url" content="" />
	<meta property="og:image" content="" />
	<meta property="og:site_name" content="" />
	<meta property="og:description" content="<?php echo (!empty($post_metadesc)) ? $post_metadesc : 'Music apps la-lights';?>" />

	<meta property="title" content="" />
	<meta property="description" content="<?php echo (!empty($post_metadesc)) ? $post_metadesc : 'Music apps la-lights';?>" />
	<meta property="keywords" content="<?php echo (!empty($post_metakey)) ? $post_metakey : 'music, music apps, android apps, blackberry apps, music project, la-lights';?>" />

	<meta property="language" content="Indonesia" />
	<meta property="revisit-after" content="7" />
	<meta property="webcrawlers" content="all" />
	<meta property="rating" content="general" />
	<meta property="spiders" content="all" />
	<meta property="robots" content="all" />
	<meta property="canonical" content="" />
	
	<!-- dns prefetch -->
	<link href="//www.google-analytics.com" rel="dns-prefetch">
	
	<!-- icons -->
	<link href="//www.la-lights.com/wp-content/themes/la-lights/img/icons/favicon.ico" rel="shortcut icon">
	<link href="//www.la-lights.com/wp-content/themes/la-lights/img/icons/touch.png" rel="apple-touch-icon-precomposed">
	
	<link href="<?php echo $template_path.'assets/css/bootstrap.min.css'; ?>" rel="stylesheet" >
	<link href="<?php echo $template_path.'assets/css/font-awesome.min.css'; ?>" rel="stylesheet" >
	<link href="<?php echo $template_path.'assets/css/flat-style.css'; ?>" rel="stylesheet">
	<link href="<?php echo $template_path.'assets/css/style.css'; ?>" rel="stylesheet">
	
	<script src="<?php echo base_url('assets/js/jquery-1.8.2.min.js'); ?>" type="text/javascript"></script>
	<script>
	jQuery(window).load(function() {
		<?php
		/*
		|
		| ---------------------------------------------------------------
		| IF AGREE
		| ---------------------------------------------------------------
		| 
		*/
		$sess_agree = $this->session->userdata('view');
		if($sess_agree <= 1): ?>
		
		$("#popup-general").fadeIn();
		$("#modal-disclaimer").addClass("active");
	
		<?php 
		/*
		|
		| ---------------------------------------------------------------
		| ENDIIF 
		| ---------------------------------------------------------------
		| 
		*/
		endif ?>
	});
	</script>
	
	<!-- analytics -->
	<script>
		var _gaq=[['_setAccount','UA-25056701-1'],['_trackPageview']];
		(function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
		g.src=('https:'==location.protocol?'//ssl':'//www')+'.google-analytics.com/ga.js';
		s.parentNode.insertBefore(g,s)})(document,'script');
	</script>
	
</head>
<body>

	<!-- BEGIN EFFECTIVE MEASURE CODE -->
	<!-- COPYRIGHT EFFECTIVE MEASURE -->
	<script type="text/javascript">
		(function() {
			var em = document.createElement('script'); em.type = 'text/javascript'; em.async = true;
			em.src = ('https:' == document.location.protocol ? 'https://id-ssl' : 'http://id-cdn') + '.effectivemeasure.net/em.js';
			var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(em, s);
		})();
	</script>
	<noscript>
		<img src="//id.effectivemeasure.net/em_image" alt="" style="position:absolute; left:-5px;" />
	</noscript>
	<!--END EFFECTIVE MEASURE CODE -->

	<div class="container">
		
		<div class="header">
			<div class="row">
				<div class="col-md-4">
					<img src="<?php echo $template_path.'assets/img/logo.jpg'; ?>">			
				</div>
				<div class="col-md-8">
					<div class="nav-topright">
						<div class="inner-nav-topright">
							<div class="top-navbar">
								<div class="login-area margin-sm-bottom">
									
									<?php 
									if ($user_login == 'yes') 
									{ 
										?>
										<div class="media">
											<div class="pull-right">
												
												<?php
												# facebook avatar
												$data['la_facebook_id'] = $this->mdl_user->get_user_meta($this->session->userdata('id'), 'la_facebook_id');
												
												if (!empty($data['la_facebook_id']))
												{
													$avatar = 'https://graph.facebook.com/'.$data['la_facebook_id'].'/picture?type=large';
												}
												else
												{
													# gravatar
													$la_email = $this->mdl_user->get_user_meta($this->session->userdata('id'), 'la_email');
													$grava_code = md5(strtolower(trim($la_email)));
													$avatar = 'http://www.gravatar.com/avatar/'.$grava_code.'?s=200&f=y&d=mm';
												}
												?>
												
												<img src="<?php echo $avatar;?>" class="ava-sm margin-xs-right img-circle">
											</div>
											<div class="media-body">
												<b><?php echo $this->session->userdata('username'); ?></b><br />
												<a href="<?php echo site_url('authentication/logout');?>">Log out</a>
											</div>
										</div>
										<?php
									} 
									else 
									{
										?>
										<div class="pull-right">
											<div class="media">
												<div class="pull-left">
													<img src="<?php echo $template_path.'assets/img/ava_reg.png'; ?>">
												</div>
												<div class="media-body">
													<div class="text-left" style="width:180px;">
													<a href="<?php echo site_url('authentication/login/home');?>" class="link-signin">SIGN IN</a><br />
													User baru? <a href="<?php echo site_url('users/register');?>" class="link-signup">Register</a> 
													</div>
												</div>
											</div>
										</div>
										<div class="clear"></div>
										<?php
									}
									?>
									
								</div>
								<div class="navbar-la-metro">
									<div class="btn-group btn-group-justified">
										<a href="<?php echo base_url(); ?>" class="btn btn-nav-la text-uppercase <?php echo ($this->uri->segment(1) == '' ? 'active' : ''); ?>">Home</a>
										<a href="<?php echo site_url('download'); ?>" class="btn btn-nav-la text-uppercase <?php echo ($this->uri->segment(1) == 'download' ? 'active' : ''); ?>">Download</a>
										<a href="<?php echo site_url('how-to-play'); ?>" class="btn btn-nav-la text-uppercase <?php echo ($this->uri->segment(1) == 'how-to-play' ? 'active' : ''); ?>">How To Play</a>
										<a href="<?php echo site_url('song-gallery'); ?>" class="btn btn-nav-la text-uppercase <?php echo ($this->uri->segment(1) == 'song-gallery' ? 'active' : ''); ?>">Song Gallery</a>
										<a href="<?php echo site_url('winners'); ?>" class="btn btn-nav-la text-uppercase <?php echo ($this->uri->segment(1) == 'winners' ? 'active' : ''); ?>">Winners</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>