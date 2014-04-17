<div class="content-admin">
	<div class="head-area heading-active">
		<span class="title"><?php echo $title_page; ?></span>
		<span class="pull-right"><a href="#" class="link-chevron"><i class="icon-chevron-up"></i></a></span>
	</div>
		
	<div class="body-area">
		<div class="body-area-padding">
			
			<?php
			# show form
			$show_form = 'yes';
			
			# get the data user detail
			if (empty($pg_query))
			{
				echo '<div class="alert alert-error">Record&acute;s not found..</div>';	
				$show_form = 'no';
			} 
			else 
			{
				foreach ($pg_query as $row)
				{
					$username = $row->username;
					$email = $row->email;
					$id_user = $row->id;
					$status = $row->status;
					$tgl_reg = $row->created_at;					
				}
				
				# meta data
				$f_name = $this->mdl_user->get_user_meta($id_user, 'first_name');
				$l_name = $this->mdl_user->get_user_meta($id_user, 'last_name');
				$address = $this->mdl_user->get_user_meta($id_user, 'address');
				$biography = $this->mdl_user->get_user_meta($id_user, 'biography');
				$special_account = $this->mdl_user->get_user_meta($id_user, 'special_account');
				$phone = $this->mdl_user->get_user_meta($id_user, 'phone');
				$avatar = $this->mdl_user->get_avatar($id_user);
				
				# user role
				$user_role_id = $this->mdl_role->get_user_role($id_user);
				
				echo 'Registered : <b>'.$tgl_reg.' ('.time_ago($tgl_reg).')</b><br/>';
				
				if ($status == 'inactive'){ 
					$btn_link = site_url('control/user_activate').'/'.$id_user.'/'.$current_url_encode;
					$btn_label = 'Activate';
				} 
				else 
				{
					$btn_link = site_url('control/user_disactive').'/'.$id_user.'/'.$current_url_encode;
					$btn_label = 'Block';
				}	
				
				echo '<div class="top-space4 bottom-space2"><a href="'.$btn_link.'" class="btn btn-la">'.$btn_label.'</a></div>';
				
			}
			?>

			
			<?php if($show_form == 'yes'): ?>
			
				<form id="form" method="post" enctype="multipart/form-data" action="<?php echo site_url('control/user_update');?>">
				
					<input type="hidden" name="id_user" value="<?php echo $id_user;?>">
				
					<div class="avatar-user top-space3 bottom-space3">
						<img src="<?php echo $avatar;?>" />
					</div>
					
					<div class="label-input">Username *</div>
					<div class="bottom-space4">
						<div><input type="text" name="username" value="<?php echo (isset($username) ? $username : ''); ?>" id="username" class="span4" disabled="disabled"/> </div>
						<div><i>Can not change this</i></div>
					</div>
				
					<div class="label-input">First Name *</div>
					<div class="bottom-space4">
						<div><input type="text" name="f_name" value="<?php echo (isset($f_name) ? $f_name : ''); ?>" id="f_name" class="span4"/> </div>
						<div><i>Show to public</i></div>
					</div>
					
					<div class="label-input">Last Name *</div>
					<div class="bottom-space4">
						<div><input type="text" name="l_name" value="<?php echo (isset($l_name) ? $l_name : ''); ?>" id="l_name" class="span4"/> </div>
						<div><i>Show to public</i></div>
					</div>
					
					<div class="label-input">Email *</div>
					<div class="bottom-space4">
						<input type="text" name="email" value="<?php echo (isset($email) ? $email : '');?>" id="email" class="span4"/>
						<span id="email_error" class="left-space4 error">Email name must be filled</span>
					</div>
					
					<div class="label-input">Phone</div>
					<div class="bottom-space4">
						<input type="text" name="phone" value="<?php echo (isset($phone) ? $phone : '');?>" id="phone" class="span4"/>
						<span id="email_error" class="left-space4 error">Email name must be filled</span>
					</div>
					
					<div class="label-input">Address</div>
					<div class="bottom-space4">
						<textarea name="address" id="address" class="span6"><?php echo (isset($address) ? $address : ''); ?></textarea>
					</div>

					<div class="label-input">Biography</div>
					<div class="bottom-space4">
						<textarea name="biography" id="biography" class="span6"><?php echo (isset($biography) ? $biography : ''); ?></textarea>
					</div>
					
					<div class="label-input">Role</div>
					<div class="bottom-space4">
						<select name="role" id="role" class="input" >
						<?php
						# get the data role
						if (empty($role_query))
						{
							echo '<option selected="selected">Record is not found..</option>';		
						} 
						else 
						{
							foreach ($role_query as $row){
								echo '<option value="'.$row->id.'" '.($user_role_id == $row->id ? 'selected="selected"' : '').'>'.$row->name.'</option>';
							}
						}
						?>
						</select>
					</div>
					
					<div class="label-input">Special Account</div>
					<div class="bottom-space4">
						<select name="special_account" id="special_account" class="input" >
						<option value="" <?php echo ($special_account == '' ? 'selected="selected"' : ''); ?>>None</option>
						<option value="senior_director" <?php echo ($special_account == 'senior_director' ? 'selected="selected"' : ''); ?> >Senior Director</option>
						<option value="senior_actor" <?php echo ($special_account == 'senior_actor' ? 'selected="selected"' : ''); ?> >Senior Actor</option>
						<option value="senior_actress" <?php echo ($special_account == 'senior_actress' ? 'selected="selected"' : ''); ?> >Senior Actress</option>
						</select>
					</div>
					
					<hr class="la-line">
					
					<div class="top-space3 t5 bottom-space3">Password</div>
					
					<div class="label-input">New Password</div>
					<div class="bottom-space4">
						<input type="text" name="new_pass" value="" id="new_pass" class="span4"/>
						<span id="new_pass_error" class="left-space4 error">Email name must be filled</span>
					</div>
					
					<button type="submit" class="btn btn-la btn-space1">Update</button>
				</form>

			<?php endif ?>
			
		</div>
	</div>
</div>
