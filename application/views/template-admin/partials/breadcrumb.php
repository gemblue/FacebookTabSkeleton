<ul class="breadcrumb">
	<?php
	
		if(isset($nav1))
		{
			if(isset($nav2))
			{
				if(isset($nav3))
				{
					echo '<li><a href="'.site_url('control').'"><i class="icon-home"></i></a> <span class="divider">/</span></li>';
					echo '<li><a href="'.$link_nav1.'">'.$nav1.'</a> <span class="divider">/</span></li>';
					echo '<li><a href="'.$link_nav2.'">'.$nav2.'</a> <span class="divider">/</span></li>';
					echo '<li>'.$nav3.'</li>';
				}
				else
				{
					echo '<li><a href="'.site_url('control').'"><i class="icon-home"></i></a> <span class="divider">/</span></li>';
					echo '<li><a href="'.$link_nav1.'">'.$nav1.'</a> <span class="divider">/</span></li>';
					echo '<li>'.$nav2.'</li>';
				}
			}
			else
			{
				echo '<li><a href="'.site_url('control').'"><i class="icon-home"></i></a> <span class="divider">/</span></li>';
				echo '<li>'.$nav1.'</li>';
			}
		
		}
		else 
		{
			echo '<li><i class="icon-home"></i></li>';
		}
		
	?>
</ul>