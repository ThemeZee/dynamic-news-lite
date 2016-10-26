
	<section id="sidebar" class="secondary clearfix" role="complementary">

		<?php
			// Check if Sidebar has widgets
		if ( is_active_sidebar( 'sidebar' ) ) :

			dynamic_sidebar( 'sidebar' );

			// Show hint where to add widgets
			else : ?>

			<aside class="widget">
				<h3 class="widgettitle"><?php esc_html_e( 'Sidebar', 'dynamic-news-lite' ); ?></h3>
				<div class="textwidget">
					<p><?php esc_html_e( 'Please go to Appearance &#8594; Widgets and add some widgets to your sidebar.', 'dynamic-news-lite' ); ?></p>
				</div>
			</aside>
		
		<?php endif; ?>

	</section>
