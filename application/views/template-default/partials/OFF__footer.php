	
		<div class="footer h3 text-uppercase text-center padding-lg-top padding-lg-bottom">
			Merokok dapat menyebabkan kanker, serangan jantung, impotensi dan gangguan kehamilan dan janin.
		</div>
		
	</div>
	
	
	<div class="modal-popup" id="popup-general">
		<div class="modal-position" id="modal-disclaimer">
			<div class="modal-wrapper">
				<div class="inner-modal-wrapper">
					
					<div class="popup-alert padding-lg-top padding-lg-bottom padding-xl-left padding-xl-right">
						<h3 class="text-uppercase text-bold text-black margin-null text-center">Disclaimer</h3>
						
						<div class="alert-body margin-sm-top text-center">
							<p>Informasi dalam website ini ditujukan untuk perokok berusia <strong>18 tahun</strong> atau lebih dan tinggal di wilayah Indonesia.</p>
							<div><img src="<?php echo $template_path.'assets/img/18plus.jpg'; ?>"></div>
							<button class="btn btn-la-login btn-alert" id="btn_agree">SETUJU</button> 
							<!--<button class="btn btn-primary btn-alert" onclick="close_window();return false;">TIDAK SETUJU</button>-->
						</div>
					</div>
					
				</div>
			</div>
		</div>
		
		
		<div class="modal-position" id="modal-general">
			<div class="modal-wrapper">
				<div class="inner-modal-wrapper">
					
					<div class="popup-alert padding-lg-top padding-lg-bottom padding-sm-left padding-sm-right">
						<div class="popup-close"></div>
						
						<div id="modal-title-general" class="text-uppercase text-center text-black margin-null"></div>
						
						<div class="alert-body text-center margin-sm-top padding-md-left padding-md-right" id="modal-body-general">
							<img src="<?php echo $template_path.'assets/img/general_loading.gif'; ?>">
						</div>
					</div>
					
				</div>
			</div>
		</div>
		
	</div>
	
	<input type="hidden" id="save_base_url" value="<?php echo base_url();?>">
	<input type="hidden" id="save_callback_url" value="<?php echo (isset($current_url_encode) ? $current_url_encode : ''); ?>">
	
	
	<?php $this->load->view($template_name.'partials/javascript'); ?>


</body>
</html>