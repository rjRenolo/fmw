<?php Embers_Utilities::get_template_parts( array( 'parts/html-header', 'parts/header' ) ); ?>

<div class="container news-container row">
	<div class="g_grid_9">
		<?php if ( have_posts() ): ?>
		<h1>Category: <?php echo single_cat_title( '', false ); ?></h1>
		<?php while ( have_posts() ) : the_post(); ?>
			<article class="blogCat">
					<h2><a href="<?php esc_url( the_permalink() ); ?>" title="Permalink to <?php the_title(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
					<span><time datetime="<?php the_time( 'Y-m-d' ); ?>" pubdate><?php the_date(); ?> <?php the_time(); ?></time></span> 
					<?php the_excerpt(); ?>
					<p><strong><a href="<?php esc_url( the_permalink() ); ?>" title="Permalink to <?php the_title(); ?>" rel="bookmark" class="has-dark-blue-color">Read more...</a></strong></p>
			</article>
		<?php endwhile; ?>
		<?php else: ?>
		<h2>No posts to display</h2>
		<?php endif; ?>
	</div>
	<div class="g_grid_3 sidebar">
		<ul>
			<?php wp_list_categories('title_li=');?>
		</ul>
	</div>
</div>



<?php Embers_Utilities::get_template_parts( array( 'parts/footer','parts/html-footer' ) ); ?>