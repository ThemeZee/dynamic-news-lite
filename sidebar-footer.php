
<?php // Check if there are footer widgets
	if(is_active_sidebar('footer-left') 
		or is_active_sidebar('footer-center-left')
		or is_active_sidebar('footer-center-right')
		or is_active_sidebar('footer-right')) : 
?>
		
	<div id="footer-widgets-bg">
	
		<div id="footer-widgets-wrap" class="container">
		
			<div id="footer-widgets" class="clearfix">
			
				<div class="footer-widgets-left">
				
					<div class="footer-widget-column">
						<?php dynamic_sidebar('footer-left'); ?>
					</div>
					<div class="footer-widget-column">
						<?php dynamic_sidebar('footer-center-left'); ?>
					</div>
					
				</div>
				
				<div class="footer-widgets-left">				
					
					<div class="footer-widget-column">
						<?php dynamic_sidebar('footer-center-right'); ?>
					</div>
					<div class="footer-widget-column">
						<?php dynamic_sidebar('footer-right'); ?>
					</div>
					
				</div>
				
			</div>
			
		</div>
	
	</div>
	
<?php endif; ?>
