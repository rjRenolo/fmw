<?php
$counter = 0;
$imageGallery = get_field('image_gallery', $post->ID);
$carousel = [];
foreach($imageGallery as $img){

    if($counter  <=5){
        $carousel[] = $img['image'];
        $counter++;
    }
}

?>
<div class="result-card g_grid_4">
    <a href="<?php the_permalink();?>">
        <div class="card-head owl-carousel-card-listing owl-carousel owl-theme" style="width:100%;">

            <?php foreach($carousel as $imgItem){ ?>
                <div class="item">
                    <div class="result-item-img" style="background-image: url(<?php echo acf_image_output_url($imgItem, 'thumbnail')?>)">
                    </div>
                </div>
            <?php } ?>

        </div>
        <div class="card-body">
            <div class="card-category">
                <span><?=apply_filters( 'term_getter', $post->ID, 'listing-category' )?></span>
                <?php
                $taxId = apply_filters( 'termdID_getter', $post->ID, 'listing-category' );
                echo apply_filters( 'taxonomy_images_getter', $taxId );
                ?>
            </div>
            <div class="listing-title">
                <h4 class="textleft"><?= the_title()?></h4>
            </div>
            <div class="reviews">

            </div>
            <div class="card-icon-with-detail">
                <img height="25px" width="25px" src="<?=get_bloginfo('template_directory');?>/images/global/fmw/person-group.svg" alt="">
                <p><?=apply_filters( 'term_getter', get_sub_field('listing'), 'listing-capacity' )?> Guests</p>
            </div>
            <div class="card-icon-with-detail">
                <img height="25px" width="25px" src="<?=get_bloginfo('template_directory');?>/images/global/fmw/geo-alt.svg" alt="">
                <p><?php echo get_field('town',$post->ID);?><?php echo (get_field('county',$post->ID) == "" ? '' : ', ' . get_field('county',$post->ID));?></p>
            </div>
        </div>
        <hr>
        <div class="card-excerpt">
            <p><?=apply_filters('custom_card_excerpt', get_field('listing_excerpt', $post->ID)) ?></p>
        </div>
    </a>
</div><!-- Card Item -->