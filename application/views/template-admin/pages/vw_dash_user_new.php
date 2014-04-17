<div class="content-admin">
	<div class="head-area heading-active">
		<span class="title"><?php echo $title_page; ?></span>
		<span class="pull-right"><a href="#" class="link-chevron"><i class="icon-chevron-up"></i></a></span>
	</div>
		
	<div class="body-area">
		<div class="body-area-padding">

			<form action="<?php echo site_url('control/user_add'); ?>" method="post">
		
				<div class="label-input">Username *</div>
				<div class="bottom-space4">
					<input type="text" name="username" value="<?php echo (isset($username) ? $username : ''); ?>" id="username" class="span4" />
					<?php echo form_error('username', '<span class="left-space4 error_display">', '</span>'); ?>
				</div>
				
				<div class="label-input">First Name</div>
				<div class="bottom-space4">
					<input type="text" name="f_name" value="<?php if (isset($f_name)){echo $f_name;}?>" id="f_name" class="span4" />
					<?php echo form_error('f_name', '<span class="left-space4 error_display">', '</span>'); ?>
				</div>
				
				<div class="label-input">Last Name</div>
				<div class="bottom-space4">
					<input type="text" name="l_name" value="<?php if (isset($l_name)){echo $l_name;}?>" id="l_name" class="span4" />
					<?php echo form_error('l_name', '<span class="left-space4 error_display">', '</span>'); ?>
				</div>
				
				<div class="label-input">Role *</div>
				<div class="bottom-space4">
					<select name="role" id="role">
						<?php
						$role_data = $this->mdl_role->get_list_role();
						
						foreach ($role_data as $row)
						{
							?>
							<option value="<?php echo $row->id;?>" ><?php echo $row->name;?></option>
							<?php
						}
						?>
					</select>
					<?php echo form_error('role', '<span class="left-space4 error_display">', '</span>'); ?>
				</div>
				
				<div class="label-input">Email *</div>
				<div class="bottom-space4">
					<input type="text" name="email" value="<?php if (isset($email)){echo $email;}?>" id="email" class="span4" />
					<?php echo form_error('email', '<span class="left-space4 error_display">', '</span>'); ?>
				</div>
				
				<div class="label-input">Password *</div>
				<div class="bottom-space4">
					<input type="password" name="password" id="password" class="span4" />
					<?php echo form_error('password', '<span class="left-space4 error_display">', '</span>'); ?>
				</div>
	
				<button type="submit" class="btn btn-la btn-space1">Submit</button>

			</form>
			
		</div>
	</div>
</div>
</div>

