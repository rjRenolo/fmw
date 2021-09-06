<?php Embers_Utilities::get_template_parts( array( 'parts/html-header', 'parts/header' ) ); ?>

<article class=" row blog-container-wrap">
	<div class="container is-style-narrow">
		<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>

			<h1 class="blogTitle"><?php the_title(); ?></h1>
			<p class="blogDate"><time datetime="<?php the_time( 'Y-m-d' ); ?>" pubdate><?php the_date(); ?> <?php the_time(); ?></time></p>

			<?php the_content(); ?>			

		<?php endwhile; ?>
	</div>

</article>

<?php Embers_Utilities::get_template_parts( array( 'parts/footer','parts/html-footer' ) ); ?>