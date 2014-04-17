	<script type="text/javascript">
	$(document).ready(function(){ 
	
		
		
		var base_url = $("#save_base_url").val();
		var current_url_encode = $("#save_callback_url").val();
		
		var savePostID = $("#save_id_post").val();
		var saveEncodeCurentURL = $("#save_current_url_encode").val();
		var url = document.location.toString();
		
		if(current_url_encode == 'aHR0cDovL3d3dy5sYS1saWdodHMuY29tL211c2ljLXByb2plY3Qtd2Vicy91c2Vycy9yZWdpc3Rlcg%3D%3D'){
			current_url_encode = 'aHR0cDovL3d3dy5sYS1saWdodHMuY29tL211c2ljLXByb2plY3Qtd2Vicy8%3D';
		}
	
	
		if (url.match('#')) {
			
			var after_hash = url.split('#')[1];	
			
			if(after_hash.split('|')[0] == 'popup'){
				var title_popup = urldecode(after_hash.split('|')[1]); 
				var body_popup = urldecode(after_hash.split('|')[2]); 
				popup_open('alert', title_popup, body_popup);
			} 
		
		} 
		
		
	
	
		$("#btn_agree").live( "click", function() {
			/*
			$.ajax({
				type:"post",
				url:"<?php echo site_url('set-agree'); ?>",
				success:function(data){
					
				}
			});
			*/
			$("#popup-general").fadeOut();
			$("#modal-disclaimer").addClass("active");
			
		});
		
		
		
		$(".link-signin").click(function(){
			var url_content = base_url + 'authentication/login/home?type=popup&callback=' + current_url_encode;
			popup_open('iframe', 'none', url_content);
			return false;
		});
		
		
		$(".link-tnc").click(function(){
			var url_content = base_url + 'content-syarat-dan-ketentuan';
			popup_open('iframe', 'Syarat dan Ketentuan', url_content);
			return false;
		});
		
		
		$(".popup-close").click(function(){
			popup_out();
		});
		
		
		$('.btn_vote').click(function(){
			/*
			$('.vote_output').html('loading..');
			$.ajax({
				type: "post",
				url: base_url + "module/music-project/action/save_vote",
				data: "ajax_mode=yes" + "&post_id=" + savePostID,
				success:function(data){
					if (data == 'not_login') {
						$('.vote_output').html('');
						alert('Login dulu bro..');
					} else if (data == 'failed') {
						$('.vote_output').html('');
						alert('Sebelumnya lo udah vote video ini bro..');
					} else {
						$('.vote_output').html('');
						alert('Thank you bro. Lo berhasil vote video ini.');
					}
				}
			});
			*/
			$("#popup-general").fadeIn();
			$("#modal-general").addClass("active");
			
			$.ajax({
				type: "post",
				url: base_url + "module/music-project/action/save_vote",
				data: "ajax_mode=yes" + "&post_id=" + savePostID,
				success:function(data){
					if (data == 'not_login') {
						$("#modal-title-general").html('<h3 class="text-bold">Vote Confirmation</h3>');
						$("#modal-body-general").html('Login dulu bro..');
					} else if (data == 'failed') {
						$("#modal-title-general").html('<h3 class="text-bold">Vote Confirmation</h3>');
						$("#modal-body-general").html('Sebelumnya lo udah vote video ini bro..');
					} else {
						$("#modal-title-general").html('<h3 class="text-bold">Vote Confirmation</h3>');
						$("#modal-body-general").html('Thank you bro. Lo berhasil vote video ini.');
					}
				}
			});
			
		});
		
		
		$("#btn_social_mindtalk").click(function(){
			var linkContent = base_url + 'module/nyansocial/sharer/mindtalk/' + saveEncodeCurentURL + '/' + savePostID;
			window.open(linkContent, 'sharer', 'toolbar=0,status=0,width=550,height=400');
			return false;
		});
		
		$("#btn_social_facebook").click(function(){
			var linkContent = base_url + 'module/nyansocial/sharer/facebook/' + saveEncodeCurentURL + '/' + savePostID;
			window.open(linkContent, 'sharer', 'toolbar=0,status=0,width=550,height=400');
			return false;
		});
		
		$("#btn_social_twitter").click(function(){
			var linkContent = base_url + 'module/nyansocial/sharer/twitter/' + saveEncodeCurentURL + '/' + savePostID;
			window.open(linkContent, 'sharer', 'toolbar=0,status=0,width=550,height=400');
			return false;
		});
		
		$("#btn_social_gplus").click(function(){
			var linkContent = base_url + 'module/nyansocial/sharer/gplus/' + saveEncodeCurentURL + '/' + savePostID;
			window.open(linkContent, 'sharer', 'toolbar=0,status=0,width=550,height=400');
			return false;
		});
	
	})
	</script>
	
	
	<script>
	function popup_open(type, head, content){
		
		$("#popup-general").fadeIn();
		$("#modal-general").addClass("active");
		
		if(head == 'none'){
			$("#modal-title-general").html('');
		} else {
			$("#modal-title-general").html('<h3 class="text-bold">'+head+'</h3>');
		}
		
		
		if(type == 'alert'){
			$("#modal-body-general").html(content);
		} else if (type == 'iframe'){
			$.get(content, function(data) {
				$("#modal-body-general").html(data);
			});
		} else {
		
		}
		
		return false;
	}
	
	
	function popup_out(){
	
		$(".modal-popup").fadeOut();
		$(".modal-position").removeClass("active");
		
	}
	
	
	function urldecode(str) {
		return decodeURIComponent((str+'').replace(/\+/g, '%20'));
	}
	</script>