	
	<div class="footer">
		Copyright &copy; <?php echo (isset($site_title) ? $site_title : 'Project Name'); ?> - All rights reserved.
	</div>
	
	
	<script type="text/javascript">
	$(document).ready(function(){
	
		var heightLeft = $(".menu-left").height();
		var heightRight = $(".content-area").height();
		
		if(heightLeft < heightRight){
			$(".menu-left").css("height",heightRight+"px");
		} else {
			$(".content-area").css("height",heightLeft+"px");
		}
		
		$('.btn-iframe').fancybox({	
			'width'		: 900,
			'height'	: 600,
			'type'		: 'iframe',
			'autoScale'    	: true
		});
	
		/* ------ ACCORDION ------ */
		var $init;
		$init = $(".accordion-body.in");
		$init.parent().addClass("accordion-group-active");
		$init.prev().addClass("accordion-heading-active");
		$init.parent().find(".icon-accordion").html('<i class="icon-minus"></i>');
		

		$(".accordion-toggle").click(function(){
			
			
			if ($(this).parent().hasClass("accordion-heading-active")) {		
				$(this).parent().removeClass("accordion-heading-active");
				$(this).parents(".accordion-group").removeClass("accordion-group-active");
				$(this).find(".menu-caret").html('<i class="icon-plus"></i>');
			} else {
			
				var attr_parent = $(this).attr('data-parent');

				if (typeof attr_parent !== 'undefined' && attr_parent !== false) {
					var parent_div_id = $(this).attr("data-parent");
					$(parent_div_id).find(".accordion-heading").removeClass("accordion-heading-active");
					$(parent_div_id).find(".accordion-group").removeClass("accordion-group-active");
					$(parent_div_id).find(".menu-caret").html('<i class="icon-plus"></i>');
				} 

				$(this).parent().addClass("accordion-heading-active");
				$(this).parents(".accordion-group").addClass("accordion-group-active");  
				$(this).find(".menu-caret").html('<i class="icon-minus"></i>');
			}

		});
		/* ------ ACCORDION END ------ */
		
		
		/* ------ BOX AREA ------ */
		$(".link-chevron").click(function(){
			
			$(this).parents(".content-admin").find(".body-area").toggle();
			
			if ($(this).parents(".head-area").hasClass("heading-active")) {
				$(this).html('<i class="icon-chevron-down"></i>');
				$(this).parents(".head-area").removeClass("heading-active");
			} else {
				$(this).html('<i class="icon-chevron-up"></i>');
				$(this).parents(".head-area").addClass("heading-active");
			}
			return false;
	
		});
		/* ------ BOX AREA END ------ */
		
		/*select post type post action*/		
		
		<?php if (isset($status) && $status == 'trash'):?>
			
			$('#post-type-filter').live("change", function() {		
				var post_type = $('#post-type-filter').val();			
				var site = '<?php echo site_url();?>';			
				window.location.href = site + 'control/post/trash/' + post_type;		
			});
		
		<?php else :?>
		
			$('#post-type-filter').live("change", function() {		
				var post_type = $('#post-type-filter').val();			
				var site = '<?php echo site_url();?>';			
				window.location.href = site + 'control/post/all/' + post_type;		
			});
		
		<?php endif;?>
		
		
	});
	</script>	
	
</body>
</html>