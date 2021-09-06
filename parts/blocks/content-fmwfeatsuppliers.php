<?php
/**
 * Block Name: FMW Featured Suppliers
 *
 */

// create id attribute for specific styling
$id = 'fmwover-' . $block['id'];

// create align class ("alignwide") from block setting ("wide")
$align_class = $block['align'] ? 'align' . $block['align'] : '';
$class = $block['className'];


$leftImage = get_field('left_image');
?>
<div class="container feats <?=$class?>" id="<?=$id?>">

    <?php
    if( have_rows('listings') ):?>
        <div class="featured-container row" data-aos="fade-up"> 

            <?php while( have_rows('listings') ) : the_row();?>

                <?php
                $counter = 0;
                $imageGallery = get_field('image_gallery', get_sub_field('listing'));
                $carousel = [];
                foreach($imageGallery as $img){

                    if($counter  <=5){
                        $carousel[] = $img['image'];
                        $counter++;
                    }
                }

                ?>
      
                    <div class="result-card g_grid_3">
                        <a href="<?php echo get_the_permalink(get_sub_field('listing'));?>">
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
                                    <span><?=apply_filters( 'term_getter', get_sub_field('listing'), 'listing-category' )?></span>
                                    <?php
                                        $taxId = apply_filters( 'termdID_getter', get_sub_field('listing'), 'listing-category' );
                                        echo apply_filters( 'taxonomy_images_getter', $taxId );
                                    ?>
                                </div>
                                <div class="listing-title">
                                    <h4 class="textleft"><?=get_the_title(get_sub_field('listing'))?></h4>
                                </div>
                                <div class="reviews">

                                </div>
                                <div class="card-icon-with-detail">
                                    <img height="25px" width="25px" src="<?=get_bloginfo('template_directory');?>/images/global/fmw/person-group.svg" alt="">
                                    <p><?=apply_filters( 'term_getter', get_sub_field('listing'), 'listing-capacity' )?> Guests</p>
                                </div>
                                <div class="card-icon-with-detail">
                                    <img height="25px" width="25px" src="<?=get_bloginfo('template_directory');?>/images/global/fmw/geo-alt.svg" alt="">
                                    <p><?php echo get_field('town',get_sub_field('listing'));?><?php echo (get_field('county',get_sub_field('listing')) == "" ? '' : ', ' . get_field('county',get_sub_field('listing')));?></p>
                                </div>
                            </div>
                            <hr>
                            <div class="card-excerpt">
                                <p><?=get_field('listing_excerpt', get_sub_field('listing')) ?></p>
                            </div>
                        </a>
                    </div><!-- Card Item -->
            <?php endwhile;?>
        </div>
    <?php endif;?>


</div>


	