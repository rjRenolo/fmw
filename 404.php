<?php Embers_Utilities::get_template_parts( array( 'parts/html-header', 'parts/header' ) ); ?>


<div class="container news-container row errorPage">
	<div class="g_grid_9">
		<h1>The page you are looking for has not been found</h1>
		<p>Please use the main menu to navigate back to the site.</p>
	</div>
	<div class="g_grid_3 sidebar">
		<ul>
			<?php wp_list_categories('title_li=');?>
		</ul>
	</div>
</div>

<?php Embers_Utilities::get_template_parts( array( 'parts/footer','parts/html-footer' ) ); ?>