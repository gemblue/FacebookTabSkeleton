<?php $this->load->view('template-admin/partials/header'); ?>
<?php $this->load->view('template-admin/partials/navbar');  ?>
    
	<!-- Main Container -->

	<div class="main-container">
		
		
		<div class="wrapper">
			<div class="row-fluid">
				
				<!-- Sidebar Left -->
				<div class="span3">
					<div class="menu-left">
						<?php $this->load->view('template-admin/partials/sidebar_left'); ?>
					</div>
				</div>
				<!-- Sidebar Left End -->
				
				<!-- Content Area -->
				<div class="span9">
					
					<div class="content-area">
						
						<?php $this->load->view('template-admin/partials/top'); ?>
						<?php $this->load->view('template-admin/partials/breadcrumb'); ?>
						
						<!-- Alert Area -->
						<?php echo $this->session->flashdata('message');?>
						<!-- Alert Area End -->
						
						<!-- Main Content -->
						<?php $this->load->view($content_page); ?>
						<!-- Main Content End -->
						
					</div>
					
				</div>
				<!-- Content Area End -->
				
			</div>
		</div>
	</div>
	<!-- Main Container End -->
	

<?php $this->load->view('template-admin/partials/footer'); ?>