<?php 
# set form as show
$show_form = 'yes';

# get the extra field information
$meta_info = $this->mdl_entries->get_meta_information($post_type);

# generate the slug
$slug_auto = random_string('alnum', 10); 

if($form_type == 'edit')
{
	if (empty($pg_query))
	{
		echo "<div class='alert alert-error'>Record's not found..</div>";
		$show_form = 'no';
	} 
	else
	{
		# get detail data
		foreach ($pg_query as $row) 		
		{
			$custom_id = $row->id;
			$title = $row->title;
			$slug = $row->slug;
		}
	}
}
?>

<?php if($show_form == 'yes'): ?>	
	
	<form action="<?php echo site_url('control/update_custom'); ?>" method="post" id="form">
	
		<div class="label label-inverse">Main Field</div>		
		<br/><br/>		
		
		<input type="hidden" name="custom_id" id="custom_id" value="<?php echo (isset($custom_id) ? $custom_id : ''); ?>" />				
		<input type="hidden" name="post_type" value="<?php echo (isset($post_type) ? $post_type : ''); ?>" id="post_type" class="span6" >	
		<input type="hidden" name="form_type" value="<?php echo $form_type; ?>" >		
		<div class="label-input">Title</div>
		
		<div class="bottom-space4">
		<input type="text" name="title" value="<?php echo (isset($title) ? $title : ''); ?>" id="title" class="span6"/>
		</div>
		
		<input type="hidden" name="slug" value="<?php echo (isset($slug) ? $slug : $slug_auto); ?>" id="slug" class="span6" />
		
		<div class="label label-inverse">Extra</div>
		<br/><br/>
				
		<?php 
		# control meta update by post type, every post type have different meta key
		if (!empty($meta_info))
		{
			foreach ($meta_info as $row => $value)
			{
				# get meta value
				if($form_type == 'edit')
				{
					$meta_value = $this->mdl_entries->get_post_meta($custom_id, $value['meta_key']);	
				}
				else
				{
					$meta_value = null;
				}
				
				?>
				
				<?php if (!empty($custom_id)) : ?>
					<div class="label-input"><?php echo ucfirst(str_replace('_',' ',$value['meta_key']));?> <a href="<?php echo site_url('control/delete_field_custom/'.$value['meta_key'].'/'.$custom_id.'/'.$current_url_encode)?>">[Erase]</a></div>
					<div class="bottom-space4">
						<input type="text" name="<?php echo $value['meta_key'];?>" cols="10" rows="4" value="<?php echo (isset($meta_value) ? $meta_value : ''); ?>">
					</div>
				<?php endif;?>
				
				<?php
			}
		}
		else
		{
			echo '<div>No Extra Field</div><br/><br/>';
		}
		?>
		
		<div id="extra_field_dynamic">
		<!--content by ajax-->
		</div>
		
		<?php
		# add new field only for new post
		if($form_type != 'edit')
		{
			?>
			<input type="button" value="I Need More Field" id="btn_opn_new_field" class="btn btn-la btn-space2"/>
			<br/><br/>
			<div id="form_new_field">
			<div class="label-input">Field Name</div>
			<input type="text" id="field_name" class="span6" /><br/>
			<input type="button" value="Add New" id="btn_new_field" class="btn btn-la btn-space2"/>
			</div>
			<br/><br/>
			<?php
		}
		?>
		
		<?php
		# add new field only for new post
		if($form_type == 'edit')
		{
			?>
			<div style="border:1px solid #dedede;padding:10px;">
			Need More field ?<br/>
			<input type="text" id="field_name" placeholder="Field Name" class="span6" /><br/>
			<input type="text" id="field_content" placeholder="Content" class="span6" /><br/>
			<input type="button" value="Add" class="btn btn-la btn-space2" id="btn-add-field"/>
			</div>
			<?php
		}
		?>
		
		<br/><br/>
		<input type="submit" value="Save" class="btn btn-la btn-space2"/>
		<input type="button" value="Cancel" class="btn btn-space2" onClick="history.go(-1);"/> 

	</form>

<?php endif ?>
<!--Tutup-->

<input type="hidden" id="base_url" value="<?php echo base_url()?>">

<!-- NotifIt -->
<link rel="stylesheet" href="<?php echo base_url('plugins/notifIt/notifIt.css'); ?>" />
<script type="text/javascript" src="<?php echo base_url('plugins/notifIt/notifIt.js'); ?>"></script>

<!--Js General-->
<script>
$(document).ready(function(){
	
	// Init
	$('#form_new_field').hide();
	var base_url = $('#base_url').val();

	// Open new field
	$('#btn_opn_new_field').click(function(){
		$('#form_new_field').show();
	});
	
	// New field trigger
	$('#btn_new_field').click(function(){
		var field_name = $('#field_name').val();
		var field_name_key = field_name.replace(' ','_');
		var field_name_key_lower = field_name_key.toLowerCase();
	
		$('#extra_field_dynamic').append('<div class=label-input>' + field_name +' </div><div class=bottom-space4><input type=text name=' + field_name_key_lower + ' class=span6 /></div>')
		$('#form_new_field').hide();
	});
	
	// Add new entries field
	$('#btn-add-field').click(function(){
	
		var field_name = $('#field_name').val(); 
		var field_content = $('#field_content').val(); 
		var entries_id = $('#custom_id').val();
		
		notif({
		  msg: "Creating new field..",
		  position: "center",
		  bgcolor: "#3FB618",
		  color: "#fff",
		  opacity: 0.8,
		  autohide: false
		});
		
		$.post( base_url + 'control/add_field_custom', { data_post: entries_id + '|' + field_name + '|' + field_content })
		.done(function( data ) {
			$('#ui_notifIt').hide();
			window.location.reload(false);
		});
		
		return false;
	});
	
});
</script>
<!--Close-->