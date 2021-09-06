
<?php Embers_Utilities::get_template_parts( array( 'parts/html-header', 'parts/header' ) ); ?>

<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
<?php the_content(); ?>
<?php endwhile; ?>

<?php Embers_Utilities::get_template_parts( array( 'parts/footer','parts/html-footer' ) ); ?>