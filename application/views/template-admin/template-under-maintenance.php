<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>LA Lights</title>


<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/style-maintenance/style.css');?>" />

<script type="text/javascript" src="http://code.jquery.com/jquery-latest.pack.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/style-maintenance/js/jquery.countdown.js');?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/style-maintenance/js/jcarousellite1.0.1_min.js');?>"></script>

<!-- jquery countdown-->
<script type="text/javascript">
$(function () {
var austDay = new Date("Dec 03, 2013 13:00:00");
    $('#defaultCountdown').countdown({until: austDay, layout: '{dn} {dl}, {hn} {hl}, {mn} {ml}, and {sn} {sl}'});
    $('#year').text(austDay.getFullYear());
    });
</script>

<!-- jquery slider -->
<script type="text/javascript">

$(function() {
    $("#slidertext").jCarouselLite({
        btnNext: ".next",
        btnPrev: ".prev"
    });
});

</script>

<!--script for IE6-image transparency recover-->
<!--[if IE 6]>
<script type="text/javascript" src="js/DD_belatedPNG_0.0.7a-min.js"></script>
<script>
  /* EXAMPLE */
  DD_belatedPNG.fix('#logo img,#main,.counter,.twitter,.flickr,.facebook,.youtube,.skype,.stumbleupon, #submit,.prev img,.next img,#email');
  
</script>
<![endif]--> 


<script type="text/javascript" language="javascript">
<!--
var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-25056701-1']);
  _gaq.push(['_addOrganic','google.co.id','q']);
  _gaq.push(['_addOrganic','images.google.co.id','q']);
  _gaq.push(['_addOrganic','images.google.com','q']);
  _gaq.push(['_trackPageview']);
 // _gaq.push(['_trackSocial', network, socialAction, opt_target, opt_pagePath]);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
  -->
</script>

</head>

<body>


<div class="container">
	
    <div id="header" align="center">
        <img src="<?php echo base_url('assets/style-maintenance/images/logo_lalights.jpg');?>" alt="logo"/>
	</div><!--end header-->
	
    <div style="clear:both"></div> 
    
	<div id="main">

		<div id="content">
            
            <div class="text">
				<h2>This website is under maintenance</h2>
            </div><!--end text-->
           
            <div class="counter">
				
				<h3>Estimated Time Remaining Before Live:</h3>
				<div id="defaultCountdown"></div>

			</div><!--end counter-->
        
        </div><!--end content-->
        
		<p class="copyright">Copyright &copy; LA Lights. All rights reserved.</p>

	</div><!--end main-->

</div><!--end class container-->

</body>

</html>
