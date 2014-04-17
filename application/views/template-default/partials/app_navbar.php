<div class="pajero-navbar">
	<div class="navbar-inner">
		<div class="btn-group btn-group-justified">
			<a href="<?php echo site_url('app/tnc'); ?>" class="btn btn-navbar text-uppercase <?php echo ($this->uri->segment(2) == 'tnc' ? 'active' : ''); ?>">T & C</a>
			<a href="<?php echo site_url('app/app_home'); ?>" class="btn btn-navbar text-uppercase <?php echo ($this->uri->segment(2) == 'app_home' ? 'active' : ''); ?>">Submit</a>
			<a href="<?php echo site_url('app/story'); ?>" class="btn btn-navbar text-uppercase <?php echo ($this->uri->segment(2) == 'story' ? 'active' : ''); ?>">All Stories</a>
			<a href="<?php echo site_url('app/prizes'); ?>" class="btn btn-navbar text-uppercase <?php echo ($this->uri->segment(2) == 'prizes' ? 'active' : ''); ?>">Prizes</a>
		</div>
	</div>
</div>