<?php Embers_Utilities::get_template_parts( array( 'parts/html-header', 'parts/header' ) ); ?>

<div class="container news-container row blog-container-wrap">
	<h1><?php echo get_the_title(get_option( 'page_for_posts' ));?></h1>

	<div class="row blog-container">	
		<?php if ( have_posts() ): ?>	
		
			<?php while ( have_posts() ) : the_post(); ?>

				<div class="result-card g_grid_4 blog-result-card">
				    <a href="<?php the_permalink();?>">
				        <div class="card-head">
				        	<?php $imgItem = get_the_post_thumbnail_url($post->ID, 'thumbnail');?>
				            <div class="result-item-img" style="background-image: url(<?php echo $imgItem?>)">
				            </div>
				        </div>
				        <div class="card-body">
				            <div class="card-category">
				                <time datetime="<?php the_time( 'Y-m-d' ); ?>" pubdate><?php the_date(); ?> <?php the_time(); ?></time>
				            </div>
				            <div class="listing-title">
				                <h2 class="textleft"><?= the_title()?></h2>
				            </div>
				        </div>
				        <hr>
				        <div class="card-excerpt">
				            <p><?php the_excerpt(); ?></p>
				        </div>
				    </a>
				</div>
			<?php endwhile; ?>
			<?php else: ?>

			<h2>No posts to display</h2>

		<?php endif; ?>

	</div>
	<div class="navigation row">
	        <?php wa_numeric_posts_nav();?>
	</div>
</div>

<?php Embers_Utilities::get_template_parts( array( 'parts/footer','parts/html-footer') ); ?>