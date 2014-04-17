<div class="accordion" id="main_menu">

	<div class="accordion-group <?php /* echo ($this->uri->segment(2) == 'index' ? 'active' : ''); */ ?>">
		<a href="<?php echo site_url('control/index'); ?>" class="main_menu"><span class="menu-icon"><i class="icon-home t5"></i></span> <span class="menu-text">Dashboard</span></a>
	</div>
	
	<!--
	<div class="accordion-group <?php echo ($this->uri->segment(2) == 'index' ? 'active' : '');  ?>">
		<a href="<?php echo site_url('control/report'); ?>" class="main_menu"><span class="menu-icon"><i class="icon-desktop t5"></i></span> <span class="menu-text">Report</span></a>
	</div>
	-->
		
	<div class="accordion-group <?php /* echo ($this->uri->segment(2) == 'user' ? 'active' : ''); */ ?>">
		<a href="<?php echo site_url('control/user'); ?>" class="main_menu"><span class="menu-icon t5"><i class="icon-user"></i></span> <span class="menu-text">User</span></a>
	</div>
	
	<div class="accordion-group <?php /* echo ($this->uri->segment(2) == 'custom' ? 'active' : ''); */ ?>">
		<div class="accordion-heading">
			<a class="accordion-toggle" data-toggle="collapse" data-parent="#main_menu" href="#menu_multi">
				<span class="menu-icon"><i class="icon-pencil t5"></i></span> <span class="menu-text">Free Post<span class="pull-right menu-caret t6"><i class="icon-plus"></i></span></span>
			</a>
		</div>
		<div id="menu_multi" class="accordion-body collapse <?php /* echo ($this->uri->segment(2) == 'custom' ? 'in' : ''); */ ?>">
			<div class="accordion-inner">
				<ul class="sub_main_menu">
					<li><a href="<?php echo site_url('control/custom/sample'); ?>">Sample</a></li>
				</ul>
			</div>
		</div>
	</div>
	
</div>